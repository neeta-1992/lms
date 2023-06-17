<?php

namespace App\Models;

use App\Encryption\Traits\EncryptedAttribute;
use App\Traits\ModelAttribute;
use DB;
use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledTaskList extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ['user_id','type', 'task_name', 'is_admin', 'how_often', 'start_time', 'us_time_zone', 'start_date', 'description', 'end_date', 'status', 'parent_id'];
    protected $encryptable = ['task_name', 'how_often', 'start_time', 'us_time_zone', 'start_date',
    'description', 'end_date'];

    public static function insertOrUpdate(array $array)
    {
        $logsmsg = "";
        $id = !empty($array['id']) ? $array['id'] : '';
        $task_name = !empty($array['task_name']) ? $array['task_name'] : '';
        $how_often = !empty($array['how_often']) ? $array['how_often'] : null;
        $us_time_zone = !empty($array['us_time_zone']) ? $array['us_time_zone'] : null;
        $start_time = !empty($array['start_time']) ? date("H:i:s", strtotime($array['start_time'])) : null;
        $start_date = !empty($array['start_date']) ? date("Y-m-d", strtotime($array['start_date'])) : null;
        $description = !empty($array['description']) ? $array['description'] : null;
        $end_date = !empty($array['end_date']) ? date("Y-m-d", strtotime($array['end_date'])) : null;
        $user_id = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson = !empty($array['logsArr']) ? json_decode($array['logsArr'], true) : null;
        $logId = !empty($array['logId']) ? $array['logId'] : $user_id;
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : null;
        $parent_id = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $type     = !empty($array['type']) ? $array['type'] : null;
        $status   = !empty($array['status']) ? $array['status'] : 0;
        $is_admin = !empty($array['is_admin']) ? $array['is_admin'] : null;

        $inserArr = [
            'task_name'     => $task_name,
            'user_id'       => $user_id,
            'how_often'     => $how_often,
            'us_time_zone'  => $us_time_zone,
            'start_time'    => $start_time,
            'start_date'    => $start_date,
            'description'   => $description,
            'end_date'      => $end_date,
            'status'        => $status,
            'type'          => $type,
            'parent_id'     => $parent_id,
        ];

        $model =  self::on("mysql");
       /*  if (!empty($onDB)) {
            $model = $model;
        } */

        DB::beginTransaction();
        try {
            $getdata = $model->updateOrCreate(['type' => $type,'parent_id'=>$parent_id], $inserArr);

        } catch (\Throwable$th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }

    public static function getData(array $array = [])
    {

        $type = isset($array['type']) ? $array['type'] : null;
        $noticeType = isset($array['noticeType']) ? $array['noticeType'] : null;
        $action = isset($array['action']) ? $array['action'] : null;
        $status = isset($array['status']) ? $array['status'] : 0;
        $id = isset($array['id']) ? $array['id'] : null;

        $model = new self;
        /* if (!empty(config("database.connections.company_mysql.database"))) {
            $model = $model->on('company_mysql');
        } */
        if (isset($type)) {
            $model = $model->whereEncrypted('name', $type);
        }

        if (!empty($status)) {
            $model = $model->whereStatus($status);
        }

        if (!empty($id)) {
            $model = $model->decrypt($id);
        }
        return $model;
    }
}
