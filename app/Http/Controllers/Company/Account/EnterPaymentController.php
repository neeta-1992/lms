<?php

namespace App\Http\Controllers\Company\Account;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\QuoteAccount;
use App\Models\Payment;
use App\Models\Logs;
use App\Models\QuoteVersion;
use App\Models\State;
use App\Models\TransactionHistory;
use App\Models\User;
use App\Models\UserPermission;
use App\Models\PendingPayment;
use App\Models\QuoteAccountExposure;
use App\Models\QuotePolicyAccountExposure;
use App\Models\QuotePolicy;
use App\Models\Setting;
use App\Models\ReturnPremiumCommission;
use Arr;
use DB;
use DBHelper;
use Error;
use Illuminate\Http\Request;
class EnterPaymentController extends Controller
{
    private $viwePath = "company.accounts.";
    public $pageTitle = "Account";
    public $activePage = "accounts";
    public $route = "company.accounts.";
    public function __construct(QuoteAccount $model)
    {
        $this->model = $model;
    }

    /**
     * Entey Paymnet
     */
    public function enterPayment(Request $request, $accountId = null)
    {
        try {
            $userData       = $request->user();
            $convenienceFee = 0;
            $userType       = $userData?->user_type;
            $type           = $request->payment_method;
            $amount         = $request->amount;
            $data           = $this->model::getData()->where('id', $accountId)->firstOrFail();
/* 
           if($data->suspend_status == 1){
                 return response()->json(['status' => false,'msg' => 'This Account Is Suspended'], 200);
            } 
           if($data->payment_status == -1){
                 return response()->json(['status' => false,'msg' => 'You cannot enter payment. Payment pending.'], 200);
            }  */

            $quoteData      = $data?->q_data;
            $accountType    = $quoteData?->account_type;
            $stateSettings  = !empty($data?->state_settings) ? json_decode($data?->state_settings, true) : '';
            $percentageFeeCreditCard = !empty($stateSettings['state_setting']['percentage_fee_credit_card']) ? toRound($stateSettings['state_setting']['percentage_fee_credit_card']) : 0;
            $feeCreditCard  = !empty($stateSettings['state_setting']['fee_credit_card']) ? formatAmount($stateSettings['state_setting']['fee_credit_card']) : 0;
            $percentageCommFeeCreditCard = !empty($stateSettings['state_setting']['percentage_comm_fee_credit_card']) ? toRound($stateSettings['state_setting']['percentage_comm_fee_credit_card']) : 0;
            $commFeeCreditCard = !empty($stateSettings['state_setting']['comm_fee_credit_card']) ? formatAmount($stateSettings['state_setting']['comm_fee_credit_card']) : 0;
            $nextPayment   =  $data?->next_payment;

            
            $pendingPayment = PendingPayment::getData(['accountId'=>$accountId])
                                            ->selectRaw('payment_number,SUM(due_installment) as amount,SUM(due_late_fee) as lateFee,SUM(due_cancel_fee) as cancelFee,SUM(due_nsf_fee) as nsfFee,SUM(due_convient_fee) as convientFee')
                                            ->orderBy('created_at','desc')->first();
                                         //   dd( $pendingPayment );

            if(empty($nextPayment) && empty($pendingPayment?->payment_number)){
                return response()->json(['status' => false, 'msg' => 'Payment Is Completed'], 200);
            }

            if ($request->ajax() && $request->isMethod('get')) {
                $bankAccount = BankAccount::getData()->get()?->pluck('bank_name', 'id')?->toArray();
                $electronicPaymentSettings = Setting::getData(['type'=>'electronic-payment-setting'])->first();
                $electronicPaymentSettings = !empty($electronicPaymentSettings->json) ? json_decode($electronicPaymentSettings->json) : null;
        
                $view = view($this->viwePath . ".pages.enter_payment", ['route' => $this->route, 'activePage' => $this->activePage, 'accountId' => $accountId, 'data' => $data, 'bankAccount' => $bankAccount,'pendingPayment'=>$pendingPayment,'EPS'=>$electronicPaymentSettings])->render();
                return ['status' => true, 'view' => $view];
            } elseif ($request->isMethod('post')) {

                $response = [];
                if (!empty($type) && $type == 'installment') {
                    $amount = $amount;
                } elseif ($type == 'payoff') {
                    $amount = $data?->next_payment?->payoff_balance;
                }

                if (!empty($accountType) && $accountType == 'commercial') {
                    $convenienceFee = $amount * $percentageCommFeeCreditCard / 100 + $feeCreditCard;
                } elseif (!empty($accountType) && $accountType == 'personal') {
                    $convenienceFee = $amount * $percentageFeeCreditCard / 100 + $feeCreditCard;
                }


                $response['convenience_fee'] = $convenienceFee;
                $response['amount']          = $amount;
                /* convenience fee Permissions */
                $convenienceShow = DBHelper::convenienceAllow($userData);
                $response['convenience_show'] = $convenienceShow;
                return response()->json(['status' => true, 'data' => $response], 200);
            }
        } catch (\Throwable $th) {
            throw $th;
            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }

    public function getPaymentChart(Request $request, $accountId = null)
    {
        try {
            /* Account Data */
            $data = $this->model::getData()->where('id', $accountId)->firstOrFail();


            $userData       = $request->user(); // Login User Data
            $userType       = $userData?->user_type; // Login User Type
            $paymentType    = $request->post('payment_type');
            $convenienceFee = floatval($request->post('convenience_fee'));
            $amountApplyInstallment = floatval($request->post('amount_apply_installment'));


            $pendingPayments = PendingPayment::getData(['accountId'=>$accountId])
                                            ->selectRaw('payment_number,due_installment,due_late_fee,due_cancel_fee,due_nsf_fee,due_convient_fee')
                                            ->orderBy('created_at','desc')->get();

            $quoteAccountExposure = QuoteAccountExposure::getData(['accountId'=>$accountId])->get();
            $view = view($this->viwePath.".pages.enter_payment.process",[
                'route' => $this->route,
                'activePage' => $this->activePage,
                'paymentType' => $paymentType,
                'data' => $data,
                'pendingPayments' => $pendingPayments,
                'amountApplyInstallment'    =>  $amountApplyInstallment ,
                'convenienceFee'    =>  $convenienceFee,
                'quoteAccountExposure'    =>  $quoteAccountExposure
            ])->render();
            return ['status' => true, 'view' => $view,'type'=>'process'];



        } catch (\Throwable $th) {
            throw $th;
            return ['status' => false, 'msg' => $th->getMessage()];
        }

    }



    public function savePayment(Request $request){

        try {
            $interestRefund         = 0;
            $userData               = $request->user();
            $input                  = $request->post();
           
            $accountId              = $request->post('account_id');

            $paymentType            = $request->post('payment_type');
            $data                   = $this->model::getData()->where('id', $accountId)->firstOrFail();  /* Account Data */
            $quoteData              = $data?->q_data; //Quote Data
            $quoteTerm              = $data?->quote_term; //Quote Trem Data
            $numberOfpayment        = $quoteTerm?->number_of_payment ?? 0;
            $accountType            = $quoteData?->account_type;
            $nextPayment            = $data?->next_payment; // Next Payment Data



            $request['activePage'] = $this->activePage;
            Payment::savePayment($data,$numberOfpayment,$accountType,$nextPayment,$request);



            return response()->json(['status'=>true,'msg'=>'Enter Payment Successfully','continue'=> routeCheck('company.payment.enter-payments'),'back'=> routeCheck($this->route."show",$accountId)], 200);


        } catch (\Throwable $th) {
            throw $th;
    
            return ['status' => false, 'msg' => $th->getMessage()];
        }
    }




    public function enterReturnPremiumCommission(Request $request,$accountId=null){
        
        /* Account Data */
        $data       = $this->model::getData()->where('id', $accountId)->firstOrFail();
        $quote      = $data?->quote;
        $version    = $data?->version;


        $quotePolicyOption = $applyPaymentOption  = [];
        $quotePolicy = QuotePolicy::getData(['version' =>$version])->with('coverage_type_data')->get();
        if(!empty($quotePolicy)){
            foreach ($quotePolicy as $key => $value) {
                $policyNumber = !empty($value->policy_number) ? $value->policy_number : 'TBD';
                $coverageTypeData = !empty($value->coverage_type_data->name) ? $value->coverage_type_data->name : '';
                $quotePolicyOption[$value->id] = "Policy: {$policyNumber} - {$coverageTypeData}";
            }
        }
        
        $setting   = Setting::getData(['type' => 'account-setting'])->first();
        $setting   = !empty($setting?->json) ? json_decode($setting?->json) : '' ;
        if(!empty($setting->allow_active_spread_rp)){ 
             $applyPaymentOption['allow_active_spread_rp'] = 'Active Spread (Spread and Recalculate)';
        }
        if(!empty($setting->allow_active_current_rp)){ 
             $applyPaymentOption['allow_active_current_rp'] = 'Active Current (Like Regular Installment)';
        }
        if(!empty($setting->allow_cancel_rp_net)){ 
             $applyPaymentOption['allow_cancel_rp_net'] = 'Cancellation Return Premium (Net)';
        }
        if(!empty($setting->allow_cancel_rp_gross)){ 
             $applyPaymentOption['allow_cancel_rp_gross'] = 'Cancellation Return Premium (Gross)';
        }
        if(!empty($setting->allow_agent_commission_rp)){ 
             $applyPaymentOption['allow_agent_commission_rp'] = 'Agent Return Commission';
        }

        $bankAccount = BankAccount::getData()->get()?->pluck('bank_name','id')?->toArray();
        $QuoteAccountExposure = QuoteAccountExposure::getData(['accountId'=>$accountId])->get()?->pluck('payment_due_date','payment_due_date')?->toArray();

        $transactionHistory = TransactionHistory::getData(['accountId'=>$accountId])->orderBy('iid','desc')->first();
        $response['account_number'] = $data?->account_number;
        $response['quotePolicyOption'] = $quotePolicyOption;
        $response['balance'] = $transactionHistory?->balance;
        $response['balance'] = $transactionHistory?->balance;
        $response['applyPaymentOption'] = $applyPaymentOption;
        $response['route'] = $this->route;
        $response['accountId'] = $accountId;
        $response['bankAccount'] = $bankAccount;
        $response['quoteAccountExposure'] = $QuoteAccountExposure;
        $view =  view($this->viwePath."pages.enter_return_premium_commission",$response)->render();

        return response()->json(['status'=>true,'view'=>$view], 200);
    }



    public function changeQuotePolicy(Request $request,$id=null){ 
        /* Account Data */
        $options = [];
        $quotePolicy = QuotePolicy::getData(['id' =>$id])->first();
        if(!empty($quotePolicy)){
            $insurance_company_data = $quotePolicy?->insurance_company_data;
            $general_agent_data     = $quotePolicy?->general_agent_data;
            $quote_data     = $quotePolicy?->quote_data;
            $agency_data     = $quote_data?->agency_data;
          
            if(!empty($insurance_company_data)){
                $options [] = ['value' => $insurance_company_data?->id,'name'=> $insurance_company_data?->name,'text' =>$insurance_company_data?->name ] ;
            }

            if(!empty($general_agent_data)){
                $options [] = ['value' => $general_agent_data?->id,'name'=> $general_agent_data?->name,'text' =>$general_agent_data?->name ] ;
            }

            if(!empty($agency_data)){
                $options [] = ['value' => $agency_data?->id,'name'=> $agency_data?->name,'text' =>$agency_data?->name ] ;
            }
            $quotePolicyAccountExposure = QuotePolicyAccountExposure::getData(['policy_id' =>$id])->selectRaw('SUM(pay_amount) as pay_amount,SUM(monthly_payment) as monthly_payment')->first();
             if(!empty($quoteAccountExposure?->monthly_payment)){
                $balancetotal =  toFloat($quoteAccountExposure?->monthly_payment) - toFloat($quoteAccountExposure?->pay_amount);
            }else{
                $balancetotal = $quotePolicy?->pure_premium;
            }
        }
        return response()->json(['status'=>true,'options'=>$options,'balancetotal'=>dollerFA($balancetotal)], 200);
    }


    
    public function enterReturnPremiumSava(Request $request,$id=null){ 
        /* Account Data */
        $validatedData = $request->all();
        try {
           if ($request->ajax()) {
                $inputs = $request->post();
                $inputs['status'] = 0;
                $inputs['activePage'] = $this->activePage;
                $data =  ReturnPremiumCommission::insertOrUpdate($inputs);
                return response()->json(['status'=>true,'msg'=>'Return Premium for Account successfully.','type'=> 'attr','action'=> "open = `account_information`"]);
            }
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'msg'=>$th->getMessage()]);
        }
     
    }
}
