<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Str;;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;

class NoticeTemplate extends Model
{
    use HasFactory;
    use EncryptedAttribute;
    use ModelAttribute;

    protected $fillable = [
      "user_id",'schedule_time','notice_id','schedule_days','status','subject','name','send_to','action','send_by','template_type','description','template_text','parent_id'
    ];
    protected $encryptable = ['subject','notice_id','name','send_to','action','send_by','template_type','description'];




    public static function insertOrUpdate(array $array){
        $logsmsg = "";
        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $name            = !empty($array['name']) ? $array['name'] : '' ;
        $send_to         = !empty($array['send_to']) ? $array['send_to'] : '' ;
        $action          = !empty($array['action']) ? $array['action'] : '' ;
        $send_by         = !empty($array['send_by']) ? $array['send_by'] : null ;
        $template_type   = !empty($array['template_type']) ? $array['template_type'] : null ;
        $description     = !empty($array['description']) ? $array['description'] : null ;
        $template_text   = !empty($array['template_text']) ? $array['template_text'] : null ;
        $schedule_days   = !empty($array['schedule_days']) ? $array['schedule_days'] : null ;
        $schedule_days = (!empty($schedule_days) && is_array($schedule_days)) ? implode(",",$schedule_days) : $schedule_days ;
        $schedule_time   = !empty($array['schedule_time']) ? $array['schedule_time'] : null ;
        $subject         = !empty($array['subject']) ? $array['subject'] : null ;
        $user_id         = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : null ;
        $parent_id       = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $status          = !empty($array['status']) ? $array['status'] : 0 ;
        $titleArr        = !empty($array['titleArr']) ? json_decode($array['titleArr'],true ) :  null;

        $inserArr = [
            'name'           =>$name,
            'user_id'        =>$user_id,
            'send_to'        =>$send_to,
            'action'         =>$action,
            'send_by'        =>$send_by,
            'template_type' =>$template_type,
            'description'   =>$description,
            'template_text' =>$template_text,
            'schedule_days' =>$schedule_days,
            'schedule_time' =>$schedule_time,
            'subject'       =>$subject,
            'status'        =>$status,
        ];

        if(!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }

        $templateTextOld = $templateTextNew="";
        if(!empty($logJson)){
            $logsArr = $logJson;
            $templateTextOld = !empty($logsArr['template_text'][0]['prevValue']) ? $logsArr['template_text'][0]['prevValue'] : '' ;
            $templateTextNew = !empty($logsArr['template_text'][0]['value']) ? $logsArr['template_text'][0]['value'] : '' ;
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

            if(!empty($getdata)){
                $sendBy = !empty($getdata->send_by) ? ucfirst($getdata->send_by[0])."N" : '' ;
                $id = str_pad($getdata->id, 2, "0",STR_PAD_LEFT);
                $noticeId = "{$sendBy}{$id}";
                if($getdata->notice_id !== $noticeId){
                        $model->whereId($getdata->id)->first()?->update(['notice_id' => $noticeId], ['timestamps' => false]);
                }
            }



            $name = $getdata?->name ?? "";
            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.notice_template.add',['name'=>$name]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.notice_template.edit',['name'=>$name])." ".$logsmsg;
                }
            }

            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type'=>'notice-templates','onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->id,'message'=>$msg,'old_value'=>$templateTextOld,'new_value'=>$templateTextNew]);
            if($saveOption === "save_and_reset"){
                $array['id'] =  $getdata?->id;
                unset($array['save_and_reset']);
                AllDataBaseUpdate::allDataSave($model,"noticeTemplates",$array,$id);
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
        $search = isset($array['search']) ? $array['search'] : null;
        $id = isset($array['id']) ? $array['id'] : null;


        $model = new self;
         if(GateAllow('isAdminCompany')){
             $model = $model->on('company_mysql');
         }

        if(!empty($search)){
            $model = $model->where(function ($query) use ($search) {
                $query->whereLike('name', $search)
                ->orwhereLike("notice_id",$search)
                ->orwhereLike("description",$search)
                ->orwhereLike("send_to",$search)
                ->orwhereLike("template_type",$search)
                ->orwhereLike("send_by",$search);
            });
        }
        if(!empty($type)){
            $type = Str::replaceFirst('-', '_', $type);
            $type = Str::ucfirst($type);
            $model = $model->whereEncrypted('send_to',$type);
        }
        if(!empty($noticeType)){
            $noticeType = Str::lower($noticeType);
            $model = $model->whereEncrypted('send_by',$noticeType);
        }
        if(!empty($action)){
            $model = $model->whereEncrypted('action',$action);
        }
        if(isset($array['status'])){
            $model = $model->where('status',$array['status']);
        }
        if(isset($array['templateType'])){
            $model = $model->whereEn('template_type',$array['templateType']);
        }
        if(!empty($id)){
            $model = $model->decrypt($id);
        }
        return $model;
    }


}
