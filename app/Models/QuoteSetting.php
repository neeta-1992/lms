<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Str,Arr;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class QuoteSetting extends Model
{
    use HasFactory;
    use ModelAttribute;
   // use EncryptedAttribute;

    protected $fillable = [
        'user_id','loan_origination_state','line_business','policy_minium_earned_percent','until_first_payment','first_due_date',
        'new_quote_expiration','renewal_quote_expiration','payment_type_commercial','payment_type_personal','stamp_fees',
        'doc_stamp_fees','down_percent','quick_quote','ofac_compliance','billing_schedule','quote_type','email_notification','personal_maximum_finance_amount',
        'commercial_maximum_finance_amount','short_rate','require_insured_phone','proprietor_require','puc_filings','auditable',
        'personal_lines','coupon_payment','credit_card_payment','ach_payment','request_activation','quote_activation',
        'broker_field','policy_fee_commercial','policy_fee_personal','unearned_fees','tax_stamp_commercial','tax_stamp_personal',
        'broker_fee_commercial','broker_fee_personal','inspection_fee_commercial','inspection_fee_personal',
        'calculating_agency','insured_existing_balance','first_due_dates','bank_risk_rating',
        'limit_company','recourse_amount','ap_interest','ap_endorsement',
        'endorsement_setup_fee','agency_name_sig','salesexecs','ach_receipt',
        'payment_schedule','add_products','company_tax_validation','agent_rate_table',
        'view_quote_exposure','view_agent_compensation','patriot_message','e_signature',
        'ofac_url','accuity_client','accuity_service_url','warning_inception_date',
        'warning_first_due_date','warning_first_due_date_number','text_signature',
    ];
  //  protected $encryptable = ['subject','notice_id','name','send_to','action','send_by','template_type','description'];




    public static function insertOrUpdate(array $array){
        $logsmsg = "";
        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $user_id         = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $status          = !empty($array['status']) ? $array['status'] : 0 ;
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : 0 ;
        $billing_schedule = !empty($array['billing_schedule']) ? implode(",",$array['billing_schedule']) : null ;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : "quote_settings" ;
        $exceptArr      = ["id","company_data",'activePage','onDB','logId','logsArr','_token'];
        $array['billing_schedule'] = $billing_schedule;
        $array['user_id'] = $user_id;

        $inserArr = Arr::except($array,$exceptArr);

        if(!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }

        $templateTextOld = $templateTextNew="";
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
                $msg = __("logs.{$activePage}.add");
            }else{
                if(!empty($logsmsg)){
                    $msg = __("logs.{$activePage}.edit",['name'=>$name])." ".$logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->id,'message'=>$msg,'old_value'=>$templateTextOld,'new_value'=>$templateTextNew]);
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
        $userId = !empty($array['user_id']) ? $array['user_id'] : '';


        $model = new self;
        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }
        if(!empty($userId)){
            $model = $model->where('user_id',$userId);
        }

        if(!empty($id)){
            $model = $model->decrypt($id);
        }
        return $model;
    }
}
