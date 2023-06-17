<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error;
use App\Traits\ModelAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class StateSettingsTwo extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ['state_settings_id',
        'max_setup_fee',
        'comm_max_setup_fee',
        'percentage_late_fee',
        'late_fee',
        'percentage_comm_late_fee',
        'comm_late_fee',
        'percentage_minimum_late_fee',
        'minimum_late_fee',
        'percentage_comm_minimum_late_fee',
        'percentage_maximum_late_fee',
        'maximum_late_fee',
        'percentage_comm_maximum_late_fee',
        'comm_maximum_late_fee',
        'day_before_late_fee',
        'comm_day_before_late_fee',
        'cancellation_fee',
        'comm_cancellation_fee',
        'percentage_fee_credit_card',
        'fee_credit_card',
        'percentage_comm_fee_credit_card',
        'comm_fee_credit_card',
        'percentage_check_credit_card',
        'check_credit_card',
        'percentage_comm_check_credit_card',
        'comm_check_credit_card',
        'percentage_recurring_credit_card',
        'recurring_credit_card',
        'percentage_comm_recurring_credit_card',
        'comm_recurring_credit_card',
        'percentage_recurring_credit_card_check',
        'recurring_credit_card_check',
        'percentage_comm_recurring_credit_card_check',
        'comm_recurring_credit_card_check',
        'agent_rebates',
        'comm_agent_rebates',
        'policies_short_rate',
        'comm_policies_short_rate',
        'comm_minimum_late_fee','late_fee_lesser_greater','late_fee_lesser_greater_comm'
    ];


    protected $encryptable =[
        'max_setup_fee',
                'comm_max_setup_fee',
                'percentage_late_fee','late_fee_lesser_greater','late_fee_lesser_greater_comm',
                'late_fee',
                'percentage_comm_late_fee',
                'comm_late_fee',
                'percentage_minimum_late_fee',
                'minimum_late_fee',
                'percentage_comm_minimum_late_fee',
                'percentage_maximum_late_fee',
                'maximum_late_fee',
                'percentage_comm_maximum_late_fee',
                'comm_maximum_late_fee',
                'day_before_late_fee',
                'comm_day_before_late_fee',
                'cancellation_fee',
                'comm_cancellation_fee',
                'percentage_fee_credit_card',
                'fee_credit_card',
                'percentage_comm_fee_credit_card',
                'comm_fee_credit_card',
                'percentage_check_credit_card',
                'check_credit_card',
                'percentage_comm_check_credit_card',
                'comm_check_credit_card',
                'percentage_recurring_credit_card',
                'recurring_credit_card',
                'percentage_comm_recurring_credit_card',
                'comm_recurring_credit_card',
                'percentage_recurring_credit_card_check',
                'recurring_credit_card_check','percentage_comm_recurring_credit_card_check','comm_recurring_credit_card_check', 'agent_rebates','comm_agent_rebates', 'policies_short_rate','comm_policies_short_rate','comm_minimum_late_fee',
    ];



     public static function insertOrUpdate(array $array){

        $id                                             = !empty($array['id']) ? $array['id'] : '' ;
        $state_settings_id                              = !empty($array['state_settings_id']) ? $array['state_settings_id'] : '' ;
        $max_setup_fee                                  = !empty($array['max_setup_fee']) ? $array['max_setup_fee'] : '' ;
        $comm_max_setup_fee                             = !empty($array['comm_max_setup_fee']) ? $array['comm_max_setup_fee']: '' ;
        $percentage_late_fee                            = !empty($array['percentage_late_fee']) ? replaceIntvalues($array['percentage_late_fee']) : '' ;
        $late_fee                                       = !empty($array['late_fee']) ? replaceIntvalues($array['late_fee']) : '' ;
        $percentage_comm_late_fee                       = !empty($array['percentage_comm_late_fee']) ? replaceIntvalues($array['percentage_comm_late_fee']) : '' ;
        $comm_late_fee                                  = !empty($array['comm_late_fee']) ? replaceIntvalues($array['comm_late_fee']) : '' ;
        $percentage_minimum_late_fee                    = !empty($array['percentage_minimum_late_fee']) ? replaceIntvalues($array['percentage_minimum_late_fee']) : '' ;
        $minimum_late_fee                               = !empty($array['minimum_late_fee']) ? replaceIntvalues($array['minimum_late_fee']) : '' ;
        $percentage_comm_minimum_late_fee               = !empty($array['percentage_comm_minimum_late_fee']) ? replaceIntvalues($array['percentage_comm_minimum_late_fee']) : '' ;
        $comm_minimum_late_fee                          = !empty($array['comm_minimum_late_fee']) ? replaceIntvalues($array['comm_minimum_late_fee']) : '' ;
        $percentage_maximum_late_fee                    = !empty($array['percentage_maximum_late_fee']) ? replaceIntvalues($array['percentage_maximum_late_fee']) : '' ;
        $maximum_late_fee                               = !empty($array['maximum_late_fee']) ? replaceIntvalues($array['maximum_late_fee']) : '' ;
        $percentage_comm_maximum_late_fee               = !empty($array['percentage_comm_maximum_late_fee']) ? replaceIntvalues($array['percentage_comm_maximum_late_fee']) : '' ;
        $comm_maximum_late_fee                          = !empty($array['comm_maximum_late_fee']) ? replaceIntvalues($array['comm_maximum_late_fee']) : '' ;
        $day_before_late_fee                            = !empty($array['day_before_late_fee']) ? replaceIntvalues($array['day_before_late_fee']) : '' ;
        $comm_day_before_late_fee                       = !empty($array['comm_day_before_late_fee']) ? replaceIntvalues($array['comm_day_before_late_fee']) : '' ;
        $cancellation_fee                               = !empty($array['cancellation_fee']) ? replaceIntvalues($array['cancellation_fee']) : '' ;
        $comm_cancellation_fee                          = !empty($array['comm_cancellation_fee']) ? replaceIntvalues($array['comm_cancellation_fee']) : '' ;
        $percentage_fee_credit_card                     = !empty($array['percentage_fee_credit_card']) ? replaceIntvalues($array['percentage_fee_credit_card']) : '' ;
        $fee_credit_card                                = !empty($array['fee_credit_card']) ? replaceIntvalues($array['fee_credit_card']) : '' ;
        $percentage_comm_fee_credit_card                = !empty($array['percentage_comm_fee_credit_card']) ? replaceIntvalues($array['percentage_comm_fee_credit_card']) : '' ;
        $comm_fee_credit_card                           = !empty($array['comm_fee_credit_card']) ? replaceIntvalues($array['comm_fee_credit_card']) : '' ;
        $percentage_check_credit_card                   = !empty($array['percentage_check_credit_card']) ? replaceIntvalues($array['percentage_check_credit_card']) : '' ;
        $check_credit_card                              = !empty($array['check_credit_card']) ? replaceIntvalues($array['check_credit_card']) : '' ;
        $percentage_comm_check_credit_card              = !empty($array['percentage_comm_check_credit_card']) ? replaceIntvalues($array['percentage_comm_check_credit_card']) : '' ;
        $comm_check_credit_card                         = !empty($array['comm_check_credit_card']) ? replaceIntvalues($array['comm_check_credit_card']) : '' ;
        $percentage_recurring_credit_card               = !empty($array['percentage_recurring_credit_card']) ? replaceIntvalues($array['percentage_recurring_credit_card']) : '' ;
        $recurring_credit_card                          = !empty($array['recurring_credit_card']) ? replaceIntvalues($array['recurring_credit_card']) : '' ;
        $percentage_comm_recurring_credit_card          = !empty($array['percentage_comm_recurring_credit_card']) ? replaceIntvalues($array['percentage_comm_recurring_credit_card']) : '' ;
        $comm_recurring_credit_card                     = !empty($array['comm_recurring_credit_card']) ? replaceIntvalues($array['comm_recurring_credit_card']) : '' ;
        $percentage_recurring_credit_card_check         = !empty($array['percentage_recurring_credit_card_check']) ? replaceIntvalues($array['percentage_recurring_credit_card_check']) : '' ;
        $recurring_credit_card_check                    = !empty($array['recurring_credit_card_check']) ? replaceIntvalues($array['recurring_credit_card_check']) : '' ;
        $percentage_comm_recurring_credit_card_check    = !empty($array['percentage_comm_recurring_credit_card_check']) ? replaceIntvalues($array['percentage_comm_recurring_credit_card_check']) : '' ;
        $comm_recurring_credit_card_check               = !empty($array['comm_recurring_credit_card_check']) ? replaceIntvalues($array['comm_recurring_credit_card_check']) : '' ;
        $agent_rebates                                  = !empty($array['agent_rebates']) ? $array['agent_rebates'] : '' ;
        $comm_agent_rebates                             = !empty($array['comm_agent_rebates']) ? $array['comm_agent_rebates'] : '' ;
        $policies_short_rate                            = !empty($array['policies_short_rate']) ? $array['policies_short_rate'] : '' ;
        $comm_policies_short_rate                       = !empty($array['comm_policies_short_rate']) ? $array['comm_policies_short_rate'] : '' ;
        $parent_id                               = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB                                    = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId                                = !empty($array['parentId']) ? $array['parentId'] : null ;

        $inserArr = [
            'state_settings_id'                         =>$state_settings_id,
            'max_setup_fee'                             =>$max_setup_fee,
            'comm_max_setup_fee'                        =>$comm_max_setup_fee,
            'percentage_late_fee'                       =>$percentage_late_fee,
            'late_fee'                                  =>$late_fee,
            'percentage_comm_late_fee'                  =>$percentage_comm_late_fee,
            'comm_late_fee'                             =>$comm_late_fee,
            'percentage_minimum_late_fee'               =>$percentage_minimum_late_fee,
            'minimum_late_fee'                          =>$minimum_late_fee,
            'percentage_comm_minimum_late_fee'          =>$percentage_comm_minimum_late_fee,
            'comm_minimum_late_fee'                     =>$comm_minimum_late_fee,
            'percentage_maximum_late_fee'               =>$percentage_maximum_late_fee,
            'maximum_late_fee'                          =>$maximum_late_fee,
            'percentage_comm_maximum_late_fee'          =>$percentage_comm_maximum_late_fee,
            'comm_maximum_late_fee'                     =>$comm_maximum_late_fee,
            'day_before_late_fee'                       =>$day_before_late_fee,
            'comm_day_before_late_fee'                  =>$comm_day_before_late_fee,
            'cancellation_fee'                          =>$cancellation_fee,
            'comm_cancellation_fee'                     =>$comm_cancellation_fee,
            'percentage_fee_credit_card'                =>$percentage_fee_credit_card,
            'fee_credit_card'                           =>$fee_credit_card,
            'percentage_comm_fee_credit_card'           =>$percentage_comm_fee_credit_card,
            'comm_fee_credit_card'                      =>$comm_fee_credit_card,
            'percentage_check_credit_card'              =>$percentage_check_credit_card,
            'check_credit_card'                         =>$check_credit_card,
            'percentage_comm_check_credit_card'         =>$percentage_comm_check_credit_card,
            'comm_check_credit_card'                    =>$comm_check_credit_card,
            'percentage_recurring_credit_card'          =>$percentage_recurring_credit_card,
            'recurring_credit_card'                     =>$recurring_credit_card,
            'percentage_comm_recurring_credit_card'     =>$percentage_comm_recurring_credit_card,
            'comm_recurring_credit_card'                =>$comm_recurring_credit_card,
            'percentage_recurring_credit_card_check'    =>$percentage_recurring_credit_card_check,
            'recurring_credit_card_check'               =>$recurring_credit_card_check,
            'percentage_comm_recurring_credit_card_check'  =>$percentage_comm_recurring_credit_card_check,
            'comm_recurring_credit_card_check'             =>$comm_recurring_credit_card_check,
            'agent_rebates'                                =>$agent_rebates,
            'comm_agent_rebates'                           =>$comm_agent_rebates,
            'policies_short_rate'                          =>$policies_short_rate,
            'comm_policies_short_rate'                     =>$comm_policies_short_rate,

       ];

        $model  = new self;
        if(GateAllow('isAdminCompany') || !empty($onDB)){
        $model = $model->on('company_mysql');
        }

         DB::beginTransaction();
        try {
            if(!empty($id)){
                $inserArr = array_filter($inserArr);
                $data     = $model->updateOrCreate(['state_settings_id'=>$id],$inserArr);
            }else{
                $data  = $model->create($inserArr);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }
        DB::commit();
        return $data;

    }

    public static function getData(array $array=null){
     $model = new self;
     if(GateAllow('isAdminCompany')){
        $model = $model->on('company_mysql');
     }
     return $model;
     }

}
