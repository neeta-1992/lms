<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,User,Entity,QuoteTerm
};
use App\Traits\ModelAttribute;
class PendingPayment extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = [
        'user_id','account_id','payment_number','due_late_fee','due_cancel_fee','due_nsf_fee',
        'due_convient_fee','due_installment','due_stop_payment','payment_processing_order',
    ];

    protected $encryptable = [];


    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $userId          = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $quote           = !empty($array['quote']) ? $array['quote'] : null;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null;
        $year            = !empty($array['year']) ? $array['year'] : null;
        $month           = !empty($array['month']) ? $array['month'] : null;


        $model           = new self; //Load Model
        $inserArr        = Arr::only($array,$model->fillable);
        $inserArr['user_id'] = $userId;
        if(!empty($year) && !empty($month)){
            $inserArr['expiration_date'] = "{$month}/{$year}";
        }


        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {

            if (!empty($id)) {
                $getdata = $model->updateOrCreate(['id' => $id], $inserArr);
            } else {
                $getdata = $model->create($inserArr);
            }



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

        if(!empty($array['accountId'])){
            $model = $model->where('account_id',$array['accountId']);
        }
        if(!empty($array['paymentNumber'])){
            $model = $model->where('payment_number',$array['paymentNumber']);
        }

        return $model;
     }

     
}
