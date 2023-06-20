<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,User,Entity,QuoteTerm,Quote,QuoteAccountExposure
};
use App\Traits\ModelAttribute;
class QuoteAccount extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = [
        'user_id','quote','version','insured','agent',
        'agency','insured_uid','agent_uid',
        'account_number','user_id',
        'activation_agent_date','underwriting_verification_date',
        'account_type','quote_type','origination_state',
        'payment_method','payment_method_account_type',
        'insured_existing_balance','bank_routing_number','bank_name',
        'bank_account_number',
        'card_holder_name','card_number','end_date','cvv',
        'cardholder_email','account_name',
        'mailing_address','mailing_city',
        'mailing_state','mailing_email','payment_method_account_type',
        'mailing_zip',
        'email_notification','cancel_date','payment_status',
        'originationstate','state_settings','late_fee','card_token','square_card_id','square_customer_id',
        'effective_date','status','quoteoriginationstate','suspend_status','suspend_date','unsuspend_date','suspend_reason','suspend_user'
    ];

    protected $encryptable = ['account_name','card_holder_name','card_number','end_date','cvv',
    'cardholder_email','mailing_address','mailing_city','mailing_state','card_token','square_card_id','square_customer_id',
    'mailing_zip',];


    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agency_data()
    {
        return $this->belongsTo(Entity::class, 'agency', 'id');
    }

    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function insur_data()
    {
        return $this->belongsTo(Entity::class, 'insured', 'id');
    }

    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function insured_user()
    {
        return $this->belongsTo(User::class, 'insured_uid', 'id');
    }

    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function agent_user()
    {
        return $this->belongsTo(User::class, 'agent', 'id');
    }

    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quote_term()
    {
        return $this->belongsTo(QuoteTerm::class, 'quote', 'quote')->where('version',$this->version);
    }


    /**
     * Get all of the quote_data for the QuoteAccount
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function q_data()
    {
        return $this->hasOne(Quote::class, 'id', 'quote');
    }


    /**
     * Get all of the quote_data for the QuoteAccount
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quote_data()
    {
        return $this->hasMany(Quote::class, 'id', 'quote');
    }

     /**
     * Get the next_payment that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function next_payment()
    {
        return $this->hasOne(QuoteAccountExposure::class, 'account_id', 'id')->where('status',0)->orderBy('payment_number','asc');
    }






    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $userId          = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $quote           = !empty($array['quote']) ? $array['quote'] : null;
        $version         = !empty($array['version']) ? $array['version'] : null;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null;
        $titleArr        = !empty($array['titleArr']) ? json_decode($array['titleArr'],true) : null;


        $model    = new self; //Load Model
        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['user_id'] = $userId;

        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }

        $logsmsg = "";
        if(!empty($logJson)){
            $logsArr  = $logJson;
            $logsmsg  = dbLogFormat($logsArr);
        }

        


        DB::beginTransaction();
        try {
            if (!empty($id) || !empty($parentId)) {
                $getdata = $model->updateOrCreate(['id' => $id], $inserArr);
            } else {
                $getdata = $model->updateOrCreate(['quote' => $quote,'version'=>$version],$inserArr);
            }

          
            $name = $getdata?->subject ?? "";
            $wasRecentlyCreated = $getdata?->wasRecentlyCreated ?? "";
            $changesArr = $getdata?->changesArr ?? [];
           
            if(empty($logsmsg) && !empty($titleArr)){
                $logsmsg = logsMsgCreate($changesArr,$titleArr)?->msg;
            }

/* dd($logsmsg,$changesArr ); */

          
            $typeId = !empty($id) ? $id : $getdata->id;
            if ($wasRecentlyCreated == true) {
                $msg = __('logs.' . $activePage . '.add', ['name' => $name]);
            } else {
                if (!empty($logsmsg)) {
                    $msg = __('logs.' . $activePage . '.edit', ['name' => $name]) . " " . $logsmsg;
                }
            }
            /*
             * Logs Save In @Log Model
             */
            !empty($msg) && Logs::saveLogs(['type'=>$activePage,'user_id'=>$userId,'type_id'=>$getdata?->id ,'message'=>$msg]);

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
        if(!empty($array['qId'])){
            $model = $model->where('qId',$array['qId']);
        }
        return $model;
     }
}
