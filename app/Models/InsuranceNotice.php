<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class InsuranceNotice extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = ['user_id','json','status','entity_id','default_email_notices','default_fax_notices','default_mail_notices'];
    protected $encryptable = ['json'];


    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $type            = !empty($array['type']) ? $array['type'] : '' ;
        $send_to         = !empty($array['send_to']) ? $array['send_to'] : '' ;
        $option          = !empty($array['option']) ? $array['option'] : '' ;
        $status          = !empty($array['status']) ? $array['status'] : null ;
        $user_id         = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : null ;
        $parent_id       = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null ;
        $entity_id       = !empty($array['entity_id']) ? $array['entity_id'] : 0 ;
        $logsTypeId = !empty($array['logsTypeId']) ? $array['logsTypeId'] : 0 ;
        $default_email_notices = !empty($array['default_email_notices']) ? $array['default_email_notices'] : 0 ;
        $default_fax_notices = !empty($array['default_fax_notices']) ? $array['default_fax_notices'] : 0 ;
        $default_mail_notices = !empty($array['default_mail_notices']) ? $array['default_mail_notices'] : null ;
        $titleArr        = !empty( $array['titleArr']) ? json_decode ( $array['titleArr'],true) : null ;

        $model  = new self;
        if(GateAllow('isAdminCompany') || !empty($onDB)){
        $model = $model->on('company_mysql');
        }

        $inserArr = $jsonArr = $notice = [];
        if (!empty($send_to)) {
            foreach ($send_to as $keyTo => $val) {
                $jsonArr[$keyTo] = [
                    "description" => $keyTo,
                    "send_type" => (!empty($option[$keyTo]) ? $option[$keyTo] : ''),
                    "send_to" => $val,
                ];
            }
        }

        $json = !empty($jsonArr) ? json_encode($jsonArr) : null;
        if (!empty($type)) {
            foreach ($type as $key => $value) {
                $frequency = !empty($array[$value]['frequency']) ? implode(",",$array[$value]['frequency']) : '';
                $cancelDay = !empty($array[$value]['cancel_days']) ? $array[$value]['cancel_days'] : 0;
                $noticeArr[$value] = [
                    "notice_type" => $value,
                    "frequency" => $frequency,
                    "cancel_days" => $cancelDay,
                ];
            }
        }

       /*  $noticeArr['description'] = $jsonArr;
        $preData = $model->whereUserId($user_id)->first()?->toArray();
        $preDataJosn = !empty($preData['json']) ? json_decode($preData['json'],true) : [] ;
        $preDataJosn['description'] = !empty($preDataJosn['description']) ? json_decode($preDataJosn['description'],true) : '' ;
        foreach ($noticeArr['description'] as $k1 => $v1) {
            if (array_diff($preDataJosn['description'][$k1], $noticeArr['description'][$k1])){
            $update_items[$k1] = array_diff($preDataJosn['description'][$k1], $noticeArr['description'][$k1]);
            }
        }
        dd($update_items); */

        $noticeArr['description'] = $json;
        $noticeJosn = !empty($noticeArr) ? json_encode($noticeArr,true) : null;
        $inserArr['user_id'] = $user_id;
        $inserArr['status'] = 1;
        $inserArr['entity_id'] =$entity_id;
        $inserArr['default_email_notices'] =$default_email_notices;
        $inserArr['default_fax_notices'] =$default_fax_notices;
        $inserArr['default_mail_notices'] =$default_mail_notices;
        $inserArr['json'] = $noticeJosn;


        if(!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }
        $logsmsg = "";
        if(!empty($logJson)){
            $logsArr = $logJson;
            $logsmsg = dbLogFormat($logsArr);
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
                $getdata = $model->create($inserArr);
            }


            $name = $getdata?->name ?? "";
            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.notices.add',['name'=>"General Agent Notices"]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.notices.edit',['name'=>$name])." ".$logsmsg;
                }
            }
            $logsTypeId = !empty($logsTypeId) ? $logsTypeId : $getdata->id ;
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) &&
            Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=> $logsTypeId ,'message'=>$msg]);
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

    public static function getData(array $array=null){

    $model = new self;
    if(GateAllow('isAdminCompany')){
    $model = $model->on('company_mysql');
    }
    return $model;
    }
}
