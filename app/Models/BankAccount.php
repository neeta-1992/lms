<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error;
use App\Models\{
    Logs,GlAccount
};
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class BankAccount extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;



    protected $fillable = ['user_id','bank_name','account_number','gl_account','status'];
    protected $encryptable = ['bank_name','account_number'];

    /**
     * Get the gl_accounts that owns the BankAccount
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function gl_accounts()
    {
        return $this->belongsTo(GlAccount::class, 'gl_account', 'id');
    }


    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $name            = !empty($array['bank_name']) ? $array['bank_name'] : '' ;
        $number          = !empty($array['account_number']) ? $array['account_number'] : '' ;
        $gl_account      = !empty($array['gl_account']) ? $array['gl_account'] : '' ;
        $status          = !empty($array['status']) ? $array['status'] : null ;
        $user_id         = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : null ;
        $activePage = !empty($array['activePage']) ? $array['activePage'] : null ;
        $parent_id       = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $titleArr        = !empty( $array['titleArr']) ? json_decode ( $array['titleArr'],true) : null ;

        $inserArr = [
            'bank_name' =>$name,
            'user_id' =>$user_id,
            'account_number' =>$number,
            'status'  =>$status,
            'gl_account' =>$gl_account,
        ];

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
           if(!empty($id) || !empty($parentId)){
                $inserArr  = arrFilter($inserArr);
                if(!empty($parentId)){
                    $getdata = $model->updateOrCreate(['parent_id'=>$parentId],$inserArr);
                    $getChanges  = $getdata?->changesArr;
                    if(!empty($getChanges)){
                        $logsMsg  = logsMsgCreate($getChanges,$titleArr,$logJson);
                        $logsmsg .= $logsMsg?->msg;
                    }
                }else{
                    $getdata     = $model->updateOrCreate(['id'=>$id],$inserArr);
                }
            }else{
                $getdata  =    $model->create($inserArr);
            }




            $name = $getdata?->name ?? "";
            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.back_account.add',['name'=>$name]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.back_account.edit',['name'=>$name])." ".$logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->id,'message'=>$msg]);
            if($saveOption === "save_and_reset"){
                $array['id'] =  $getdata?->id;

                unset($array['save_and_reset']);
                AllDataBaseUpdate::allDataSave($model,"glAccount",$array,$id);
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
     return $model;
     }



}
