<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr,DBHelper;
use App\Models\{
    Logs,User,QuoteVersion,StateSettings,Payable,Funding,NoticeTemplate,TransactionHistory,
    QuotePolicy,Entity,QuoteTerm,Message,Task,QuoteAccountExposure,QuoteAccount,State,StateSettingInterestRate,CoverageType
};
use App\Traits\ModelAttribute;
use App\Helpers\{
    QuoteHelper,DailyNotice
};
class Quote extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;

    protected $fillable = [
        'user_id','qid','vid','version','insured','agent',
        'agency','insured_uid','agent_uid','rate_table',
        'activation_insured','activation_agent',
        'reverse_activation_agent','reverse_activation',
        'activation_agent_date','underwriting_verification_date',
        'account_type','quote_type','origination_state',
        'payment_method','payment_method_account_type',
        'insured_existing_balance','bank_routing_number',
        'bank_account_number',
        'card_holder_name','card_number','end_date','cvv',
        'cardholder_email','account_name',
        'mailing_address','mailing_city','mailing_state','finance_company',
        'mailing_zip',
        'email_notification','quote_notes',"status",'aggregate_limit_approve',
        'aggregate_limit_admin_user_id','quoteoriginationstate'
    ];

    protected $encryptable = [];


    /* Status */
    public const DRAFT          = -1;
    public const NEW            = 1;
    public const ACTIVEREQUEST  = 2;
    public const PROCESS        = 3;  //underwriting Quote
    public const APPROVE        = 4;
    public const DECLINE        = 5;
    public const DELETE         = 6;
    public const FINALAPPROVAL  = 7;


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
    public function terms_data()
    {
        return $this->hasOne(QuoteTerm::class, 'quote', 'id');
    }


    /**
     * Get the QuoteAccount that owns the Quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function quote_account()
    {
        return $this->belongsTo(QuoteAccount::class, 'quote', 'id');
    }
    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function policy_data()
    {
        return $this->hasMany(QuotePolicy::class, 'quote', 'id');
    }

    protected $appends = ['quote_number'];


    public function getQuoteNumberAttribute(){
        return $this->qid.'.'.$this->version;
    }




    private static function qid(){
        $count = self::getData()->count();
        $count =  (int)$count + 1 ;
        return idCount(1,$count);
    }

    public static function darftSaveData(array $array)
    {

        $draftId            = !empty($array['draftId']) ? $array['draftId'] : false ;
        $id                 = !empty($array['id']) ? $array['id'] :  $draftId ;
        $user_id            = !empty($array['user_id']) ? $array['user_id'] : auth()->user()->id;
        $onDB               = !empty($array['onDB']) ? $array['onDB'] : null ;
        $insured            = !empty($array['insured']) ? $array['insured'] : null ;
        $agency              = !empty($array['agency']) ? $array['agency'] : null ;
        $isDraft            = !empty($array['isDraft']) ? $array['isDraft'] : false ;
        $activePage         = !empty($array['activePage']) ? $array['activePage'] : null ;
        $month              = !empty($array['month']) ? $array['month'] : null ;
        $year               = !empty($array['year']) ? $array['year'] : null ;


        $model    = new self; //Load Model
        $inserArr = Arr::only($array,$model->fillable);
        if(empty($id)){
            $inserArr['qid'] = self::qid();
            $inserArr['user_id'] = $user_id;
        }
        $input['end_date'] = "{$year}-$month";

        $inserArr['insured_uid']  = User::getData(['entityId'=>$insured,'type'=>User::INSURED])->orderBy('id','asc')->first()?->id ?? null;
        $inserArr['agent']  = User::getData(['entityId'=>$agency,'type'=>User::AGENT])->orderBy('id','asc')->first()?->id ?? null;


        if(GateAllow('isAdminCompany') || !empty($onDB)){
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
        if(!empty($id) || !empty($parentId)){
            $inserArr  = arrFilter($inserArr);
            $getdata   = $model->updateOrCreate(['id'=>$id],$inserArr);
        }else{
            $getdata   = $model->create($inserArr);
        }



        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }




    public static function insertOrUpdate(array $array){

        $draftId            = !empty($array['draftId']) ? $array['draftId'] : false ;
        $id                 = !empty($array['id']) ? $array['id'] :  $draftId ;
        $user_id            = !empty($array['user_id']) ? $array['user_id'] : auth()->user()->id;
        $logsArr            = !empty($array['logsArr']) ? json_decode($array['logsArr'],true) : null ;
        $logId              = !empty($array['logId']) ? $array['logId'] : '' ;
        $onDB               = !empty($array['onDB']) ? $array['onDB'] : null ;
        $isDraft            = !empty($array['isDraft']) ? $array['isDraft'] : false ;
        $activePage         = !empty($array['activePage']) ? $array['activePage'] : 'quotes' ;
		
		if(!empty($array['agency']) && !empty($array['insured']) && !empty($array['rate_table'])){
			$agency = $array['agency'];
			$insured = $array['insured'];
			$rate_table = $array['rate_table'];
		}else if(!empty($id)){
			$quoteData =   self::getData(['id'=>$id])->first();
			if(!empty($quoteData)){
				$agency = $quoteData->agency;
				$insured = $quoteData->insured;
				$rate_table = $quoteData->rate_table;
			}
		}
		if($agency && $insured){
			$agencyData = Entity::getData(['id'=>$agency])->first();
			$insuredData = Entity::getData(['id'=>$insured])->first();
			$origination_state = isset($array['origination_state']) && !empty($array['origination_state']) ? $array['origination_state'] : '';
			if($origination_state == 'insured_physical'){
				$mainoriginationstate = $insuredData->state;
			}else if($origination_state == 'insured_mailing'){
				$mainoriginationstate = $insuredData->mailing_state;
				if(empty($mainoriginationstate)){
					$mainoriginationstate = $insuredData->state;
				}
			}else if($origination_state == 'agent'){
				$mainoriginationstate = $agencyData->state;
			}
			if(!empty($mainoriginationstate)){
				$array['quoteoriginationstate'] = $mainoriginationstate;
			}
		}
		if(!empty($rate_table)){
			$rate_table_data  = RateTable::getData(['id'=>$rate_table])->first();
		}
		if(!empty($array['quoteoriginationstate']) && !empty($rate_table_data)){
			if(!empty($rate_table_data->state) && ($rate_table_data->state == 'All' || strtolower($rate_table_data->state) == strtolower($array['quoteoriginationstate']))){
				
			}else{
				throw new Error("This Rate table is not allowed for ".$array['quoteoriginationstate']);
			}
		}
		if(isset($array['coverage_type']) && !empty($array['coverage_type']) && !empty($rate_table_data)){
			if(($rate_table_data->coverage_type == '0' || $rate_table_data->coverage_type == $array['coverage_type'])){
				
			}else{
				$coverageType = CoverageType::getData(['id'=>$array['coverage_type']])->first();
				throw new Error("This Rate table is not allowed for ".$coverageType->name);
			}
		}
        $msg = "";
        if (!empty($logsArr)) {
            $msg = dbLogFormat($logsArr);
        }

        $model    = new self; //Load Model
        $inserArr = Arr::only($array,$model->fillable);
        $inserArr['status'] = $model::NEW;
        if(empty($id)){
            $inserArr['qid'] = self::qid();
            $inserArr['user_id'] = $user_id;
        }

       /*  dd($inserArr); */
        if(GateAllow('isAdminCompany') || !empty($onDB)){
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {
        if(!empty($id) || !empty($parentId)){
            $inserArr  = arrFilter($inserArr);
            $getdata     = $model->updateOrCreate(['id'=>$id],$inserArr);
        }else{
            $getdata  =    $model->create($inserArr);
        }

        $wasRecentlyCreated = $getdata?->wasRecentlyCreated ?? false;

        if(!empty($draftId)){

            $msg .= "<li>".__('logs.quote.add',['id'=> "# {$getdata->qid}"])." </li>";

            //QuoteVersion Create
            $array['quote_id'] = $getdata->qid;
            $array['logId'] = $draftId;
            $array['quote_parent_id'] = $getdata->id;
            $array['favourite'] = 1;
            $array['version_id'] = 1;
            $array['isLogMsg'] = true;
            $QuoteVersion = QuoteVersion::insertOrUpdate($array);
            $msg .= !empty($QuoteVersion->logMsg) ? $QuoteVersion->logMsg : '' ;

            /* Version id Update In Quote   */
            $getdata->vid = $QuoteVersion->id;
            $getdata->version = $QuoteVersion->version_id;
            $getdata->save();

            //QuotePolicy Create
            $array['quote'] = $getdata->id;
            $array['version'] = $QuoteVersion?->id;
            $array['isLogMsg'] = true;
            $QuotePolicy = QuotePolicy::insertOrUpdate($array);
            $msg .= !empty($QuotePolicy->logMsg) ? $QuotePolicy->logMsg : '' ;


            $getdata['quoteVersion'] = $QuoteVersion;
            $getdata['quotePolicy']  = $QuotePolicy;
        }else{
			if(isset($quoteData) && ((isset($array['rate_table']) && ($quoteData->rate_table != $array['rate_table'])) || (isset($array['quoteoriginationstate']) && ($quoteData->quoteoriginationstate != $array['quoteoriginationstate'])))){
				$versionList = QuoteVersion::getData(['qId' => $id])->get();
				if(!empty($versionList)){
					foreach($versionList as $version){
						$array['quote'] = $id;
						$array['version'] = $version->id;
						QuoteTerm::insertOrUpdate($array);
					}
				}
			}
		}


        /*
        * Logs Save In @Log Model
        */
        !empty($msg) && Logs::saveLogs(['type' => $activePage, 'onDB' => $onDB, 'user_id' => $user_id, 'type_id' => $getdata->id, 'message' => $msg]);

        } catch (\Throwable $th) {
            DB::rollback();

            throw new Error($th->getMessage());
        }

        DB::commit();

        return $getdata;
    }


    public static function quoteCloneVersion(array $array){

        $id          = !empty($array['id']) ? $array['id'] : "" ;
        $user_id     = !empty($array['user_id']) ? $array['user_id'] : auth()->user()->id;
        $logId       = !empty($array['logId']) ? $array['logId'] : '' ;
        $onDB        = !empty($array['onDB']) ? $array['onDB'] : null ;
        $isDraft     = !empty($array['isDraft']) ? $array['isDraft'] : false ;
        $activePage  = !empty($array['activePage']) ? $array['activePage'] : 'quotes' ;


        DB::beginTransaction();
        try {
        $QuoteVersionData =  QuoteVersion::getData(['id'=>$id])->first();
        $versionData      =  $QuoteVersionData->only(['document','quote_parent_id','quote_id','user_id']); //Load Model
        if(empty($versionData))
                    throw new Error("Invalid Quote Version Id");


        $versionId =  QuoteVersion::getData(['qId'=>$QuoteVersionData?->quote_parent_id])->orderBy('version_id','Desc')->first(); //Load Model
        $versionNo  = (int)$versionId?->version_id + 1;

        $versionData['favourite']   = 0;
        $versionData['user_id']     = $user_id;
        $versionData['version_id']  = $versionNo;
        $versionData['activePage']  = $activePage;
        $versionData['logId']       = $QuoteVersionData?->quote_parent_id;
        $versionData['isLogMsg'] = true;
        $insertOrUpdate             =  QuoteVersion::insertOrUpdate($versionData);


        $QuotePolicyData   = QuotePolicy::getData(['version'=>$id])->get(); //Load Model
        $QuotePolicyArr    = $QuotePolicyData?->makeHidden(['id','created_at','updated_at','user_id'])?->toArray();
        if(!empty($QuotePolicyArr)){
              foreach ($QuotePolicyArr as $key => $poilyRow) {
                $quotePolicyInsertArr =$poilyRow ;
                $quotePolicyInsertArr['user_id'] = $user_id;
                $quotePolicyInsertArr['activePage'] = $activePage;
                $quotePolicyInsertArr['logId']      = $QuoteVersionData?->quote_parent_id;
                $quotePolicyInsertArr['quote']      = $QuoteVersionData?->quote_parent_id;
                $quotePolicyInsertArr['version'] = $insertOrUpdate?->id ?? '';
                $quotePolicyInsertArr['isLogMsg'] = true;
                $insertQuotePolicy   =  QuotePolicy::insertOrUpdate($quotePolicyInsertArr);
              }
        }

        $msg = "<li> Clone Version  <b>{$QuoteVersionData->quote_data->qid}.{$QuoteVersionData->version_id}</b> to <b>{$insertOrUpdate->quote_data->qid}.{$insertOrUpdate->version_id}</b> </li>";

         /** Logs Save In @Log Model*/
        !empty($msg) && Logs::saveLogs(['type' => $activePage, 'onDB' => $onDB, 'user_id' => $user_id, 'type_id' =>$QuoteVersionData?->quote_parent_id, 'message' => $msg]);
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }
        DB::commit();
        return $insertOrUpdate;
    }


    public static function quoteNewVersion(array $array){

        $id          = !empty($array['id']) ? $array['id'] : "" ;
        $user_id     = !empty($array['user_id']) ? $array['user_id'] : auth()->user()->id;
        $logId       = !empty($array['logId']) ? $array['logId'] : '' ;
        $onDB        = !empty($array['onDB']) ? $array['onDB'] : null ;
        $isDraft     = !empty($array['isDraft']) ? $array['isDraft'] : false ;
        $activePage  = !empty($array['activePage']) ? $array['activePage'] : 'quotes' ;


        $QuoteData =  self::getData(['id'=>$id])->first();
        $versionData      =  $QuoteData?->makeHidden(['id'])->toArray(); //Load Model
        if(empty($versionData))
                throw new Error("Invalid Quote Id");

        $versionId =  QuoteVersion::getData(['qId'=>$id])->orderBy('version_id','Desc')->first(); //Load Model
        $versionNo  = (int)$versionId?->version_id + 1;

        $versionData['favourite']   = 0;
        $versionData['user_id']     = $user_id;
        $versionData['version_id']  = $versionNo;
        $versionData['activePage']  = $activePage;
        $versionData['logId']       = $id;
        $versionData['quote_id']    = $QuoteData?->qid;
        $versionData['quote_parent_id']    = $QuoteData?->id;
        $versionData['logMsg']      = true;
        $insertOrUpdate             =  QuoteVersion::insertOrUpdate($versionData);
        $msg = !empty($QuotePolicy->logMsg) ? $QuotePolicy->logMsg : '' ;


        $quotePolicyInsertArr =$array ;
        $quotePolicyInsertArr['user_id'] = $user_id;
        $quotePolicyInsertArr['activePage'] = $activePage;
        $quotePolicyInsertArr['logId']  = $id;
        $quotePolicyInsertArr['quote']  = $id;
        $quotePolicyInsertArr['version'] = $insertOrUpdate?->id ?? '';
        $quotePolicyInsertArr['isLogMsg']      = true;
        $insertQuotePolicy   =  QuotePolicy::insertOrUpdate($quotePolicyInsertArr);

        DB::beginTransaction();
        try {

         /** Logs Save In @Log Model*/
        !empty($msg) && Logs::saveLogs(['type' => $activePage, 'onDB' => $onDB, 'user_id' => $user_id, 'type_id' => $getdata->id, 'message' => $msg]);
        } catch (\Throwable $th) {
            DB::rollback();
            /* dd($th); */
            throw new Error($th->getMessage());
        }
        DB::commit();
        return $insertOrUpdate;
    }


    /* underwritingVerification */
    public static function underwritingVerification($qId = null,$quoteData =null,$array =null){


        $activePage  = !empty($array['activePage']) ? $array['activePage'] : 'quotes' ;
        try {
            DB::beginTransaction();
            $userData = auth()->user();
            $userId = $userData?->id;
            $userType = $userData?->user_type;
            $userName = $userData?->name;

            if(empty($quoteData)){
                $quoteData = self::getData(['id' => $qId])->where('status', self::ACTIVEREQUEST)->first();
            }

            if (empty($quoteData))
                throw new Error("Invalid Quote Id");


            $vId        = $quoteData?->vid;
            $version    = $quoteData?->version;
            $quoteNumber= $quoteData?->quote_number;
            $agentData  = $quoteData?->agent_user;
            $agentName  = $quoteData?->agent_data?->name;
            $agentEmail = $quoteData?->agent_data?->email;

            $quoteData->finance_company = $userId;
            $quoteData->status  = self::PROCESS;
            $quoteData->save();

            $msg = "Quote # {$quoteNumber} Underwriting Verification Successfully";
            Logs::saveLogs(['type' => $activePage,'user_id' => $userId, 'type_id' => $qId, 'message' => $msg]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th->getMessage();
        }

    }


    /* quote Approved */
    public static function quoteApproved($qId =null,array $array=null){

        try {
            DB::beginTransaction();

            $userData = auth()->user();
            $userId = $userData?->id;
            $userType = $userData?->user_type;
            $userName = $userData?->name;

            $currentDate    = !empty($array['current_date']) ? $array['current_date'] : now() ;
            $activePage     = !empty($array['activePage']) ? $array['activePage'] : '' ;
            $route          = !empty($array['route']) ? $array['route'] : '' ;
            $note           = !empty($array['note']) ? $array['note'] : '' ;
            $send_inmail    = !empty($array['send_inmail']) ? strtolower($array['send_inmail']) : '' ;

            $quoteData = self::getData(['id' => $qId])->first();
            if (empty($quoteData))
                throw new Error("Invalid Quote Id");

            $vId = $quoteData?->vid;

            $version = $quoteData?->version;
            $agentId = $quoteData?->agent;
            $agencyData = $quoteData?->agency_data;
            $quoteid = $quoteData->quote_number;
            $AggregateLimit = !empty($agencyData->aggregate_limit) ? $agencyData->aggregate_limit : 0;
            $aggregate_limit_approve = $quoteData?->aggregate_limit_approve ?? 0;
            $allowAggregateLimit = DBHelper::Qsetting('limit_company');
            $status = true;
            if (!empty($AggregateLimit) && !empty($allowAggregateLimit) && $aggregate_limit_approve !== 2) {
                $quotePolicy = QuotePolicy::getData(['qId' => $qId, 'vId' => $vId])->where('pure_premium', '>', $allowAggregateLimit)->first();
                if (!empty($quotePolicy)) {
                    $status = false;
                }
            }

            if (empty($status)) {
                $companyAdmin = User::getData(['type' => User::COMPANYUSER])->where('role', 1)->orderBy('created_at', 'asc')->first();
               /* dd( $companyAdmin?->toArray() ); */
                $companyAdminName = $companyAdmin?->name;
                $companyAdminEmail = $companyAdmin?->email;

                $quoteData->aggregate_limit_approve = 1;
                $quoteData->aggregate_limit_admin_user_id = $companyAdmin->id;
                $quoteData->save();

                $message = 'Quote <a href="' . routeCheck('company.quotes.edit', ['quote' => $qId]) . '"># ' . $quoteData->qid . "." . $quoteData->version . '</a> premium limit has been reached to Aggregate limit. Please approve or decline this quote.';
                $subject = 'Quote Approve/Decline';

                $inserArr = [
                    'from_id'       => $userId,
                    'to_id'         => $companyAdmin->id,
                    'subject'       => $subject,
                    'qid'           => $qId,
                    'vid'           => $vId,
                    'version'       => $version,
                    'message'       => $message,
                    'activePage'    => $activePage,
                ];
                $data = Message::insertOrUpdate($inserArr);
                $resMsg = 'Quote #' . $quoteid . ' premium limit has been reached to Aggregate limit. Quote not approve.';
                DB::commit();
                return ['status' => true, 'msg' => $resMsg, 'url' => routeCheck($route . "edit", $qId)];

            } else {

                /* Check Question */
                $quoteVersion  = QuoteVersion::getData(['qId'=>$qId,'id'=>$vId])->first();
                $underwritingInformations = !empty($quoteVersion->underwriting_informations) ? json_decode($quoteVersion->underwriting_informations,true) : '' ;
                $paymentReceivedGeneralAgent = !empty($underwritingInformations['payment_received_general_agent']) ? strtolower($underwritingInformations['payment_received_general_agent']) : '' ;
                $paymentReceivedAgentSendemail = $paymentReceivedGeneralAgent == 'pending' ? true : false;

                if($send_inmail == 'no'){
					$paymentReceivedAgentSendemail = false;
				}


                if($paymentReceivedAgentSendemail == true && !empty($agentId)){
                    $mailmessage = 'General Agent has not received the Down Payment. Please provide payment confirmation at your earliest. Please note that activation is pening payment receipt confirmation.';
                    $subject     = "Down Payment to General Agent/Insurance Company";

                    $inserArr = [
                        'from_id'   => $userId,
                        'to_id'     => $agentId,
                        'subject'   => $subject,
                        'qid'       => $qId,
                        'vid'       => $vId,
                        'version'   => $version,
                        'message'   => $mailmessage,
                        'activePage' => $activePage,
                    ];
                    $data = Message::insertOrUpdate($inserArr);
                }
                /* Check final approval */
                if($userData->can('companyUser') && $quoteData->status != self::FINALAPPROVAL){
                    $companyData = Company::getData()->first();
                    $finalApproval = !empty($companyData->final_approval) ? $companyData->final_approval : '' ;

                    if(!empty($finalApproval)){ //check final_approval status is Enable
                        $finalApprovalUser = !empty($companyData->final_approval_users) ? explode(',',$companyData->final_approval_users) : '' ;

                        if(!in_array($userId,$finalApprovalUser)){ //check Quote final approval assigned users

                            $quoteData->finance_company = $userId;
                            $quoteData->status  = self::FINALAPPROVAL;   /* quote Status update */
                            $quoteData->save();

                            $statustexts = 'Request final approval';
			                $message     = "{$statustexts}  by {$userName} on {$currentDate}";

                            /* logs for  quote status update */
                            Logs::saveLogs(['type' => $activePage, 'user_id' => $userId, 'type_id' => $qId, 'message' => $message]);

                            $taskSubject    = "Request final approval for Quote # {$quoteid}";
                            $taskMessages   = $taskSubject .'  <a href="' . routeCheck('company.quotes.edit', ['quote' => $qId]) . '">Please Click to view the quote</a>';



                            /* Task Create */
                            $array = [
                                'subject'       => $taskSubject,
                                'notes'         => $taskMessages,
                                'shedule'       => now(),
                                'priority'      => 'High',
                                'status'        => 0,
                                'view_status'   => 1,
                                'show_task'     => 1,
                                'qId'           => $qId,
                                'vId'           => $vId,
                                'user_type'     => User::COMPANYUSER,
                                'type'          => 'quote',
                                'type_id'       => $qId,
                                'logId'         => $qId,
                                'activePage'    => $activePage,
                            ];

                            Task::insertOrUpdate($array);
                            DB::commit();
                            return ['status' => true, 'msg' => $taskSubject, 'url' => routeCheck($route . "edit", $qId)];
                        }
                    }
                }



                $quoteData->status = self::APPROVE;
                $quoteData->aggregate_limit_approve = 0;
                $quoteData->aggregate_limit_admin_user_id = 0;
                $quoteData->save();
                $StateSettingArr = $StateSetting = $lateChargeObj = null;
                if(!empty($quoteData->quoteoriginationstate)){
                    $quoteoriginationstate = $quoteData->quoteoriginationstate;
                    $stateId      = State::getData(['name'=>$quoteoriginationstate])->first()?->id ?? '';
                    $StateSetting = StateSettings::getData(['state'=>$stateId])->with('stateSetting')->first();
                    $StateSettingArr = $StateSetting?->makeHidden(['id','created_at','updated_at'])?->toArray();
                    $StateSettingArr['state_name'] = $quoteoriginationstate;
                    $StateSettingArr['interest_rate'] = StateSettingInterestRate::getData(['state'=>$StateSetting?->id])->get()?->makeHidden(['id','created_at','updated_at'])?->toArray();
                    $StateSettingArr = json_encode($StateSettingArr);
                    $lateChargeObj = self::getLateCharge($qId,$vId,$quoteData,null,$quoteoriginationstate,$StateSetting);
                }


                $lateCharge = $lateChargeObj?->lateCharge ?? 0;
                $accountArr =  $quoteData?->toArray() ?? [];
                $accountArr['quote']          = $qId;
                $accountArr['user_id']        =  $userId;
                $accountArr['version']        = $vId;
                $accountArr['status']         = 1;
                $accountArr['account_number'] = $quoteData?->quote_number;
                $accountArr['state_settings'] = $StateSettingArr;
                $accountArr['latecharge']    = $lateCharge;
                $accountArr['effective_date'] = $lateChargeObj?->effectiveDate ?? null;


          
                $quoteAccount = QuoteAccount::insertOrUpdate($accountArr);
                if(!empty($quoteAccount->id)){
                    $accountId = $quoteAccount->id;
                    $getLoanPaymentSchedule = self::getLoanPaymentSchedule($qId,$vId,$accountId,$quoteData, $StateSetting,$lateCharge);
                    $quoteTerm = $getLoanPaymentSchedule?->quoteTerm ?? '' ;
                    $quoteSetting = $getLoanPaymentSchedule?->quoteSetting ?? '' ;
                    $shortCode     = $getLoanPaymentSchedule?->shortCode ?? '';

                     if(!empty($quoteTerm)){ /* policyAccountQuoteExposure */
                        $quoteExposure = self::policyAccountQuoteExposure($qId,$vId,$accountId,$quoteTerm,$quoteSetting);
                      
                        if(!empty($quoteExposure)){
                            $quotePolicy =  $quoteExposure?->quotePolicy ?? null ;

                            $savePayable = self::savePayable($qId,$vId,$quoteData,$quoteVersion,$quotePolicy,$accountId,$quoteTerm);

                            DailyNotice::quoteDailyNotice(['qId'=>$qId,'vId'=>$vId,'quoteData'=>$quoteData,'quotePolicy'=>$quotePolicy,'quoteTerm'=>$quoteTerm,'accountId'=>$accountId,'quoteAccount'=>$quoteAccount]);
                          /* dd($shortCode); */
                            if(!empty($shortCode)){
                                DailyNotice::quotePaymentCoupons([
                                    'qId'            => $qId,
                                    'vId'            => $vId,
                                    'quoteData'      => $quoteData,
                                    'quotePolicy'    => $quotePolicy,
                                    'quoteTerm'      => $quoteTerm,
                                    'accountId'      => $accountId,
                                    'quoteAccount'   => $quoteAccount,
                                    'shortCode'      => $shortCode,
                                    'paymentMethode' => $quoteData?->payment_method,
                                ]);

                            }
                        }
                     }



                    $repUrl =  routeCheck('company.accounts.show', $quoteAccount->id);

                }else{
                    $repUrl =  routeCheck($route . "edit", $qId);
                }


                $message = 'Approved by ' . $userName . ' on ' . $currentDate;
                Logs::saveLogs(['type' => $activePage, 'user_id' => $userId, 'type_id' => $qId, 'message' => $message]);
                $resMsg = 'Quote #' . $quoteid . ' status approved.';
                DB::commit();
                return ['status' => true, 'msg' => $resMsg, 'url' =>$repUrl];
            }




        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            //throw $th;
        }
    }

    private static function getLateCharge($quoteId,$vId,$quoteData=null,$quoteTerm = null,$orgstate=null,$quoteSetting =null,){

        $StateSetting = null;
        $lateCharge  = 0;
        if(empty($quoteData)){
            $quoteData =   self::getData(['id'=>$quoteId])->first();
        }
        if (empty($quoteData))
                throw new Error("Invalid Quote Id");

        if(empty($quoteTerm)){
            $quoteTerm =   QuoteTerm::getData(['qId'=>$quoteId,'vId'=>$vId])->first();
        }
        if(empty($quoteSetting)){
            $quoteSetting = QuoteSetting::getData()->first();
        }
        $orgstate = !empty($orgstate) ? $orgstate : $quoteData->quoteoriginationstate ;
        if(!empty($orgstate) && empty($quoteSetting)){
            $stateId      = State::getData(['name'=>$orgstate])->first()?->id ?? '';
            $StateSetting = StateSettings::getData(['state'=>$stateId])->with('stateSetting')->first();
        }


        $accountType            = $quoteData?->account_type ?? '';
        $paymentAmount          = $quoteTerm?->payment_amount ?? '';
        if($accountType == 'commercial'){
            $letFee                 = $StateSetting?->stateSetting?->late_fee ?? 0;
            $percentageLetFee       = $StateSetting?->stateSetting?->percentage_late_fee ?? 0;
            $lateFeeLesserGreater   = $StateSetting?->stateSetting?->late_fee_lesser_greater ?? 0;
        }elseif($accountType == 'personal'){
            $letFee                 = $StateSetting?->stateSetting?->comm_late_fee ?? 0;
            $percentageLetFee       = $StateSetting?->stateSetting?->percentage_comm_late_fee ?? 0;
            $lateFeeLesserGreater   = $StateSetting?->stateSetting?->late_fee_lesser_greater_comm ?? 0;
        }

        $percentFee = !empty($percentageLetFee) ? $paymentAmount*($percentageLetFee/100) : 0 ;
        $fixFee     = !empty($letFee) ? floatval($letFee) : 0;

        if(!empty($percentFee) && !empty($fixFee)){
            if(!empty($lateFeeLesserGreater)){
                if($lateFeeLesserGreater == 'lesser'){
                        $lateCharge = min($percentFee,$fixFee);
                    }else{
                        $lateCharge = max($percentFee,$fixFee);
                    }
                }else{
                    if(!empty($percentFee) && !empty($fixFee)){
                        $lateCharge =  $percentFee + $fixFee;
                    }
                }
        }else{
            if(!empty($percentFee) && empty($fixFee)){
                $lateCharge = $percentFee;
            }
            if(empty($percentFee) && !empty($fixFee)){
                $lateCharge = $fixFee;
            }
        }
        $effectiveDate =   QuotePolicy::getData(['qId'=>$quoteId,'version'=>$vId])->selectRaw('min(inception_date) as inception_date')->first();
        $effectiveDate = !empty($effectiveDate->inception_date) ? $effectiveDate->inception_date : '' ;

        return (object)['effectiveDate'=>$effectiveDate,'lateCharge'=>$lateCharge];

    }


    private static function getLoanPaymentSchedule($quoteId="null",$vId="null",$accountId,$quoteData=null, $StateSetting=null,$lateCharge = 0){
		$quoteTerm =   QuoteTerm::getData(['qId'=>$quoteId,'vId'=>$vId])->first();
		if(empty($quoteTerm))
			throw new Error("Invalid Quote and Version Id");

        $shortCode = [];
		$quoteSetting = QuoteSetting::getData()->first();
		$Firstpaymentdate = $quoteTerm?->first_payment_due_date;
		$new_payment_date = $quoteTerm?->first_payment_due_date;
		$no_of_Payments = $quoteTerm?->number_of_payment ?? 9;
		$payment_due_days = $quoteSetting?->until_first_payment ;
		$totalinterest = $quoteTerm?->total_interest;
		$Setup_Fee = $quoteTerm?->setup_fee;
		$payment_amount = $quoteTerm?->payment_amount;
		$total_interest_inc_setup_fee = $quoteTerm?->total_interest_with_setup_fee;
		$html = $quotehtml = '';
		$i = 1;
		$interest = 0;
		$totalmonthly = $totalint = $totalprin = 0;
		$amount_financed = $principal_balances = $unearned_premium = $quoteTerm?->amount_financed;
		$totaldayscanceldays = 10;
		$sum = 0 ;
		$paymentArr = array();
		for($n=$no_of_Payments; $n>=1;$n--){
			$payment_no =  $i ;
			if($payment_due_days == '30'){
				$currentmonth = date('m', strtotime("+1 month",strtotime($new_payment_date)));
				$currentnextmonth = date('m', strtotime("first day of +1 month",strtotime($new_payment_date)));
				if($currentmonth == $currentnextmonth){
					$payment_due_date =   changeDateFormat(date('Y-m-d',strtotime("+".$i." month",strtotime($Firstpaymentdate))));
				}else{
					$payment_due_date =   changeDateFormat(date('Y-m-d',strtotime("last day of +".$i." month",strtotime($Firstpaymentdate))));
				}
			}else{
				if($i == '1'){
					$payment_due_date =   changeDateFormat(date('Y-m-d',strtotime("+".$payment_due_days." day",strtotime($Firstpaymentdate))));
				}else{
					$payment_due_date =   changeDateFormat(date('Y-m-d',strtotime("+".$payment_due_days." day",strtotime($payment_due_date))));
				}
			}
			$new_payment_date = $payment_due_date;
			$payment_on_amount = ($Setup_Fee == 0) ?  $payment_amount : 0 ;
			$total_interest = !empty($payment_on_amount) ? ($totalinterest * (2*($no_of_Payments - $sum))/($no_of_Payments * ($no_of_Payments + 1))) : 0 ;
			$no_inc_setup_fee = !empty($payment_on_amount) ? $payment_on_amount - $total_interest : 0  ;
			$pay_on_amount = $Setup_Fee > 0 ?  $payment_amount : '' ;

			$tot_interest = !empty($pay_on_amount) ? ($total_interest_inc_setup_fee * ((2*($no_of_Payments - $sum))/($no_of_Payments * ($no_of_Payments + 1)))) : 0 ;
			$inc_setup_fee =  !empty($pay_on_amount) ? $pay_on_amount - $tot_interest : '';
			$amount_financed = $principal_balances;
			$principal_balances  =   $Setup_Fee == 0 ? $amount_financed - $no_inc_setup_fee  : $amount_financed - $inc_setup_fee ;
			$payoff_balance =   $Setup_Fee == 0 ?  $amount_financed +  $total_interest  : $amount_financed + $tot_interest  ;
			if($Setup_Fee == 0){
				$interest += $total_interest;
			}else{
				$interest += $tot_interest;
			}

			$interest_refund =  ($Setup_Fee == 0) ?  ($totalinterest - $interest) : ($total_interest_inc_setup_fee - $interest);

			$interest_refund = ($interest_refund >= 1) ? $interest_refund : 0;

			$paymentArr[$i] = array('amount_financed'=>$amount_financed,'principal_balances'=>$principal_balances);

			$UnearnedPremium = $difference = '';
			$cancellationdate = changeDateFormat(date('Y-m-d',strtotime("+".$totaldayscanceldays." day",strtotime($payment_due_date))));
			$PrincipalBalanceDue = ($i == 1) ? $amount_financed : $paymentArr[$i-1]['principal_balances'];
			$UnearnedPremium = ($i == 1 || $i == 2) ? $paymentArr[1]['amount_financed'] : 0;
			$difference = ($i == 1 || $i == 2) ?  $UnearnedPremium - $PrincipalBalanceDue : 0;

            if($Setup_Fee == 0){
				$totalmonthly += $payment_on_amount;
				$totalint += $total_interest;
				$totalprin += $no_inc_setup_fee;
				$monthly_payment = $payment_on_amount;
				$interests = $total_interest;
				$principal = $no_inc_setup_fee;
			}else {
				$totalmonthly += $pay_on_amount;
				$totalint += $tot_interest;
				$totalprin += $inc_setup_fee;
				$monthly_payment = $pay_on_amount;
				$interests = $tot_interest;
				$principal = $inc_setup_fee;
			}


            $account_quote_exposure = [
                'payment_number'    => $payment_no,
                'payment_due_date'  => dbDateFormat($payment_due_date),
                'amount_financed'   => $amount_financed,
                'monthly_payment'   => $monthly_payment,
                'interest'          => $interests,
                'principal'         => $principal,
                'principal_balance' => $principal_balances,
                'payoff_balance'    => $payoff_balance,
                'interest_refund'   => $interest_refund,
                'account_id'        => $accountId,
            ];
            QuoteAccountExposure::insertOrUpdate($account_quote_exposure);
           
            $shortCode[] = [
                "{Payment_Late_Charge}"                 =>  dollerFA($lateCharge + $amount_financed),
                "{Payment_Installment_Number}"          =>  $payment_no,
                "{Payment_Installment_Due_Date}"        =>   changeDateFormat($payment_due_date,true),
                "{Payment_Late_Charge_Installment_Due_Date}" =>  '',
            ];

			$i++;
			$sum++;
		}

        if(!empty($totalmonthly)){
            TransactionHistory::insertOrUpdate([
                'account_id'=>$accountId,
                'transaction_type' =>'Account Activation',
                'debit'=>$totalmonthly,
                'balance'=>$totalmonthly,
                'description' => 'Account Activation',
            ]);
            $TransactionHistory = TransactionHistory::insertOrUpdate([
                'account_id'=>$accountId,
                'transaction_type' =>'Status',
                'debit'=>0,
                'balance'=>$totalmonthly,
                'description' => 'Account Current',
               // 'created_at' => now()->addSeconds(120),
            ]);
            $TransactionHistory->created_at = now()->addSeconds(120);
            $TransactionHistory->save();
        }


        return (object)['quoteTerm'=>$quoteTerm,'quoteSetting'=>$quoteSetting,'shortCode'=>$shortCode];
	}

	private static function policyAccountQuoteExposure($quoteId,$vId,$accountId,$quoteTerm = null,$quoteSetting =null){


		$quotePolicy =   QuotePolicy::getData(['qId'=>$quoteId,'version'=>$vId])->get();
		if(empty($quotePolicy))
			throw new Error("Invalid Quote and Version Id");

        if(empty($quoteTerm)){
            $quoteTerm =   QuoteTerm::getData(['qId'=>$quoteId,'vId'=>$vId])->first();
        }
        if(empty($quoteSetting)){
            $quoteSetting = QuoteSetting::getData()->first();
        }

        $Firstpaymentdate   = $quoteTerm?->first_payment_due_date;
        $new_payment_date   = $quoteTerm?->first_payment_due_date;
		$interest_rate   = $quoteTerm?->interest_rate;
		$interest_type   = $quoteTerm?->interest_type;
		$no_of_Payments     = $quoteTerm?->number_of_payment;
		$payment_due_days   = $quoteSetting?->until_first_payment ;
		$down_percent      = $quoteTerm?->down_percent;



        foreach ($quotePolicy  as $key => $qp) {
			$purePremium = !empty($qp->pure_premium) ? toFloat($qp->pure_premium) : 0;
			$policy_fee = !empty($qp->policy_fee) ? $qp->policy_fee : 0;
			$taxes_and_stamp_fees = !empty($qp->taxes_and_stamp_fees) ? $qp->taxes_and_stamp_fees : 0;
			$broker_fee = !empty($qp->broker_fee) ? $qp->broker_fee : 0;
			$inspection_fee = !empty($qp->inspection_fee) ? $qp->inspection_fee : 0;

			$setupFee = !empty($qp->setup_fee) ? $qp->setup_fee : 0;
			$docStampFees = !empty($qp->doc_stamp_fees) ? $qp->doc_stamp_fees : 0;
			$totalPremium           = $purePremium + $policy_fee + $taxes_and_stamp_fees + $broker_fee + $inspection_fee;
			$downPayment = ($purePremium + $taxes_and_stamp_fees)*($down_percent/100) + $broker_fee + $inspection_fee + $policy_fee;

			$amountFinanced         = $totalPremium - $downPayment + $docStampFees;
			/**
			  @formula
			  Payment on Amount Financed = -PMT(Interest Rate/12,Number of Payments ,Amount Financed)
			*/
			$paymentAmountInterest           = QuoteHelper::calculatePaymentAmountInterest($interest_type,$interest_rate,$purePremium,$no_of_Payments,$amountFinanced,$setupFee);

			/**
			  @formula
			  Total Interest        = Payment on Amount Financed*Number of Payments - Amount Financed
			*/
			$total_interest_inc_setup_fee = $paymentAmountInterest['totalInterest'];
			$totalinterest          = $total_interest_inc_setup_fee - $setupFee;
			$payment_amount          = $paymentAmountInterest['paymentAmount'];
			/**
			  @formula
			  Total Payments        = (Payment Amount*Number of Payments)
			*/
			$totalPayMent           = $payment_amount*$no_of_Payments;


			$interest = 0;
			$totalmonthly = $totalint = $totalprin = 0;
			$amount_financed = $principal_balances = $unearned_premium = $amountFinanced;
			$totaldayscanceldays = 10;

			$i = 1;
			$sum = 0 ;
			$paymentArr = array();
			for($n=$no_of_Payments; $n>=1;$n--){
				$payment_no =  $i ;
				if($payment_due_days == '30'){
					$currentmonth = date('m', strtotime("+1 month",strtotime($new_payment_date)));
					$currentnextmonth = date('m', strtotime("first day of +1 month",strtotime($new_payment_date)));
					if($currentmonth == $currentnextmonth){
						$payment_due_date =   changeDateFormat(date('Y-m-d',strtotime("+".$i." month",strtotime($Firstpaymentdate))));
					}else{
						$payment_due_date =   changeDateFormat(date('Y-m-d',strtotime("last day of +".$i." month",strtotime($Firstpaymentdate))));
					}
				}else{
					if($i == '1'){
						$payment_due_date =   changeDateFormat(date('Y-m-d',strtotime("+".$payment_due_days." day",strtotime($Firstpaymentdate))));
					}else{
						$payment_due_date =   changeDateFormat(date('Y-m-d',strtotime("+".$payment_due_days." day",strtotime($payment_due_date))));
					}
				}
				$new_payment_date = $payment_due_date;
				$payment_on_amount = ($setupFee == 0) ?  $payment_amount : 0 ;
				$total_interest = !empty($payment_on_amount) ? ($totalinterest * (2*($no_of_Payments - $sum))/($no_of_Payments * ($no_of_Payments + 1))) : 0 ;
				$no_inc_setup_fee = !empty($payment_on_amount) ? $payment_on_amount - $total_interest : 0  ;
				$pay_on_amount = $setupFee > 0 ?  $payment_amount : '' ;

				$tot_interest = !empty($pay_on_amount) ? ($total_interest_inc_setup_fee * ((2*($no_of_Payments - $sum))/($no_of_Payments * ($no_of_Payments + 1)))) : 0 ;
				$inc_setup_fee =  !empty($pay_on_amount) ? $pay_on_amount - $tot_interest : '';
				$amount_financed = $principal_balances;
				$principal_balances  =   $setupFee == 0 ? $amount_financed - $no_inc_setup_fee  : $amount_financed - $inc_setup_fee ;
				$payoff_balance =   $setupFee == 0 ?  $amount_financed +  $total_interest  : $amount_financed + $tot_interest  ;
				if($setupFee == 0){
					$interest += $total_interest;
				}else{
					$interest += $tot_interest;
				}

				$interest_refund =  ($setupFee == 0) ?  ($totalinterest - $interest) : ($total_interest_inc_setup_fee - $interest);

				$interest_refund = ($interest_refund >= 1) ? $interest_refund : 0;

				$paymentArr[$i] = array('amount_financed'=>$amount_financed,'principal_balances'=>$principal_balances);

				$UnearnedPremium = $difference = '';
				$cancellationdate = changeDateFormat(date('Y-m-d',strtotime("+".$totaldayscanceldays." day",strtotime($payment_due_date))));
				$PrincipalBalanceDue = ($i == 1) ? $amount_financed : $paymentArr[$i-1]['principal_balances'];
				$UnearnedPremium = ($i == 1 || $i == 2) ? $paymentArr[1]['amount_financed'] : 0;
				$difference = ($i == 1 || $i == 2) ?  $UnearnedPremium - $PrincipalBalanceDue : 0;

				if($setupFee == 0){
					$totalmonthly += $payment_on_amount;
					$totalint += $total_interest;
					$totalprin += $no_inc_setup_fee;
					$monthly_payment = $payment_on_amount;
					$interests = $total_interest;
					$principal = $no_inc_setup_fee;
				}else {
					$totalmonthly += $pay_on_amount;
					$totalint += $tot_interest;
					$totalprin += $inc_setup_fee;
					$monthly_payment = $pay_on_amount;
					$interests = $tot_interest;
					$principal = $inc_setup_fee;
				}


				$policy_account_quote_exposure = [
					'payment_number'    =>$payment_no,
					'payment_due_date'  =>$payment_due_date,
					'amount_financed'   =>$amount_financed,
					'monthly_payment'   =>$monthly_payment,
					'interest'          =>$interests,
					'principal'         =>$principal,
					'principal_balance' =>$principal_balances,
					'payoff_balance'    =>$payoff_balance,
					'interest_refund'   =>$interest_refund,
					'account_id'        => $accountId,
                    'policy_id'         => $qp->id,
				];
                QuotePolicyAccountExposure::insertOrUpdate($policy_account_quote_exposure);
				$i++;
				$sum++;
           }
        }
/* dd($quotePolicy); */
        return (object)['quotePolicy'=>$quotePolicy,'quoteSetting'=>$quoteSetting];

	}



    private static function savePayable($quoteId,$vId,$quoteData=null,$quoteVersion=null,$quotePolicy=null,$accountId=null,$quoteTerm = null){


		if(empty($quotePolicy)){
            $quotePolicy =   QuotePolicy::getData(['qId'=>$quoteId,'version'=>$vId])->get();
        }
       /*  dd($quotePolicy ); */
		if(empty($quoteVersion)){
            $quoteVersion =   QuoteVersion::getData(['qId'=>$quoteId,'id'=>$vId])->first();
        }

        if(empty($quotePolicy))
			throw new Error("Invalid Quote and Version Id");

		if(empty($quoteTerm)){
            $quoteTerm =  QuoteTerm::getData(['qId'=>$quoteId,'vId'=>$vId])->first();
        }

        if(empty($quoteTerm))
			throw new Error("Invalid Quote Term data");


       $inceptionDate =   QuotePolicy::getData(['qId'=>$quoteId,'version'=>$vId])->selectRaw('min(inception_date) as inception_date,first_payment_due_date,minimum_earned')->first();
       $inceptionDate = !empty($inceptionDate->inception_date) ? $inceptionDate->inception_date : '' ;
       $first_payment_due_date = !empty($inceptionDate->first_payment_due_date) ? $inceptionDate->first_payment_due_date : '' ;
       $minimum_earned = !empty($inceptionDate->minimum_earned) ? $inceptionDate->minimum_earned : '' ;


       $firstPaymentDueDate = !empty($quoteTerm->first_payment_due_date) ? $quoteTerm->first_payment_due_date : $first_payment_due_date ;
       $downPercent         = !empty($quoteTerm->down_percent) ? $quoteTerm->down_percent : $minimum_earned ;
       $term_other_data     = !empty($quoteTerm->term_other_data) ? json_decode($quoteTerm->term_other_data,true) : '';
       $term_other_data     = !empty($quoteTerm->term_other_data) ? json_decode($quoteTerm->term_other_data,true) : '';
       $deafult_down_payment = !empty($term_other_data['deafult_down_payment']) ? $term_other_data['deafult_down_payment'] : 0;
       $round_down_payment = !empty($term_other_data['round_down_payment']) ? $term_other_data['round_down_payment'] : 0;
       $underwritingInformations = !empty($quoteVersion->underwriting_informations) ? json_decode($quoteVersion->underwriting_informations,true) : '';
       $paymentDue = !empty($underwritingInformations['payment_due']) ? dbDateFormat($underwritingInformations['payment_due']) : '';

       foreach ($quotePolicy as $key => $policy) {

            $policyPayable = !empty($policy->general_agent) ? $policy->general_agent : $policy?->insurance_company;
            if(empty($paymentDue)){
                $paymentDue = date('Y-m-d');
                $fundingData = Funding::getData(['eId'=>$policyPayable])->first();
                $remittanceSchedule = !empty($fundingData->remittance_schedule) ? $fundingData->remittance_schedule : '';
                 if($remittanceSchedule == 'Days After Policy Inception'){
                    $days_after_policy_inception_text = !empty($fundingData->days_after_policy_inception_text) ? $fundingData->days_after_policy_inception_text : '14';
                    if(!empty($inceptionDate)){
                        $paymentDue = date('Y-m-d', strtotime("+".$days_after_policy_inception_text." day",strtotime($inceptionDate)));
                    }
                 }elseif($remittanceSchedule == 'Days After 1st Payment Due Date'){
                    $days_after_1st_payment_due_date_text = !empty($fundingData->days_after_1st_payment_due_date_text) ? $fundingData->days_after_1st_payment_due_date_text : '';
                    if(!empty($days_after_1st_payment_due_date_text)){
                        $paymentDue = date('Y-m-d', strtotime("+".$days_after_1st_payment_due_date_text." day",strtotime($inceptionDate)));
                    }
                }elseif($remittanceSchedule == '15 Days After the End of The Month of Policy Inception'){
                    $paymentDue = date('Y-m-d', strtotime("+15 day",strtotime($inceptionDate)));
                }

            }

            $total              = !empty($policy['total']) ? ($policy['total']) : 0;
            $purePremium        = !empty($policy['pure_premium']) ? ($policy['pure_premium']) : 0;
            $policyFee          = !empty($policy['policy_fee']) ? $policy['policy_fee'] : 0;
            $brokerFee          = !empty($policy['broker_fee']) ? $policy['broker_fee'] : 0;
            $inspectionFee      = !empty($policy['inspection_fee']) ? $policy['inspection_fee'] : 0;
            $down_payment       = !empty($policy['down_payment']) ? $policy['down_payment'] : 0;
            $taxesAndStampFees  = !empty($policy['taxes_and_stamp_fees']) ? $policy['taxes_and_stamp_fees'] : 0;
            if(!empty($downPercent)){
                $policyDownPayment = ($purePremium * $downPercent/100) + $policyFee + $brokerFee +   $inspectionFee + $taxesAndStampFees;
                if(!empty($deafult_down_payment) && $deafult_down_payment > $policyDownPayment){
                    $policyDownPayment = $deafult_down_payment;
                }

                if(!empty($round_down_payment)){
                    $policyDownPayment = round($policyDownPayment);
                }
                $preAmount = $total - $policyDownPayment;
            }else{
                $preAmount = $total - $down_payment;
            }


            $payables = [
                 'status'    =>  '1',
                'logId'     =>  $quoteId,
                'activePage'     =>  'quote',
                'policy_id' =>  $policy?->id,
                'type'      =>  'Policy',
                'inception_date'    => dbDateFormat($inceptionDate),
                'first_payment_due_date'=> dbDateFormat($firstPaymentDueDate),
                'vendor'        => $policyPayable,
                'due_date'      =>  ($paymentDue),
                'totalamount'   => $preAmount,
                'reference_no'  => '',
                'user_id'       => auth()->user()?->id,
            ];
            Payable::insertOrUpdate($payables);
        }

    }

    public static function getData(array $array = null)
    {
        $model = new self;
        if (GateAllow('isAdminCompany')) {
            $model = $model->on('company_mysql');
        }

        if (!empty($array['id'])) {
            $model = $model->whereId($array['id']);
        }

        if (!empty($array['status']) && !is_array($array['status'])) {
            $model = $model->whereStatus($array['status']);
        }
        if (!empty($array['quoteId']) && !is_array($array['quoteId'])) {
            $model = $model->where('qid',$array['quoteId']);
        }

        if (!empty($array['account_type'])) {
            if(is_array($array['account_type'])){
                $model = $model->whereIn('account_type',$array['account_type']);
            }else{
                $model = $model->where('account_type',$array['account_type']);
            }

        }
        if (!empty($array['quote_type'])) {
            if(is_array($array['quote_type'])){
                $model = $model->whereIn('quote_type',$array['quote_type']);
            }else{
                $model = $model->where('quote_type',$array['quote_type']);
            }

        }

        return $model;
    }



}
