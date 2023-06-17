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
class AccountAlert extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = ['user_id','show_task','account_id','parent_id','parent_id_append','alert_date','alert_subject','category','alert_text',
    'task','append_status',];
    protected $encryptable = ['alert_subject','task',];

     /**
     * Get the user that owns the AgentOffice
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
      // dd( $inserArr);

        $logsmsg = "";
        if(!empty($logJson)){
            $logsArr = $logJson;
            $logsmsg = dbLogFormat($logsArr);
        }


        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }
         $model2 = $model;

        DB::beginTransaction();
        try {
           if(!empty($id)){
           // dd($id);
                $inserArr['parent_id'] = $id;
                self::getData()->where('parent_id',$id)->orwhere('id',$id)->update(['show_task'=>0]);
               // $model->updateOrCreate(['id'=>$id],['current_status'=>(int)$status,'show_task'=>0]);
           }


         //  $inserArr['current_status'] = $status;
          $inserArr['show_task'] = 1;

           $getdata = $model->create($inserArr);




            $name = $getdata?->subject ?? "";
            $typeId = !empty($id) ? $id : $getdata->id;
            if($getdata->wasRecentlyCreated == true && empty($id)){
                $msg = __('logs.task.add',['name'=>$name]);
            }else{
                $msg = __('logs.task.appended',['name'=>$name]);
            }
            if($status == 4){
                $msg = "{$name} task status was updated reopne";
            }
            /*
             * Logs Save In @Log Model
             */
            $logId = !empty($logId) ? $logId : $typeId;
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$userId,'type_id'=>$logId ,'message'=>$msg]);
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

        if(!empty($array['id'])){
            $model = $model->where('id',$array['id']);
        }
        if(!empty($array['accountId'])){
            $model = $model->where('account_id',$array['accountId']);
        }
        return $model;
     }
}
