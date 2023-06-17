<?php

namespace App\Models;

use App\Encryption\Traits\EncryptedAttribute;
use App\Helpers\AllDataBaseUpdate;

use App\Models\Logs;

use App\Models\State;

use App\Models\StateSettingsTwo;
use App\Models\StateSettingInterestRate;
use App\Traits\ModelAttribute;
use DB;use Error;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Arr,Str;
class StateSettings extends Model
{
    use HasUuids;
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ["user_id", "status", "state", "refund_send_check", 'percentage_nsf_fee', 'nsf_fee_lesser_greater',
        "spread_method", "refund_required", "interest_earned_start_date",
        "interest_earned_stop_date", "licensed_personal", "nsf_fees",
        "licensed_commercial", "maximum_charge", "agent_authority", "late_fees",
        "refund_payable", "personal_maximum_finance_amount",
        "commercial_maximum_finance_amount", "minimum_interest",
        "comm_minimum_interest", "maximum_rate", "comm_maximum_rate",
        "maximum_setup_fee", "comm_maximum_setup_fee", "setup_percent",
        "comm_setup_percent", "due_date_intent_cancel", "comm_due_date_intent_cancel",'personal_multiple_maximum_rate','personal_multiple_comm_maximum_rate',
        "intent_cancel", "comm_intent_cancel", "effective_cancel", "comm_effective_cancel",'maximum_comm_setup_fee_lesser_greater',
     'parent_id','percentage_maximum_setup_fee','maximum_setup_fee_lesser_greater','percentage_comm_maximum_setup_fee'
    ];
    protected $encryptable
    = ["refund_send_check", "spread_method", 'percentage_nsf_fee', "refund_required", "interest_earned_start_date", "interest_earned_stop_date", "licensed_personal", "nsf_fees", "licensed_commercial", "maximum_charge", "agent_authority", "late_fees",
        "refund_payable", "personal_maximum_finance_amount", "commercial_maximum_finance_amount", "minimum_interest", "comm_minimum_interest", "maximum_rate", "comm_maximum_rate", "maximum_setup_fee",
        "comm_maximum_setup_fee", "setup_percent", "comm_setup_percent", "due_date_intent_cancel", "comm_due_date_intent_cancel",
        "intent_cancel", "comm_intent_cancel", "effective_cancel", "comm_effective_cancel", 'nsf_fee_lesser_greater'];

