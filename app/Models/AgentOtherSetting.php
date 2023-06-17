<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
        Logs
};
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class AgentOtherSetting extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;



    protected $fillable = [
        'user_id', 'agency_id', 'down_payment_increase', 'program',
        'loan_origination_state', 'origination_state_override', 'down_payment_rule_original_quoting',
        'down_payment_rule_ap_quoting', 'printing_below_amount_financed', 'printing_above_amount_financed',
        'modify_quote_interest_rate', 'quote_point','quotes_point_user_group','account_point',
        'accounts_point_user_group','marketing_point','marketing_point_user_group','processing_fee_table',
        'email_message_read_only','default_email_subject','email_subject_read_only','agent_signs',
        'insured_signs','require_approval_step','approver_label','default_email_message'
    ];

    protected $encryptable = [
        'down_payment_increase', 'program',
        'loan_origination_state', 'origination_state_override', 'down_payment_rule_original_quoting',
        'down_payment_rule_ap_quoting', 'printing_below_amount_financed', 'printing_above_amount_financed',
        'modify_quote_interest_rate', 'quote_point','quotes_point_user_group','account_point',
        'accounts_point_user_group','marketing_point','marketing_point_user_group','processing_fee_table',
        'email_message_read_only','default_email_subject','email_subject_read_only','agent_signs',
        'insured_signs','require_approval_step','approver_label','default_email_message'
    ];

    public static function insertOrUpdate(array $array)
    {

        $id         = !empty($array['id']) ? $array['id'] : '';
        $entity_id  = !empty($array['entity_id']) ? $array['entity_id'] : '';
         $user_id = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $program = !empty($array['program']) ? json_encode($array['program']) : '';
        $logsArr = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId      = !empty($array['logId']) ? $array['logId'] : '';
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : null;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : null;
        $parent_id  = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $onDB       = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId   = !empty($array['parentId']) ? $array['parentId'] : null;
        $titleArr   = !empty($array['titleArr']) ? json_decode($array['titleArr'], true) : null;

        /*
         * @Load Model
        */
        $model = new self;
        $inserArr = Arr::only($array, $model->fillable);
        $inserArr['agency_id'] = $entity_id;
        $inserArr['program'] = $program;

        if (!empty($array['parent_id']) || !empty($onDB)) {
            $inserArr['parent_id'] = $parent_id;
        }
        $logsmsg = "";
        if (!empty($logsArr)) {
             $logsmsg = dbLogFormat($logsArr);
        }

        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
            if (!empty($id) || !empty($parentId)) {
                $getdata = $model->updateOrCreate(['id' => $id], $inserArr);
            } else {
                $getdata = $model->create($inserArr);
            }

            $name = $getdata?->name ?? "";
            if ($getdata->wasRecentlyCreated == true) {
                $msg = __('logs.other_setting.add', ['name' => $name]);
            } else {
                if (!empty($logsmsg)) {
                    $msg = __('logs.other_setting.edit', ['name' => $name]) . " " . $logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            $logId = !empty($logId) ? $logId : $getdata?->id ;
            !empty($msg) && Logs::saveLogs(['type' => $activePage, 'onDB' => $onDB, 'user_id' => $user_id, 'type_id' => $logId, 'message' => $msg]);

        } catch (\Throwable$th) {
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
        if (!empty($array['dId'])) {
         $model = $model->decrypt($array['dId']);
        }
        if (!empty($array['entityId'])) {
             $model = $model->whereAgencyId($array['entityId']);
        }
         if (!empty($array['id'])) {
         $model = $model->whereId($array['id']);
         }
        return $model;
    }
}
