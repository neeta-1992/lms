<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attachment;
use App\Models\Logs;
use App\Models\Setting;
use App\Models\State;
use App\Models\StateSettings;
use App\Models\User;
use DBHelper,Error,DB,Arr,Str,URSC,Validator;
use App\Models\{
    Quote,QuoteAccount,Payment,Entity,QuoteVersion,QuoteTerm,TransactionHistory,BankAccount,UserPermission,
    QuoteAccountExposure,Payable,QuotePolicy,AccountAlert,Task,Note,DailyNotice,NoticeTemplate,PendingPayment
};
use App\Helpers\DailyNotice as DNH;
use App\Helpers\Email;
class AccountsController extends Controller
{
    private $viwePath   = "company.accounts.";
    public $pageTitle   = "Account";
    public $activePage  = "accounts";
    public $route       = "company.accounts.";
    public function __construct(QuoteAccount $model){
       $this->model =  $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()){
            return $this->viewList(request()->all());
        }
        return view($this->viwePath."index",['route'=>$this->route,'activePage'=>$this->activePage]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view($this->viwePath."create",['route'=>$this->route]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
           if ($request->ajax()) {
                $inputs = $request->post();
                $stateData =  $this->model::insertOrUpdate($inputs);
                return   response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been created successfully','backurl'=> route($this->route."index")], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data  = $this->model::getData()->where('id',$id)->firstOrFail();
        $stateData = !empty($data->state_settings) ?  (object)(json_decode($data->state_settings,true)) : null;
        $quoteoriginationstate = 'Alabama';
        $stateId      = \App\Models\State::getData(['name'=>$quoteoriginationstate])->first()?->id ?? '';
        $StateSetting = \App\Models\StateSettings::getData(['state'=>$stateId])->with('stateSetting')->first()?->makeHidden(['created_at','updated_at'])?->toArray();
        $StateSetting['state_name'] = $quoteoriginationstate;
        $quote = !empty($data->quote) ? $data->quote : '';
        $version = !empty($data->version) ? $data->version : '';
        /* dd( $quotePolicy); */
        $todayAlert = AccountAlert::getData(['accountId'=>$id])->get();
        $electronicPaymentSettings = Setting::getData(['type'=>'electronic-payment-setting'])->first();
        $EPS = !empty($electronicPaymentSettings->json) ? json_decode($electronicPaymentSettings->json) : null;

        return view($this->viwePath."show",['route'=>$this->route,'data'=>$data,'id'=>$id,'viwePath'=>$this->viwePath,'activePage'=>$this->activePage,'stateData'=>$stateData,'todayAlert'=>$todayAlert,'EPS'=>$EPS]);
    }

    /* suspend-account */
    public function suspendAccount(Request $request,$accountId){

        try {
            $data  = $this->model::getData()->where('id',$accountId)->firstOrFail();
            $input  = $request->post();

            $validator = Validator::make($request->all(), [
                'days'      => 'required|numeric|max:999',
                'reason'    => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['status'=>false,'errors'=>$validator->errors()], 422);
            }

            $suspendDay = $data?->suspend_days;
            $suspendDay = $suspendDay + $request?->days;

            $userData = $request->user();

            
            $data->suspend_date = now();
            $data->unsuspend_date = now()->addDays($suspendDay);
            $data->suspend_reason = $request->reason;
            $data->suspend_user = $userData?->id;
            $data->suspend_status = 1;
            $data->save();
            

            $logsmessage = 'Account Suspend by '.$userData?->name;
            Logs::saveLogs(['type'=>$this->activePage,'user_id'=>$userData?->id,'type_id'=>$accountId,'message'=>$logsmessage]);
           
            return   response()->json(['status'=>true,'msg'=>'Account Suspend Successfully.','singleurl'=> route($this->route."show",$accountId)], 200);
            
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>'something went wrong please try again'], 200);
        }

    }


    /* unsuspend-account */
    public function unsuspendAccount(Request $request,$accountId){

            try {
                $data  = $this->model::getData()->where('id',$accountId)->firstOrFail();
                $input  = $request->post();
    
                $validator = Validator::make($request->all(), [
                    'reason'    => 'required',
                ]);
    
                if ($validator->fails()) {
                    return response()->json(['status'=>false,'errors'=>$validator->errors()], 422);
                }
    
         
                $userData = $request->user();
    
                
                $data->suspend_date = now();
                $data->unsuspend_date = null;
                $data->suspend_reason = $request->reason;
                $data->suspend_user = $userData?->id;
                $data->suspend_status = 0;
                $data->save();
                
    
                $logsmessage = 'Account Unsuspend by '.$userData?->name;
                Logs::saveLogs(['type'=>$this->activePage,'user_id'=>$userData?->id,'type_id'=>$accountId,'message'=>$logsmessage]);
               
                return   response()->json(['status'=>true,'msg'=>'Account Unsuspend Successfully.','singleurl'=> route($this->route."show",$accountId)], 200);
                
            } catch (\Throwable $th) {
                return response()->json(['status'=>false,'msg'=>'something went wrong please try again'], 200);
            }
    
        }


