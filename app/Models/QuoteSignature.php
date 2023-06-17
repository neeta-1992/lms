<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,User,Quote,QuoteVersion
};
use App\Traits\ModelAttribute;
use Stevebauman\Location\Facades\Location;
class QuoteSignature extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ['user_id','qid',"vid",'ip','index','current_datetime','title',
        'email','name','timezone','region','city','lat','longs','country',
        'signature_text','signature_font','signature','agree','type','action'
    ];
    protected $encryptable = ['title'];

    protected $appends = ['key_index'];

    public function getKeyIndexAttribute(){
        return $this->type.'_'.$this->index;
    }

    public static function insertOrUpdate(array $array){
        $count             = 0;
        $id                 = !empty($array['id']) ? $array['id'] : '' ;
        $action             = !empty($array['action']) ? $array['action'] : '' ;
        $type               = !empty($array['type']) ? $array['type'] : '' ;
        $signatureAgent     = !empty($array['signature_agent']) ? $array['signature_agent'] : '' ;
        $signatureIsnured   = !empty($array['signature_isnured']) ? $array['signature_isnured'] : '' ;
        $ip                 = !empty($array['ip']) ? $array['ip'] : request()->ip() ;
        $qId                = !empty($array['qid']) ? $array['qid'] : '' ;
        $vId                = !empty($array['vid']) ? $array['vid'] : '' ;
        $userId             = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);

        $userIpdetails  = Location::get($ip);
        $countryName    = !empty($userIpdetails->countryName) ? $userIpdetails->countryName : '' ;
        $regionName     = !empty($userIpdetails->regionName) ? $userIpdetails->regionName : '' ;
        $cityName       = !empty($userIpdetails->cityName) ? $userIpdetails->cityName : '' ;
        $zipCode        = !empty($userIpdetails->zipCode) ? $userIpdetails->zipCode : '' ;
        $latitude       = !empty($userIpdetails->latitude) ? $userIpdetails->latitude : '' ;
        $longitude      = !empty($userIpdetails->longitude) ? $userIpdetails->longitude : '' ;
        $timezone       = !empty($userIpdetails->timezone) ? $userIpdetails->timezone : '' ;
        $model          = new self; //Load Model

        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['user_id']    = $userId;
        $inserArr['ip']         = $ip;
        $inserArr['country']    = $countryName;
        $inserArr['region']     = $regionName;
        $inserArr['city']       = $cityName;
        $inserArr['lat']        = $latitude;
        $inserArr['longs']      = $longitude;
        $inserArr['timezone']   = $timezone;
/* dd($inserArr); */




        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }


        DB::beginTransaction();
        try {


            if(!empty($action) && $action == 'signature'){
                if($type == 'agent'){
                    $count = self::getData(['type'=>$type,'action'=>['signature','completed'],'qId'=>$array['qid'],'vId'=>$array['vid']])->count();
                    $count = $count + 1;
                    $inserArr['action']   = $count == $signatureAgent ? 'completed' : $action;
                    if($inserArr['action'] == 'completed'){
                        QuoteVersion::getData(['qId'=>$qId,'id'=>$vId])->update(['agent_signature'=>1]);
                    }
                    $inserArr['action']   = $count == $signatureAgent ? 'completed' : $action;
                }else if($type == 'isnured'){
                    $count = self::getData(['type'=>$type,'action'=>['signature','completed'],'qId'=>$array['qid'],'vId'=>$array['vid']])->count();
                    $count = $count + 1;
                    $inserArr['action']   = $count == $signatureIsnured ? 'completed' : $action;
                    if($inserArr['action'] == 'completed'){
                        QuoteVersion::getData(['qId'=>$qId,'id'=>$vId])->update(['isnured_signature'=>1]);
                    }
                }
            }

           if(!empty($id) || !empty($parentId)){
                $model->updateOrCreate(['id'=>$id],['current_status'=>(int)$status,'show_task'=>0]);
           }else{
                $getdata = $model->create($inserArr);
           }

        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        $getdata['count'] =$count;
        return $getdata;
    }

    public static function getData(array $array=[]){


        $userId   = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);


        $model = new self;
        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }
        if(isset($array['qId'])){
            $model = $model->where('qid',$array['qId']);
        }
        if(isset($array['vId'])){
            $model = $model->where('vid',$array['vId']);
        }
        if(isset($array['ip'])){
            $model = $model->whereEn('ip',$array['ip']);
        }
        if(isset($array['otp'])){
            $model = $model->whereEn('otp',$array['otp']);
        }

        if(isset($array['status'])){
            $model = $model->where('status',$array['status']);
        }
        if(isset($array['type'])){
            $model = $model->where('type',$array['type']);
        }
        if(isset($array['action'])){
            if(is_array($array['action'])){
                $model = $model->whereIn('action',$array['action']);
            }else{
                $model = $model->where('action',$array['action']);
            }

        }

        if(!empty($id)){
            $model = $model->decrypt($id);
        }
        return $model;
    }
}
