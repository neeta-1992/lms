<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Hash;
use App\Models\{
    Logs,Company,UserProfile,UserSecuritySetting,PasswordReset,Entity,AgentOffice
};
use App\Traits\ModelAttribute;
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use ModelAttribute;
    use EncryptedAttribute;

    public const ADMIN          = 1;
    public const AGENT          = 2;
    public const COMPANYADMIN   = 3;
    public const COMPANYUSER    = 4;
    public const INSURED        = 5;
    public const SALESORG       = 6;

    /* User Status */
    public const DEACTIVEUSER   = 0;
    public const ACTIVEUSER     = 1;
    public const SUSPENDEDUSER  = 2;
    public const INACTIVEUSER   = 3;
    public const DISABLEUSER = 4;



    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'company_id',
        'username',
        'first_name',
        'middle_name',
        'last_name',
        'mobile',
        'email',
        'email_verified_at',
        'password',
        'status',
        'profile_photo_path',
        'user_type',
        'inmail_service',
        'extenstion','fax',
        'alternate_telephone','office',
        'alternate_telephone_extenstion','role','login_date','suspend',
        'entity_id','esignature','owner','owner_percent','office','email_information','old_passwords','password_expiry'
    ];


    protected $encryptable = ['username','fax',
    'first_name','middle_name','last_name','mobile','email','email_information'];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
       'profile_photo_url','name',
    ];



    public function getNameAttribute()
    {
        return removeWhiteSpace("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }



    /**
     * Get the company that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }


    /**
     * Get the entity that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id', 'id');
    }

    /**
     * Get the profile associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }
    /**
     * Get the profile associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function office_data()
    {
        return $this->hasOne(AgentOffice::class, 'id', 'office');
    }


    private static function generateUsername(?array $array=null,$role =null,$id=null):string{
        $type = isset($array['type'])  ? $array['type'] : '' ;
        switch ($type) {
            case ('company'):
                $prefix = 'PF';
                $userType = self::COMPANYUSER;
                break;
            case 'agent':
                $prefix = 'AG';
                $userType = self::AGENT;
                break;
            /*case ('company' && $role == 2):
                $prefix = 'FC';
                $userType = self::COMPANYUSER;
                break;*/
            default:
                $prefix = '';
                $userType = 0;
                break;
        }

        $count = self::getData(['type'=>$userType]);
      /*   if(!empty($count)){
            $count = $count->where('id','!=',$id);
        } */
        $count = $count->count();
        $count = !empty($count) ? $count + 1 : 1;
        return dbUsername($prefix,$count);
    }


    private static function agentUsername($entityId,$entityUsername){
        $agencyCount = self::getData(['entityId'=>$entityId])->count();

        $agencyCount = (int)$agencyCount + 1;
        return "{$entityUsername}-{$agencyCount}";
    }


    public static function saveCompany(array $array)
    {
        $editId     = !empty($array['editId']) ? $array['editId'] : '' ;
        $company_id = isset($array['company_id']) ? $array['company_id'] : null;
        $username   = !empty($array['username']) ?  $array['username'] : self::generateUsername(['type'=>'company']);
        $first_name = isset($array['first_name']) ? $array['first_name']  :null;
        $middle_name= isset($array['middle_name']) ? $array['middle_name']  : null;
        $last_name  = isset($array['last_name']) ? $array['last_name']  :null;
        $name       = isset($array['comp_contact_name']) ? $array['comp_contact_name']  :null;

        if(!empty($name)){
            list($first_name,$middle_name,$last_name) = nameDivision($name); // This Is Common  Helpers
        }

        $mobile     = isset($array['primary_telephone']) ? $array['primary_telephone']  :'';
        $email      = isset($array['comp_contact_email']) ? $array['comp_contact_email']  :null;
        $email      = !empty($array['email']) ? $array['email'] :$email ;
        $email      = !empty($array['mobile']) ? $array['mobile'] :$mobile ;
        $password   = isset($array['password']) ? $array['password']  :null;
        $onDB       = isset($array['onDB']) ? $array['onDB']  :null;
        $logId      = isset($array['logId']) ? $array['logId']  :null;
        $password   = empty($password) ? randomPassword()  : $password;

        $password   = !empty($password) ? Hash::make($password)  :null;

        $insertArray = [
            'company_id'    => $company_id,
            'username'      => $username,
            'first_name'    => removeWhiteSpace($first_name),
            'middle_name'   => removeWhiteSpace($middle_name),
            'last_name'     => removeWhiteSpace($last_name),
            'mobile'        => $mobile,
            'email'         => removeWhiteSpace($email),
            'password'      => $password,
            'user_type'     => self::COMPANYUSER,
            'status'        => 0,
            'role'          => 1,
        ];

        $model  = new self;
        if(GateAllow('isAdminCompany')){
        $model = $model->on('company_mysql');
        }
        DB::beginTransaction();
        try {
            if(!empty($editId)){
                $insertArray = array_filter($insertArray);
                $getdata     =  $model->updateOrCreate(['company_id'=>$editId],$insertArray);
            }else{
                $getdata     =  $model->create($insertArray);
                Logs::saveLogs(['type'=>'finance-company','user_id'=>$logId,'type_id'=>$company_id,'message'=>__('logs.finance_company.add',['username'=>$username])]);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }
      DB::commit();
      return $getdata;

    }




    public static function saveAgent(array $array)
    {
        $editId         = !empty($array['id']) ? $array['id'] : '' ;
        $entity_id      = isset($array['entity_id']) ? $array['entity_id'] : null;
        $company_id     = isset($array['company_id']) ? $array['company_id'] : null;
        $agencyUsername = isset($array['agencyUsername']) ? $array['agencyUsername'] : null;
        $username       = !empty($array['username']) ? $array['username'] : '';
        $userType       = !empty($array['userType']) ? $array['userType'] : '';
        $role = isset($array['role']) ? (int)$array['role'] :0;
        $agencyUsername = !empty($agencyUsername) ? self::agentUsername($entity_id,$agencyUsername) : $username;
        if(empty($agencyUsername) && !empty($userType) && empty($editId)){
            $agencyUsername = self::generateUsername(['type'=>$userType],$role,$editId) ;
        }
        $first_name     = isset($array['first_name']) ? $array['first_name']  :null;
        $middle_name    = isset($array['middle_name']) ? $array['middle_name']  :null;
        $last_name      = isset($array['last_name']) ? $array['last_name']  :null;
        $name           = isset($array['name']) ? $array['name'] :null;
        $reset_password = isset($array['reset_password']) ? $array['reset_password'] :null;
        $inmail_service = isset($array['inmail_service']) ? (bool)$array['inmail_service'] :false;
        $extenstion     = isset($array['extenstion']) ? $array['extenstion'] :null;
        $alternate_telephone = isset($array['alternate_telephone']) ? $array['alternate_telephone'] :null;
        $alternate_telephone_extenstion = isset($array['alternate_telephone_extenstion']) ? $array['alternate_telephone_extenstion'] :null;
        if(empty($first_name) && !empty($name)){
            list($first_name,$middle_name,$last_name) = nameDivision($name); // This Is Common  Helpers
        }
        $user_id        = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $password       = isset($array['password']) ? $array['password']  :null;
        $activePage     = isset($array['activePage']) ? $array['activePage'] :null;
        $onDB           = isset($array['onDB']) ? $array['onDB']  :null;
        $logId          = isset($array['logId']) ? $array['logId']  :null;
        $type           = isset($array['type']) ? $array['type'] :null;
        $mobile         = isset($array['mobile']) ? $array['mobile'] :null;
        $reset_password_email = isset($array['reset_password_email']) ? $array['reset_password_email'] :null;
        $fax            = isset($array['fax']) ? $array['fax'] :null;
        $email          = isset($array['email']) ? $array['email'] :null;
        $esignature     = isset($array['esignature']) ? $array['esignature'] :null;
        $owner_percent  = isset($array['owner_percent']) ? $array['owner_percent'] :null;
        $office         = isset($array['office']) ? $array['office'] :null;
        $status         = isset($array['status']) ? (bool)$array['status'] :false;

        $is_agent_admin = isset($array['is_agent_admin']) ? (int)$array['is_agent_admin'] : $role;
        $owner          = !empty($array['owner']) ? true :false;
        $email_information = !empty($array['email_information']) ? json_encode($array['email_information']) :null;
        $logJson        = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
       // $password       = empty($password) ? randomPassword()  : $password;


         $logsmsg = $msg = "";
        if(!empty($logJson)){
            $logsArr  = $logJson;
            $logsmsg = dbLogFormat($logsArr);
        }

        $insertArray = [
            'entity_id'         => $entity_id,
            'company_id' => $company_id,
            'esignature'        => $esignature,
            'owner_percent'     => $owner_percent,
            'first_name'        => removeWhiteSpace($first_name),
            'middle_name'       => removeWhiteSpace($middle_name),
            'last_name'         => removeWhiteSpace($last_name),
            'mobile'            => $mobile,
            'email'             => $email,
            'fax'               => $fax,
          //  'password'          => $password,
            'alternate_telephone' => $alternate_telephone,
            'alternate_telephone_extenstion' => $alternate_telephone_extenstion,
            'inmail_service'    => $inmail_service,
            'extenstion'        => $extenstion,
            'role'              => $is_agent_admin,
            'status'            => $status,
            'owner'             => $owner,
            'office'            => $office,
            'email_information' => $email_information,
        ];



        if(!empty($agencyUsername)){
            $insertArray['username'] = $agencyUsername;
        }
        if(!empty($type)){
            $insertArray['user_type'] = $type;
        }


        $model  = new self;
        if(GateAllow('isAdminCompany')){
        $model = $model->on('company_mysql');
        }
        DB::beginTransaction();
        try {
            if(!empty($editId)){
                $insertArray = arrFilter($insertArray);
                $getdata     =  $model->updateOrCreate(['id'=>$editId],$insertArray);
            }else{
                $getdata     =  $model->create($insertArray);
            }

///dd($password);
            if(!empty($password)){
                self::oldPassword($getdata,$password);
            }

            if(!empty($reset_password) && ($reset_password == 'yes' || $reset_password == 'email') && !empty($status)){
                $email = $reset_password == 'email' ? $reset_password_email : $email;
                if(!empty($email)){
                    PasswordReset::resetPassword([
                        'email' => $email,
                        'username' => $getdata?->username,
                        'name' => $getdata?->name,
                        'userType' => $getdata?->user_type,
                    ]);
                }

            }




            $profileArray = $array;
            $profileArray['user_id'] =$getdata?->id;
            $data = UserProfile::insertOrUpdate($profileArray);

            $name = $getdata?->name ?? "";
            if($getdata->wasRecentlyCreated == true){
                $msg = __('logs.user.add',['name'=>$name]);
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.user.edit',['name'=>$name])." ".$logsmsg;
                }
            }

            !empty($getdata) && $getdata['logMsg'] = $msg;
             $logId = !empty($logId) ? $logId : $getdata->id;
            /*
             * Logs Save In @Log Model
             */

            !empty($msg) &&
            Logs::saveLogs([
                'type'      =>$activePage,
                'onDB'      =>$onDB,
                'user_id'   =>$user_id,
                'type_id'   =>$logId,
                'uId'       =>$getdata->id,
                'message'   =>$msg
            ]);


        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }
      DB::commit();
      return $getdata;

    }




    public static function oldPassword($userData,$password,$securitySetting= null){

        $userType = !empty($userData->user_type) ? $userData->user_type : 'null' ;
        if(empty($securitySetting)){
            $securitySetting = UserSecuritySetting::getData(['type'=>$userType])->first();
        }

        $minimum_password_age = !empty($securitySetting->minimum_password_age) ? $securitySetting->minimum_password_age : '' ;
        $passArr = [];
        $oldPassword = $userData?->old_passwords ?? null;
        $oldPassword = !empty($oldPassword) ? json_decode($oldPassword,true) : [] ;

        if(!empty($oldPassword)){
            if(count($oldPassword) >= 3){
                unset($oldPassword[2]);
                array_unshift($oldPassword,$password);
            }else{
                array_unshift($oldPassword,$password);
            }
            $passArr = $oldPassword;
        }else{
            $passArr[] = $password;
        }
	///	echo $password;
        if(!empty($passArr)){
            $expiry = !empty($minimum_password_age) ? now()->addDays($minimum_password_age) : null;
            $userData->password_expiry = $expiry;
            $userData->password = $password;
            $userData->old_passwords = json_encode($passArr);
            $userData->save();
        }


    }

    public static function getData(array $array=null){

        $model = new self;

        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }

        $model
        ->when(!empty($array['entityId']), function ($q) use($array) {
            $entityId = (int)$array['entityId'];
            return $q->whereEntityId($entityId);
        })
        ->when(!empty($array['office']), function ($q) use($array) {
            $office = (int)$array['office'];
            return $q->whereOffice($office);
        })

        ->when(!empty($array['name']), function ($q) use($array) {
            return $q->whereConcatLike('first_name','last_name','LIKE',$array['name']);
        })
        ->when((!empty($array['first_name']) || !empty($array['last_name'])), function ($q) use($array) {
            $first_name = !empty($array['first_name']) ? $array['first_name'] : '';
            $last_name = !empty($array['last_name']) ? $array['last_name'] : '';
            if(!empty($first_name) && empty($last_name)){
                return $q->whereLike('first_name',$first_name);
            }elseif(!empty($last_name) && empty($first_name)){
                return $q->whereLike('last_name',$last_name);
            }elseif(!empty($last_name) && !empty($first_name)){
                return $q->whereLike('first_name',$first_name)->orwhereLike('last_name',$last_name);
            }
        })
        ->when(!empty($array['email']), function ($q) use($array) {
            return $q->whereLike('email',$array['email']);
        })
        ->when(!empty($array['telephone']), function ($q) use($array) {
            return $q->whereLike('mobile',$array['telephone']);
        })
      /*   ->when(!empty($array['role']), function ($q) use($array) {
            return $q->where('role',$array['role']);
        }) */
        ->when(!empty($array['status']), function ($q) use($array) {
                return $q->where('status',$array['status']);
        })
        ->when(!empty($array['user_type']), function ($q) use($array) {
            $userType = !empty($array['user_type']) ? $array['user_type'] : '' ;
            $userType = $userType == 3 ? [2,3] : $userType;
            if(is_array($userType)){
                return $q->whereIn('user_type',$userType);
            }else{
              return $q->where('user_type',$userType);
            }
        })
        ->when(!empty($array['dId']), function ($q) use($array) {
            return $q->decrypt($array['dId']);
        });

        if(!empty($array['role'])){
            $model = $model->where('role',$array['role']);
        }

        if(!empty($array['username'])){
            $model = $model->whereEn('username',$array['username']);
        }
        if(!empty($array['id'])){
            $model = $model->whereId($array['id']);
        }

        if(!empty($array['notEq'])){
            $key = !empty($array['notEq']['key']) ? $array['notEq']['key'] : '';
            $value = !empty($array['notEq']['value']) ? $array['notEq']['value'] : '';
            $model = $model->whereNot($key,$value);
        }

        if(!empty($array['type'])){
            $type = !empty($array['type']) ? $array['type'] : '' ;
            if(is_array($type)){
               $model = $model->whereIn('user_type',$type);
            }else{
               $model = $model->where('user_type',$type);
            }
        }

        return $model;
     }

}
