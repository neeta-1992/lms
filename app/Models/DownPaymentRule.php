<?php

namespace App\Models;

use App\Encryption\Traits\EncryptedAttribute;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use Arr;
use DB;
use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class DownPaymentRule extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;
    protected $fillable = [
        'down_payment_id', 'rule_name', 'minimum_down_payment', 'down_payment_increase',
        'deafult_down_payment',
        'dollar_down_payment', 'minimum_installment', 'maximumm_installment',
        'deafult_installment',
        'first_due_date', 'override_minimum_earned',  'rule_description','round_down_payment'
    ];

    protected $encryptable = [
       'rule_name', 'minimum_down_payment', 'down_payment_increase',
       'deafult_down_payment',
       'dollar_down_payment', 'minimum_installment', 'maximumm_installment',
       'deafult_installment',
       'first_due_date', 'override_minimum_earned', 'rule_description','round_down_payment'
    ];

    public static function insertOrUpdate(array $array)
    {

        $id = !empty($array['ruleid']) ? $array['ruleid'] : '';
        $user_id = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId = !empty($array['logId']) ? $array['logId'] : $user_id;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : null;
        $parent_id = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId = !empty($array['parentId']) ? $array['parentId'] : null;
        $round_down_payment = !empty($array['round_down_payment_2']) ? $array['round_down_payment_2'] : null;
        $override_minimum_earned = !empty($array['override_minimum_earned_2']) ? $array['override_minimum_earned_2'] : null;
        $titleArr = !empty($array['titleArr']) ? json_decode($array['titleArr'], true) : null;
        $exceptArr = ["id", "company_data", 'activePage', 'onDB', 'logId', 'logsArr', '_token'];
     /*    dd( $array); */

        $model = new self;
        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['round_down_payment'] = $round_down_payment;
        $inserArr['override_minimum_earned'] = $override_minimum_earned;

        if (!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }
        $logsmsg = "";
        if (!empty($logJson)) {
            $logsArr = $logJson;
            $logsArr = !empty($logsArr) ? array_reduce($logsArr, 'array_merge', array()) : [];
            $logsArr = !empty($logsArr) ? array_column($logsArr, 'msg') : [];
            $logsmsg = implode(' and ', $logsArr);
        }


        if (GateAllow('isAdminCompany') || !empty($onDB)) {
            $model = $model->on('company_mysql');
        }
     
        DB::beginTransaction();
        try {
            if (!empty($id) || !empty($parentId)) {
               //$inserArr = arrFilter($inserArr);
          /*     dd($inserArr ); */
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

        if (!empty($array['id'])) {
            $model = $model->whereId($array['id']);
        }
        if (!empty($array['dId'])) {
            $model = $model->decrypt($array['dId']);
        }
        if (!empty($array['downPaymentId'])) {
            $model = $model->decrypt($array['downPaymentId'],'down_payment_id');
        }
        return $model;
    }
}
