<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,User,Entity,QuoteTerm,TransactionHistory,PendingPayment,QuoteAccountExposure,Setting,BankAccount
};
use App\Traits\ModelAttribute;
use App\Helpers\DailyNotice;
class PaymentsHistory extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = [
        'user_id','payment_ids','total_deposits','deposit_amount','payment_date','totals','payments','status','type'
    ];

    protected $encryptable = [];

     /**
     * Get the user that owns the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $userId          = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $quote           = !empty($array['quote']) ? $array['quote'] : null;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null;
    


        $model           = new self; //Load Model
        $inserArr        = Arr::only($array,$model->fillable);
        $inserArr['user_id'] = $userId;
        

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


    public static function getData(array $array = null){

        $model = new self;

        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }
       
        return $model;
    }

}
