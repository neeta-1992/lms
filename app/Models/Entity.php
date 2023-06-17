<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Mail;
use App\Models\{
    Logs,User,AgentOffice,EntityContact,State,Notice
};
use App\Traits\ModelAttribute;
use App\Helpers\AllDataBaseUpdate;
use Illuminate\Support\Arr;
use App\Mail\LoginDetails;
class Entity extends Model
{
    use HasFactory;
    use ModelAttribute;
    use EncryptedAttribute;


    /**
     * Get the license_state_data that owns the Entity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function license_state_data(): BelongsTo
    {
        return $this->belongsTo(State::class, 'license_state', 'id');
    }


    /**
     * Get the notice_setting that owns the Entity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function notice_setting()
    {
        return $this->belongsTo(Notice::class, 'entity_id', 'id');
    }

    protected $fillable = [
        'user_id','name','username','agency',
        'legal_name',
        'telephone','email','website','fax','tin',
        'license_state','license_no','licence_expiration_date',
        'maximum_reinstate_allowed','mailing_address',
        'mailing_city','mailing_state','mailing_zip',
        'city','address','state','zip','sales_organization',
        'sales_excustive','sales_excustive_user',
        'other_fields','tax_id','down_payment_rule','aggregate_limit',
        'entity_type','notes','mailing_address_radio','type','parent_id',
        'rate_table','compensation_table','personal_maximum_finance_amount','commercial_maximum_finance_amount',
        'year_established','non_resident_licenses','json','upload_agency_ec_insurance','e_signature','status'
    ];
    protected $encryptable = [
        'name','username',
        'entity_name','legal_name',
        'telephone','email','website','fax','tin',
        'license_state','license_no','licence_expiration_date',
        'maximum_reinstate_allowed','mailing_address',
        'mailing_city','mailing_state','mailing_zip',
        'city','address','state','zip',
        'sales_excustive','sales_excustive_user',
        'other_fields','tax_id','down_payment_rule','personal_maximum_finance_amount','commercial_maximum_finance_amount',
        'notes','mailing_address_radio','rate_table','upload_agency_ec_insurance'
    ];



    /*=======---Entity Type is Define---======= */
    public const AGENT = 1;
    public const BROKER = 2;
    public const GENERALAGENT = 3;
    public const INSURED = 4;
    public const INSURANCECOMPANY   = 5;
    public const LINEHOLDER         = 6;
    public const SALESORG           = 7;


    /* status */
    public const  ACTIVE = 1;
    public const  TEMPORARY = -1;



    protected $appends = ['upload_agency_ec_insurance_url'];
    public function getUploadAgencyEcInsuranceUrlAttribute(){
        $file = $this->upload_agency_ec_insurance ;
        return !empty($file) ?  fileUrl($file) : '';
    }


    private static function entityUsername($type = null){

        if(empty($type)) {
            return null;
        }
        $type = (int)$type;
        switch ($type) {
            case self::INSURANCECOMPANY:
                $prefix = "IC";
                break;
            case self::GENERALAGENT:
                $prefix = "GA";
                break;
            case self::AGENT:
                $prefix = "AG";
                break;
            case self::INSURED:
                $prefix = "IN";
                break;
            case self::BROKER:
                $prefix = "BR";
                break;
            case self::LINEHOLDER:
                $prefix = "LH";
                break;
            case self::SALESORG:
                $prefix = "SE";
                break;
            default:
                $prefix = "";
                break;
        }

        $agencyCount = self::getData(['type'=>$type])->count();
        $agencyCount = (int)$agencyCount + 1;
        return  dbUsername($prefix,$agencyCount);
    }






