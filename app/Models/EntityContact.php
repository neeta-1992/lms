<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error;
use App\Models\Logs;
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class EntityContact extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;
    protected $fillable = ['entity_id','first_name',
      'middle_name','last_name','title','month',
      'day','email','telephone','extension','fax','notes'
    ]  ;
    protected $encryptable =  ['first_name',
        'middle_name','last_name','title','month',
        'day','email','telephone','extension','fax','notes'
    ] ;



      /**
      * The accessors to append to the model's array form.
      *
      * @var array
      */
      protected $appends = [
        'name',
      ];



      public function getNameAttribute()
      {
      return removeWhiteSpace("{$this->first_name} {$this->middle_name} {$this->last_name}");
      }


    public static function insertOrUpdate(array $array){

        $id               = !empty($array['id']) ? $array['id'] : '' ;
        $entityId         = !empty($array['entity_id']) ? $array['entity_id'] : null ;
        $first_name       = !empty($array['first_name']) ? $array['first_name'] : null ;
        $middle_name      = !empty($array['middle_name']) ? $array['middle_name'] : null ;
        $last_name        = !empty($array['last_name']) ? $array['last_name'] : null ;
        $title            = !empty($array['title']) ? $array['title'] : null ;
        $month            = !empty($array['month']) ? $array['month'] : 0 ;
        $day              = !empty($array['day']) ? $array['day'] : 0 ;
        $telephone        = !empty($array['telephone']) ? $array['telephone'] : null ;
        $extension        = !empty($array['extension']) ? $array['extension'] : null ;
        $fax              = !empty($array['fax']) ? $array['fax'] : null ;
        $notes            = !empty($array['notes']) ? $array['notes'] : null ;
        $email            = !empty($array['email']) ? $array['email'] : null ;
        $user_id          = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson          = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId            = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $saveOption       = !empty($array['save_option']) ? $array['save_option'] : null ;
        $parent_id        = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB             = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId         = !empty($array['parentId']) ? $array['parentId'] : null ;
        $activePage     = !empty($array['activePage']) ? $array['activePage'] : 'insuranceCompany' ;
        $entityName = !empty($array['entityName']) ? $array['entityName'] : 'Insurance' ;
        $logMag = !empty($array['logMag']) ? $array['logMag'] :false ;
        $titleArr         = !empty( $array['titleArr']) ? json_decode ( $array['titleArr'],true) : null ;

        $inserArr = [
            'entity_id'         => $entityId,
            'first_name'        => $first_name,
            'middle_name'       => $middle_name,
            'last_name'         => $last_name,
            'title'             => $title,
            'month'             => $month,
            'day'               => $day,
            'email'             => $email,
            'telephone'         => $telephone,
            'extension'         => $extension,
            'fax'               => $fax,
            'notes'             => $notes,
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
                    $getdata     = $model->updateOrCreate(['parent_id'=>$parentId],$inserArr);
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
                $msg = __('logs.entity_contact.add',['name'=>$name,'entity_name'=>$entityName]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.entity_contact.edit',['name'=>$name,'entity_name'=>$entityName])." ".$logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
           // dd(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->entity_id,'message'=>$msg]);
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$logId,'type_id'=>$getdata->entity_id,'message'=>$msg]);
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
        return !empty($logMag) ? $msg  : $getdata;
    }

     public static function getData(array $array = null)
    {

        $model = new self;

        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }
         if (isset($array['type'])) {
            $model = $model->whereType($array['type']);
         }
         if (isset($array['dId'])) {
            $model = $model->decrypt($array['dId']);
         }
         if (!empty($array['id'])) {
            $model = $model->whereId($array['id']);
         }
         if (!empty($array['eId'])) {
            $model = $model->whereEntityId($array['eId']);
         }
        return $model;
    }
}
