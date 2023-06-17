<?php

namespace App\Models;

use App\Traits\ModelAttribute;
use DB;
use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessingTableFee extends Model
{
    use HasFactory;
    use ModelAttribute;

    protected $fillable = [
        'processing_table_id',
        'from',
        'to',
        'fee',
    ];

    public static function insertOrUpdate(array $array)
    {

        $id = !empty($array['id']) ? $array['id'] : '';
        $processing_table_id = !empty($array['processing_table_id']) ? $array['processing_table_id'] : 0;
        $from = !empty($array['from']) ? floatval($array['from']) : 0;
        $to = !empty($array['to']) ? floatval($array['to']) : 0;
        $fee = !empty($array['fee']) ? floatval($array['fee']) : 0;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId = !empty($array['parentId']) ? $array['parentId'] : null;

        $inserArr = [
            'processing_table_id' => $processing_table_id,
            'from' => $from,
            'to' => $to,
            'fee' => $fee,
        ];

        $model = new self;
        if (GateAllow('isAdminCompany') || !empty($onDB)) {
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
