<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class UserPermission extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ['user_id','user_type','days_allowed_to_modify_due_date',
        'days_allowed_to_suspend_accounts','days_to_suspend_account_after_payment','convenience_fee_override',
        'quote_activation_review_limit','quote_activation_limit','ap_quote_start_installment_threshold_days','permissions','reports'
    ];

    protected $encryptable = ['days_allowed_to_modify_due_date',
        'days_allowed_to_suspend_accounts','days_to_suspend_account_after_payment','convenience_fee_override',
        'quote_activation_review_limit','quote_activation_limit','ap_quote_start_installment_threshold_days','permissions','reports'
    ];


    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $user_id         = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : null ;
        $parent_id       = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null ;
        $userId          = !empty($array['userId']) ? $array['userId'] : 0 ;
        $permissions     = !empty($array['permission']) ? json_encode($array['permission']) : "" ;
        $report          = !empty($array['report']) ? json_encode($array['report']) : "" ;
        $userType        = (!empty($array['userType']) && isEncryptValue($array['userType']))? decryptUrl($array['userType']) : '' ;
        $titleArr        = !empty( $array['titleArr']) ? json_decode ( $array['titleArr'],true) : null ;
        $exceptArr       = ["id",'permission','userId','report','company_data','activePage','onDB','logId','logsArr','_token','userType','save_option'];
        $inserArr        = Arr::except($array,$exceptArr);
       /// $inserArr['user_type']  = (int)$userType;
        $inserArr['permissions'] = $permissions;
        $inserArr['reports'] = $report;
        $inserArr['user_id'] = $userId;
/* dd($inserArr); */
        if(!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }

        $logsmsg = "";
        if(!empty($logJson)){
            $logsArr = $logJson;
             $logsmsg = dbLogFormat($logsArr);
        }

        $model  = new self;
        if(GateAllow('isAdminCompany') || !empty($onDB)){
            $model = $model->on('company_mysql');
        }
        $selfModel = $model;

        DB::beginTransaction();
        try {
           if(!empty($id)){
                $inserArr  = arrFilter($inserArr);
                $getdata     = $model->updateOrCreate(['id'=>$id],$inserArr);
            }else{
                $getdata  =    $model->create($inserArr);
            }

            $insetId = $getdata->id ?? null;
            $userType = (int)$getdata->user_type ?? null;


            $name = loginUserTypeArr($userType ?? 'null') ;
            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.user_permission.add',['type'=>$name]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.user_permission.edit',['type'=>$name])." ".$logsmsg;
                }
            }
            $logId = !empty($logId) ? $logId : $getdata->user_type ;
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) &&
            Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$user_id,'type_id'=>$logId,'message'=>$msg,'uId'=>$userId]);
            if($saveOption === "save_and_reset"){

                unset($inserArr['user_id']);
                $dataSaveOption = $model->upsert(['user_type'=>$userType],$inserArr);

            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }


  /*   private static function logMessage($arr){
dd($arr);
    } */

     public static function getData(array $array = null)
    {

        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        
        if(!empty($array['userId'])){
           $model =  $model->whereUserId($array['userId']);
        }
        if(!empty($array['userType'])){
           $model =  $model->whereUserType($array['userType']);
        }
        if(!empty($array['notId'])){
           $model =  $model->whereNot('id',$array['notId']);
        }

        return $model;
    }
}