    /**
     * Get the state associated with the StateSettings
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stateData()
    {
        return $this->hasOne(State::class, 'id', 'state');
    }

    /**
     * Get the StateSetting that owns the StateSettings
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function StateSetting()
    {
        return $this->belongsTo(StateSettingsTwo::class, 'id', 'state_settings_id');
    }

    public static function insertOrUpdate(array $array)
    {
        $msg = "";
        $status = $array['status'];
        $id = !empty($array['id']) ? $array['id'] : '';
        $user_id = !empty($array['user_id']) ? $array['user_id'] : auth()->user()?->id ?? 0;
        $logsArr = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId = !empty($array['logId']) ? $array['logId'] : $user_id;
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : null;
        $parent_id = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId = !empty($array['parentId']) ? $array['parentId'] : null;
		$personal_multiple_maximum_rate = !empty($array['personal_multiple_maximum_rate']) ? $array['personal_multiple_maximum_rate_table'] : null;
        $personal_multiple_comm_maximum_rate = !empty($array['personal_multiple_comm_maximum_rate_table']) ? $array['personal_multiple_comm_maximum_rate_table'] : null;
        $array['personal_multiple_maximum_rate'] = isset($array['personal_multiple_maximum_rate']) && !empty($array['personal_multiple_maximum_rate']) && !empty($personal_multiple_maximum_rate) ? 1 : 0;
        $array['personal_multiple_comm_maximum_rate'] = isset($array['personal_multiple_comm_maximum_rate']) && !empty($array['personal_multiple_comm_maximum_rate']) && !empty($personal_multiple_comm_maximum_rate) ? 1 : 0;
        $titleArr = !empty($array['titleArr']) ? json_decode($array['titleArr'], true) : null;


        $model    = new self; //Load Model
        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['user_id'] = $user_id;
       // dd($inserArr);
     
        if (!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }
        $logsmsg = "";
        if (!empty($logsArr)) {
            $logsmsg = dbLogFormat($logsArr);
        }
    /*  dd( $logsmsg);  */
        $model = new self;
        if (GateAllow('isAdminCompany') || !empty($onDB)) {
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
            if (!empty($id) || !empty($parentId)) {
                $inserArr = arrFilter($inserArr);
                if (!empty($parentId)) {
                    $getdata = $model->updateOrCreate(['parent_id' => $parentId], $inserArr);
                    $getChanges = $getdata?->changesArr;
                  
                } else {
                    $getdata = $model->updateOrCreate(['id' => $id], $inserArr);
                }
            } else {
                $getdata = $model->create($inserArr);
            }

            $array['id'] = $getdata?->id;
            $array['state_settings_id'] = $getdata?->id;
            $state_settings2 = StateSettingsTwo::insertOrUpdate($array);
          
           
            if(!empty($personal_multiple_maximum_rate) && isset($array['personal_multiple_maximum_rate']) && !empty($array['personal_multiple_maximum_rate'])){
                $personal_multiple_maximum_rate_save =  self::stateSettingFeeInsertOrUpdate($personal_multiple_maximum_rate,$getdata?->id,$array);
                $logs = !empty($personal_multiple_maximum_rate_save->logs) ? $personal_multiple_maximum_rate_save->logs : '';
                $msg .= $logs;
            }else{
				$deleteRowData = StateSettingInterestRate::getData()->where('state_setting_id',$array['state_settings_id'])->where('type','personal_multiple_maximum_rate')->get()?->toArray();
                if(!empty($deleteRowData)){
					foreach($deleteRowData as $deleteRow){
						$id             = decryptData($deleteRow['id']);
						$deleteRowData  = StateSettingInterestRate::getData(['id'=>$id])->first();
						$deleteRowData->forceDelete();
					}
                }
			} 
          /*   dd($array);  */
            if(!empty($personal_multiple_comm_maximum_rate) && isset($array['personal_multiple_comm_maximum_rate']) && !empty($array['personal_multiple_comm_maximum_rate'])){
                
                $personal_multiple_comm_maximum_rate_save =  self::stateSettingFeeInsertOrUpdate($personal_multiple_comm_maximum_rate,$getdata?->id,$array);
                $logs = !empty($personal_multiple_comm_maximum_rate_save->logs) ? $personal_multiple_comm_maximum_rate_save->logs : '';
                $msg .= $logs;
            }else{
				$deleteRowData = StateSettingInterestRate::getData()->where('state_setting_id',$array['state_settings_id'])->where('type','personal_multiple_comm_maximum_rate')->get()?->toArray();
                if(!empty($deleteRowData)){
					foreach($deleteRowData as $deleteRow){
						$id             = decryptData($deleteRow['id']);
						$deleteRowData = StateSettingInterestRate::getData(['id'=>$id])->first();
						$deleteRowData->forceDelete();
					}
                }
			} 
           
            /* dd($personal_multiple_comm_maximum_rate); */
            $name = !empty($getdata?->stateData?->toArray()['state']) ? $getdata?->stateData?->toArray()['state'] : '';
            if ($getdata->wasRecentlyCreated == true) {
                $msg = __('logs.state_setting.add', ['name' => $name]);
            } else {
                if (!empty($logsmsg)) {
                    $msg = __('logs.state_setting.edit', ['name' => $name]) . " " . $logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type' => 'state-setting', 'onDB' => $onDB, 'user_id' => $user_id, 'type_id' => $getdata->id, 'message' => $msg]);
            if ($saveOption === "save_and_reset") {
                $array['id'] = $getdata?->id;
                AllDataBaseUpdate::allDataSave($model, "stateSetting", $array, $id);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;

    }


    
    private static function stateSettingFeeInsertOrUpdate(array $stateSetting = null, $state_setting_id = 0, $arrayInput=null)
    {
        if (empty($stateSetting)) {
            return;
        }
        $msg = "";
        $interestRateType       = isset($stateSetting['interest_rate_type']) ? $stateSetting['interest_rate_type'] : '';
        $from       = isset($stateSetting['from']) ? $stateSetting['from'] : '';

        if (!empty($from)) {
            $titleArr = [
               'personal_multiple_maximum_rate' => 'Personal Account Maximum Finance Amount',
               'personal_multiple_comm_maximum_rate' => 'Commercial Account Maximum Finance Amount',
            ];
            $titleMain = isset($titleArr[$interestRateType]) ? $titleArr[$interestRateType] : '';
         /*    dd(  $titleMain); */
            foreach ($from as $key => $value) {
                $fromVal        = !empty($value) ? $value : 0;
                $id             = !empty($stateSetting['feeId'][$key]) ? ($stateSetting['feeId'][$key]) : 0;
                $toVal          = !empty($stateSetting['to'][$key]) ? $stateSetting['to'][$key] : 0;
                $rateVal        = !empty($stateSetting['rate'][$key]) ? $stateSetting['rate'][$key] : 0;
                $array = [
                    "feeId"        => $id,
                    "state_setting_id" => $state_setting_id,
                    "from"  => $fromVal,
                    "to"    => $toVal,
                    "rate"  => $rateVal,
                    "type"  => $interestRateType,
                ];

          
             
                $getdatastateSettingFee = StateSettingInterestRate::insertOrUpdate($array);
                // dd($getdatastateSettingFee);
                if ($getdatastateSettingFee->wasRecentlyCreated == true) {
                    
                    $msg .=  "<li>".__('logs.state_setting.fee_add', ['name' => $titleMain, 'from' => '<b> $' . $fromVal . '</b>', 'to' => '<b> $' . $toVal . '</b>'])."</li>";
                } else {
                    $changeArray = $isDoller = $isPercentage = "";
                    if (!empty($getdatastateSettingFee->changesArr)) {
                        $changeArray = $getdatastateSettingFee->changesArr ?? [];
                    }
                
                   
                    if (!empty($changeArray)) {
                        foreach ($changeArray as $key => $logValue) {
                            $isDollerArr =['from', 'to', 'setup_fee'];
                            $isPercentageArr = ['rate'];
                            $old = !empty($logValue['old']) ? $logValue['old'] : '' ;
                            $new = !empty($logValue['new']) ? $logValue['new'] : '' ;
                            if(in_array($key, $isDollerArr)){
                                 $old = !empty($old) ? '$'.number_format($old,2) : '';
                                $new = !empty($new) ? '$'.number_format($new,2) : '';
                            }

                            if(in_array($key, $isPercentageArr)){
                                $old = !empty($old) ? "{$old}%" : '';
                                $new = !empty($new) ? "{$new}%" : '';
                            }
                            $title      = Str::title($key);
                            $msgTitle   = "<li>{$titleMain} {$title} was changed from <b>{$old}</b> to <b>{$new}</b></li>";
                            $msg .= isset($logsArr[$key]) ? "" : removeWhiteSpace($msgTitle);
                        }

                    }

                }

            }

        }
         $deleteRows = !empty($arrayInput['delete_rows']) ? json_decode($arrayInput['delete_rows'],true) : '';
        if(!empty($deleteRows)){
          
            foreach ($deleteRows as $key => $value) {
                $id             = decryptData($value);
                $deleteRowData = StateSettingInterestRate::getData(['id'=>$id])->first();
                if(!empty($deleteRowData)){
                    $dfrom          = !empty($deleteRowData['from']) ? '$'.number_format($deleteRowData['from'],2) : '' ;
                    $dto            = !empty($deleteRowData['to']) ? '$'.number_format($deleteRowData['to'],2) : '' ;
                    $msg .= "<li> {$titleMain}  Range from <b>{$dfrom}</b> To <b>{$dto}</b> was deleted </li>";
                  
                    $deleteRowData->forceDelete();
                }
            }
        };
      /*   dd( $msg ); */
        return (object) ['logs' => $msg];

        //
    }

    public static function getData(array $array = null)
    {
        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }
        return $model;
    }
}
