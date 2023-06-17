<?php

namespace App\Models;

use App\Encryption\Traits\EncryptedAttribute;

use App\Models\Logs;

use App\Models\User;
use App\Traits\ModelAttribute;
use DB;
use Error,Arr;
use Illuminate\Database\Eloquent\Concerns\HasUuids;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotePolicyAccountExposure extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = [
        'account_id', 'payment_number', 
        'payment_due_date', 'amount_financed', 'monthly_payment', 'interest',
        'principal', 'principal_balance', 'payoff_balance', 'interest_refund','current_payment_date',
        'prev_payment_date', 'payment_notes', 'status',  'pay_amount','pay_interest','policy_id'
    ];
    protected $encryptable = [];

    public static function insertOrUpdate(array $array)
    {

        $id         = !empty($array['id']) ? $array['id'] : '';
        $userId     = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logId      = !empty($array['logId']) ? $array['logId'] : '';
        $saveOption = !empty($array['save_option']) ? $array['save_option'] : null;
        $parent_id  = !empty($array['parent_id']) ? $array['parent_id'] : 0;
        $onDB       = !empty($array['onDB']) ? $array['onDB'] : null;
        $parentId   = !empty($array['parentId']) ? $array['parentId'] : null;
        $titleArr   = !empty($array['titleArr']) ? json_decode($array['titleArr'], true) : null;
       
      
        $model    = new self; //Load Model
        $inserArr = Arr::only($array,$model->fillable);


       
      

        $model = new self;
        if (GateAllow('isAdminCompany')) {
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