    public static function insertOrUpdate(array $array){

        $id                     = !empty($array['id']) ? $array['id'] : '' ;
        $user_id                = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $logJson                = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId                  = !empty($array['logId']) ? $array['logId'] : '' ;
        $saveOption             = !empty($array['save_option']) ? $array['save_option'] : null ;
        $parent_id              = !empty($array['parent_id']) ? $array['parent_id'] : 0 ;
        $onDB                   = !empty($array['onDB']) ? $array['onDB'] : null ;
        $parentId               = !empty($array['parentId']) ? $array['parentId'] : null ;
        $notes                  = !empty($array['notes']) ? $array['notes'] : null ;
        $lang                   = !empty($array['lang']) ? $array['lang'] : null ;
        $type                   = !empty($array['type']) ? $array['type'] : null ;
        $rateTable              = !empty($array['rate_table']) ? implode(",",$array['rate_table']) : null ;
        $activePage             = !empty($array['activePage']) ? $array['activePage'] : null ;
        $owner                  = !empty($array['owner']) ?$array['owner'] : null ;
        $attachments            = !empty($array['attachments']) ? $array['attachments'] : null ;
        $entityContact          = !empty($array['entityContact']) ? $array['entityContact'] : null ;
        $pageTitle              = !empty($array['pageTitle']) ? $array['pageTitle'] : null ;
        $json                   = !empty($array['json']) ? json_encode($array['json']) : null ;
        $titleArr               = !empty($array['titleArr']) ? json_decode ( $array['titleArr'],true) : null ;
        $exceptArr              = ["id",'entityContact','pageTitle','company_data','attachments','activePage','first_name','middle_name','last_name','onDB','logId','logsArr','_token','pageTitle','user_type','owner','insurance'];
    /*     $insurance              = !empty($array['insurance']) ? $array['insurance'] : '';
        $json                   = !empty($insurance) ? json_encode($insurance) : $json; */
        $inserArr               = Arr::except($array,$exceptArr);
        $inserArr['user_id']    = $user_id;
        $inserArr['type'] = $type;


        if(!empty($json)){
            $inserArr['json'] = $json;
        }

        if(!empty($rateTable)){
            $inserArr['rate_table'] = $rateTable;
        }


        if(!empty($type) && empty($id)){
            $inserArr['username'] = self::entityUsername($type);
        }

        if(!empty($attachments)){
            $inserArr['upload_agency_ec_insurance'] = $attachments;
        }

        if(!empty($array['parent_id'])) {
            $inserArr['parent_id'] = $parent_id;
        }


        $logsmsg = $templateTextOld = $templateTextNew="";

        if(!empty($logJson)){
            $logsArr  = $logJson;
            $templateTextOld = !empty($logsArr['e_signature'][0]['prevValue']) ? $logsArr['e_signature'][0]['prevValue'] : '' ;
            $templateTextNew = !empty($logsArr['e_signature'][0]['value']) ? $logsArr['e_signature'][0]['value'] : '' ;
            $logsmsg = dbLogFormat($logsArr);
        }

        $model  = new self;
        if(GateAllow('isAdminCompany') || !empty($onDB)){
         $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
           if(!empty($id) || !empty($parentId)){
                //$inserArr  = arrFilter($inserArr);
              //  dd($inserArr );
                if(!empty($parentId)){

                    $getdata     = $model->updateOrCreate(['parent_id'=>$parentId],$inserArr);
                    $getChanges  = $getdata?->changesArr;
                    if(!empty($getChanges)){
                        $logsMsg  = logsMsgCreate($getChanges,$titleArr,$logJson);
                        $logsmsg .= $logsMsg?->msg;
                    }
                }else{
                    $getdata  = $model->updateOrCreate(['id'=>$id],$inserArr);
                }
            }else{
                $getdata  =  $model->create($inserArr);
            }
            $entityId = $getdata?->id;
            $wasRecentlyCreated = $getdata?->wasRecentlyCreated;
            $name = $getdata?->name ?? "";
            if($wasRecentlyCreated == true){
                $msg = "<li>".__('logs.'.$lang.'.add',['name'=>$name])." </li>";
            }else{
                if(!empty($logsmsg)){
                    $msg = __('logs.'.$lang.'.edit',['name'=>$name])." ".$logsmsg;
                }
            }


            /*
             $entity Contact Save
            */
            if(!empty($entityContact) && $wasRecentlyCreated == true){
              //  $msg .= !empty($msg) ? ' and '  : '' ;
                $msg .= "<li>".self::entityContact($entityContact,$entityId,$lang,$pageTitle)." </li>";

            }

            /*
             * Add Home Office For Agent
             */
            $officeData = null;
            if($wasRecentlyCreated == true && ($activePage == 'agents' || $activePage == 'sales-organizations')){
                $officeArr      = $array;
                $city           = !empty($officeArr['city']) ? $officeArr['city'] : '';
                $state          = !empty($officeArr['state']) ? $officeArr['state'] : '';
                $officeArr['logMag'] = true;
                $officeArr['agency_id'] = $entityId;
                $officeArr['name'] = "{$city},{$state} *";
                $officeData =  AgentOffice::insertOrUpdate($officeArr);
                $msg .= !empty($officeData?->logMsg) ? "<li>".$officeData?->logMsg." </li>" : '';
            }

            /*
             *  Add Agency Ownership  Users
             */

            if(!empty($owner) && $wasRecentlyCreated == true ){
                $owner['officeId'] = $officeData?->id;
                if($activePage == 'agents'){
                    $owner['userType'] = User::AGENT;
                }elseif($activePage == 'insureds'){
                    $owner['userType'] = User::INSURED;
                }elseif($activePage == 'sales-organizations'){
                    $owner['userType'] = User::SALESORG;
                }

                $loguserMsg = self::agentUser($owner,$getdata,$lang);
                $msg .= !empty($loguserMsg) ? "<li>".$loguserMsg." </li>" : '';
            }
            if(!empty($array) && $activePage == 'insureds' && $wasRecentlyCreated == true){
                $array['userType'] =  User::INSURED;
                self::insuredUser($array,$getdata,$lang);
            }
            if($wasRecentlyCreated == true ){
              /*   dd($msg); */
                $msg = "<ul class='logs_ul'>{$msg}</ul>";
            }

            /*
            * Logs Save In @Log Model
            */
            $logId = !empty($logId) ? $logId : $getdata->id;
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$user_id,'type_id'=>$logId,'message'=>$msg,'old_value'=>$templateTextOld,'new_value'=>$templateTextNew]);
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


