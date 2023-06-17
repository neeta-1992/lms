<?php


namespace App\Models;

use App\Encryption\Traits\EncryptedAttribute;
use App\Helpers\AllDataBaseUpdate;

use App\Models\Logs;

use App\Models\State;

use App\Models\StateSettingsTwo;
use App\Models\StateSettingInterestRate;
use App\Traits\ModelAttribute;
use DB;use Error;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Arr;
class StateSettingInterestRate extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
   

    protected $fillable = [
       
        'state_setting_id',
        'from',
        'to',
        'rate','type'
    
    ];

 

    public static function insertOrUpdate(array $array)
    {

        $id = !empty($array['id']) ? $array['id'] : '';
        $user_id = !empty($array['user_id']) ? $array['user_id'] : 0;
        $state_setting_id = !empty($array['state_setting_id']) ? $array['state_setting_id'] : 0;
        $from = !empty($array['from']) ? floatval($array['from']) : 0;
        $to = !empty($array['to']) ? floatval($array['to']) : 0;
        $rate = !empty($array['rate']) ? floatval($array['rate']) : 0;
        $parent_id = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $feeId = !empty($array['feeId']) ? $array['feeId'] : 0;
        $type = !empty($array['type']) ? $array['type'] : null;
        $onDB = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId = !empty($array['parentId']) ? $array['parentId'] : null;

        $inserArr = [
            'state_setting_id' => $state_setting_id,
            'from' => $from,
            'to' => $to,
            'rate' => $rate,
            'type' => $type,
        ];

        $model = new self;
        if (GateAllow('isAdminCompany') || !empty($onDB)) {
            $model = $model->on('company_mysql');
        }
        DB::beginTransaction();
        try {
            if (!empty($feeId)) {
                $inserArr = arrFilter($inserArr);
               
                $data = $model->updateOrCreate(['state_setting_id' => $state_setting_id, 'id' => $feeId], $inserArr);
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
        if (!empty($array['state'])) {
            $model = $model->where('state_setting_id',$array['state']);
        }
        return $model;
    }
}
