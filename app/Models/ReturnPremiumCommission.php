<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,User,Entity,Payment,TransactionHistory,QuoteAccount,Setting
};
use App\Traits\ModelAttribute;
use App\Helpers\DailyNotice;
class ReturnPremiumCommission extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = [
        'user_id','payment_method','account_holder_name','bank_name',
        'routing_number','account_number','check_number','bank_account',
        'account_id','policy','policy_type',
        'insured_refund_payable','insured_refund_payable_status','return_premium_from',
        'check_number','bank_account','apply_payment','refund_payable',
        'print_rp_notices','reduce_remaining_interest','refund_payable_amount',
        'first_payment_due_date',
        'agent_commission_due',
        'amount_paid','status'
    ];
    protected $encryptable = [];
	
 


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
        $inserArr['user_id'] = $userId;




        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }
        

        DB::beginTransaction();
        try {
           if(!empty($id) || !empty($parentId)){
            $getdata =   $model->updateOrCreate(['id'=>$id],$inserArr);
           }else{
            $getdata=    $model->create($inserArr);
           }
			$name = $getdata?->subject ?? "";
            $typeId = !empty($id) ? $id : $getdata->id;
            if($getdata->wasRecentlyCreated == true && empty($id)){
             //   $msg = __('logs.task.add',['name'=>$name]);
            }else{
                $msg = "Return Premium for Account Added";
            }
			$apply_payment = $array['apply_payment'];
			$transaction_history_type = $transactiontype = '';
			if($apply_payment == 'allow_active_spread_rp'){
				$transaction_history_type = 'Return Premium active spread applied';
				$transactiontype = 'Return Premium';
			}else if($apply_payment == 'allow_active_current_rp'){
				$transaction_history_type = 'Return Premium applied as installment';
				$transactiontype = 'Return Premium';
			}else if($apply_payment == 'allow_cancel_rp_net'){
				$transaction_history_type = 'Cancel Return Premium (Net)';
				$transactiontype = 'Cancel Return Premium';
			}else if($apply_payment == 'allow_cancel_rp_gross'){
				$transaction_history_type = 'Cancel Return Premium (Gross)';
				$transactiontype = 'Cancel Return Premium';
			}else if($apply_payment == 'allow_agent_commission_rp'){
				$transactiontype = 'Unearned Commission';
				$transaction_history_type = 'Cancel Return Premium incl Agent Commission';
			}	
			$return_premium_from_user_data = Entity::getData(['id'=>$array['return_premium_from']])->first();
			$return_premium_from_user_name = !empty($return_premium_from_user_data) ? $return_premium_from_user_data->name : '';
			if($array['payment_method'] == 'Check'){
				$Installmentdescription = $transaction_history_type.' by '.$return_premium_from_user_name.': Amount : $'.number_format($array['amount_paid'],2).', Check #'.$array['check_number'];
			}else{
				$Installmentdescription = $transaction_history_type.' by '.$return_premium_from_user_name.': Amount : $'.number_format($array['amount_paid'],2).', Account Holder Name: '.$array['account_holder_name'].', Bank Name: '.$array['bank_name'].', Routing Number: '.$array['routing_number'].', Account Number: '.$array['bank_account_number'];
			}
			!empty($Installmentdescription) && Logs::saveLogs(['type'=>$activePage,'user_id'=>$userId,'type_id'=>$array['account_id'] ,'message'=>$Installmentdescription]);
			
			self::ReturnPremiumCommissionTransaction($array,$typeId,$transactiontype,$transaction_history_type,$Installmentdescription);
           
        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }


	public static function ReturnPremiumCommissionTransaction($data	,$id,$transactiontype,$transaction_history_type,$Installmentdescription){
		$amount = floatval($data['amount_paid']);
		if($data['apply_payment'] == 'allow_agent_commission_rp'){
			self::allow_agent_commission_rp($amount,$data,$id,$transactiontype,$transaction_history_type,$Installmentdescription);
		}
		if($data['apply_payment'] == 'allow_active_current_rp'){
			self::allow_active_current_rp($amount,$data,$id,$transactiontype,$transaction_history_type,$Installmentdescription);	
		}
	}
	
	public static function allow_agent_commission_rp($amount,$data,$id,$transactiontype,$transaction_history_type,$Installmentdescription){
		if($data['payment_method'] == 'Check'){
			$tdescription = 'UEC from agent : Check #'.$data['check_number'];
		}else{
			$tdescription = 'UEC from agent : Account Holder Name: '.$data['account_holder_name'].', Bank Name: '.$data['bank_name'].', Routing Number: '.$data['routing_number'].', Account Number: '.$data['account_number'];
		}
		$transactionHistory = TransactionHistory::getData(['accountId'=>$data['account_id']])->orderBy('iid','desc')->first();
		$balance                    = !empty($transactionHistory?->balance) ? $transactionHistory?->balance : 0 ;
		
		$paymentInputs['account_id']        = $data['account_id'];
		$paymentInputs['payment_method']        = $data['payment_method'];
		$paymentInputs['bank_account']        = $data['bank_account'];
		$paymentInputs['installment_pay']        = $amount;
		$paymentInputs['amount']        = $amount;
		$paymentInputs['total_due']        = $balance;
		$paymentInputs['account_holder_name'] = isset($data['account_holder_name']) ? $data['account_holder_name'] : '';
		$paymentInputs['bank_name'] = isset($data['bank_name']) ? $data['bank_name'] : '';
		$paymentInputs['routing_number'] = isset($data['routing_number']) ? $data['routing_number'] : '';
		$paymentInputs['account_number'] = isset($data['account_number']) ? $data['account_number'] : '';
		$paymentInputs['return_premium_id'] = $id;
		$paymentData = Payment::insertOrUpdate($paymentInputs);
		
		
		$totalBalance               = $balance - ($amount);
		$input['account_id']        = $data['account_id'];
		$input['payment_id']        = $paymentData->id;
		$input['type']              = $transactiontype;
		$input['transaction_type']  = 'Return Premium';
		$input['payment_method']    = $data['payment_method'];
		$input['description']       = $tdescription;
		$input['debit']             = null;
		$input['amount']            = $amount;
		$input['credit']            = $amount;
		$input['balance']           = $totalBalance;
		$input['return_premium_commission'] = $id;
		TransactionHistory::insertOrUpdate($input);
	}
	
	public static function allow_active_current_rp($amount,$data,$id,$transactiontype,$transaction_history_type,$Installmentdescription){
		$interestRefund         = $extraAmount  = $peadingAmount = $paymentThershold = $payoffStatus = 0;
		$isPeding               = false;
		$paymentType            = 'installment';
		$paymentMethod          = $data['payment_method'];
		$amountApplyInstallment = $amount;
		$accountId              = $data['account_id'];
		$accountdata           	= QuoteAccount::getData()->where('id', $accountId)->firstOrFail();
		$quoteData              = $accountdata?->q_data; //Quote Data
		$quoteTerm              = $accountdata?->quote_term; //Quote Trem Data
		$numberOfpayment        = $quoteTerm?->number_of_payment ?? 0;
		$accountType            = $quoteData?->account_type;
		$nextPayment   			= $accountdata?->next_payment;
		
		$monthlyPayment         = !empty($nextPayment->monthly_payment) ? floatval($nextPayment->monthly_payment) : 0;
		$late_fee               = !empty($nextPayment->late_fee) ? floatval($nextPayment->late_fee) : 0;
		$cancel_fee             = !empty($nextPayment->cancel_fee) ? floatval($nextPayment->cancel_fee) : 0;
		$nsf_fee                = !empty($nextPayment->nsf_fee) ? floatval($nextPayment->nsf_fee) : 0;
		$paymentNumber          = $nextPayment?->payment_number;

		//Get Data Account Setting Data
		$accountSettingData     = Setting::getData(['type' => 'account-setting'])->first();
		$request = request();
		$request['account_id']                  =  $accountId;
		$request['payment_number']              =  $nextPayment->payment_number;
		$request['payment_type']                =  'installment';
		$request['payment_method']              =  $paymentMethod;
		$request['due_payment']                 =  $amount;
		$request['amount_apply_installment']    =  $amount;
		$request['received_from']               =  '';
	   
		if(!empty($accountSettingData)){
			$jsonData = $accountSettingData?->json;
			$jsonData = !empty($jsonData) ? json_decode($jsonData) : '' ;
			$paymentThershold = $jsonData?->payment_thershold;
			$paymentProcessingOrder = $jsonData?->payment_processing_order;
			$request['payment_thershold'] = $paymentThershold;
			$request['payment_processing_order'] = !empty($paymentProcessingOrder) ? strtolower($paymentProcessingOrder) : '';
		}
	  
		$installmentsArr = array();
		$pendingPaymentArr = ['accountId'=>$accountId,'amount' =>$amountApplyInstallment,'paymentProcessingOrder'=>$paymentProcessingOrder,'installmentsArr'=>$installmentsArr];
		$pendingPaymentArr = Payment::pendingPaymentAmount(['accountId'=>$accountId,'amount' =>$amountApplyInstallment,'paymentProcessingOrder'=>$paymentProcessingOrder,'installmentsArr'=>$installmentsArr]);
		//print_r($pendingPaymentArr);
		$paymentDataArr  =  Payment::installmentPay($accountdata,$numberOfpayment,$accountType,$nextPayment,$request,$pendingPaymentArr);
		
		$accountdata->payment_status = -1; // Peading Payment
		$accountdata->save();
	

		$input['account_id']        = $data['account_id'];
		$input['bank_account']      = $data['bank_account'];
		$input['payment_method']    = $data['payment_method'];
		$input['late_fee']          = !empty($paymentDataArr) && isset($paymentDataArr['late_fee']) ? $paymentDataArr['late_fee'] : 0;
		$input['cancel_fee']        = !empty($paymentDataArr) && isset($paymentDataArr['cancel_fee']) ? $paymentDataArr['cancel_fee'] : 0;
		$input['nsf_fee']           = !empty($paymentDataArr) && isset($paymentDataArr['nsf_fee']) ? $paymentDataArr['nsf_fee'] : 0;
		$input['convient_fee']      = !empty($paymentDataArr) && isset($paymentDataArr['convient_fee']) ? ($paymentDataArr['convient_fee'] ) : 0;
		$input['stop_payment']      = !empty($paymentDataArr) && isset($paymentDataArr['stop_payment']) ? $paymentDataArr['stop_payment'] : 0;
		$input['installment_pay']   = !empty($paymentDataArr) && isset($paymentDataArr['installment']) ? $paymentDataArr['installment'] : 0;
		$input['payoff_status']     = $payoffStatus;
		$input['amount']            = $amountApplyInstallment;
		$input['installment_json']  = !empty($paymentDataArr) && isset($paymentDataArr['installmentsArr']) ? json_encode($paymentDataArr['installmentsArr']) : null;
		$input['payment_number']    = $paymentNumber;
		$input['total_due']    		= $amount;
		$input['payment_type']    		= 0;
		$input['return_premium_id']    		= $id;
	  
		$paymentData                = Payment::insertOrUpdate($input);

		if(!empty($paymentData->id)){
			 $transactionHistory = TransactionHistory::getData(['accountId'=>$accountId])->orderBy('iid','desc')->first();
			//$transactionHistory         = $transactionHistory?->refresh();
			$balance                    = !empty($transactionHistory?->balance) ? $transactionHistory?->balance : 0 ;
			$totalBalance               = $balance - ($amountApplyInstallment + $interestRefund);
			
			$description                = $Installmentdescription.' for Installment Payment '.$paymentNumber.' of '.$numberOfpayment;
			$input['account_id']        = $data['account_id'];
			$input['payment_id']        = $paymentData->id;
			$input['type']              = $transactiontype;
			$input['transaction_type']  = 'Return Premium';
			$input['description']       = $description;
			$input['debit']             = null;
			$input['amount']            = $amountApplyInstallment;
			$input['credit']            = $amountApplyInstallment;
			$input['balance']           = $totalBalance;
			$input['return_premium_commission'] = $id;
			TransactionHistory::insertOrUpdate($input);
		}
		
		DailyNotice::paymentNoticesSend(['paymentData'=>$paymentData,'accountData'=>$accountdata]);
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
            $model = $model->where('type_id',$array['qId']);
        }
        if(!empty($array['type'])){
            $model = $model->whereEn('type',$array['type']);
        }
        return $model;
     }
}
