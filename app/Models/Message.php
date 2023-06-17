<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB,Error,Arr;
use App\Models\{
    Logs,User,MessageFile
};
use App\Traits\ModelAttribute;
use App\Encryption\Traits\EncryptedAttribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
class Message extends Model
{

    use HasUuids;
    use HasFactory;
    use SoftDeletes;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable =
    ['from_id','to_id','subject','cc','message','is_delete','quote_subject','important','sent_important','read','parent_id','type','qid','vid','version'];
    protected $encryptable = ['subject','message','quote_subject'];

    /**
     * Get the user that owns the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'to_id', 'id');
    }

    /**
     * Get the user that owns the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form_user()
    {
        return $this->belongsTo(User::class, 'from_id', 'id');
    }


    /**
     * Get all of the replyMail for the Message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reply_mail()
    {
        return $this->hasMany($this, 'parent_id', 'id')->where('type',1)->with('children');
    }

    public function children(){
        return $this->hasMany($this,'parent_id', 'id')->where('type',1);
    }

    public function files(){
        return $this->hasMany(MessageFile::class,'message', 'id');
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


                $getdata = $model->updateOrCreate(['id'=>$id],['current_status'=>(int)$status,'show_task'=>0]);
           }else{
                $getdata = $model->create($inserArr);
           }

         /*    $name = $getdata?->subject ?? "";
            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.message.add',['name'=>$name]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.message.edit',['name'=>$name])." ".$logsmsg;
                }
            } */

            /*
             * Logs Save In @Log Model
             */
          /*   !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->id ,'message'=>$msg]);
 */
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
        if(isset($array['qId'])){
            $data = $data->where('qid',$array['qId']);
        }
        if(isset($array['vId'])){
            $data = $data->where('vid',$array['vId']);
        }

        return $data;
    }


}
