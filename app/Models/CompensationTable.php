<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use App\Helpers\AllDataBaseUpdate;
use App\Models\Logs;
use App\Models\CompensationTableFee;
use App\Traits\ModelAttribute;
use DB,Error,Arr;
class CompensationTable extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ['user_id', 'name', 'status', 'compensation','description'];
    protected $encryptable = ['name',  'compensation','description'];

    /**
     * Get all of the compensationTableFee for the feeTable
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function compensationTableFee()
    {
        return $this->hasMany(compensationTableFee::class, 'compensation_id', 'id');
    }

    public static function insertOrUpdate(array $array)
    {
        $msg = $logsmsg = "";
        $id = !empty($array['id']) ? $array['id'] : null;
        $name = !empty($array['name']) ? $array['name'] : null;
        $compensation = !empty($array['compensation']) ? $array['compensation'] : null;
        $status = !empty($array['status']) ? $array['status'] : 0;
        $description = !empty($array['description']) ? $array['description'] : null;
        $user_id = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId = !empty($array['logId']) ? $array['logId'] : $user_id;
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : null;
        $parent_id = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId = !empty($array['parentId']) ? $array['parentId'] : null;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : null;
        $feeTable = !empty($array['feeTable']) ? $array['feeTable'] : [];
       // $feeTable['onDB'] = $onDB;

        $inserArr = [
            'name' => $name,
            'user_id' => $user_id,
            'compensation' => $compensation,
            'status' => $status,
            'description' => $description,

        ];

        if (!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }

        if (!empty($logJson)) {
            $logsArr = $logJson;
            $logsArr = Arr::except($logsArr,['feeTable[from][]','feeTable[to][]','feeTable[financed_rate][]','feeTable[markup][]','feeTable[add_on_points][]','feeTable[fee][]','feeTable[total_premium][]']);
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
                $msg = __('logs.compensation_tables.add', ['name' => $name]);
            } else {
                if (!empty($logsmsg)) {
                    $msg = __('logs.compensation_tables.edit', ['name' => $name]) . " " . $logsmsg;
                }
            }

            /*
            Rate Table Fee Add Or Update
             */
            $feeData = self::feeInsertOrUpdate($feeTable, $getdata?->id, $user_id, $name,$array);
            $logs = !empty($feeData->logs) ? "<ul>{$feeData->logs}</ul>" : '';
            $msg .= $logs;

            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type' => $activePage, 'onDB' => $onDB, 'user_id' => $logId, 'type_id' =>
            $getdata->id, 'message' => $msg]);
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

    private static function feeInsertOrUpdate(array $feeTable = null, $feeId = 0, $userId = 0, $name = "",$arrayInput=null)
    {
        if (empty($feeTable)) {
            return;
        }
        $msg    = "";
        $from   = !empty($feeTable['from']) ? $feeTable['from']: null ;

        if (!empty($from)) {
            foreach ($from as $key => $value) {
                $fromVal        = !empty($value) ? $value : 0;
                $id            = !empty($feeTable['id'][$key]) ? decryptData($feeTable['id'][$key]) : 0;
                $toVal          = !empty($feeTable['to'][$key]) ? $feeTable['to'][$key] : 0;
                $rateVal        = !empty($feeTable['financed_rate'][$key]) ? $feeTable['financed_rate'][$key] : 0;
                $feeIdVal       = !empty($encryptidArr[$key]) ? $encryptidArr[$key] : 0;
                $markup         = !empty($feeTable['markup'][$key]) ? $feeTable['markup'][$key] : 0;
                $add_on_points  = !empty($feeTable['add_on_points'][$key]) ? $feeTable['add_on_points'][$key] : 0;
                $fee    = !empty($feeTable['fee'][$key]) ? $feeTable['fee'][$key] : 0;
                $total_premium = !empty($feeTable['total_premium'][$key]) ? $feeTable['total_premium'][$key] : 0;
              //  $msg            .= !empty($msg) ? " and " : '';
                $array = [
                    "compensation_id"   => $feeId,
                    "id" => $id,
                    "from"              => $fromVal,
                    "to"                => $toVal,
                    "financed_rate"     => $rateVal,
                    "markup"            => $markup,
                    "add_on_points"     => $add_on_points,
                    "fee"               => $fee,
                    "total_premium"     => $total_premium,
                ];

                $getdataRateTableFee = CompensationTableFee::insertOrUpdate($array);
                if ($getdataRateTableFee->wasRecentlyCreated == true) {
                    $msg .= "<li>".__('logs.compensation_tables.fee_add', ['name' => $name, 'from' => '<b> $' . $fromVal
                            . '</b>',
                    'to' => '<b> $' . $toVal . '</b>'])."</li>";
                } else {
                    $changeArray = $isDoller = $isPercentage = "";
                    $changeArray = $getdataRateTableFee?->changesArr ?? [];

                    if (!empty($changeArray)) {
                        foreach ($changeArray as $key => $logValue) {
                            $isDollerArr = ['from', 'to', 'add_on_points','fee'];
                            $isPercentageArr = ['financed_rate', 'markup', 'total_premium'];
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
                            $title      = ucfirst($key);
                            $msgTitle   = " {$title} was changed from <b>{$old}</b> to <b>{$new}</b>";
                            $msg .= isset($logsArr[$key]) ? "" : "<li>".removeWhiteSpace($msgTitle)."</li>";
                        }

                    }

                }


            }

        }
         $deleteRows = !empty($arrayInput['delete_rows']) ? json_decode($arrayInput['delete_rows'],true) : '';
        if(!empty($deleteRows)){
          //  $and = !empty($msg) ? ' and' : '' ;
            foreach ($deleteRows as $key => $value) {
                $id             = decryptData($value);
                $deleteRowData = CompensationTableFee::getData(['id'=>$id])->first();
                if(!empty($deleteRowData)){
                    $dfrom          = !empty($deleteRowData['from']) ? '$'.number_format($deleteRowData['from'],2) : '' ;
                    $dto            = !empty($deleteRowData['to']) ? '$'.number_format($deleteRowData['to'],2) : '' ;
                    $msg .= "<li> Range from <b>{$dfrom}</b> To <b>{$dto}</b> was deleted </li>";
                   // $and = ' and';
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
        return $model;
    }

}
