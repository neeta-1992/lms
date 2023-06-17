<?php

namespace App\Models;

use App\Traits\ModelAttribute;
use DB;
use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;
    use ModelAttribute;

    protected $fillable = ['user_id', 'type', 'type_id', 'message', 'ip', 'country', 'company_id', 'system', 'old_value', 'new_value','login_user_id'];
    //protected $encryptable = ['type','message','ip','country','system'];

    /**
     * Get the user associated with the Log
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public static function saveLogs(array $array)
    {

        $type = !empty($array['type']) ? $array['type'] : '';
        $type_id = !empty($array['type_id']) ? $array['type_id'] : '';
        $message = !empty($array['message']) ? $array['message'] : '';
        $system = !empty($array['system']) ? $array['system'] : '';
        $old_value = !empty($array['old_value']) ? $array['old_value'] : '';
        $new_value = !empty($array['new_value']) ? $array['new_value'] : '';
        $onDB = !empty($array['onDB']) ? $array['onDB'] : '';
        $uId = !empty($array['uId']) ? (int)$array['uId'] : 0 ;
        $ip = request()->ip();
        $country = session()->get('country') ?? 0;
        $company_id = auth()->user()->company_id ?? 0;
        $user_id = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);

        $inserArr = [
            'type' => $type,
            'type_id' => $type_id,
            'message' => "<ul class='logs_ul'>{$message}</ul>",
            'system' => $system,
            'ip' => $ip,
            'country' => $country,
            'company_id' => $company_id,
            'user_id' => $user_id,
            'login_user_id' => $uId,
        ];

        if (!empty($new_value)) {
            $inserArr['new_value'] = $new_value;
        }
        if (!empty($old_value)) {
            $inserArr['old_value'] = $old_value;
        }

        $model = new self;
        if (GateAllow('isAdminCompany') || !empty($onDB)) {
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
            $data = $model->create($inserArr);
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



        if(!empty($array['duId'])){
            $duId = $array['duId'];
            $model = $model->decrypt($duId,'login_user_id');
        }
        if(!empty($array['type'])){
            $model = $model->whereType($array['type']);
        }

        return $model;
    }

}
