<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class MetaTag extends Model
{
    use HasFactory;
    use ModelAttribute;
    use HasUuids;


    protected $fillable = ['user_id','key','value','parent_id','type'];


    public static function insertOrUpdate(array $array){
        $logsmsg = "";
        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $key             = !empty($array['key']) ? $array['key'] : '' ;
        $value           = !empty($array['value']) ? $array['value'] : '' ;
        $user_id         = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : null ;
        $title           = !empty($array['title']) ? $array['title'] : null ;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null ;
        $parent_id       = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $type            = !empty($array['type']) ? $array['type'] : null ;
        $titleArr        = !empty($array['titleArr']) ? json_decode($array['titleArr'],true ) :  null;

        $inserArr = [
            'key'      => $key,
            'user_id'  => $user_id,
            'value'    => $value,
            'type'     => $type,
        ];

       if(!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }

        $logsmsg = "";
        if(!empty($logJson)){
            $logsArr  = $logJson;
             $logsmsg = dbLogFormat($logsArr);
        }

        $model  = new self;
        if(GateAllow('isAdminCompany') || !empty($onDB)){
        $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
           if(!empty($id) || !empty($parentId)){
                $inserArr  = arrFilter($inserArr);

                if(!empty($parentId)){

                    $getdata = $model->updateOrCreate(['parent_id'=>$parentId,'key'=>$key],$inserArr);
                    $getChanges  = $getdata?->changesArr;
                    if(!empty($getChanges)){
                        $logsMsg  = logsMsgCreate($getChanges,$titleArr,$logJson);
                        $logsmsg .= $logsMsg?->msg;
                    }
                }else{
                    $getdata = $model->updateOrCreate(['key'=>$key,'type'=>$type],$inserArr);
                }
            }else{
                $getdata = $model->updateOrCreate(['key'=>$key,'type'=>$type],$inserArr);
            }


            $name = $getdata?->name ?? "";
            if($getdata->wasRecentlyCreated == true){
                $msg = __("logs.meta_tag.add",["key"=>$key,'name'=>$title]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __("logs.meta_tag.edit",["key"=>$key, 'name'=>$title])." ".$logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->id,'message'=>$msg]);
            if($saveOption === "save_and_reset"){
                $array['id'] =  $getdata?->id;

                unset($array['save_and_reset']);
                AllDataBaseUpdate::allDataSave($model,$activePage,$array,$id);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }


    public static function getData(array $array){

        $key    = !empty($array['key']) ? $array['key'] : "" ;
        $type   = !empty($array['type']) ? $array['type'] : "" ;
        $value  = !empty($array['value']) ? $array['value'] : "" ;
        $userId = !empty($array['userId']) ? $array['userId'] : (auth()->user()?->id ?? 0);

        $data = new self;
        if (GateAllow('isAdminCompany')) {
            $data = $data->on("company_mysql");
        }

        if(!empty($userId)){
            $data = $data->whereUserId($userId);
        }

        if(!empty($key)){
            if(is_array($key)){
                $data = $data->whereIn("key",$key);
            }else{
                $data = $data->where("key",$key);
            }
           
        }
        if(!empty($type)){
            $data = $data->where("type",$type);
        }

        if(!empty($value)){
            $data = $data->whereValue($value);
        }

        return $data;
    }

}
