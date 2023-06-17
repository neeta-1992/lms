<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class GlAccount extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;



    protected $fillable = ['user_id','name','number','notes','status','parent_id'];
    protected $encryptable = ['name','number','notes'];


    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $name            = !empty($array['name']) ? $array['name'] : '' ;
        $number          = !empty($array['number']) ? $array['number'] : '' ;
        $notes           = !empty($array['notes']) ? $array['notes'] : '' ;
        $status          = !empty($array['status']) ? $array['status'] : null ;
        $user_id         = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : null ;
        $parent_id       = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $titleArr        = !empty( $array['titleArr']) ? json_decode ( $array['titleArr'],true) : null ;

        $inserArr = [
            'name'    =>$name,
            'user_id' =>$user_id,
            'number'  =>$number,
            'status'  =>$status,
            'notes'   =>$notes,
        ];

        if(!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
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
                if(!empty($parentId)){
                    $getdata = $model->updateOrCreate(['parent_id'=>$parentId],$inserArr);
                    $getChanges  = $getdata?->changesArr;
                    if(!empty($getChanges)){
                        $logsMsg  = logsMsgCreate($getChanges,$titleArr,$logJson);
                        $logsmsg .= $logsMsg?->msg;
                    }
                }else{
                    $getdata     = $model->updateOrCreate(['id'=>$id],$inserArr);
                }
            }else{
                $getdata  =    $model->create($inserArr);
            }




            $name = $getdata?->name ?? "";
            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.gl_account.add',['name'=>$name]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.gl_account.edit',['name'=>$name])." ".$logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type'=>'gl-account','onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->id,'message'=>$msg]);
            if($saveOption === "save_and_reset"){
                $array['id'] =  $getdata?->id;

                unset($array['save_and_reset']);
                AllDataBaseUpdate::allDataSave($model,"glAccount",$array,$id);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }

     public static function getData(array $array = null)
    {

        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        if(!empty($array['name'])){
            $model = $model->whereEn('name',$array['name']);
        }
        if(!empty($array['status'])){
            $model = $model->where('status',$array['status']);
        }
        if(!empty($array['id'])){
            $model = $model->where('id',$array['id']);
        }
        return $model;
    }



}
