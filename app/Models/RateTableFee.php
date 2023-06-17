<?php

namespace App\Models;

use App\Traits\ModelAttribute;
use DB;
use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RateTableFee extends Model
{
    use HasFactory;
    use ModelAttribute;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'rate_table_id',
        'from',
        'to',
        'rate',
        'setup_fee',
        'is_state_maximun',
    ];

    /*  protected $encryptable =[
    'user_id',
    'rate_table_id',
    'from',
    'to',
    'rate',
    'setup_fee',
    'is_state_maximun',
    ];
     */

    public static function insertOrUpdate(array $array)
    {

        $id = !empty($array['id']) ? $array['id'] : '';
        $user_id = !empty($array['user_id']) ? $array['user_id'] : 0;
        $rate_table_id = !empty($array['rate_table_id']) ? $array['rate_table_id'] : 0;
        $from = !empty($array['from']) ? floatval($array['from']) : 0;
        $to = !empty($array['to']) ? floatval($array['to']) : 0;
        $rate = !empty($array['rate']) ? floatval($array['rate']) : 0;
        $setup_fee = !empty($array['setup_fee']) ? floatval($array['setup_fee']) : 0;
        $is_state_maximun = !empty($array['is_state_maximun']) ? $array['is_state_maximun'] : false;
        $parent_id = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $feeId = !empty($array['feeId']) ? $array['feeId'] : 0;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId = !empty($array['parentId']) ? $array['parentId'] : null;

        $inserArr = [
            'user_id' => $user_id,
            'rate_table_id' => $rate_table_id,
            'from' => $from,
            'to' => $to,
            'rate' => $rate,
            'setup_fee' => $setup_fee,
            'is_state_maximun' => $is_state_maximun,
        ];

        $model = new self;
        if (GateAllow('isAdminCompany') || !empty($onDB)) {
            $model = $model->on('company_mysql');
        }
        DB::beginTransaction();
        try {
            if (!empty($id)) {
                $inserArr = arrFilter($inserArr);
                $data = $model->updateOrCreate(['rate_table_id' => $rate_table_id, 'id' => $id], $inserArr);
            } else {
                $data = $model->updateOrCreate($inserArr);
            }
        } catch (\Throwable$th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }
        DB::commit();
        return $data;

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
