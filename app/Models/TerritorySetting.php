<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class TerritorySetting extends Model
{
    use HasFactory;
    use ModelAttribute;
   // use EncryptedAttribute;

    protected $fillable = ['user_id','name','state_ids','status'];
    protected $encryptable = ['name','state_ids',];





    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $status          = isset($array['status']) ? $array['status'] : null;
        $name            = isset($array['name']) ? $array['name'] : null;
        $state_ids       = isset($array['state']) ? $array['state'] : null;
        $user_id         = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : null ;
        $parent_id       = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null ;
        $titleArr        = !empty( $array['titleArr']) ? json_decode ( $array['titleArr'],true) : null ;
        $state_ids       = !empty($state_ids) ? implode(",", $state_ids) : null ;

        $inserArr = [
            'name'           =>$name,
            'status'         =>$status,
            'state_ids'      =>$state_ids,
            'user_id'        =>$user_id,
        ];

        if(!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }
        $logsmsg = "";
        if(!empty($logJson)){
            $logsArr  = $logJson;
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
                    $getdata     = $model->updateOrCreate(['parent_id'=>$parentId],$inserArr);
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
                $msg =  __('logs.territory_setting.add',['name'=>$name]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.territory_setting.edit',['name'=>$name])." ".$logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->id,'message'=>$msg]);
            if($saveOption === "save_and_reset"){
                $array['id'] =  $getdata?->id;
                unset($array['save_and_reset']);
                AllDataBaseUpdate::allDataSave($model,"coverageType",$array,$id);
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
     return $model;
     }

}
