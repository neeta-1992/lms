<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Str,Arr;
use App\Models\{
    Logs,Entity
};
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class Funding extends Model
{
    use HasFactory;
    use ModelAttribute;
    ///use EncryptedAttribute;
    protected $fillable = [
        'entity_id','remittance_paid',
        'financial_institution_name','routing_number','account_number','remittance_schedule',
        'funding_address_checkbox','hold_all_payables','general_default','deposit_default',
        'deposit_credit_card','deposit_eCheck','remittance_default','remittance_check','remittance_draft',
        'days_after_policy_inception_text','days_after_1st_payment_due_date_text','funding_address',
        'funding_address_second','funding_city','funding_state',
        'uneamed_compensation','compensation_pay_using',
        'compensation_financial_institution_name','compensation_routing_number','compensation_account_number',
        'compensation_remittance_schedule','compensation_days_after_policy_inception_text',
        'compensation_days_after_1st_payment_due_date_text','products_paid_using','products_financial_institution_name',
        'products_routing_number','products_account_number','refund_check_to','refund_check_payable'
    ];


    //protected $encryptable = ['user_id','name','account_type','account_active','cancel_terms'];

    /**
     * Get the entity that owns the Funding
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
    }



    public static function insertOrUpdate(array $array){

        $id                 = !empty($array['id']) ? $array['id'] : '' ;
        $entityId           = !empty($array['entity_id']) ? $array['entity_id'] : null ;
        $user_id            = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson            = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId              = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $saveOption         = !empty($array['save_option']) ? $array['save_option'] : null ;
        $parent_id          = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB               = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId           = !empty($array['parentId']) ? $array['parentId'] : null ;
        $activePage         = !empty($array['activePage']) ? $array['activePage'] : null ;
        $titleArr           = !empty($array['titleArr']) ? json_decode ( $array['titleArr'],true) : null ;
        $exceptArr              = ["id",'company_data','activePage','lang','onDB','logId','logsArr','_token','pageTitle','user_type','owner','insurance'];
        $insurance              = !empty($array['insurance']) ? $array['insurance'] : '';
        $json                   = !empty($insurance) ? json_encode($insurance) : null;
        $inserArr               = Arr::except($array,$exceptArr);
        $inserArr['user_id']    = $user_id;





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

                    $getdata = $model->updateOrCreate(['entity_id'=>$id],$inserArr);
                }
            }else{
                $getdata  =  $model->create($inserArr);
            }


            $name = $getdata?->entity?->name ?? "";

            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.entity_funding_settings.add',['entity_name '=>$name]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.entity_funding_settings.edit',['entity_name '=>$name])." ".$logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->entity_id,'message'=>$msg]);
            if($saveOption === "save_and_reset"){
                $array['id'] =  $getdata?->id;
                unset($array['save_and_reset']);
                AllDataBaseUpdate::allDataSave($model,"insuranceCompany",$array,$id);
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


        if(!empty($array['eId'])){
            $model = $model->where('entity_id',$array['eId']);
        }
        return $model;
    }
}
