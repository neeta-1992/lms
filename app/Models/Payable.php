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
class Payable extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = [
        'user_id','policy_id','vendor','gl_account','account_id',
        'payee_name','reference_no','totalamount',
        'due_date','inception_date',
        'first_payment_due_date','type',
        'check_number','status',
    ];

    protected $encryptable = [];


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }


    public function paymee()
    {
        return $this->hasOne(User::class, 'id', 'vendor');
    }





    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $userId          = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $quote           = !empty($array['quote']) ? $array['quote'] : null;
        $activePage         = !empty($array['activePage']) ? $array['activePage'] : null;
        $onDB         = !empty($array['onDB']) ? $array['onDB'] : null;


        $model    = new self; //Load Model
        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['user_id'] = $userId;

        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }


        DB::beginTransaction();
        try {
            if (!empty($id) || !empty($parentId)) {
                $getdata = $model->updateOrCreate(['id' => $id], $inserArr);
            } else {
                $getdata = $model->create($inserArr);
            }




            $name = $getdata?->subject ?? "";
            $wasRecentlyCreated = $getdata?->wasRecentlyCreated ?? "";
            $typeId = !empty($id) ? $id : $getdata->id;
             if ($wasRecentlyCreated == true) {
                $msg = 'Payable created';
            } else {
                if (!empty($logsmsg)) {
                    $msg = __('logs.' . $lang . '.edit', ['name' => $name]) . " " . $logsmsg;
                }
            }
            $logId = !empty($logId) ? $logId : $getdata?->id;
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$userId,'type_id'=>$logId ,'message'=>$msg]);

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

        return $model;
     }

}
