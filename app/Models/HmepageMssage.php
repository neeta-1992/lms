<?php

namespace App\Models;

use App\Encryption\Traits\EncryptedAttribute;
use App\Helpers\AllDataBaseUpdate;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use DB;
use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HmepageMssage extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ['user_id', 'user_type', 'from_date', 'to_date', 'body', 'status'];
    protected $encryptable = ['body'];

    public static function insertOrUpdate(array $array)
    {
        $logsmsg = "";
        $id = !empty($array['id']) ? $array['id'] : '';
        $user_type = !empty($array['user_type']) ? $array['user_type'] : '';
        $from_date = !empty($array['from_date']) ? date("Y-m-d H:i:s", strtotime($array['from_date'])) : null;
        $to_date = !empty($array['to_date']) ? date("Y-m-d H:i:s", strtotime($array['to_date'])) : null;
        $body = !empty($array['body']) ? $array['body'] : null;
        $user_id = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId = !empty($array['logId']) ? $array['logId'] : $user_id;
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : null;
        $parent_id = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId = !empty($array['parentId']) ? $array['parentId'] : null;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : null;
        $status = !empty($array['status']) ? $array['status'] : 0;
        $titleArr = !empty($array['titleArr']) ? json_decode($array['titleArr'], true) : null;

        $inserArr = [
            'user_id' => $user_id,
            'user_type' => $user_type,
            'from_date' => $from_date,
            'to_date' => $to_date,
            'body' => $body,
            'status' => $status,
        ];

        if (!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }

        $templateTextOld = $templateTextNew = "";
        if (!empty($logJson)) {
            $logsArr = $logJson;
            $templateTextOld = !empty($logsArr['body'][0]['prevValue']) ? $logsArr['body'][0]['prevValue'] : '';
            $templateTextNew = !empty($logsArr['body'][0]['value']) ? $logsArr['body'][0]['value'] : '';
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
            $lang = str_replace("-", "_", $activePage);
            if ($getdata->wasRecentlyCreated == true) {
                $msg = __("logs.{$lang}.add", ['name' => $name]);
            } else {
                if (!empty($logsmsg)) {
                    $msg = __("logs.{$lang}.edit", ['name' => $name]) . " " . $logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type' => $activePage, 'onDB' => $onDB, 'user_id' => $logId, 'type_id' => $getdata->id, 'message' => $msg, 'old_value' => $templateTextOld, 'new_value' => $templateTextNew]);
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

    public static function getData(array $array = null)
    {
        $model = new self;

        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }
        return $model;
    }

}
