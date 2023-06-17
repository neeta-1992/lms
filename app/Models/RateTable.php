<?php

namespace App\Models;

use App\Encryption\Traits\EncryptedAttribute;
use App\Helpers\AllDataBaseUpdate;

use App\Models\Logs;

use App\Models\RateTableFee;
use App\Traits\ModelAttribute;
use DB,Error,Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateTable extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ['user_id', 'company_id', 'name', 'type', 'account_type', 'state', 'coverage_type', 'description', 'parent_id'];
    protected $encryptable = ['name', 'type', 'account_type', 'description'];

    /**
     * Get all of the rateTableFee for the RateTable
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rateTableFee()
    {
        return $this->hasMany(RateTableFee::class, 'rate_table_id', 'id');
    }

    public static function insertOrUpdate(array $array)
    {
        $msg = $logsmsg = "";
        $id = !empty($array['id']) ? $array['id'] : null;
        $name = !empty($array['name']) ? $array['name'] : null;
        $type = !empty($array['type']) ? $array['type'] : null;
        $account_type = !empty($array['account_type']) ? $array['account_type'] : null;
        $coverage_type = !empty($array['coverage_type']) ? $array['coverage_type'] : 0;
        $state = !empty($array['state']) ? $array['state'] : 0;
        $description = !empty($array['description']) ? $array['description'] : null;
        $user_id = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId = !empty($array['logId']) ? $array['logId'] : $user_id;
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : null;
        $parent_id = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId = !empty($array['parentId']) ? $array['parentId'] : null;
        $rateTable = !empty($array['rateTable']) ? $array['rateTable'] : [];
        $titleArr = !empty($array['titleArr']) ? json_decode($array['titleArr'], true) : [];
        $rateTable['onDB'] = $onDB;

        $inserArr = [
            'name' => $name,
            'user_id' => $user_id,
            'account_type' => $account_type,
            'type' => $type,
            'coverage_type' => $coverage_type,
            'description' => $description,
            'state' => $state,
        ];

        if (!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }

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
                    $getChanges = $getdata?->changesArr ?? [];

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
            $name = $getdata?->name ?? "";
            if ($getdata->wasRecentlyCreated == true) {
                $msg = __('logs.rate_table.add', ['name' => $name]);
            } else {
                if (!empty($logsmsg)) {
                    $msg = __('logs.rate_table.edit', ['name' => $name]) . " " . $logsmsg;
                }
            }

            /*
            Rate Table Fee Add Or Update
             */
            $feeData = self::rateTableFeeInsertOrUpdate($rateTable, $getdata?->id, $user_id, $name,$array);
            $logs = !empty($feeData->logs) ? $feeData->logs : '';
            $msg .= $logs;

            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type' => 'rate-table', 'onDB' => $onDB, 'user_id' => $logId, 'type_id' => $getdata->id, 'message' => $msg]);
            if ($saveOption === "save_and_reset") {
                $array['id'] = $getdata?->id;
                unset($array['save_and_reset']);
                AllDataBaseUpdate::allDataSave($model, "rateTable", $array, $id);
            }
        } catch (\Throwable$th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }
        DB::commit();
        return $getdata;
    }

    private static function rateTableFeeInsertOrUpdate(array $rateTable = null, $rateTableId = 0, $userId = 0, $name = "",$arrayInput=null)
    {
        if (empty($rateTable)) {
            return;
        }
        $msg = "";
        $from       = isset($rateTable['from']) ? $rateTable['from'] : '';
        if (!empty($from)) {

            foreach ($from as $key => $value) {
                $fromVal        = !empty($value) ? $value : 0;
                $id             = !empty($rateTable['feeId'][$key]) ? decryptData($rateTable['feeId'][$key]) : 0;
                $toVal          = !empty($rateTable['to'][$key]) ? $rateTable['to'][$key] : 0;
                $rateVal        = !empty($rateTable['rate'][$key]) ? $rateTable['rate'][$key] : 0;
                $setupFeeVal    = !empty($rateTable['setup_fee'][$key]) ? true : false;
                $setupFeeAmountVal = !empty($rateTable['setup_fee_amount'][$key]) ? $rateTable['setup_fee_amount'][$key] : 0;
                $msg .= !empty($msg) ? " and " : '';
                $array = [
                    "id"        => $id,
                    "user_id"   => $userId,
                    "rate_table_id" => $rateTableId,
                    "from"  => $fromVal,
                    "to"    => $toVal,
                    "rate"  => $rateVal,
                    "is_state_maximun" => $setupFeeVal,
                    "setup_fee" => $setupFeeAmountVal,
                ];
                $getdataRateTableFee = RateTableFee::insertOrUpdate($array);
                if ($getdataRateTableFee->wasRecentlyCreated == true) {
                    $msg .= " ".__('logs.rate_table.fee_add', ['name' => $name, 'from' => '<b> $' . $fromVal . '</b>', 'to' => '<b> $' . $toVal . '</b>']);
                } else {
                    $changeArray = $isDoller = $isPercentage = "";
                    if (!empty($getdataRateTableFee->changesArr)) {
                        $changeArray = $getdataRateTableFee->changesArr ?? [];
                    }

                    if (isset($changeArray['is_state_maximun'])) {
                        unset($changeArray['is_state_maximun']);
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
                            $msgTitle   = " {$title} was changed from <b>{$old}</b> to <b>{$new}</b>";
                            $msg .= isset($logsArr[$key]) ? "" : removeWhiteSpace($msgTitle);
                        }

                    }

                }

            }

        }
         $deleteRows = !empty($arrayInput['delete_rows']) ? json_decode($arrayInput['delete_rows'],true) : '';
        if(!empty($deleteRows)){
            $and = !empty($msg) ? ' and' : '' ;
            foreach ($deleteRows as $key => $value) {
                $id             = decryptData($value);
                $deleteRowData = RateTableFee::getData(['id'=>$id])->first();
                if(!empty($deleteRowData)){
                    $dfrom          = !empty($deleteRowData['from']) ? '$'.number_format($deleteRowData['from'],2) : '' ;
                    $dto            = !empty($deleteRowData['to']) ? '$'.number_format($deleteRowData['to'],2) : '' ;
                    $msg .= "{$and} Range from <b>{$dfrom}</b> To <b>{$dto}</b> was deleted";
                    $and = ' and';
                    $deleteRowData->forceDelete();
                }
            }
        };
        return (object) ['logs' => $msg];

        //
    }

    public static function getData(array $array = null)
    {
        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        if (isset($array['id'])) {
            $model = $model->whereId($array['id']);
        }

        return $model;
    }

}
