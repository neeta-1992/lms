<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,User
};
use App\Traits\ModelAttribute;
class StateProgramSettingOverride extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
   // use EncryptedAttribute;

    protected $fillable = [
        'state_program_id',
        'override_settings',
        'assigned_territory',
        'assigned_states',
        'value','assigned_states[]'
    ];



    public static function insertOrUpdate(array $array)
    {

        $id = !empty($array['settingId']) ? $array['settingId'] : '';
        $user_id    = !empty($array['user_id']) ? $array['user_id'] : auth()->user()->id;
        $logJson    = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId      = !empty($array['logId']) ? $array['logId'] : '' ;
        $onDB       = !empty($array['onDB']) ? $array['onDB'] : null ;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : null ;
        $assigned_states = !empty($array['assigned_states']) ? implode(',',$array['assigned_states']) : 0;
        $override_settings = !empty($array['override_settings']) ? $array['override_settings'] : 0;


        $model    = new self; //Load Model

        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['assigned_states'] = $assigned_states;
/* dd($inserArr); */
/* dd( $inserArr); */
       /*  $logsmsg = "";
        if(!empty($logJson)){
            $logsArr = $logJson;
            $logsmsg = dbLogFormat($logsArr);
        } */

        $model  = new self;
        if(GateAllow('isAdminCompany') || !empty($onDB)){
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
           if(!empty($id) || !empty($parentId)){
                $inserArr  = arrFilter($inserArr);
                $getdata     = $model->updateOrCreate(['id'=>$id],$inserArr);
            }else{
                $getdata  =    $model->create($inserArr);
            }




        } catch (\Throwable $th) {
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
