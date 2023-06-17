<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,User,Quote
};
use App\Traits\ModelAttribute;
class QuoteSignatureOtp extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;

  

    protected $fillable = ['user_id','qid','vid','ip','otp','status','start_time','verify_time'];
    protected $encryptable = ['ip','otp'];


   

    public static function insertOrUpdate(array $array){

        $id        = !empty($array['id']) ? $array['id'] : '' ;
        $userId    = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
    
        $model     = new self; //Load Model

        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['user_id'] = $userId;
       

        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }
       

        DB::beginTransaction();
        try {
           if(!empty($id) || !empty($parentId)){
                $model->updateOrCreate(['id'=>$id],['current_status'=>(int)$status,'show_task'=>0]);
           }else{
                $getdata = $model->create($inserArr);
           }
            
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }

    public static function getData(array $array=[]){

      
        $userId   = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);


        $model = new self;
        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }
        if(isset($array['qId'])){
            $model = $model->where('qid',$array['qId']);
        }
        if(isset($array['vId'])){
            $model = $model->where('vid',$array['vId']);
        }
        if(isset($array['ip'])){
            $model = $model->whereEn('ip',$array['ip']);
        }
        if(isset($array['otp'])){
            $model = $model->whereEn('otp',$array['otp']);
        }

        if(isset($array['status'])){
            $model = $model->where('status',$array['status']);
        }

        if(!empty($id)){
            $model = $model->decrypt($id);
        }
        return $model;
    }

}
