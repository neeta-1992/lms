<?php

namespace App\Models;

use App\Encryption\Traits\EncryptedAttribute;

use App\Models\DownPaymentRule;

use App\Models\Logs;
use App\Traits\ModelAttribute;use Arr;
use DB;
use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class DownPayment extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;
    protected $fillable = [
        'user_id', 'name','agency', 'monthly_minimum_installment', 'monthly_deafult_installment',
        'monthly_maximum_installment',
        'quarterly_minimum_installment', 'quarterly_deafult_installment', 'quarterly_maximum_installment', 'annually_minimum_installment',
        'annually_deafult_installment', 'annually_maximum_installment', 'round_down_payment', 'minimum_down_payment_policies',
        'description', 'status',
    ];

    protected $encryptable = [
        'name', 'monthly_minimum_installment', 'monthly_deafult_installment', 'monthly_maximum_installment',
        'quarterly_minimum_installment', 'quarterly_deafult_installment', 'quarterly_maximum_installment', 'annually_minimum_installment',
        'annually_deafult_installment', 'annually_maximum_installment', 'round_down_payment', 'minimum_down_payment_policies',
        'description',
    ];

    public static function insertOrUpdate(array $array)
    {

        $id = !empty($array['id']) ? $array['id'] : '';
        $user_id = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId = !empty($array['logId']) ? $array['logId'] : $user_id;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : null;
        $parent_id = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId = !empty($array['parentId']) ? $array['parentId'] : null;
        $titleArr = !empty($array['titleArr']) ? json_decode($array['titleArr'], true) : null;
        $exceptArr = ["id", "company_data", 'activePage', 'onDB', 'logId', 'logsArr', '_token'];
        $inserArr = Arr::except($array, $exceptArr);
        $inserArr['user_id'] = $user_id;

        if (!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }
        $logsmsg = "";
        $DownPaymentRuleMOdel = new DownPaymentRule;

        if (!empty($logJson)) {
            $logsArr = $logJson;
            $logsArr = Arr::except($logsArr, ($DownPaymentRuleMOdel->getFillable() ?? []));
            $logsmsg = dbLogFormat($logsArr);
        }

        $model = new self;
        if (GateAllow('isAdminCompany') || !empty($onDB)) {
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
            if (!empty($id) || !empty($parentId)) {
              /*    dd( $inserArr); */
                $inserArr = arrFilter($inserArr);

                if (!empty($parentId)) {
                    $getdata = $model->updateOrCreate(['parent_id' => $parentId], $inserArr);
                    $getChanges = $getdata?->changesArr;
                    if (!empty($getChanges)) {
                        $logsMsg = logsMsgCreate($getChanges, $titleArr, $logJson);
                        $logsmsg .= $logsMsg?->msg;
                    }
                } else {
                    $getdata = $model->updateOrCreate(['id' => $id], $inserArr);
                }
            } else {
                $getdata = $model->create($inserArr);
            }

            $msg = "";
            $name = $getdata?->name ?? "";
            if ($getdata->wasRecentlyCreated == true) {
                $msg = __('logs.down_payment_rule.add', ['name' => $name]);
            } else {
                if (!empty($logsmsg)) {
                    $msg = __('logs.down_payment_rule.edit', ['name' => $name]) . " " . $logsmsg;
                }
            }

            /*
            DownPaymentRule Add And Edit
             */
            if (!empty($array['rule_name'])) {
                $array['down_payment_id'] = $getdata?->id;
                $DownPaymentRule = DownPaymentRule::insertOrUpdate($array);

                if ($DownPaymentRule->wasRecentlyCreated == true) {
                   // $and = !empty($msg) ? " and " : ' ';
                    $msg .=  __('logs.down_payment_rule.rule');
                } else {
                    $msg .= self::downPaymentRuleLogs($DownPaymentRule);
                }
            }

            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type' => $activePage, 'onDB' => $onDB, 'user_id' => $logId, 'type_id' => $getdata->id, 'message' => $msg]);

        } catch (\Throwable$th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }

    private static function downPaymentRuleLogs($DownPaymentRule)
    {
        $lables = [
            'rule_name' => 'Rule set name',
            'minimum_down_payment' => "Down payment minimum",
            'down_payment_increase' => "Down payment percent increase",
            'deafult_down_payment' => "Down payment deafult",
            'dollar_down_payment' => "Down payment dollar",
            'minimum_installment' => "Installment minimum",
            'maximumm_installment' => "Installment maximumm",
            'deafult_installment' => "Installment deafult",
            'first_due_date' => "First due date",
            'override_minimum_earned' => "Round down payment to nearest dollar",
            // 'agency'=> "Down payment deafult",
            'rule_description' => "Description",
        ];
        $msg = $and = "";
        $changesArr = $DownPaymentRule?->changesArr ?? [];
        if (!empty($changesArr)) {
            foreach ($changesArr as $key => $logValue) {
                $isDollerArr = ['dollar_down_payment', 'down_payment_increase'];
                $isPercentageArr = [];
                $old = !empty($logValue['old']) ? $logValue['old'] : '';
                $new = !empty($logValue['new']) ? $logValue['new'] : '';
                if (in_array($key, $isDollerArr)) {
                    $old = !empty($old) ? '$' . number_format($old, 2) : '';
                    $new = !empty($new) ? '$' . number_format($new, 2) : '';
                }

                if (in_array($key, $isPercentageArr)) {
                    $old = !empty($old) ? "{$old}%" : '';
                    $new = !empty($new) ? "{$new}%" : '';
                }
                if ($key == 'rule_description') {
                    $title = "{$DownPaymentRule->rule_name} Description";
                } else {
                    $title = isset($lables[$key]) ? $lables[$key] : Str::title($key);
                }

                if (!empty($old) && !empty($new)) {
                    $msgTitle = " {$title} was changed from <b>{$old}</b> to <b>{$new}</b>";
                } elseif (empty($old)) {
                    $msgTitle = " {$title} was updated <b>{$new}</b>";
                } else {
                    $msgTitle = " {$title} was changed from <b>{$old}</b> to <b>None</b>";
                }

                $msg .= "<li>".removeWhiteSpace($msgTitle)."</li>";
               // $and = " and ";
            }
        }
        return $msg;

    }

    public static function getData(array $array = null)
    {
        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        if (!empty($array['id'])) {
            $model = $model->whereId($array['id']);
        }
        if (!empty($array['dId'])) {
            $model = $model->decrypt($array['dId']);
        }
        return $model;
    }
}
