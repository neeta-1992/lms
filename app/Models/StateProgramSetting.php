<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,StateProgramSettingOverride
};
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class StateProgramSetting extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ['user_id','name','status'];
    protected $encryptable = ['name'];





    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $name            = isset($array['name']) ? $array['name'] : null;
        $status          = isset($array['status']) ? $array['status'] : 0;
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
            'user_id'        =>$user_id,
        ];

        if(!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }
        $StateProgramSettingOverrideModels = new StateProgramSettingOverride();

        $logsmsg = "";
        if(!empty($logJson)){
            $logsArr  = $logJson;
            $logsArr =Arr::except($logsArr,$StateProgramSettingOverrideModels?->getFillable());
           /*  dd($logsArr); */
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


            $name = $getdata?->name ?? "";$msg="";
            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.state_program_settings.add',['name'=>$name]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.state_program_settings.edit',['name'=>$name])." ".$logsmsg;
                }
            }

             if (!empty($id) && !empty($array['override_settings'])) {
                $array['state_program_id'] = $getdata?->id;
                $array['logId'] = $getdata?->id;
                $array['activePage'] = $activePage;
                $StateProgramSettingOverride = $StateProgramSettingOverrideModels::insertOrUpdate($array);

                if ($StateProgramSettingOverride->wasRecentlyCreated == true) {
                    $pageTitle = Overridesettings($array['override_settings']);
                    $msg .= "<li>".__('logs.state_program_settings.override_setting_add',['name'=>$pageTitle])."</li>";
                } else {
                    $msg .= self::stateProgramLogs($StateProgramSettingOverride);
                }
            }
            /*
             * Logs Save In @Log Model
             */
            /* dd($msg); */
            if(!empty($msg)){
                Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->id,'message'=>$msg]);
            }
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


    public static function stateProgramLogs($logs){
        $lables = [
            'override_settings' => 'Override settings',
            'assigned_territory' => "Assigned Territory",
            'assigned_states'   => "Assigned States",
            'value' => "Value",
        ];
        $msg = $and = "";
        $changesArr = $logs?->changesArr ?? [];
        if (!empty($changesArr)) {
            foreach ($changesArr as $key => $logValue) {

                $old = !empty($logValue['old']) ? $logValue['old'] : '';
                $new = !empty($logValue['new']) ? $logValue['new'] : '';
                $title = isset($lables[$key]) ? $lables[$key] : '' ;
                if (!empty($old) && !empty($new)) {
                    $msgTitle = "<li> {$title} was changed from <b>{$old}</b> to <b>{$new}</b> </li>";
                } elseif (empty($old)) {
                    $msgTitle = "<li> {$title} was updated <b>{$new}</b> </li>";
                } else {
                    $msgTitle = "<li> {$title} was changed from <b>{$old}</b> to <b>None</b> </li>";
                }

                $msg .=  removeWhiteSpace($msgTitle);

            }
        }
        return $msg;

    }

    public static function getData(array $array=null){

     $model = new self;
     if(GateAllow('isAdminCompany')){

        $model = $model->on('company_mysql');
     }
     return $model;
     }
}
