<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error;
use App\Models\{
    Logs,ScheduledTaskList
};
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class ScheduledTask extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ['user_id','task_name','is_admin','how_often','start_time','us_time_zone','start_date','description','end_date','status','parent_id'];
    protected $encryptable = ['task_name','how_often','start_time','us_time_zone','start_date','description','end_date'];



    public static function insertOrUpdate(array $array){
        $logsmsg = "";
        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $task_name       = !empty($array['task_name']) ? $array['task_name'] : '' ;
        $how_often       = !empty($array['how_often']) ? $array['how_often'] : null ;
        $us_time_zone    = !empty($array['us_time_zone']) ? $array['us_time_zone'] : null ;
        $start_time      = !empty($array['start_time']) ? date("H:i:s",strtotime($array['start_time'])) : null ;
        $start_date      = !empty($array['start_date']) ? date("Y-m-d",strtotime($array['start_date'])) : null ;
        $description     = !empty($array['description']) ? $array['description'] : null ;
        $end_date        = !empty($array['end_date']) ? date("Y-m-d",strtotime($array['end_date'])) : null ;
        $user_id         = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : null ;
        $parent_id       = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $status          = !empty($array['status']) ? $array['status'] : 0 ;
        $is_admin        = !empty($array['is_admin']) ? $array['is_admin'] : null ;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] :'scheduled-task' ;
        $titleArr        = !empty($array['titleArr']) ? json_decode($array['titleArr'],true ) :  null;

        $inserArr = [
            'task_name'       => $task_name,
            'user_id'         => $user_id,
            'how_often'       => $how_often,
            'us_time_zone'    => $us_time_zone,
            'start_time'      => $start_time,
            'start_date'      => $start_date,
            'description'     => $description,
            'end_date'        => $end_date,
            'status'          => $status,
            'is_admin' => $is_admin,
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
        $listType   = "admin";
        if (GateAllow('isAdminCompany') || !empty($onDB)) {
            $model = $model->on('company_mysql');
            $listType = "company";
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
            $inserArr['type'] = $listType;
            $inserArr['parent_id'] = $getdata?->id;
            ScheduledTaskList::insertOrUpdate($inserArr);


            $name = $getdata?->name ?? "";
            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.scheduled_tasks.add',['name'=>taskName($task_name)]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.scheduled_tasks.edit',['name'=>taskName($task_name)])." ".$logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->id,'message'=>$msg]);
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

        $type = isset($array['type']) ? $array['type'] : null;
        $noticeType = isset($array['noticeType']) ? $array['noticeType'] : null;
        $action = isset($array['action']) ? $array['action'] : null;
        $id = isset($array['id']) ? $array['id'] : null;


        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
           // $model = $model->where('is_admin',0);
        }

        if(isset($type)){
            $model = $model->whereEncrypted('name',$type);
        }

        if(!empty($id)){
            $model = $model->decrypt($id);
        }
        return $model;
    }
}
