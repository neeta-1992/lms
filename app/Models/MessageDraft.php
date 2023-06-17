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
class MessageDraft extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $primaryKey = 'id';
    protected $keyType = 'string';


    protected $fillable = ['from_id','to_id','subject','quote_subject','cc','message','important','files','user_id','qid','vid','version'];
    protected $encryptable = ['subject','message','files','quote_subject'];

    protected $appends = ['to_name'];
    public function getToNameAttribute() {
        if(!empty($this->to_id)){
            $toId = explode(',',$this->to_id);
            $usernames = User::getData()->whereIn('id',$toId)->get()?->pluck('name')?->toArray();
         /*dd( $usernames);*/
            return !empty($usernames) ? implode(",",$usernames) : '';
        }

    }

    public function files(){
        return $this->hasMany(MessageFile::class,'message', 'id')->where('message_type',1)->select(['id as fileId','file_name as fileName','file_type as fileType','message','original_name as originalName']);
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


    public static function getData(array $array=null){

        $id = !empty($array['id']) ? $array['id'] : "" ;
        $type   = !empty($array['type']) ? $array['type'] : "" ;
        $value  = !empty($array['value']) ? $array['value'] : "" ;
        $userId = !empty($array['userId']) ? $array['userId'] : (auth()->user()?->id ?? 0);

        $data = new self;
        if (GateAllow('isAdminCompany')) {
            $data = $data->on("company_mysql");
        }

        if(!empty($id)){
            $data = $data->whereId($id);
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