    private static function entityContact($data,$entityId=null,$lang="",$pageTitle=null){
        $data = arrayFormatGroup($data) ?? [];
        $data['entity_id'] = $entityId;
        $data['logId'] = $entityId;
        $data['lang'] = $lang;
        $data['entityName'] = $pageTitle;
        $data['logMag'] = true;
        $response = EntityContact::insertOrUpdate($data);
        return $response;
    }





    private static function insuredUser($owner,$getdata,$lang=""){
        $first_name = isset($owner['first_name']) ? $owner['first_name'] : '' ;
        $middle_name    = isset($owner['middle_name']) ? $owner['middle_name'] : '' ;
        $last_name      = isset($owner['last_name']) ? $owner['last_name'] : '' ;
        $title          = isset($owner['title']) ? $owner['title'] : '' ;
        $month          = isset($owner['month']) ? $owner['month'] : '' ;
        $day            = isset($owner['day']) ? $owner['day'] : '' ;
        $inmail_service = isset($owner['inmail_service']) ? $owner['inmail_service'] : '' ;
        $email          = isset($owner['email']) ? $owner['email'] : '' ;
        $telephone      = isset($owner['telephone']) ? $owner['telephone'] : '' ;
        $extenstion     = isset($owner['extenstion']) ? $owner['extenstion'] : '' ;
        $alternate_telephone = isset($owner['alternate_telephone']) ? $owner['alternate_telephone'] : '' ;
        $alternate_telephone_extenstion = isset($owner['alternate_telephone_extenstion']) ? $owner['alternate_telephone_extenstion'] : '' ;
        $state              = isset($owner['state']) ? $owner['state'] : '' ;
        $licence_no         = isset($owner['licence_no']) ? $owner['licence_no'] : '' ;
        $expiration_date    = isset($owner['expiration_date']) ? $owner['expiration_date'] : '' ;
        $owner_percent      = isset($owner['owner_percent']) ? $owner['owner_percent'] : '' ;
        $userType           = isset($owner['userType']) ? $owner['userType'] : '' ;
        $owner              = isset($owner['owner']) ? $owner['owner'] : false ;

        $password           = randomPasswordUser($userType);

        $insertArray = [
            'entity_id'         => $getdata?->id ?? 0,
            'agencyUsername'    => $getdata?->username ?? '',
            'first_name'        => $first_name,
            'middle_name'       => $middle_name,
            'last_name'         => $last_name,
            'title'             => $title,
            'month'             => $month,
            'day'               => $day,
            'inmail_service'    => $inmail_service,
            'mobile'            => $telephone,
            'extenstion'        => $extenstion,
            'alternate_telephone' => $alternate_telephone,
            'state'             => $state,
            'licence_no'        => $licence_no,
            'expiration_date'   => $expiration_date,
            'email'             => $email,
            'lang'              => $lang,
            'type'              =>$userType,
            'password'          => bcrypt($password),
            'logId'             => $getdata?->id ?? 0,
        ];

        $data =  User::saveAgent($insertArray);

        if(!empty($email)){
            Mail::to($email)->send(new LoginDetails(['name'=>$first_name,'username'=>$data?->username,'password'=>$password]));
        }


        return $data;
    }




