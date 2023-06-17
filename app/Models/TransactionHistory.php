<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,User,QuoteAccount,Payment
};
use App\Traits\ModelAttribute;
class TransactionHistory extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = [
        'user_id','payment_id','account_id','transaction_id','payment_number','new_payment_number',
        'transaction_type','reversal','type','payment_method','nsf_fee','stop_payment_fee','amount',
        "debit_fee",'debit','credit','balance','interest','resaon','description','system','reverse_status','return_premium_commission'
    ];
    protected $encryptable = [];

     /**
     * Get the user associated with the Log
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


     /**
     * Get the account_data associated with the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account_data()
    {
        return $this->hasOne(QuoteAccount::class, 'id', 'account_id');
    }


     /**
     * Get the account_data associated with the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment_data()
    {
        return $this->hasOne(Payment::class, 'id', 'payment_id');
    }


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
       

        $logsmsg = "";
        if(!empty($logJson)){
            $logsArr = $logJson;
            $logsmsg = dbLogFormat($logsArr);
        }


        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }


        DB::beginTransaction();
        try {
           if(!empty($id)){
                $model->updateOrCreate(['id'=>$id],$inserArr);
           }else{
            $getdata = $model->create($inserArr);
           }


       /*  $name = $getdata?->subject ?? "";
        $typeId = !empty($id) ? $id : $getdata->id;
        if($getdata->wasRecentlyCreated == true && empty($id)){
            $msg = __('logs.task.add',['name'=>$name]);
        }else{
            $msg = __('logs.task.appended',['name'=>$name]);
        }
        if($status == 4){
            $msg = "{$name} task status was updated reopne";
        } */
            /*
             * Logs Save In @Log Model
             */
        !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$typeId ,'message'=>$msg]);

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
            $model = $model->where('type_id',$array['type']);
        }
        if(!empty($array['accountId'])){
            $model = $model->where('account_id',$array['accountId']);
        }
        if(!empty($array['paymentId'])){
            $model = $model->where('payment_id',$array['paymentId']);
        }
        return $model;
     }
}
