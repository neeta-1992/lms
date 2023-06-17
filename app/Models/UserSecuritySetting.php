<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class UserSecuritySetting extends Model
{
    use HasFactory;
    use ModelAttribute;
   // use EncryptedAttribute;



    protected $fillable = [
        'user_type','minimum_length','minimum_digits','minimum_upper_case_letters',
        'minimum_lower_case_letters','minimum_special_characters','special_characters','minimum_password_age','expires_every',
        'number_unsuccessful_in','number_unsuccessful_minutes','number_inactivity_days','prevent_reuse'
    ];





    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $user_id         = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : null ;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null ;
        $parent_id       = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $titleArr        = !empty( $array['titleArr']) ? json_decode ( $array['titleArr'],true) : null ;
        $exceptArr       = ["id",'company_data','activePage','onDB','logId','logsArr','_token'];
        $inserArr = Arr::except($array,$exceptArr);


        if(!empty($array['parent_id']) || !empty($onDB)) {
            $inserArr['parent_id'] = $parent_id;
        }
        $logsmsg = "";
        if(!empty($logJson)){
            $logsArr = $logJson;
             $logsmsg = dbLogFormat($logsArr);
        }

        $model  = new self;
        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
           if(!empty($id)){
                $inserArr  = arrFilter($inserArr);

                    $getdata     = $model->updateOrCreate(['id'=>$id],$inserArr);

            }else{
                $getdata  =    $model->create($inserArr);
            }


            $name = loginUserTypeArr($getdata->user_type ?? 'null');
            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.user_security_settings.add',['type'=>$name]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.user_security_settings.edit',['type'=>$name])." ".$logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) &&
            Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->user_type,'message'=>$msg]);

        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }


    public static function getData(array $array=null){

     $model = new self;
     if(GateAllow('isAdminCompany')){
        $model = $model->on('company_mysql');
     }

        if(isset($array['type'])){
            $type = !empty($array['type']) ? $array['type'] : '' ;
            $model = $model->where('user_type',$type);
        }

        return $model;
     }
}