    private static function agentUser($owner,$getdata){

        $msg = "";
         if(!empty($owner)){
            $first_name = !empty($owner['first_name']) ? $owner['first_name'] : '' ;
            $officeId = !empty($owner['officeId']) ? $owner['officeId'] : '' ;
            $userType = !empty($owner['userType']) ? $owner['userType'] : 0 ;
            $randomPasswordUser = randomPasswordUser($userType);
            if(!empty($first_name)){
                $count = 1;
                foreach ($first_name as $key => $value) {

                    $role = $count == 1 ? 1 : 2;
                    $first_name = $value;
                    $middle_name = isset($owner['middle_name'][$key]) ? $owner['middle_name'][$key] : '' ;
                    $last_name = isset($owner['last_name'][$key]) ? $owner['last_name'][$key] : '' ;
                    $title = isset($owner['title'][$key]) ? $owner['title'][$key] : '' ;
                    $month = isset($owner['month'][$key]) ? $owner['month'][$key] : '' ;
                    $day = isset($owner['day'][$key]) ? $owner['day'][$key] : '' ;
                    $inmail_service = isset($owner['inmail_service'][$key]) ? $owner['inmail_service'][$key] : '' ;
                    $email = isset($owner['email'][$key]) ? $owner['email'][$key] : '' ;
                    $telephone = isset($owner['telephone'][$key]) ? $owner['telephone'][$key] : '' ;
                    $extenstion = isset($owner['extenstion'][$key]) ? $owner['extenstion'][$key] : '' ;
                    $alternate_telephone = isset($owner['alternate_telephone'][$key]) ? $owner['alternate_telephone'][$key] : '' ;
                    $alternate_telephone_extenstion = isset($owner['alternate_telephone_extenstion'][$key]) ?
                    $owner['alternate_telephone_extenstion'][$key] : '' ;
                    $state = isset($owner['state'][$key]) ? $owner['state'][$key] : '' ;
                    $licence_no = isset($owner['licence_no'][$key]) ? $owner['licence_no'][$key] : '' ;
                    $expiration_date = isset($owner['expiration_date'][$key]) ? $owner['expiration_date'][$key] : '' ;
                    $owner_percent = isset($owner['owner_percent'][$key]) ? $owner['owner_percent'][$key] : '' ;
                    $email_information = isset($owner['email_information'][$key]) ? ($owner['email_information'][$key]) : null;
                    $password = isset($owner['password'][$key]) ? ($owner['password'][$key]) : null ;
                    $password = !empty($password) ? $password : $randomPasswordUser;



                    $insertArray = [
                        'entity_id'         => $getdata?->id ?? 0,
                        'agencyUsername'    => $getdata?->username ?? '',
                        'office'            => $officeId,
                        'first_name'        => $first_name,
                        'middle_name'       => $middle_name,
                        'last_name'         => $last_name,
                        'title'             => $title,
                        'month'             => $month,
                        'day'               => $day,
                        'inmail_service'    => $inmail_service,
                        'mobile'            => $telephone,
                        'extenstion'        => $extenstion,
                        'alternate_telephone' => $alternate_telephone,
                        'state'             => $state,
                        'licence_no'        => $licence_no,
                        'expiration_date'   => $expiration_date,
                        'owner_percent'     => $owner_percent,
                        'email'             => $email,
                        'password'          => bcrypt($password),
                        'type'              => $userType,
                        'role'              => 1,
                        'owner'             => 1,
                        'email_information' => $email_information,
                    ];

                    $userInserrtData = User::saveAgent($insertArray);
                    if(!empty($email) && $userType == User::AGENT){
                        Mail::to($email)->send(new LoginDetails(['name'=>$first_name,'username'=>$userInserrtData?->username,'password'=>$password]));
                    }
                    $msg .= !empty($userInserrtData?->logMsg) ? $userInserrtData?->logMsg : '';
                    $count++;
                 }
            }
        }
        return $msg;
    }

    public static function getData(array $array = null){

        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        $model->when(!empty($array['search']) , function ($q) use($array) {
             return $q->whereLike('name',$array['search']);
        });

         if (!empty($array['agency'])) {
             $model = $model->where('agency',$array['agency']);
         }
         if (!empty($array['salesOrganization'])) {
             $model = $model->where('sales_organization',$array['salesOrganization']);
         }
         if (isset($array['type'])) {
            $model = $model->whereType($array['type']);
         }
         if (isset($array['id'])) {
            $model = $model->whereId($array['id']);
         }
         if (isset($array['dId'])) {
            $model = $model->decrypt($array['dId']);
         }

        return $model;
    }


}
