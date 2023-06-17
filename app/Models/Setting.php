<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Str,Arr;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class Setting extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = [
        'user_id',"json",'type','status','user_type'
    ];
    protected $encryptable = [ "json"];




    public static function insertOrUpdate(array $array){
        $logsmsg = "";
        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $user_id         = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $status          = !empty($array['status']) ? $array['status'] : 0 ;
        $user_type       = !empty($array['user_type']) ? (int)$array['user_type'] : 0 ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : 0 ;
        $pageTitle       = !empty($array['pageTitle']) ? $array['pageTitle'] : null ;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : null ;
        $logActivePage = !empty($array['logActivePage']) ? $array['logActivePage'] : $activePage ;
        $exceptArr = ["id",'company_data','activePage','onDB','logId','logsArr','_token','pageTitle','user_type'];
      //  $array['user_id'] = $user_id;
        //$array['type'] = $type;

        $array    = Arr::except($array,$exceptArr);
        $settingJson    = !empty($array) ? json_encode($array) : "";
        $inserArr = [
            "user_id"   => $user_id,
            "json"      => $settingJson,
            "type"      => $activePage,
            "user_type" => $user_type,
        ];

        if(!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }

        $templateTextOld = $templateTextNew="";
        if(!empty($logJson)){
            $logsArr = $logJson;
            $logsmsg = dbLogFormat($logsArr);
        }

        $model  = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
           if(!empty($id) || !empty($parentId)){
                $inserArr  = arrFilter($inserArr);
                if(!empty($parentId)){
                    $getdata     = $model->updateOrCreate(['parent_id'=>$parentId],$inserArr);
                    $getChanges = $getdata?->changesArr;
                    if(!empty($getChanges)){
                        $logsMsg = logsMsgCreate($getChanges,$titleArr,$logJson);
                        $logsmsg .= $logsMsg?->msg;
                        $templateTextOld = $logsMsg?->preValue;
                        $templateTextNew = $logsMsg?->newValue;
                    }
                }else{
                    $getdata     = $model->updateOrCreate(['id'=>$id],$inserArr);
                }
            }else{
                $getdata  =    $model->create($inserArr);
            }






            if($getdata->wasRecentlyCreated == true){
                $msg = __("logs.setting.add",['title'=>$pageTitle]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __("logs.setting.edit",['title'=>$pageTitle])." ".$logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type'=>$logActivePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->id,'message'=>$msg,'old_value'=>$templateTextOld,'new_value'=>$templateTextNew]);
            if($saveOption === "save_and_reset"){
                $array['id'] =  $getdata?->id;
                unset($array['save_and_reset']);
                AllDataBaseUpdate::allDataSave($model,$activePage,$array,$id);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }


    public static function getData(array $array=[]){

        $type    = isset($array['type']) ? $array['type'] : null;
        $noticeType = isset($array['noticeType']) ? $array['noticeType'] : null;
        $action  = isset($array['action']) ? $array['action'] : null;
        $id      = isset($array['id']) ? $array['id'] : null;
        $userType = isset($array['userType']) ? $array['userType'] : null;
        $userId = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);


        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }
        if(isset($userId)){
           // $model = $model->where('user_id',$userId);
        }
        if(isset($type)){
            $model = $model->where('type',$type);
        }
        if(isset($userType)){
            $model = $model->where('user_type',$userType);
        }

        if(!empty($id)){
            $model = $model->decrypt($id);
        }
        return $model;
    }


}
