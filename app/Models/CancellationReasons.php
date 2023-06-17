<?php

namespace App\Models;

use App\Helpers\AllDataBaseUpdate;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use DB;
use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class CancellationReasons extends Model
{
    use HasFactory;
    use ModelAttribute;
    use HasUuids;
    // use EncryptedAttribute;

    protected $fillable = ['user_id', 'name', 'status', 'description','parent_id'];
    protected $encryptable = ['name', 'description'];

    public static function insertOrUpdate(array $array)
    {

        $id = !empty($array['id']) ? $array['id'] : '';
        $name = !empty($array['name']) ? $array['name'] : null;
        $description = !empty($array['description']) ? $array['description'] : null;
        $status = isset($array['status']) ? $array['status'] : null;
        $status_id = !empty($array['status_id']) ? $array['status_id'] : 0;
        $user_id = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId = !empty($array['logId']) ? $array['logId'] : $user_id;
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : null;
        $parent_id = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId = !empty($array['parentId']) ? $array['parentId'] : null;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : null;
        $titleArr = !empty($array['titleArr']) ? json_decode($array['titleArr'], true) : null;

        $inserArr = [
       
            'status' => $status,
            'description' => $description,
            'user_id' => $user_id,
        ];

        if (!empty($array['name'])) {
            $inserArr['name'] = $name;
        }
        if (!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }
        $logsmsg = "";
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
                //  $inserArr  = arrFilter($inserArr);
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

            $name = $getdata?->name ?? "";
            if ($getdata->wasRecentlyCreated == true) {
                $msg = __('logs.cancellation_reasons.add', ['name' => $name]);
            } else {
                if (!empty($logsmsg)) {
                    $msg = __('logs.cancellation_reasons.edit', ['name' => $name]) . " " . $logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type' => $activePage, 'onDB' => $onDB, 'user_id' => $logId, 'type_id' => $getdata->id, 'message' => $msg]);
            if ($saveOption === "save_and_reset") {
                $array['id'] = $getdata?->id;
              /*   dd( $array['id']); */
                unset($array['save_and_reset']);
                AllDataBaseUpdate::allDataSave($model, "coverageType", $array, $id);
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
        return $model;
    }
}
