<?php

namespace App\Models;

use Arr;
use DB;
use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotes extends Model
{
    use HasFactory;
    protected $table = "quotes";
    protected $fillable = [
        'insured_name', 'agent', 'email_notification', 'line_of_business', 'quote_type', 'rate_table', 'origination_state',
        'payment_method', 'insurance_company', 'inception_date',
         'general_agent', 'policy_term', 'policy_number', 'expiration_date',
        'coverage_type', 'first_installment_date', 'pure_premium',
         'policy_fee', 'minimum_earned', 'taxes_stamp_fees', 'cancel_term_in_days',
        'broker_fee', 'short_rate', 'inspection_fee', 'auditable',
         'puc_filings','finance_company','unlock_request','notes',
    ];

    public static function insertOrUpdate(array $array)
    {
        $logsmsg = "";
        $id = !empty($array['id']) ? $array['id'] : '';
        $user_id = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId = !empty($array['logId']) ? $array['logId'] : $user_id;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $status = !empty($array['status']) ? $array['status'] : 0;
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : 0;
        $billing_schedule = !empty($array['billing_schedule']) ? implode(",", $array['billing_schedule']) : null;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : "quote_settings";
        $exceptArr = ["id", "company_data", 'activePage', 'onDB', 'logId', 'logsArr', '_token'];
        $array['billing_schedule'] = $billing_schedule;
        $array['user_id'] = $user_id;
        $inserArr = Arr::except($array, $exceptArr);
        if (!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }

        $templateTextOld = $templateTextNew = "";
        if (!empty($logJson)) {
            $logsArr = $logJson;
            $logsmsg = dbLogFormat($logsArr);
        }

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
                    if (!empty($getChanges)) {
                        $logsMsg = logsMsgCreate($getChanges, $titleArr, $logJson);
                        $logsmsg .= $logsMsg?->msg;
                        $templateTextOld = $logsMsg?->preValue;
                        $templateTextNew = $logsMsg?->newValue;
                    }
                } else {
                    $getdata = $model->updateOrCreate(['id' => $id], $inserArr);
                }
            } else {
                $getdata = $model->create($inserArr);
            }

            $name = $getdata?->name ?? "";
            if ($getdata->wasRecentlyCreated == true) {
                $msg = __("logs.{$activePage}.add");
            } else {
                if (!empty($logsmsg)) {
                    $msg = __("logs.{$activePage}.edit", ['name' => $name]) . " " . $logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) &&
            Logs::saveLogs(['type' => $activePage, 'onDB' => $onDB, 'user_id' => $logId, 'type_id' => $getdata->id, 'message' => $msg, 'old_value' => $templateTextOld, 'new_value' => $templateTextNew]);
            if ($saveOption === "save_and_reset") {
                $array['id'] = $getdata?->id;
                unset($array['save_and_reset']);
                AllDataBaseUpdate::allDataSave($model, $activePage, $array, $id);
            }
        } catch (\Throwable$th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }

    public static function getData(array $array = [])
    {

        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }
        return $model;
    }

}
