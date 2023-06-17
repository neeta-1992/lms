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
class Note extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = ['user_id','parent_id','note_type','subject','note_type','description','files','view_status','current_status','type','show_status','type_id','vid'];
    protected $encryptable = ['subject','notes','priority','files','note_type'];

    /**
     * Get the created_by that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function created_by()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the created_by that owns the Task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assigned()
    {
        return $this->belongsTo(User::class, 'assign_task', 'id');
    }




    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $userId          = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $userId ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : null ;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null ;
        $status           = !empty($array['status']) ? $array['status'] : null ;
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
         $model2 = $model;

        DB::beginTransaction();
        try {
           if(!empty($id) || !empty($parentId)){
                $inserArr['parent_id'] = $id;
                self::getData()->where('parent_id',$id)->update(['show_status'=>0]);
                $model->updateOrCreate(['id'=>$id],['current_status'=>(int)$status,'show_status'=>0]);
           }


           $inserArr['current_status'] = $status;
           $inserArr['show_status'] = 1;
          /*  dd( $inserArr); */
           $getdata = $model->create($inserArr);
/* dd( $getdata); */



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
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$typeId ,'message'=>$msg]);
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

    public static function userData(){

        $userData = auth()->user();
        $userType = $userData?->user_type ?? 0;
        if ($userType == User::ADMIN) {
            $type = [User::COMPANYUSER, User::ADMIN];
        } elseif ($userType == User::COMPANYUSER) {
            $type = [User::COMPANYUSER];
        } elseif ($userType == User::AGENT) {
            $type = [User::AGENT];
        } elseif ($userType == User::SALESORG) {
            $type = [User::SALESORG];
        } elseif ($userType == User::INSURED) {
            $type = [User::INSURED];
        }
        return User::getData(['type' => $type])->get()?->pluck("name", 'id');
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
            $model = $model->whereEn('type',$array['type']);
        }
        return $model;
     }
}
