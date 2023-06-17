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

class ReturnPremiumCommission extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = ['user_id','account_id','policy','return_premium_from','check_number','bank_account','apply_payment','print_rp_notices','reduce_remaining_interest','first_payment_due_date','agent_commission_due','amount_paid','status'];
    protected $encryptable = [];

 


    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $userId          = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $userId ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : null ;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null ;
        $status          = !empty($array['status']) ? $array['status'] : null ;
        $parent_id       = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $titleArr        = !empty($array['titleArr']) ? json_decode ( $array['titleArr'],true) : null ;


        $model    = new self; //Load Model

        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['user_id'] = $userId;




        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }
        

        DB::beginTransaction();
        try {
           if(!empty($id) || !empty($parentId)){
            $getdata =   $model->updateOrCreate(['id'=>$id],$inserArr);
           }else{
            $getdata=    $model->create($inserArr);
           }


            $name = $getdata?->subject ?? "";
            $typeId = !empty($id) ? $id : $getdata->id;
            if($getdata->wasRecentlyCreated == true && empty($id)){
             //   $msg = __('logs.task.add',['name'=>$name]);
            }else{
                $msg = "Return Premium for Account Added";
            }
          
           
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'user_id'=>$userId,'type_id'=>$typeId ,'message'=>$msg]);
           
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

        if(!empty($array['id'])){
            $model = $model->where('id',$array['id']);
        }
        if(!empty($array['qId'])){
            $model = $model->where('type_id',$array['qId']);
        }
        if(!empty($array['type'])){
            $model = $model->whereEn('type',$array['type']);
        }
        return $model;
     }
}
