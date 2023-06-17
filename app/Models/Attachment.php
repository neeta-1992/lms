<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,User
};
use App\Traits\ModelAttribute;
class Attachment extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = ['user_id','type_id','description','subject','original_filename','filename','type','attachment_type','v_id','is_pfa'];
    protected $encryptable =['description','subject','original_filename','filename','type','attachment_type'];




    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $userId          = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $userId ;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $titleArr        = !empty($array['titleArr']) ? json_decode ( $array['titleArr'],true) : null ;


        $model    = new self; //Load Model

        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['user_id'] = $userId;
        if(isset($array['is_pfa'])){
            $inserArr['is_pfa']  = !empty($array['is_pfa']) ? true : false ;
        }

        $logsmsg = "";
        if(!empty($logJson)){
            $logsArr = $logJson;
            $logsmsg = dbLogFormat($logsArr);
        }

        $model  = new self;
        if(GateAllow('isAdminCompany') || !empty($onDB)){
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
           if(!empty($id) || !empty($parentId)){
                $inserArr  = arrFilter($inserArr);

                $getdata     = $model->updateOrCreate(['id'=>$id],$inserArr);
            }else{
                $getdata  =    $model->create($inserArr);
            }


        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }



    public static function getData(array $array=null){

        $model = new self;
        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }

        if(!empty($array['qId'])){
            $model = $model->where('type_id',$array['qId']);
        }
        if(isset($array['vId'])){
            $model = $model->where('v_id',$array['vId']);
        }
        if(isset($array['pfa'])){
            $model = $model->where('is_pfa',$array['pfa']);
        }



        return $model;
     }
}
