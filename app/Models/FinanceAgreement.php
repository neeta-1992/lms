<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class FinanceAgreement extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ['user_id','name','description','template','status'];
    protected $encryptable = ['name','description'];



    public static function insertOrUpdate(array $array){
        $logsmsg = "";
        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $name            = !empty($array['name']) ? $array['name'] : '' ;
        $description     = !empty($array['description']) ? $array['description'] : null ;
        $template        = !empty($array['template']) ? $array['template'] : null ;
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
            'description'   =>$description,
            'template'      =>$template,
            'status'        =>$status,
        ];

        if(!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }

        $templateTextOld = $templateTextNew="";
        if(!empty($logJson)){
            $logsArr = $logJson;
            $templateTextOld = !empty($logsArr['template'][0]['prevValue']) ? $logsArr['template'][0]['prevValue'] : '' ;
            $templateTextNew = !empty($logsArr['template'][0]['value']) ? $logsArr['template'][0]['value'] : '' ;
            $logsmsg    = dbLogFormat($logsArr);
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


            $name = $getdata?->name ?? "";
            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.finance_agreement.add',['name'=>$name]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.finance_agreement.edit',['name'=>$name])." ".$logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type'=>'finance-agreement','onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->id,'message'=>$msg,'old_value'=>$templateTextOld,'new_value'=>$templateTextNew]);
            if($saveOption === "save_and_reset"){
                $array['id'] =  $getdata?->id;
                unset($array['save_and_reset']);
                AllDataBaseUpdate::allDataSave($model,"financeAgreement",$array,$id);
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
