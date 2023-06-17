<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB,Error,Arr;
use App\Models\{
    Logs,User
};
use App\Traits\ModelAttribute;
use App\Encryption\Traits\EncryptedAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MessageFile extends Model
{
    use HasUuids;
    use HasFactory;

    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = ['message','original_name','file_name','file_type','message_type'];
    protected $encryptable = ['file_name','original_name'];



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
           if(!empty($id) || !empty($parentId)){
                $getdata = $model->updateOrCreate(['id'=>$id],$inserArr);
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

        $id     = !empty($array['id']) ? $array['id'] : "" ;
        $toId   = !empty($array['toId']) ? $array['toId'] : "" ;
        $formId = !empty($array['formId']) ? $array['formId'] : "" ;
        $value  = !empty($array['value']) ? $array['value'] : "" ;
        $userId = !empty($array['userId']) ? $array['userId'] : (auth()->user()?->id ?? 0);


        $data = new self;
        if (GateAllow('isAdminCompany')) {
            $data = $data->on("company_mysql");
        }

        if(!empty($id)){
            $data = $data->whereId($id);
        }

        if(!empty($toId)){
            $data = $data->whereToId($toId);
        }
        if(!empty($formId)){
            $data = $data->whereFromId($formId);
        }

        if(isset($array['type'])){
            $data = $data->whereType($array['type']);
        }

        return $data;
    }

}
