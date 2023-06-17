<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error;
use App\Models\{
    Logs,State
};
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
class UserProfile extends Model
{
    use HasFactory;
    use ModelAttribute;
 //   use EncryptedAttribute;


 
    /**
     * Get the license_state_data that owns the Entity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function license_state_data()
    {
        return $this->belongsTo(State::class, 'state_resident', 'id');
    }

    protected $fillable = ['user_id','title','month'
        ,'day','state_resident', 'licence_no', 'expiration_date'
        ,'convicted',
        'insurance_department','notes',
  ];
   // protected $encryptable = ['name','description'];


    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $user_id = !empty($array['user_id']) ? $array['user_id'] : '' ;
        $name            = !empty($array['name']) ? $array['name'] : '' ;
        $description     = !empty($array['description']) ? $array['description'] : null ;
        $status          = !empty($array['status']) ? $array['status'] : 0 ;
        $logJson         = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId           = !empty($array['logId']) ? $array['logId'] : $user_id ;
        $saveOption      = !empty($array['save_option']) ? $array['save_option'] : null ;
        $parent_id       = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $parentId        = !empty($array['parentId']) ? $array['parentId'] : null ;
        $titleArr        = !empty( $array['titleArr']) ? json_decode ( $array['titleArr'],true) : null ;

        $inserArr = [
            'user_id' => $user_id,
            'title'     => isset($array['title']) ? $array['title'] : null,
            'month' => isset($array['month']) ? $array['month'] : null,
            'day' => isset($array['day']) ? $array['day'] : null,
            'state_resident' => isset($array['state_resident']) ? $array['state_resident'] : null,
            'licence_no' => isset($array['licence_no']) ? $array['licence_no'] : null,
            'expiration_date' => isset($array['expiration_date']) ? date("Y-m-d",strtotime($array['expiration_date'])): null,
            //'owner_percent' => !empty($array['owner_percent']) ? $array['owner_percent'] : null,
            'convicted' => isset($array['convicted']) ? $array['convicted'] : null,
            'insurance_department' => isset($array['insurance_department']) ? $array['insurance_department'] : null,
            'notes' => isset($array['notes']) ? $array['notes'] : null,
        ];

        if(!empty($array['parent_id']) ) {
            $inserArr['parent_id'] = $parent_id;
        }


        $model  = new self;
        if(GateAllow('isAdminCompany') || !empty($onDB)){
             $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
           if(!empty($user_id)){
                $inserArr  = arrFilter($inserArr);
                $getdata = $model->updateOrCreate(['user_id'=>$user_id],$inserArr);
            }else{
                $getdata  =    $model->create($inserArr);
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
