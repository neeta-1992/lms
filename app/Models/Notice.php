<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error;
use App\Models\{
    Logs,Entity
};
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class Notice extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = ['user_id','type','json','status','entity_id','default_email_notices','default_fax_notices','default_mail_notices'];
    protected $encryptable = ['json','type'];

    /**
     * Get the entity that owns the Notice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
    }


    public static function insertOrUpdate(array $array){
        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $type            = !empty($array['type']) ? $array['type'] : '' ;
        $send_to         = !empty($array['send_to']) ? $array['send_to'] : '' ;
        $option          = !empty($array['option']) ? $array['option'] : '' ;
        $status          = !empty($array['status']) ? $array['status'] : null ;
        $user_id         = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $title           = !empty($array['title']) ? $array['title'] : '';
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null ;
        $noticeType      = !empty($array['noticeType']) ? $array['noticeType'] : $activePage ;
        $entityId        = !empty($array['entity_id']) ? $array['entity_id'] : 0 ;
        $logsTypeId      = !empty($array['logsTypeId']) ? $array['logsTypeId'] : 0 ;
        $defEmailNotices = !empty($array['default_email_notices']) ? $array['default_email_notices'] : 0 ;
        $defFaxNotices   = !empty($array['default_fax_notices']) ? $array['default_fax_notices'] : 0 ;
        $defMailNotices  = !empty($array['default_mail_notices']) ? $array['default_mail_notices'] : null ;

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



        $noticeArr['description'] = $json;
        $noticeJosn = !empty($noticeArr) ? json_encode($noticeArr,true) : null;
        $inserArr['user_id'] = $user_id;
        $inserArr['status']  = 1;
        $inserArr['entity_id'] =$entityId;
        $inserArr['default_email_notices'] =$defEmailNotices;
        $inserArr['default_fax_notices'] =$defFaxNotices;
        $inserArr['default_mail_notices'] =$defMailNotices;
        $inserArr['json'] = $noticeJosn;
        $inserArr['type'] = $noticeType;



        $logsmsg = "";
        if(!empty($logJson)){
            $logsArr = $logJson;
            $logsmsg = dbLogFormat($logsArr);
        }

        DB::beginTransaction();
        try {
           if(!empty($id)){
                $inserArr  = arrFilter($inserArr);
                $getdata     = $model->updateOrCreate(['id'=>$id],$inserArr);
            }else{
                $getdata = $model->create($inserArr);
            }


            $title = !empty($getdata?->entity->name) ? $getdata?->entity->name : $title;

            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.notices.add',['name'=>$title]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.notices.edit',['name'=>$title])." ".$logsmsg;
                }
            }
            $logsTypeId = !empty($logsTypeId) ? $logsTypeId : $getdata->id ;
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) &&
            Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=> $logsTypeId ,'message'=>$msg]);
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }

    public static function getData(array $array){
        $type       = isset($array['type']) ? $array['type'] : null;
        $userId     = isset($array['userId']) ? $array['userId'] : auth()->user()->id;
        $entityId   = isset($array['entityId']) ? $array['entityId'] : null;
        $id         = isset($array['id']) ? $array['id'] : null;


        $model =  new self;
          if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }
        if(!empty($type)){
            $model = $model->whereEncrypted('type',$type);
        }
       /*  if(!empty($userId)){
            $model = $model->whereUserId($userId);
        } */
        if(!empty($entityId)){
            $model = $model->whereEntityId($entityId);
        }
        if(!empty($id)){
            $model = $model->decrypt($id);
        }
        return $model;
    }
}