    public function viewAccountData($id)
    {
       try {
            $data        = $this->model::getData()->where('id',$id)->firstOrFail();
           
            $paymentData = Payment::getData(['accountId'=>$id])
                          ->selectRaw('
                            SUM(late_fee) as late_fee,
                            SUM(cancel_fee) as cancel_fee,
                            SUM(nsf_fee) as nsf_fee,
                            SUM(convient_fee) as convient_fee,
                            SUM(amount) as amount,
                            SUM(total_due) as total_due
                            ')->first();
                          
            $qoteAccountExposure = QuoteAccountExposure::getData(['accountId'=>$id])
                         ->selectRaw('
                            SUM(pay_interest) as pay_interest,
                            SUM(principal) as principal,
                            SUM(principal_balance) as principal_balance,
                            SUM(interest_refund) as interest_refund,
                            SUM(interest) as interest
                            ')->first();
            $lastPayment =  Payment::getData(['accountId'=>$id])->select()->latest()->first();
            $view        = view($this->viwePath."pages.view-account",['data'=>$data,'id'=>$id,'pD'=>$paymentData,'qAE'=>$qoteAccountExposure,'lastPayment'=>$lastPayment])->render();
            return response()->json(['status'=>true,'view'=>$view], 200);
       } catch (\Throwable $th) {
        throw $th;
        
        return response()->json(['status'=>false,'view'=>''], 200);
       }
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {

        if ($request->ajax()) {
            $type   = $request->type;
            $convenienceFee = 0;
            $data  = $this->model::getData()->with('next_payment')->where('id',$id)->firstOrFail();
            $quoteData = $data?->q_data;
            $accountType = $quoteData?->account_type;
            $stateSettings = !empty($data?->state_settings) ? json_decode($data?->state_settings,true) : '' ;
            $percentageFeeCreditCard = !empty($stateSettings['state_setting']['percentage_fee_credit_card']) ? toRound($stateSettings['state_setting']['percentage_fee_credit_card']) : 0;
            $feeCreditCard = !empty($stateSettings['state_setting']['fee_credit_card']) ? formatAmount($stateSettings['state_setting']['fee_credit_card']) : 0 ;
            $percentageCommFeeCreditCard = !empty($stateSettings['state_setting']['percentage_comm_fee_credit_card']) ? toRound($stateSettings['state_setting']['percentage_comm_fee_credit_card']) : 0 ;
            $commFeeCreditCard = !empty($stateSettings['state_setting']['comm_fee_credit_card']) ? formatAmount($stateSettings['state_setting']['comm_fee_credit_card']) :0;


            $amount = 0;
            if(!empty($type) && $type == 'installment'){
                $amount = $data?->next_payment?->monthly_payment;
            }elseif($type == 'payoff'){
                $amount = $data?->next_payment?->payoff_balance;
            }

            if(!empty($accountType) && $accountType == 'commercial' ){
                $convenienceFee  = $amount*$percentageCommFeeCreditCard/100 + $feeCreditCard;
            }elseif(!empty($accountType) && $accountType == 'personal'){
                $convenienceFee  = $amount*$percentageFeeCreditCard/100 + $feeCreditCard;
            }

            

            $data  = $data?->next_payment?->makeHidden(['json_payment_due_date','created_at','updated_at','status','payment_notes','account_id','id',])?->toArray();
            $data['convenience_fee'] = $convenienceFee;
            return response()->json(['status'=>true,'data'=>$data], 200);
        }
         $data  = $this->model::getData()->where('id',$id)->firstOrFail();
        return view($this->viwePath."edit",['route'=>$this->route,'data'=>$data,'id'=>$id]);
    }

   /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
           if ($request->ajax()) {
                $inputs = $request->post();
                $payment_method = $request->post('payment_method');
                if($payment_method == 'credit_card'){
                    $inputs['card_token'] = $request->post('sqtoken');
                }else{
                    $inputs['card_token'] = $request->post('sqtoken');
                }
                $inputs['id'] = $id;
                $inputs['activePage'] = $this->activePage;
               /*  dd($inputs); */
                $this->model::insertOrUpdate($inputs);
                
                return   response()->json(['status'=>true,'msg'=>$this->pageTitle.' has been updated successfully','type'=>'account'], 200);
            }
        } catch (\Throwable $th) {

            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);


        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /* @Ajax Get Data List */
    private function viewList(array $request = null){

        $userData = auth()->user();
        $userId = $userData->id;
        $userType = $userData->user_type;
        $entityId = $userData->entity_id;

        $columnName         = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder    = !empty($request['order'])  ? $request['order'] : '';
        $offset             = !empty($request['offset']) ? $request['offset'] : 0;
        $limit              = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue        = !empty($request['search']) ? $request['search'] : '';
        $policy_number      = !empty($request['policy_number']) ? $request['policy_number'] : '';
        $insurance_company  = !empty($request['insurance_company']) ? $request['insurance_company'] : '';
        $general_agent      = !empty($request['general_agent']) ? $request['general_agent'] : '';
        $coverageType       = !empty($request['coverage_type']) ? $request['coverage_type'] : '';
        $email              = !empty($request['email']) ? $request['email'] : '';
        $telephone          = !empty($request['telephone']) ? $request['telephone'] : '';
        $address            = !empty($request['address']) ? $request['address'] : '';
        $city               = !empty($request['primary_address_city']) ? $request['primary_address_city'] : '';
        $state              = !empty($request['primary_address_state']) ? $request['primary_address_state'] : '';
        $zip                = !empty($request['primary_address_zip']) ? $request['primary_address_zip'] : '';
        $startDate          = !empty($request['start_date']) ? $request['start_date'] : '';

        $columnNameArr      = [ 'created_at' => 'quote_accounts.created_at', 'updated_at' => 'quote_accounts.updated_at', 'insured' => 'insured_e.name', 'agency' => 'agency_e.name',];
        $columnName         = isset($columnNameArr[$columnName]) ? $columnNameArr[$columnName] : 'quote_accounts.created_at';

        $selectFields       = ['quote_accounts.*','insured_e.name as insured_name','agency_e.name as agency_name',
                                // 'qae.monthly_payment as payment_number',
                                //'qae.payment_due_date as next_due_date',
                                //'qae.payment_number as payment_number'
                            ];
        $sqlData =  $this->model::getData($request)
                        ->Join('entities as insured_e', function ($join) {
                            $join->on('insured_e.id', '=', 'quote_accounts.insured')
                        ->where('insured_e.type', Entity::INSURED);
                        })->Join('entities as agency_e', function ($join) {
                            $join->on('agency_e.id', '=', 'quote_accounts.agency')
                                 ->where('agency_e.type', Entity::AGENT);
                        });
                       /*
                        ->leftJoin('quote_account_exposures as qae', function ($join) {
                            $join->on('qae.account_id', '=', 'quote_accounts.id')
                                ->where('qae.status', 0);
                        })
                        ;*/
        $sqlData->when($userType == User::AGENT, function ($q) use($entityId) {
            return $q->where('quote_accounts.agency', $entityId);
        });
        $sqlData->when($userType == User::INSURED, function ($q) use($entityId) {
            return $q->where('quote_accounts.insured', $entityId);
        });

        if(!empty($request['accountId'])){
            $sqlData = $sqlData->where('account_number',$request['accountId']);
        }

         /* filtter for policy_number on join quotes policy  table */
         if(!empty($policy_number) || !empty($insurance_company) || !empty($general_agent) || !empty($coverageType)){
            $sqlData = $sqlData->Join('quote_policies as qp', function ($join) use($policy_number,$insurance_company,$general_agent) {
                $join->on('qp.version', '=', 'quote_accounts.version');
            });

            if(!empty($policy_number)){
                $sqlData = $sqlData->where('qp.policy_number','LIKE',"%{$policy_number}%");
            }

            if(!empty($insurance_company)){
                $sqlData = $sqlData->where('qp.insurance_company',$insurance_company);
            }

            if(!empty($general_agent)){
                $sqlData = $sqlData->where('qp.general_agent',$general_agent);
            }
            if(!empty($coverageType)){
                $sqlData = $sqlData->where('qp.coverage_type',$coverageType);
            }

        }

        if(!empty($email)){
            $sqlData = $sqlData->where(function($q) use($email) {
                $q->whereLike('insured_e.email',$email)
                ->orwhereLike('agency_e.email',$email);
            });
        }

        if(!empty($telephone)){
            $sqlData = $sqlData->where(function($q) use($telephone)   {
                $q->whereEn('insured_e.telephone',$telephone)
                ->orWhereEncrypted('agency_e.telephone',$telephone);
            });

        }

        if(!empty($address)){
            $sqlData = $sqlData->where(function($q) use($address)   {
                $q->whereEn('insured_e.address',$address)
                ->orWhereEncrypted('agency_e.address',$address);
            });
        }

        if(!empty($state)){
            $sqlData = $sqlData->where(function($q) use($state)   {
                $q->whereEn('insured_e.state',$state)
                ->orWhereEncrypted('agency_e.state',$state);
            });
        }

        if(!empty($city)){
            $sqlData = $sqlData->where(function($q) use($city)   {
                $q->whereEn('insured_e.city',$city)
                ->orWhereEncrypted('agency_e.city',$city);
            });
        }
        if(!empty($zip)){
            $sqlData = $sqlData->where(function($q) use($zip)   {
                $q->whereEn('insured_e.zip',$zip)
                ->orWhereEncrypted('agency_e.zip',$zip);
            });

        }

        if(!empty($insured)){
            $sqlData = $sqlData->where('quotes.insured',$insured);
        }
        if(!empty($searchValue)){
            $sqlData = $sqlData->where(function($q)  use($searchValue) {
                $q->where('account_number',$searchValue)
                   ->orwhereLike('insured_e.name',$searchValue)
                   ->orwhereLike('agency_e.name',$searchValue);
            });
        }
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $data            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get($selectFields);

        $statusArr = [ 1=> 'Account Current',2=>'Intent to cancel',3=>'Canceled',4=>'Cancel 1',5=>'Cancel 2',6=>'Collection',7=>'Closed'];
          if(!empty($data)){
                foreach($data as $row){
                    $editUrl = routeCheck($this->route."show",($row['id']));
                    $name    =  $row->account_number;
                    $status  = dotBtn($row?->status, 'quote');
                    $fname  = !empty($row?->fname) ? decryptData($row?->fname) : '';
                    $mname  = !empty($row?->mname) ? decryptData($row?->mname) : '';
                    $lname  = !empty($row?->lname) ? decryptData($row?->lname) : '';

                    $numberOfPayment = $row->quote_term?->number_of_payment ?? 0;
                    $paymentNumber =  $row?->next_payment?->payment_number ?? 0 ;
                    $paymentNumber = !empty($paymentNumber) ? $paymentNumber : $numberOfPayment;
                    $paymentStatus = $row?->payment_status ?? 0 ;
                    if($paymentStatus == 2){
                        $paymentNumber = $numberOfPayment;
                        $installment =  $paymentNumber."/".$numberOfPayment;
                    }else{
                       $installment =  $paymentNumber."/".$numberOfPayment;
                    }
                    $dataArr[] = [
                        "created_at" => changeDateFormat($row?->created_at),
                        "updated_at" => changeDateFormat($row?->updated_at),
                        "next_due_date" => changeDateFormat($row?->next_due_date),
                        "insured"    => decryptData($row?->insured_name),
                        "agency"     => decryptData($row?->agency_name),
                        "status"     => isset($statusArr[$row?->status]) ? $statusArr[$row?->status] : 'Account Current',
                        "account_number" => "<a href='{$editUrl}'  data-turbolinks='false' >{$name}</a> ",
                        "payment_amount" => dollerFA($row->next_payment->monthly_payment ?? '0.00'),
                        "balance_due" => dollerFA($row->next_payment->balance_due ?? '0.00'),
                        'installment' => $installment
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }


    public function findAccounts(){
        $this->pageTitle = "Find/Edit Accounts";
        return view($this->viwePath."find",['route'=>$this->route,'pageTitle'=>$this->pageTitle,'activePage'=>$this->activePage]);
    }



    /* Change Payment due date */
    public function changePaymentDueDate(Request $request,$accountId=null,$id){

        $DbData  = QuoteAccountExposure::getData(['accountId'=>$accountId,'id'=>$id])->firstORFail();
        $prevData = changeDateFormat($DbData?->payment_due_date,true);
        $jsonPaymentDueDate = !empty($DbData?->json_payment_due_date) ? json_decode($DbData?->json_payment_due_date,true) : [];
      /*  dd( $jsonPaymentDueDate); */
        try {
            if ($request->ajax()) {
                $userData = $request->user();
                $payment_due_date = $request->payment_due_date;
                $note = $request->note;

                if(!empty($payment_due_date)){


                    $date  = dbDateFormat($payment_due_date);
                    array_push($jsonPaymentDueDate,['date'=>$date,'notes'=>$note,'updated_at'=>now()]);
                   /*  dd( $jsonPaymentDueDate); */
                    $DbData->payment_due_date = $date;
                    $DbData->payment_notes    = $note;
                    $DbData->json_payment_due_date =  !empty($jsonPaymentDueDate) ? json_encode($jsonPaymentDueDate) : null;
                    $DbData->save();


                }
                $msg = "Payment Due Date was changed from <b>".$prevData."</b> to <b>".$payment_due_date."</b>" ;
                Logs::saveLogs(['type'=>$this->activePage,'user_id'=>$userData?->id,'type_id'=>$accountId,'message'=>$msg]);

            }
            return response()->json(['status' => true, 'msg' =>'Payment Due Date was changed successfully','type'=>'payment_due_date','accountId'=>$accountId]);
        } catch (\Throwable$th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }

    }

    public function getPaymentScheduleHistory(Request $request,$accountId){


        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';


        $sqlData         = QuoteAccountExposure::getData(['accountId'=>$accountId]);
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date      = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();
        $totalMonthlyPayment = $totalInterest = $totalPrincipal = 0;
        $isActiveRow   =  null;
        $i  =  $activeIndex = null;
        $statusArr = [0=> 'Next Due',1=>'Completed',2=>'Cancelled',3=>'Pending'];
          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."edit",encryptUrl($row['id']));
                    $totalMonthlyPayment += $row->monthly_payment ?? 0;
                    $totalInterest += $row->interest ?? 0;
                    $totalPrincipal += $row->principal ?? 0;
                    $payment_due_date = changeDateFormat($row->payment_due_date,true) ?? '';
                    if($row->status == 0 && empty($isActiveRow)){
                        $activeRow  =  'active';
                        $isActiveRow  = true;
                        $activeIndex  = $i;
                        $payment_due_date =  "<kbd style='background-color: white; font-size: 12px;'><a class='OverrideDueDate' x-on:click='overrideDueDate(`{$row->id}`)' href='javascript:void(0)'  data-date='{$payment_due_date}'>{$payment_due_date}</a> </kbd> ";
                    }else{
                        $activeRow  =  '';

                    }

                    $dataArr[] = array(
                        "created_at" =>changeDateFormat($row->created_at ?? ''),
                        "payment_number" => ($row->payment_number) ?? '',
                        "payment_due_date" => $payment_due_date ,
                        "amount_financed" => dollerFormatAmount($row->amount_financed) ?? '',
                        "monthly_payment" => dollerFormatAmount($row->monthly_payment) ?? '',
                        "interest" => dollerFormatAmount($row->interest) ?? '',
                        "principal" => dollerFormatAmount($row->principal) ?? '',
                        "principal_balance" => dollerFormatAmount($row->principal_balance) ?? '',
                        "payoff_balance" => dollerFormatAmount($row->payoff_balance) ?? '',
                        "interest_refund" => dollerFormatAmount($row->interest_refund) ?? '',
                        "status" => isset($statusArr[$row->status]) ? $statusArr[$row->status] : '',
                        "class" => $activeRow,

                    );
                    $i++;
                }
          }
          $totalMonthlyPayment = dollerFormatAmount($totalMonthlyPayment);
          $totalInterest = dollerFormatAmount($totalInterest);
          $totalPrincipal = dollerFormatAmount($totalPrincipal);
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr,'totalMonthlyPayment'=>$totalMonthlyPayment,'totalInterest'=>$totalInterest,'totalPrincipal'=>$totalPrincipal,'activeIndex'=>$activeIndex);
          return json_encode($response);
    }


    /* public function quotesActivation(){
        $this->pageTitle = "Quotes In Activation";
        return view($this->viwePath."quotes-activation",['route'=>$this->route,'pageTitle'=>$this->pageTitle]);
    } */

    public function alertViewList(Request $request,$accountId=null){

        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';
        $parentId     = !empty($request['parentId']) ? $request['parentId'] : '';

       /*  dd(  $parentId  ); */
        $columnNameArr = ['created_by' => 'users.first_name', 'created_at' => 'account_alerts.created_at', 'alert_subject' => 'account_alerts.alert_subject', 'category' => 'account_alerts.category', 'task' => 'account_alerts.task',];
        $columnName = isset($columnNameArr[$columnName]) ? $columnNameArr[$columnName] : 'account_alerts.created_at';
        $sqlData         = AccountAlert::getData(['accountId'=>$accountId])->join('users','users.id','account_alerts.user_id');
        if(isset($request['parentId'])){
            $sqlData = $sqlData->where('account_alerts.id', $parentId)->orWhere('account_alerts.parent_id', $parentId);
        }else{
            $sqlData = $sqlData->where('show_task',1);
        }
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $date            = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get(['account_alerts.*','users.first_name as first_name','users.middle_name as middle_name','users.last_name as last_name']);

          if(!empty($date)){
                foreach($date as $row){
                    $editUrl = routeCheck($this->route."edit",encryptUrl($row['id']));
                    $name    = ucfirst($row['alert_subject']);
                    if(!empty($parentId)){
                        $alert_subject = "<a href='javascript:void(0)' data-turbolinks='false' >{$name}</a>";
                    }else{
                        $alert_subject = "<a href='javascript:void(0)' x-on:click='accountAlertDetails(`{$row?->id}`)' data-turbolinks='false' >{$name}</a>";
                    }
                    $dataArr[] = [
                       // "created_by" => $row?->user->name,
                        "created_by" => decryptData($row?->first_name)." ".decryptData($row?->middle_name)." ".decryptData($row?->last_name),
                        "created_at" => changeDateFormat($row?->created_at),
                        "alert_subject" => $alert_subject,
                        "category" => $row?->category ?? '',
                        "task" => !empty($row?->task) ? 'Yes' : 'No',
                    ];

                }
          }
          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }


    public function accountAlertInsertOrUpdate(Request $request,$accountId){

        $id = $request->id;
        if(!empty($id)){
            $accountAlert = AccountAlert::getData(['id'=>$id,'accountId'=>$accountId])->firstOrFail();
        }
        return view($this->viwePath."pages.account_alert.create",['accountId'=>$accountId,'route'=>$this->route,'alertId'=>$id]);
    }

    public function accountAlertDetails(Request $request,$accountId,$id){
        $accountAlert = AccountAlert::getData(['id'=>$id,'accountId'=>$accountId])->firstOrFail();
        return view($this->viwePath."pages.account_alert.details",['accountId'=>$accountId,'route'=>$this->route,'data'=>$accountAlert,'id'=>$id,'activePage'=>$this->activePage]);
    }

    public function accountAlertStore(Request $request,$accountId){

        $validatedData = $request->all();
        $quoteAccount = QuoteAccount::getData(['id'=>$accountId])->firstOrFail();
        try {
            if ($request->ajax()) {
                $inputs = $request->post();
                $inputs['account_id'] = $accountId;
                $inputs['alert_date'] = !empty($request->alert_date) ? dbDateFormat($request->alert_date) : null;
                $inputs['task'] = !empty($request->add_task) ? 1 : 0;
                $inputs['onDB'] = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
              //  dd($inputs);
                $data = AccountAlert::insertOrUpdate($inputs);
                if(!empty($request->add_task)){
                    $inputs['type_id'] = $data->id;
                    $inputs['type'] = "account";
                    $inputs['logId'] = $accountId;
                    Task::insertOrUpdate($inputs);
                }

                $id = !empty($data->id) ? ($data->id) : null;
                if(!empty($accountId)){
                    return response()->json(['status' => true, 'msg' => $this->pageTitle . ' has been created successfully','type' =>'attr','action'=>"open = `account_alerts`"], 200);
                }else{
                    return response()->json(['status' => true, 'msg' => $this->pageTitle . ' has been created
                    successfully', 'continue' => routeCheck($this->route . "edit", $id), 'back' =>
                        routeCheck($this->route . "index")], 200);
                }

            }
        } catch (\Throwable$th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }

      /**
     * Policy details Show In Quote Id Base
     */
    public function policiesAndEndorsments(Request $request,$accountId=null, $id = "null")
    {
        try {
            $data  = $this->model::getData()->where('id',$accountId)->firstOrFail();
            $quote = !empty($data->quote) ? $data->quote : '';
            $version = !empty($data->version) ? $data->version : '';
            $quotePolicy = QuotePolicy::getData(['qId'=>$quote,'version'=>$version])->with('payable')->get();
            $view = view($this->viwePath . ".pages.policies_endorsments", ['route' => $this->route, 'activePage' => $this->activePage, 'quotePolicy' => $quotePolicy,'accountId'=>$accountId])->render();
            return ['status' => true, 'view' => $view];
        } catch (\Throwable $th) {
            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }


  

      /**
     * Policy details Show In Quote Id Base
     */
    public function policyDetail(Request $request,$accountId=null, $id = "null")
    {

        $data = QuotePolicy::getData(['id' => $id])->first();

        try {
            /* Update Code In Ajax */

            if ($request->ajax() && $request->isMethod('post')) {
                $titleArr = !empty($request->titleArr) ? json_decode($request->titleArr,true) : '' ;

                $inputs = $request->except(['company_data','_token']);
                $inputs = Arr::only($inputs,$data->getFillable());
                $inputs['effective_cancel_date'] = !empty($request->effective_cancel_date) ? dbDateFormat($request->effective_cancel_date) : '' ;
                $data->fill($inputs);
                $data->save();
                $msg = !empty($data->changesArr) ? logsMsgCreate($data->changesArr,$titleArr)?->msg : '' ;
                !empty($msg) && Logs::saveLogs(['type' => $this->activePage, 'user_id' => $request->user()->id, 'type_id' =>$accountId, 'message' => $msg]);
                return response()->json(['status' => true, 'msg' => 'Quote Policy has been updated successfully'], 200);
            }

            $insurance = !empty($data->insurance_company_data) ? $data->insurance_company_data : null;
            $generalAgent = !empty($data->general_agent_data) ? $data->general_agent_data : null;
            $view = view($this->viwePath . ".pages.policy.edit", ['route' => $this->route, 'activePage' => $this->activePage, 'data' => $data,'accountId'=>$accountId])->render();
            $insuranceJson = [['value' => $insurance?->id, 'text' => $insurance?->name, 'name' => $insurance?->name, 'selected' => true]];
            $generalAgentJson = [['value' => $generalAgent?->id, 'text' => $generalAgent?->name, 'name' => $generalAgent?->name, 'selected' => true]];
            return ['status' => true, 'view' => $view, 'insuranceJson' => $insuranceJson, 'generalAgentJson' => $generalAgentJson];
        } catch (\Throwable $th) {
            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }




      /*
      @Ajax Get Data List
    */
    public function notsViewList(Request $request,$type_id=null)
    {

        $sort = !empty($request['sort']) ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order']) ? $request['order'] : "desc";
        $offset = !empty($request['offset']) ? $request['offset'] : 0;
        $limit = !empty($request['limit']) ? $request['limit'] : 25;
        $searchValue = !empty($request['search']) ? $request['search'] : '';
        $parentId = !empty($request['parentId']) ? $request['parentId'] : '';
        $statusVal = !empty($request['statusVal']) ? explode(',', $request['statusVal']) : '';

        $columnName = [
            'created_at' => 'notes.created_at',
            'updated_at' => 'notes.updated_at',
            'subject' => 'notes.subject',
            'description' => 'notes.description',

        ];

        $columnName = !empty($columnName[$sort]) ? $columnName[$sort] : 'notes.created_at';
        $sqlData = Note::getData(['qId'=>$type_id]);
        if (!empty($parentId)) {
             $sqlData = $sqlData->where('notes.id', $parentId)
                ->orWhere('notes.parent_id', $parentId);
        } else {
            $sqlData = $sqlData->where('show_status', '=', 1);
        }

        $totalstateDatas = $sqlData->count();
        $dataArr = [];
        $data = $sqlData->skip($offset)->take($limit)->orderByEn($columnName, $columnSortOrder)->get();

        if (!empty($data)) {
            foreach ($data as $row) {
                $id = !empty($row['parent_id']) ? $row['parent_id'] : $row['id'];
                $editUrl = '';
                $subject = ucfirst($row['subject']);
                $show_status = !empty($row->show_status) ? $row->show_status : '' ;
                if(empty($show_status)){
                    $subject = "<del>$subject</del>";
                    $subject = "<a href='javasacript:void(0)' onclick=textAlertModel(false,'{$row->description}')>{$subject}</a>";
                }else{
                    $subject = "<a href='javasacript:void(0)' x-on:click=detailsNotes('{$row['id']}')>{$subject}</a>";
                }



                $dataArr[] = [
                    "created_at"    => changeDateFormat($row?->created_at),
                    "updated_at"    => changeDateFormat($row?->updated_at),
                    "username"      => $row?->created_by?->name ?? null,
                    "description"      => $row?->description,
                    "subject" => $subject,
                ];

            }
        }
        $response = array("total" => $totalstateDatas, "totalNotFiltered" => $totalstateDatas, "rows" => $dataArr);
        return json_encode($response);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notesAdd(Request $request,$type=null,$vId=null)
    {
        try {
            $id = $request->id;
            if ($request->ajax() && $request->isMethod('post')) {
                $is_task    = $request->post('is_task');
                $inputs     = $request->post();
                $task       = $request->post('task');
                $inputs['onDB']     = 'company_mysql';
                $inputs['type_id']      = $type;
                $inputs['type']      = 'account';
                $inputs['files']    =  $request->post('attachments');
                $inputs['onDB']     = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $type;
                $inputs['id'] = $id;
                $data = Note::insertOrUpdate($inputs);
                if(!empty($is_task)){
                    $taskData =  Task::insertOrUpdate($inputs);
                 }
                $id = !empty($data->id) ? ($data->id) : null;
                return response()->json(['status' => true, 'msg' => $this->pageTitle . ' Notes has been created
                successfully', 'type' => 'attr','action' => "open = 'notes'"], 200);
            }else{
                $userData = Note::userData();
               return view($this->viwePath."pages.notes.create",['route'=>$this->route,'typeId'=>$type,'activePage'=>$this->activePage,'userData'=>$userData]);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
    }


     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function notesDetails($type=null,$id=null)
    {
        $data = Note::getData(['id'=>$id,'type'=>$type])->firstOrFail();
        return view($this->viwePath."pages.notes.details",['route'=>$this->route,'typeId'=>$type,'id'=>$id,'activePage'=>$this->activePage,'data'=>$data]);
    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function notesEdit(Request $request,$type=null,$id=null)
    {
        try {

            if ($request->ajax() && $request->isMethod('put')) {
                $is_task    = $request->post('is_task');
                $inputs     = $request->post();
                $task       = $request->post('task');
                $inputs['onDB']     = 'company_mysql';
                $inputs['type_id']      = $type;
                $inputs['type']      = 'account';
                $inputs['files']    =  $request->post('attachments');
                $inputs['onDB']     = 'company_mysql';
                $inputs['activePage'] = $this->activePage;
                $inputs['logId'] = $type;
                $inputs['id'] = $id;
                $data = Note::insertOrUpdate($inputs);
                if(!empty($is_task)){
                    $taskData =  Task::insertOrUpdate($inputs);
                 }
                $id = !empty($data->id) ? ($data->id) : null;
                return response()->json(['status' => true, 'msg' => $this->pageTitle . ' Notes has been updated
                successfully', 'type' => 'attr','action' => "open = 'notes'"], 200);
            }else{
                $userData = Note::userData();
                $data  = Note::getData(['id'=>$id,'type'=>$type])->firstOrFail();
               return view($this->viwePath."pages.notes.edit",['data'=>$data,'route'=>$this->route,'typeId'=>$type,'activePage'=>$this->activePage,'userData'=>$userData,'id'=>$id]);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
    }


    /* Notice History */
    public function getNoticeHistory(Request $request,$accountId){

        $optionsHtml     = "";
        $columnName      = !empty($request['sort'])   ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : '';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';


        $sqlData         = DailyNotice::getData(['accountId'=>$accountId])->with('send_data');
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $data      = $sqlData->skip($offset)->take($limit)->orderBy($columnName,$columnSortOrder)->get();

        if(!empty($data)){
            foreach($data as $row){
                $status = $row->status;
                $noticeAction = $row->notice_action;
                $noticeType = $row->notice_type;
                $sendBy = !empty($row->send_by) ? strtolower($row->send_by)  : '';

                $sendTo = !empty($row->send_type) ? str_replace(" ","_",ucfirst($row->send_type)) : '' ;
                $templateType = NoticeTemplate::getData(['action'=>$noticeAction,'status'=>1,'template_type'=>$noticeType,'type'=>$sendTo])->eGroupBy('send_by')->get()?->pluck('send_by','send_by')?->toArray();


                if(!empty($templateType) && ($status == 1 || $status == 2)){
                    $optionsHtml = "<div class='form-group'><select data-id='{$row->id}' data-account='{$row->account_id}' data-notice='{$row->send_by}' class='ui dropdown noticeStatus' id='status_{$row->id}'>";
                    foreach ($templateType as $key => $options) {
                       $optionsHtml .= "<option value='".ucfirst($options)."' ".($sendBy == $options ? 'selected' : '').">".ucfirst($options)."</option>";
                    }
                    if(!in_array('email',$templateType) && !in_array('attachments',$templateType) && in_array('mail',$templateType)){
                        $optionsHtml .= '<option value="Attachments">Attachments</option>';
                    }
                    $optionsHtml .= '<option value="Do not send" '.($sendBy == 'do not send' ? "selected" : "").'>Do not send</option>';
                    if($sendBy != "do not send"){
                        $optionsHtml .= '<option value="Resend">Resend</option>';
                    }

                    $optionsHtml .= "</div>";
                }else{
                    $optionsHtml  = ucfirst($row->send_by) ?? '' ;
                }


                $dataArr[] = array(
                    "created_at"    => changeDateFormat($row->created_at ?? ''),
                    "sent_printed"  => '',
                    "notice"        => '<a href="javasctipt:void(0)"  data-id="'.$row->id.'" data-account="'.$row->account_id.'"  class="linkButton dailyNoticeDetails">'.$row->notice_name.'</a>',
                    "sent_to"       => $row?->send_type." - ".$row?->send_data?->name,
                    "action"        => $optionsHtml,
                   // "status"        => $status,
                   // "sendBy"        => $sendBy,
                );
            }
        }

          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }


     /* Notice History */
    public function getNoticeHistoryDetails(Request $request,$accountId,$id){
        $sqlData  = DailyNotice::getData(['accountId'=>$accountId,'id'=>$id])->firstOrFail();
        return $sqlData;
    }


     /* Notice History */
    public function noticeStatusUpdate(Request $request,$id){


        $type           = strtolower($request->type);
        $data           = DailyNotice::getData(['id'=>$id])->firstOrFail();
        $noticeId       = !empty($data?->notice_id) ? $data?->notice_id : '' ;
        $noticeType     = !empty($data?->notice_type) ? $data?->notice_type : '' ;
        $noticeType     = !empty($data?->notice_type) ? $data?->notice_type : '' ;
        $noticeAction   = !empty($data?->notice_action) ? $data?->notice_action : '' ;
        $sendBy         = !empty($data?->send_by) ? $data?->send_by : '' ;
        $sendBy         = !empty($data?->send_by) ? $data?->send_by : '' ;
        $sendType       = !empty($data->send_type) ? str_replace(" ","_",ucfirst($data->send_type)) : '' ;
        $accountId      = $data?->account_id ?? '' ;
        $quoteId        = $data?->quote_id ?? '' ;
        $versionId      = $data?->version_id ?? '' ;
        $policyId       = $data?->policy_id ?? '' ;


        $noticeTypeDB = $type == 'attachments'  ? 'mail' : $type ;
        $temPlateData = NoticeTemplate::getData(['action'=>$noticeAction,'status'=>1,'noticeType'=>$noticeTypeDB,'type'=>$sendType])->first();



        $quoteData = Quote::getData(['id' => $quoteId])->first();
        if(empty($quoteData))
               throw new Error("Quote Id Invalid");

        $agencyData = $quoteData?->agency_data ?? '';
        $agentData = $quoteData?->agent_user ?? '';
        $insuredUser = $quoteData?->insured_user;

        $quoteVersion = QuoteVersion::getData(['id' => $versionId])->first();
        if(empty($quoteData))
               throw new Error("Quote Version Id Invalid");

       $quoteTerm = QuoteTerm::getData(['qId' => $quoteId, 'vId' => $versionId])->first();

        $policyData = QuotePolicy::getData(['id' => $policyId])->first();
        if(empty($quoteData))
               throw new Error("Quote Policy Id Invalid");


        $accountData = QuoteAccount::getData(['id' => $accountId])->first();
        if(empty($quoteData))
               throw new Error("Quote Account Id Invalid");

      /*  dd($noticeAction); */
        if($noticeAction == 'notice_of_financed_premium'){
            $templateText = !empty($temPlateData->template_text) ? $temPlateData->template_text : null;
            $templateText = (new URSC)
                   ->FCT(['template' => $templateText])
                   ->AT(['data' => $agentData])
                   ->IT(['data' => $insuredUser])
                   ->QT(['date' => $quoteData])
                   ->QTermT(['data' => $quoteTerm]);
            DNH::quoteDailyNoticeSave($accountId, $policyData, $templateText, $temPlateData, $quoteData, $quoteVersion, $quoteTerm, $accountData, $agencyData);

        }elseif($noticeAction == 'payment_coupons'){
            DNH::quotePaymentCouponsSave([
                'qId'           =>  $quoteId,
                'vId'           =>  $versionId,
                'quoteData'     =>  $quoteData,
                'quoteTerm'     =>  $quoteTerm,
                'accountId'     =>  $accountId,
                'quoteAccount'  =>  $accountData,
                'agencyData'    =>  $agencyData,
                'agentData'     =>  $agentData,
                'insuredUser'   =>  $insuredUser,
            ]);
        }


        if($type == 'mail'){
            $data->status = 4;
            $data->save();
            return response()->json(['status'=>true,'msg'=>'Mail Send Successfully'], 200);
        } elseif($type == 'email'){
            $data->status = 4;
            $data->save();
            return response()->json(['status'=>true,'msg'=>'Email Send Successfully'], 200);
        }elseif($type == 'resend'){
            $data->status = 4;
            $data->save();
            return response()->json(['status'=>true,'msg'=>'Resend Successfully'], 200);
        }elseif($type == 'do not send'){
            $data->status = 4;
            $data->send_by = "Do Not Send";
            $data->save();
            return response()->json(['status'=>true,'msg'=>'Resend Successfully'], 200);
        }elseif($type == 'fax'){

            $data->status = 4;
            $data->send_by = "fax";
            $data->save();
            return response()->json(['status'=>true,'msg'=>'Fax Send Successfully'], 200);
        }elseif($type == 'attachments'){
            $data->status = 4;
            $data->send_by = "attachments";
            $data->save();
            return response()->json(['status'=>true,'msg'=>'Attachment Send Successfully'], 200);
        }
        return $data;
    }





    /* payment transaction history*/
    public function getPaymentTransactionHistory(Request $request,$accountId){

        $optionsHtml     = "";
        $userData        = $request->user();
        $userType        = $userData?->user_type;
        $columnName      = !empty($request['sort'])   ? $request['sort'] : 'iid';
        $columnSortOrder = !empty($request['order'])  ? $request['order'] : 'desc';
        $offset          = !empty($request['offset']) ? $request['offset'] : 0;
        $limit           = !empty($request['limit'])  ? $request['limit'] : 25 ;
        $searchValue     = !empty($request['search']) ? $request['search'] : '';

        $sqlData         = TransactionHistory::getData(['accountId'=>$accountId]);
        $totalstateDatas = $sqlData->count();
        $dataArr         = [];
        $data      = $sqlData->skip($offset)->take($limit)->orderBy('iid',$columnSortOrder)->get();
        
        if(!empty($data)){
            foreach($data as $row){
                $accountStatus = $row?->account_data?->status ?? 0;
                $transaction_type = $row?->transaction_type ?? '' ;
                $name = $row->user?->user_type == 1 ? "System" : $row->user?->name ;
                $action = "";
                $viewAction = '<a class="dropdown-item" x-on:click="transactionHistoryDetails(`'.$row?->id.'`)" href="javascript:void(0)" >'.__('labels.view').'</a>';
                if($row->transaction_type == 'Installment Payment'  || $row->transaction_type == 'Return Premium'){
                     if($row->reverse_status == 0){
                        $action .= $viewAction;
                        $action .= '<a class="dropdown-item" href="javascript:void(0)" data-type="reverse">'.__('labels.reverse').'</a>';
                        $action .= '<a class="dropdown-item" href="javascript:void(0)"   x-on:click="transactionHistoryDetails(`'.$row?->id.'`,`emailReceipt`)" >'.__('labels.email_receipt').'</a>';
                     }else{
                        $action .= $viewAction;
                        $action .= '<a class="dropdown-item" href="javascript:void(0)"   x-on:click="transactionHistoryDetails(`'.$row?->id.'`,`emailReceipt`)" >'.__('labels.email_receipt').'</a>';
                     }
                }else if(($transaction_type == 'Convenience Fee' || $transaction_type == 'Late Fee' || 
                $transaction_type == 'Cancel Fee' || $transaction_type == 'NSF Fee' ||
                 $transaction_type == 'Stop Payment Fee') && $row->reverse_status == 0){
                    $action .= '<a class="dropdown-item" href="javascript:void(0)" data-id="'.$row?->id.'" data-type="reverse">'.__('labels.reverse').'</a>';
               }
                //$action  = ""

                if($accountStatus == 8 && !empty($action)){
                    $action = $viewAction;
                }

                if(!empty($action)){
                    $action = '<div class="dropdown transactionHistoryDropdown">
                    <a class="btn btn-secondary " href="javascript:void(0)" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       '.$row->transaction_type.'
                    </a>    
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        '.$action.'
                    </div>
                </div>';
                }else{
                    $action = $row->transaction_type;
                }

                $dataArr[] = array(
                    "transaction_date"    => changeDateFormat($row->created_at ?? ''),
                    "user"                => $name ,
                    "transaction"         => $action,
                    "debit"               => (!empty($row?->debit) && $row?->debit != "0.00") ? dollerFA($row?->debit) : '',
                    "credit"              => (!empty($row?->credit) && $row?->credit != "0.00") ? dollerFA($row?->credit) : '',
                    "balance"             => dollerFA($row?->balance),
                    "description"         => $row?->description,
                );
            }
        }

          $response = array("total" =>$totalstateDatas,"totalNotFiltered" =>$totalstateDatas,"rows" => $dataArr);
          return json_encode($response);
    }


    /* transaction History Details */
    public function transactionHistoryDetails(Request $request,$accountId="null",$id="null"){

        try {
            $data    = TransactionHistory::getData(['accountId'=>$accountId,'id'=>$id])->firstOrFail();
           
            if ($request->ajax() && $request->isMethod('post') ) {
                return response()->json(['status'=>true,'data'=>$data], 200);
            }

            $view = view($this->viwePath."pages.transaction-history-details",['data'=>$data])->render();
            return response()->json(['status'=>true,'view'=>$view], 200);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /*  email Receipt */
    public function emailReceipt(Request $request){

        try {
            $userData   = $request->user();
            $username   = $userData?->name;
            $id         = $request->id;
            $send_to    = $request->send_to;
            $email      = $request->email;
            $data    = TransactionHistory::getData(['id'=>$id])->firstOrFail();
            if ($request->ajax() && $request->isMethod('post') ) {
                $input      = $request->post();
                $accountData = $data?->account_data;

                if($send_to == 'insured'){
                    $email  =   $accountData?->insured_user?->email;
                }elseif($send_to == 'agent'){
                    $email  =   $accountData?->agent_user?->email;
                }

                if(!empty($email)){
                        $payMentData = $data?->payment_data;
                        $temPlateData = NoticeTemplate::getData(['action' =>'email_receipt','status' =>1,'type'=>'any','templateType'=>'email'])->first();
                        $templateText   = !empty($temPlateData->template_text) ? $temPlateData->template_text : null;
        
                        $templateText   = (new URSC)
                                        ->FCT(['template' => $templateText])
                                        ->ACCT(['data' => $accountData])
                                        ->PAYMENT(['data' => $payMentData]);
                        
                        $template  = $templateText?->template ?? '';
                        Email::sendemail(['email'=>$email,'body'=>$template,'subject'=>'Email Receipt']);
                        
                        $message = 'Email Receipt sent by '.$username;
                        Logs::saveLogs(['type'=>$this->activePage,'user_id'=>$userData?->id,'type_id'=>$accountData?->id,'message'=>$message]);
                }
            }
            
            return response()->json(['status' => true, 'msg' => 'Email Receipt successfully.']);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    
    /* save-assess-manual-fee */
    public function saveAssessManualFee(Request $request,$accountId){
     
        try {
            $userData = $request->user();
            $currrent_amount_fee = 0;
            if ($request->ajax() && $request->isMethod('post') ) {

                $accountData  = $this->model::getData(['id'=>$accountId])->first();
                if(empty($accountData)){
                    throw new Error("Invalid Account", 1);     
                }
                
                $fees       = $request->post('fees');
                $amount     = floatval($request->post('amount'));
                $note       = $request->post('note');

                if(!empty($accountId) && !empty($fees) && !empty($amount) && !empty($note)){
                    $message = 'Assess Manual Fee: '.$note;

                    $qoteAccountExposure = QuoteAccountExposure::getData(['accountId'=>$accountId,'status'=>1])->latest()->first();
                    if(empty($qoteAccountExposure) && empty($qoteAccountExposure?->id)){
                        $qoteAccountExposure = QuoteAccountExposure::getData(['accountId'=>$accountId,'status'=>0])->latest()->first();
                    }
                    if(empty($qoteAccountExposure) && empty($qoteAccountExposure?->id)){
                        $qoteAccountExposure = QuoteAccountExposure::getData(['accountId'=>$accountId,'status'=>3])->latest()->first();
                    }

                    if(!empty($qoteAccountExposure)){
                        $payment_number = $qoteAccountExposure->payment_number;

                        $transactionHistory = TransactionHistory::getData(['accountId'=>$accountId])->orderBy('iid','desc')->first();
                        if(!empty($amount)){
                            $balance                    = !empty($transactionHistory?->balance) ? $transactionHistory?->balance : 0 ;
                            $totalBalance               = $balance + $amount;
                            $input['account_id']        = $accountId;
                            $input['payment_number']    = $payment_number;
                            $input['type']              = $fees;
                            $input['transaction_type']  = $fees;
                            $input['description']       = $message;
                            $input['amount']            = $amount;
                            $input['debit']             = $amount;
                            $input['balance']           = $totalBalance;
                            TransactionHistory::insertOrUpdate($input);
                        }


                        $paymentname = '';
                        if($fees == 'Late Fee'){
                            $paymentname = 'late_fee';
                            $currrentamountfee =  floatval($qoteAccountExposure?->late_fee ?? 0);
                        }else if($fees == 'NSF Fee'){
                            $paymentname = 'nsf_fee';
                            $currrentamountfee = floatval($qoteAccountExposure?->nsf_fee ?? 0);
                        }else if($fees == 'Cancel Fee'){
                            $paymentname = 'cancel_fee';
                            $currrentamountfee = floatval($qoteAccountExposure?->cancel_fee ?? 0);
                        }else if($fees == 'Convenience Fee'){
                            $paymentname = 'convient_fee';
                            $currrentamountfee = floatval($qoteAccountExposure?->convient_fee ?? 0);
                        }
                       
                        $accounttotalfee = ($currrentamountfee + $amount);
                        $qoteAccountExposure->{$paymentname} = $accounttotalfee;
                        $qoteAccountExposure->save();


                        $pendingPaymentData  = PendingPayment::getData(['accountId'=>$accountId,'paymentNumber'=>$payment_number])->first();
                        if(empty($pendingPaymentData) && !empty($pendingPaymentData)){
                            if($fees == 'Late Fee'){
                                $fieldname = 'due_late_fee';
                                $currrent_amount_fee = floatval($pendingPaymentData?->due_late_fee ?? 0);
                            }else if($fees == 'NSF Fee'){
                                $fieldname = 'due_nsf_fee';
                                $currrent_amount_fee = floatval($pendingPaymentData?->due_nsf_fee ?? 0);
                            }else if($fees == 'Cancel Fee'){
                                $fieldname = 'due_cancel_fee';
                                $currrent_amount_fee = floatval($pendingPaymentData?->due_cancel_fee ?? 0);
                            }else if($fees == 'Convenience Fee'){
                                $fieldname = 'due_convient_fee';
                                $currrent_amount_fee = floatval($pendingPaymentData?->due_convient_fee ?? 0);
                            }

                            $total_amount_due = ($currrent_amount_fee + $amount);
                            $pendingPaymentData->{$fieldname} = $total_amount_due;
                            $pendingPaymentData->save();

                        }else{

                            $qoteAccountExposure->status = 1;
                            $qoteAccountExposure->save();

                            /* Account Setting Data  */
                            $paymentProcessingOrder = 'pay fee first';
                            $accountSettingData     = Setting::getData(['type' => 'account-setting'])->first();
                            if(!empty($accountSettingData)){
                                $jsonData = $accountSettingData?->json;
                                $jsonData = !empty($jsonData) ? json_decode($jsonData) : '' ;
                                $paymentThershold = $jsonData?->payment_thershold;
                                $paymentProcessingOrder = $jsonData?->payment_processing_order;
                                $paymentProcessingOrder = !empty($paymentProcessingOrder) ? strtolower($paymentProcessingOrder) : '';
                            }


                            $input['account_id']      	= $accountId;
                           
                            $input['due_installment']   = $qoteAccountExposure->monthly_payment;
                            $input['payment_number']    = $payment_number;
                            $input['payment_processing_order']    = $paymentProcessingOrder;

                            if($fees == 'Late Fee'){
                                $input['due_late_fee'] = $amount;
                            }else if($fees == 'NSF Fee'){
                                $input['due_nsf_fee'] = $amount;
                            }else if($fees == 'Cancel Fee'){
                                $input['due_cancel_fee'] = $amount;
                            }else if($fees == 'Convenience Fee'){
                                $input['due_convient_fee'] = $amount;
                            }
                            PendingPayment::insertOrUpdate($input);
                        }

                    }


                    Logs::saveLogs(['type'=>$this->activePage,'user_id'=>$userData?->id,'type_id'=>$accountId,'message'=>$message]);

                }
                
            
            }
            return response()->json(['status' => true, 'msg' => 'Assess Manual Fee for Account successfully.','type'=> 'attr','action'=> "open = `account_information`"]);

        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => $th->getMessage()]);
        }
    }

}
