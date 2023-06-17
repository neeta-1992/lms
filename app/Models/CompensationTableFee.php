<?php

namespace App\Models;

use App\Traits\ModelAttribute;
use DB;
use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompensationTableFee extends Model
{
    use HasFactory;
    use ModelAttribute;
    //
    protected $fillable = [
        'compensation_id',
        'from',
        'to',
        'financed_rate',
        'markup',
        'add_on_points',
        'fee',
        'total_premium',
    ];

    /*   protected $encryptable =[
    'from',
    'to',
    'financed_rate',
    'markup',
    'add_on_points',
    'fee',
    'total_premium',
    ]; */

    public static function insertOrUpdate(array $array)
    {

        $id = !empty($array['id']) ? $array['id'] : '';
        $compensation_id = !empty($array['compensation_id']) ? $array['compensation_id'] : 0;
        $from = !empty($array['from']) ? floatval($array['from']) : 0;
        $to = !empty($array['to']) ? floatval($array['to']) : 0;
        $financed_rate = !empty($array['financed_rate']) ? floatval($array['financed_rate']) : 0;
        $markup = !empty($array['markup']) ? floatval($array['markup']) : 0;
        $add_on_points = !empty($array['add_on_points']) ? floatval($array['add_on_points']) : 0;
        $fee = !empty($array['fee']) ? floatval($array['fee']) : 0;
        $total_premium = !empty($array['total_premium']) ? $array['total_premium'] : false;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId = !empty($array['parentId']) ? $array['parentId'] : null;

        $inserArr = [
            'compensation_id' => $compensation_id,
            'from' => $from,
            'to' => $to,
            'financed_rate' => $financed_rate,
            'markup' => $markup,
            'add_on_points' => $add_on_points,
            'fee' => $fee,
            'total_premium' => $total_premium,
        ];

        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }
        DB::beginTransaction();
        try {
            if (!empty($id)) {
                $inserArr = arrFilter($inserArr);
                $data = $model->updateOrCreate(['id' => $id], $inserArr);
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
