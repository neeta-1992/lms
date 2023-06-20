<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Encryption\Traits\EncryptedAttribute;
use DB,Error,Arr;
use App\Models\{
    Logs,User,Entity,QuoteTerm,TransactionHistory,PendingPayment,QuoteAccountExposure,Setting,BankAccount
};
use App\Traits\ModelAttribute;
use App\Helpers\DailyNotice;
class Payment extends Model
{
    use HasFactory;
    use HasUuids;
    use ModelAttribute;
    use EncryptedAttribute;


    protected $fillable = [
        'user_id','account_id','bank_account','payment_number','status','payment_method','notes','card_number','expiration_date','cvv','zip',
        'account_holder_name','bank_name','routing_number','account_number','reference','installment_pay','sqtoken','square_payment_id',
        'late_fee','cancel_fee','nsf_fee','convient_fee','stop_payment','amount','total_due','received_from','payoff_status','payment_type','installment_json',
    ];

    protected $encryptable = ['account_holder_name','card_number','expiration_date','cvv','zip','bank_name','routing_number','account_number','sqtoken','square_payment_id'];


	 /**
     * Get the account_data associated with the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
	 /**
     * Get the account_data associated with the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account_data()
    {
        return $this->hasOne(QuoteAccount::class, 'id', 'account_id');
    }

	 /**
     * Get the account_data associated with the Payment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bank_data()
    {
        return $this->hasOne(BankAccount::class, 'id', 'bank_account');
    }


    public static function insertOrUpdate(array $array){

        $id              = !empty($array['id']) ? $array['id'] : '' ;
        $userId          = !empty($array['user_id']) ? $array['user_id'] : (auth()->user()?->id ?? 0);
        $quote           = !empty($array['quote']) ? $array['quote'] : null;
        $activePage      = !empty($array['activePage']) ? $array['activePage'] : null;
        $onDB            = !empty($array['onDB']) ? $array['onDB'] : null;
        $year            = !empty($array['year']) ? $array['year'] : null;
        $month           = !empty($array['month']) ? $array['month'] : null;


        $model           = new self; //Load Model
        $inserArr        = Arr::only($array,$model->fillable);
        $inserArr['user_id'] = $userId;
        if(!empty($year) && !empty($month)){
            $inserArr['expiration_date'] = "{$month}/{$year}";
        }


        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }

        DB::beginTransaction();
        try {

            if (!empty($id)) {
                $getdata = $model->updateOrCreate(['id' => $id], $inserArr);
            } else {
                $getdata = $model->create($inserArr);
            }



        } catch (\Throwable $th) {
            DB::rollback();
            throw new Error($th->getMessage());
        }

        DB::commit();
        return $getdata;
    }


    public static function pendingPaymentAmount(array $arr){


        $accountId  = isset($arr['accountId']) ? $arr['accountId'] : '' ;
        $amount     = isset($arr['amount']) ? toRound($arr['amount']) : 0;
        $installmentsArr     = isset($arr['installmentsArr']) ? $arr['installmentsArr'] : array();
        $paymentProcessingOrder     = isset($arr['paymentProcessingOrder']) ? ($arr['paymentProcessingOrder']) : 0;
        if(!empty($accountId)){
            $pendingPayment = PendingPayment::getData(['accountId'=> $accountId])->orderBy('created_at','desc')->first();
       
            if(!empty($pendingPayment)){
                $installment        = !empty($pendingPayment->due_installment) ? toRound($pendingPayment->due_installment) : 0;
                $late_fee               = !empty($pendingPayment->due_late_fee) ? toRound($pendingPayment->due_late_fee) : 0;
                $cancel_fee             = !empty($pendingPayment->due_cancel_fee) ? toRound($pendingPayment->due_cancel_fee) : 0;
                $nsf_fee                = !empty($pendingPayment->due_nsf_fee) ? toRound($pendingPayment->due_nsf_fee) : 0;
                $convient_fee           = !empty($pendingPayment->due_convient_fee) ? toRound($pendingPayment->due_convient_fee) : 0;
                $stop_payment           = !empty($pendingPayment->due_stop_payment) ? toRound($pendingPayment->due_stop_payment) : 0;
                $totalAmount            =  $installment + $late_fee  + $cancel_fee + $nsf_fee  +   $convient_fee + $stop_payment ;
               
				$due_late_fee = $due_cancel_fee = $due_nsf_fee = $due_convient_fee = $due_installment = $due_stop_payment = 0;
				
				$exposurePayment =  QuoteAccountExposure::getData(['accountId'=>$accountId,'paymentNumber'=>$pendingPayment->payment_number])->first();
				$interest                = !empty($exposurePayment->interest) ? toRound($exposurePayment->interest) : 0;
				$paidinterest                = !empty($exposurePayment->pay_interest) ? toRound($exposurePayment->pay_interest) : 0;
				$principal               = !empty($exposurePayment->principal) ? toRound($exposurePayment->principal) : 0;
				$remainingInterest = $interest - $paidinterest;
				$remainingPrincipal = $installment - $remainingInterest;
				
				
				//if payment order is in pay fee first
				//$amount =200 $late_fee = 10
				//$amount =10 $late_fee = 20
                if($paymentProcessingOrder == 'pay fee first'){
                    if($late_fee > 0 && $amount > 0){
						if($amount <= $late_fee){
                            $due_late_fee = $late_fee - $amount;
							$installmentsArr[$pendingPayment->payment_number]['late_fee'] = $amount;
							$amount = 0;
                        }else{
							$due_late_fee = 0;
							$amount = $amount - $late_fee;
							$installmentsArr[$pendingPayment->payment_number]['late_fee'] = $late_fee;
						}
                    }
					if($cancel_fee > 0 && $amount > 0){
						if($amount <= $cancel_fee){
                            $due_cancel_fee = $cancel_fee - $amount;
							$installmentsArr[$pendingPayment->payment_number]['cancel_fee'] = $amount;
							$amount = 0;
                        }else{
							$due_cancel_fee = 0;
							$amount = $amount - $cancel_fee;
							$installmentsArr[$pendingPayment->payment_number]['cancel_fee'] = $cancel_fee;
						}
                    }
					if($nsf_fee > 0 && $amount > 0){
						if($amount <= $nsf_fee){
                            $due_nsf_fee = $nsf_fee - $amount;
							$installmentsArr[$pendingPayment->payment_number]['nsf_fee'] = $amount;
							$amount = 0;
                        }else{
							$due_nsf_fee = 0;
							$amount = $amount - $nsf_fee;
							$installmentsArr[$pendingPayment->payment_number]['nsf_fee'] = $nsf_fee;
						}
                    }
					if($convient_fee > 0 && $amount > 0){
						if($amount <= $convient_fee){
                            $due_convient_fee = $convient_fee - $amount;
							$installmentsArr[$pendingPayment->payment_number]['convient_fee'] = $amount;
							$amount = 0;
                        }else{
							$due_convient_fee = 0;
							$amount = $amount - $convient_fee;
							$installmentsArr[$pendingPayment->payment_number]['convient_fee'] = $convient_fee;
						}
                    }
					if($stop_payment > 0 && $amount > 0){
						if($amount <= $stop_payment){
                            $due_stop_payment = $stop_payment - $amount;
							$installmentsArr[$pendingPayment->payment_number]['stop_payment'] = $amount;
							$amount = 0;
                        }else{
							$due_stop_payment = 0;
							$amount = $amount - $stop_payment;
							$installmentsArr[$pendingPayment->payment_number]['stop_payment'] = $stop_payment;
						}
                    }
					if($installment > 0 && $amount > 0){
						if($amount <= $installment){
                            $due_installment = $installment - $amount;
							$installmentsArr[$pendingPayment->payment_number]['installment'] = $amount;
							if($remainingInterest >0){
								$installmentsArr[$pendingPayment->payment_number]['interest'] = ($amount >= $remainingInterest) ? $remainingInterest : $amount;
								if($amount > $remainingInterest){
									$remainingAmount = $amount-$remainingInterest;
									$installmentsArr[$pendingPayment->payment_number]['principal'] = ($remainingAmount >= $remainingPrincipal) ? $remainingPrincipal : $remainingAmount;
								}
							}else{
								$installmentsArr[$pendingPayment->payment_number]['principal'] = $amount;
							}
							$amount = 0;
                        }else{
							$due_installment = 0;
							$amount = $amount - $installment;
							$installmentsArr[$pendingPayment->payment_number]['installment'] = $installment;
							if($remainingInterest >0){
								$installmentsArr[$pendingPayment->payment_number]['interest'] = $remainingInterest;
								$installmentsArr[$pendingPayment->payment_number]['principal'] = $remainingPrincipal;
							}else{
								$installmentsArr[$pendingPayment->payment_number]['principal'] = $installment;
							}
						}
						if(isset($installmentsArr[$pendingPayment->payment_number]['interest'])){
							$paidinterest += $installmentsArr[$pendingPayment->payment_number]['interest'];
						}
                    }
                }else{
                   if($installment > 0 && $amount > 0){
						if($amount <= $installment){
                            $due_installment = $installment - $amount;
							$installmentsArr[$pendingPayment->payment_number]['installment'] = $amount;
							if($remainingInterest >0){
								$installmentsArr[$pendingPayment->payment_number]['interest'] = ($amount >= $remainingInterest) ? $remainingInterest : $amount;
								if($amount > $remainingInterest){
									$remainingAmount = $amount-$remainingInterest;
									$installmentsArr[$pendingPayment->payment_number]['principal'] = ($remainingAmount >= $remainingPrincipal) ? $remainingPrincipal : $remainingAmount;
								}
							}else{
								$installmentsArr[$pendingPayment->payment_number]['principal'] = $amount;
							}
							$amount = 0;
                        }else{
							$due_installment = 0;
							$amount = $amount - $installment;
							$installmentsArr[$pendingPayment->payment_number]['installment'] = $installment;
							if($remainingInterest >0){
								$installmentsArr[$pendingPayment->payment_number]['interest'] = $remainingInterest;
								$installmentsArr[$pendingPayment->payment_number]['principal'] = $remainingPrincipal;
							}else{
								$installmentsArr[$pendingPayment->payment_number]['principal'] = $installment;
							}
						}
						if(isset($installmentsArr[$pendingPayment->payment_number]['interest'])){
							$paidinterest += $installmentsArr[$pendingPayment->payment_number]['interest'];
						}
                    }
					if($late_fee > 0 && $amount > 0){
						if($amount <= $late_fee){
                            $due_late_fee = $late_fee - $amount;
							$installmentsArr[$pendingPayment->payment_number]['late_fee'] = $amount;
							$amount = 0;
                        }else{
							$due_late_fee = 0;
							$amount = $amount - $late_fee;
							$installmentsArr[$pendingPayment->payment_number]['late_fee'] = $late_fee;
						}
                    }
					if($cancel_fee > 0 && $amount > 0){
						if($amount <= $cancel_fee){
                            $due_cancel_fee = $cancel_fee - $amount;
							$installmentsArr[$pendingPayment->payment_number]['cancel_fee'] = $amount;
							$amount = 0;
                        }else{
							$due_cancel_fee = 0;
							$amount = $amount - $cancel_fee;
							$installmentsArr[$pendingPayment->payment_number]['cancel_fee'] = $cancel_fee;
						}
                    }
					if($nsf_fee > 0 && $amount > 0){
						if($amount <= $nsf_fee){
                            $due_nsf_fee = $nsf_fee - $amount;
							$installmentsArr[$pendingPayment->payment_number]['nsf_fee'] = $amount;
							$amount = 0;
                        }else{
							$due_nsf_fee = 0;
							$amount = $amount - $nsf_fee;
							$installmentsArr[$pendingPayment->payment_number]['nsf_fee'] = $nsf_fee;
						}
                    }
					if($convient_fee > 0 && $amount > 0){
						if($amount <= $convient_fee){
                            $due_convient_fee = $convient_fee - $amount;
							$installmentsArr[$pendingPayment->payment_number]['convient_fee'] = $amount;
							$amount = 0;
                        }else{
							$due_convient_fee = 0;
							$amount = $amount - $convient_fee;
							$installmentsArr[$pendingPayment->payment_number]['convient_fee'] = $convient_fee;
						}
                    }
					if($stop_payment > 0 && $amount > 0){
						if($amount <= $stop_payment){
                            $due_stop_payment = $stop_payment - $amount;
							$installmentsArr[$pendingPayment->payment_number]['stop_payment'] = $amount;
							$amount = 0;
                        }else{
							$due_stop_payment = 0;
							$amount = $amount - $stop_payment;
							$installmentsArr[$pendingPayment->payment_number]['stop_payment'] = $stop_payment;
						}
                    }
                }
				$arr['installmentsArr'] = $installmentsArr;
				if(isset($installmentsArr[$pendingPayment->payment_number]['late_fee'])){
					$arr['late_fee'] = isset($arr['late_fee']) ? ($arr['late_fee'] + $installmentsArr[$pendingPayment->payment_number]['late_fee']) : $installmentsArr[$pendingPayment->payment_number]['late_fee'];
				}
				if(isset($installmentsArr[$pendingPayment->payment_number]['cancel_fee'])){
					$arr['cancel_fee'] = isset($arr['cancel_fee']) ? ($arr['cancel_fee'] + $installmentsArr[$pendingPayment->payment_number]['cancel_fee']) : $installmentsArr[$pendingPayment->payment_number]['cancel_fee'];
				}
				if(isset($installmentsArr[$pendingPayment->payment_number]['nsf_fee'])){
					$arr['nsf_fee'] = isset($arr['nsf_fee']) ? ($arr['nsf_fee'] + $installmentsArr[$pendingPayment->payment_number]['nsf_fee']) : $installmentsArr[$pendingPayment->payment_number]['nsf_fee'];
				}
				if(isset($installmentsArr[$pendingPayment->payment_number]['convient_fee'])){
					$arr['convient_fee'] = isset($arr['convient_fee']) ? ($arr['convient_fee'] + $installmentsArr[$pendingPayment->payment_number]['convient_fee']) : $installmentsArr[$pendingPayment->payment_number]['convient_fee'];
				}
				if(isset($installmentsArr[$pendingPayment->payment_number]['stop_payment'])){
					$arr['stop_payment'] = isset($arr['stop_payment']) ? ($arr['stop_payment'] + $installmentsArr[$pendingPayment->payment_number]['stop_payment']) : $installmentsArr[$pendingPayment->payment_number]['stop_payment'];
				}
				if(isset($installmentsArr[$pendingPayment->payment_number]['installment'])){
					$arr['installment'] = isset($arr['installment']) ? ($arr['installment'] + $installmentsArr[$pendingPayment->payment_number]['installment']) : $installmentsArr[$pendingPayment->payment_number]['installment'];
				}
				$exposurePayment->pay_interest = $paidinterest;
                if($due_installment >0 || $due_late_fee >0 || $due_cancel_fee >0 || $due_nsf_fee >0 || $due_convient_fee >0 || $due_stop_payment >0){
                    $pendingPayment->due_installment = $amount;
                    $pendingPayment->save();
                }else{
                    $pendingPayment->delete();
					$exposurePayment->status = 1;
					$arr['amount'] = $amount;
                    $arr = self::pendingPaymentAmount($arr);
                }
				$exposurePayment->save();
            }
        }
        return $arr ;
    }



    public static function installmentPay($data,$numberOfpayment=null,$accountType=null,$nextPayment=null,$request=null,$newArr=[]){

        $input                  = $request->post();
        $paymentType            = $request->payment_type;
        $payment_number         = $request->payment_number;
        $paymentMethod          = $request->payment_method;
        $payType          		= $request->payType;
		$payType                = $payType == 'cron' ? 1 : 0 ;
        $convenienceFee         = floatval($request->convenience_fee);
		$amountApplyInstallment = floatval($request->amount_apply_installment);
		if(!empty($newArr)){
			$amountApplyInstallment = $newArr['amount'];
		}
		$installmentsArr     = isset($newArr['installmentsArr']) ? $newArr['installmentsArr'] : [];
		
        $paymentThershold       = $request?->payment_thershold;
        $paymentProcessingOrder = $request?->payment_processing_order;
		/*  if(empty($nextPayment)){
             throw new Error("Error Processing Request",);
        } */
		if($amountApplyInstallment >0){
			$monthlyPayment = $installment = !empty($nextPayment->monthly_payment) ? toRound($nextPayment->monthly_payment) : 0;
			if ($paymentType == 'payoff' && $nextPayment?->payment_number != $payment_number ) {
				$monthlyPayment = !empty($nextPayment->principal) ? toRound($nextPayment->principal) : 0;
			}
			$late_fee               = !empty($nextPayment->late_fee) ? toRound($nextPayment->late_fee) : 0;
			$cancel_fee             = !empty($nextPayment->cancel_fee) ? toRound($nextPayment->cancel_fee) : 0;
			$nsf_fee                = !empty($nextPayment->nsf_fee) ? toRound($nextPayment->nsf_fee) : 0;
			$interest               = !empty($nextPayment->interest) ? toRound($nextPayment->interest) : 0;
			$principal              = !empty($nextPayment->principal) ? toRound($nextPayment->principal) : 0;
			
			$payoffStatus           = 0;
			$paid_interest = 0;
			$payAmount              = formatAmount($monthlyPayment);
			$paymentNumber          = $nextPayment?->payment_number;
			$totalAmountPay = ($late_fee + $cancel_fee + $nsf_fee + $monthlyPayment);
			$amount = $amountApplyInstallment;
			$due_late_fee = $due_cancel_fee = $due_nsf_fee = $due_convient_fee = $due_installment = $due_stop_payment = 0;
			if($paymentProcessingOrder == 'pay fee first'){
				if($late_fee > 0 && $amount > 0){
					if($amount <= $late_fee){
						$due_late_fee = $late_fee - $amount;
						$installmentsArr[$paymentNumber]['late_fee'] = $amount;
						$amount = 0;
					}else{
						$due_late_fee = 0;
						$amount = $amount - $late_fee;
						$installmentsArr[$paymentNumber]['late_fee'] = $late_fee;
					}
				}
				if($cancel_fee > 0 && $amount > 0){
					if($amount <= $cancel_fee){
						$due_cancel_fee = $cancel_fee - $amount;
						$installmentsArr[$paymentNumber]['cancel_fee'] = $amount;
						$amount = 0;
					}else{
						$due_cancel_fee = 0;
						$amount = $amount - $cancel_fee;
						$installmentsArr[$paymentNumber]['cancel_fee'] = $cancel_fee;
					}
				}
				if($nsf_fee > 0 && $amount > 0){
					if($amount <= $nsf_fee){
						$due_nsf_fee = $nsf_fee - $amount;
						$installmentsArr[$paymentNumber]['nsf_fee'] = $amount;
						$amount = 0;
					}else{
						$due_nsf_fee = 0;
						$amount = $amount - $nsf_fee;
						$installmentsArr[$paymentNumber]['nsf_fee'] = $nsf_fee;
					}
				}
				if($installment > 0 && $amount > 0){
					if($amount <= $installment){
						$due_installment = $installment - $amount;
						$installmentsArr[$paymentNumber]['installment'] = $amount;
						$paid_interest = ($amount >= $interest) ? $interest : $amount;
						$remainingamount = ($amount > $interest) ? $amount-$interest : 0;
						$principal = ($remainingamount > 0) ? ($remainingamount >=$principal ? $principal : $remainingamount) : 0;
						$installmentsArr[$paymentNumber]['interest'] = $paid_interest;
						$installmentsArr[$paymentNumber]['principal'] = $principal;
						$amount = 0;
					}else{
						$due_installment = 0;
						$amount = $amount - $installment;
						$installmentsArr[$paymentNumber]['installment'] = $installment;
						$installmentsArr[$paymentNumber]['interest'] = $interest;
						$paid_interest = $interest;
						$installmentsArr[$paymentNumber]['principal'] = $principal;
					}
				}
			}else{
				if($installment > 0 && $amount > 0){
					if($amount <= $installment){
						$due_installment = $installment - $amount;
						$installmentsArr[$paymentNumber]['installment'] = $amount;
						$paid_interest = ($amount >= $interest) ? $interest : $amount;
						$remainingamount = ($amount > $interest) ? $amount-$interest : 0;
						$principal = ($remainingamount > 0) ? ($remainingamount >=$principal ? $principal : $remainingamount) : 0;
						$installmentsArr[$paymentNumber]['interest'] = $paid_interest;
						$installmentsArr[$paymentNumber]['principal'] = $principal;
						$amount = 0;
					}else{
						$due_installment = 0;
						$amount = $amount - $installment;
						$installmentsArr[$paymentNumber]['installment'] = $installment;
						$installmentsArr[$paymentNumber]['interest'] = $interest;
						$paid_interest = $interest;
						$installmentsArr[$paymentNumber]['principal'] = $principal;
					}
				}
				if($late_fee > 0 && $amount > 0){
					if($amount <= $late_fee){
						$due_late_fee = $late_fee - $amount;
						$installmentsArr[$paymentNumber]['late_fee'] = $amount;
						$amount = 0;
					}else{
						$due_late_fee = 0;
						$amount = $amount - $late_fee;
						$installmentsArr[$paymentNumber]['late_fee'] = $late_fee;
					}
				}
				if($cancel_fee > 0 && $amount > 0){
					if($amount <= $cancel_fee){
						$due_cancel_fee = $cancel_fee - $amount;
						$installmentsArr[$paymentNumber]['cancel_fee'] = $amount;
						$amount = 0;
					}else{
						$due_cancel_fee = 0;
						$amount = $amount - $cancel_fee;
						$installmentsArr[$paymentNumber]['cancel_fee'] = $cancel_fee;
					}
				}
				if($nsf_fee > 0 && $amount > 0){
					if($amount <= $nsf_fee){
						$due_nsf_fee = $nsf_fee - $amount;
						$installmentsArr[$paymentNumber]['nsf_fee'] = $amount;
						$amount = 0;
					}else{
						$due_nsf_fee = 0;
						$amount = $amount - $nsf_fee;
						$installmentsArr[$paymentNumber]['nsf_fee'] = $nsf_fee;
					}
				}
			}
			$newArr['installmentsArr'] = $installmentsArr;
			if(isset($installmentsArr[$paymentNumber]['late_fee'])){
				$newArr['late_fee'] = isset($newArr['late_fee']) ? ($newArr['late_fee'] + $installmentsArr[$paymentNumber]['late_fee']) : $installmentsArr[$paymentNumber]['late_fee'];
			}
			if(isset($installmentsArr[$paymentNumber]['cancel_fee'])){
				$newArr['cancel_fee'] = isset($newArr['cancel_fee']) ? ($newArr['cancel_fee'] + $installmentsArr[$paymentNumber]['cancel_fee']) : $installmentsArr[$paymentNumber]['cancel_fee'];
			}
			if(isset($installmentsArr[$paymentNumber]['nsf_fee'])){
				$newArr['nsf_fee'] = isset($newArr['nsf_fee']) ? ($newArr['nsf_fee'] + $installmentsArr[$paymentNumber]['nsf_fee']) : $installmentsArr[$paymentNumber]['nsf_fee'];
			}
			if(isset($installmentsArr[$paymentNumber]['installment'])){
				$newArr['installment'] = isset($newArr['installment']) ? ($newArr['installment'] + $installmentsArr[$paymentNumber]['installment']) : $installmentsArr[$paymentNumber]['installment'];
			}
			$newArr['amount'] = $amount;
			$nextPayment->pay_interest = $paid_interest;
			if($due_installment >0 || $due_late_fee >0 || $due_cancel_fee >0 || $due_nsf_fee >0 ){
				$totalAmountPaid = $totalAmountPay - ($due_late_fee + $due_cancel_fee + $due_nsf_fee + $due_installment);
				if(!empty($paymentThershold)){
					$amountCheck = ($totalAmountPaid/$totalAmountPay)*100;
					if($amountCheck >= $paymentThershold){
						$nextPayment->payment_type = $payType;
						$nextPayment->status = 1;
						$nextPayment->save();
					}else{
						$nextPayment->payment_type = $payType;
						$nextPayment->status = 3;
						$nextPayment->save();
					}
				}else{
					$nextPayment->payment_type = $payType;
					$nextPayment->status = 3;
					$nextPayment->save();
				}
				$input['account_id']      	= $data?->id;
				$input['due_late_fee']      = $due_late_fee;
				$input['due_cancel_fee']    = $due_cancel_fee;
				$input['due_nsf_fee']       = $due_nsf_fee;
				$input['due_installment']   = $due_installment;
				$input['payment_number']    = $paymentNumber;
				$input['payment_processing_order']    = $paymentProcessingOrder;
				PendingPayment::insertOrUpdate($input);
			}else{
				$nextPayment->payment_type = $payType;
				$nextPayment->status = 1;
				$nextPayment->save();
				$nextPayment =  QuoteAccountExposure::getData(['accountId'=>$data?->id])->whereStatus(0)->first(); // Next Payment Data
				if(!empty($nextPayment) && $newArr['amount'] >0){
					$newArr = self::installmentPay($data,$numberOfpayment,$accountType,$nextPayment,$request,$newArr);
				}
			}
		}
		
        return $newArr;

    }




    public static function savePayment($data=null,$numberOfpayment=null,$accountType=null,$nextPayment=null,$request=null){

       // DB::beginTransaction();
        try {

            //code...
            $interestRefund         = $extraAmount  = $peadingAmount = $paymentThershold = $payoffStatus = 0;
            $isPeding               = false;
            $userData               = !empty($request['userData'])  ? $request['userData'] : $request->user();
            $activePage             = !empty($request['activePage'])  ? $request['activePage'] : $request->activePage;
          
			$input                  = $request->all();
            $paymentType            = $request->payment_type;
            $paymentMethod          = $request->payment_method;
            $duePayment             = $request->due_payment;
            $convenienceFee         = floatval($request->convenience_fee);
            $amountApplyInstallment = floatval($request->amount_apply_installment);
			if ($paymentType == 'payoff') {
				$amountApplyInstallment = $nextPayment?->payoff_balance;
			}
            $accountId              = $data->id;
            $monthlyPayment         = !empty($nextPayment->monthly_payment) ? floatval($nextPayment->monthly_payment) : 0;
            $late_fee               = !empty($nextPayment->late_fee) ? floatval($nextPayment->late_fee) : 0;
            $cancel_fee             = !empty($nextPayment->cancel_fee) ? floatval($nextPayment->cancel_fee) : 0;
            $nsf_fee                = !empty($nextPayment->nsf_fee) ? floatval($nextPayment->nsf_fee) : 0;
            $paymentNumber          = $nextPayment?->payment_number;

            //Get Data Account Setting Data
            $accountSettingData     = Setting::getData(['type' => 'account-setting'])->first();

            if(!empty($accountSettingData)){
                $jsonData = $accountSettingData?->json;
                $jsonData = !empty($jsonData) ? json_decode($jsonData) : '' ;
                $paymentThershold = $jsonData?->payment_thershold;
                $paymentProcessingOrder = $jsonData?->payment_processing_order;
                $request['payment_thershold'] = $paymentThershold;
                $request['payment_processing_order'] = !empty($paymentProcessingOrder) ? strtolower($paymentProcessingOrder) : '';
            }
          
			$installmentsArr = array();
			$pendingPaymentArr = ['accountId'=>$data?->id,'amount' =>$amountApplyInstallment,'paymentProcessingOrder'=>$paymentProcessingOrder,'installmentsArr'=>$installmentsArr];
			$pendingPaymentArr = self::pendingPaymentAmount(['accountId'=>$data?->id,'amount' =>$amountApplyInstallment,'paymentProcessingOrder'=>$paymentProcessingOrder,'installmentsArr'=>$installmentsArr]);
			//print_r($pendingPaymentArr);
			$paymentDataArr  =  self::installmentPay($data,$numberOfpayment,$accountType,$nextPayment,$request,$pendingPaymentArr);
			//print_r($paymentDataArr);
			if($paymentType != 'installment'){
                /* Pay off payment  */
                QuoteAccountExposure::getData(['accountId'=>$accountId])->update(['status' => 1]);
                $data->payment_status = -1; // Peading Payment
                $data->save();
                $payoffStatus = 1;
                $interestRefund = $nextPayment?->interest_refund ?? 0 ;
                $paymentNumber = $numberOfpayment;
            }else{
                $data->payment_status = -1; // Peading Payment
                $data->save();
            }



            $input['late_fee']          = !empty($paymentDataArr) && isset($paymentDataArr['late_fee']) ? $paymentDataArr['late_fee'] : 0;
            $input['cancel_fee']        = !empty($paymentDataArr) && isset($paymentDataArr['cancel_fee']) ? $paymentDataArr['cancel_fee'] : 0;
            $input['nsf_fee']           = !empty($paymentDataArr) && isset($paymentDataArr['nsf_fee']) ? $paymentDataArr['nsf_fee'] : 0;
            $input['convient_fee']      = !empty($paymentDataArr) && isset($paymentDataArr['convient_fee']) ? ($paymentDataArr['convient_fee'] + $convenienceFee) : $convenienceFee;
            $input['stop_payment']      = !empty($paymentDataArr) && isset($paymentDataArr['stop_payment']) ? $paymentDataArr['stop_payment'] : 0;
            $input['installment_pay']   = !empty($paymentDataArr) && isset($paymentDataArr['installment']) ? $paymentDataArr['installment'] : 0;
            $input['payoff_status']     = $payoffStatus;
            $input['amount']            = $amountApplyInstallment+$convenienceFee;
            $input['installment_json']  = !empty($paymentDataArr) && isset($paymentDataArr['installmentsArr']) ? json_encode($paymentDataArr['installmentsArr']) : null;
            $input['payment_number']    = $paymentNumber;
            $input['total_due']    		= $duePayment;
          
            $paymentData                = self::insertOrUpdate($input);


            $transactionHistory = TransactionHistory::getData(['accountId'=>$accountId])->orderBy('iid','desc')->first();
            if(!empty($convenienceFee) && in_array($paymentMethod,['Credit Card','eCheck'])){
                $balance                    = !empty($transactionHistory?->balance) ? $transactionHistory?->balance : 0 ;
                $totalBalance               = $balance + $convenienceFee;
                $description                = 'Convenience Fee for Installment '.$paymentNumber.' of '.$numberOfpayment;
                $input['payment_id']        = $paymentData->id;
                $input['type']              = 'Convenience Fee';
                $input['transaction_type']  = 'Convenience Fee';
                $input['description']       = $description;
                $input['amount']            = $convenienceFee;
                $input['debit']             = $convenienceFee;
                $input['balance']           = $totalBalance;
                TransactionHistory::insertOrUpdate($input);
            }

            if(!empty($paymentData->id)){
				 $transactionHistory = TransactionHistory::getData(['accountId'=>$accountId])->orderBy('iid','desc')->first();
                //$transactionHistory         = $transactionHistory?->refresh();
				$balance                    = !empty($transactionHistory?->balance) ? $transactionHistory?->balance : 0 ;
                $totalBalance               = $balance - ($amountApplyInstallment + $interestRefund + $convenienceFee);
				$description                = $paymentMethod.' Installment Payment '.$paymentNumber.' of '.$numberOfpayment;
                $input['payment_id']        = $paymentData->id;
                $input['type']              = 'Installment Payment';
                $input['transaction_type']  = 'Installment Payment';
                $input['description']       = $description;
                $input['debit']             = null;
                $input['amount']            = $amountApplyInstallment+$convenienceFee;
                $input['credit']            = $amountApplyInstallment+$convenienceFee;
                $input['balance']           = $totalBalance;
                TransactionHistory::insertOrUpdate($input);

				
            }

			DailyNotice::paymentNoticesSend(['paymentData'=>$paymentData,'accountData'=>$data]);

            $messages ='Payment installment '.$paymentNumber.' of '.$numberOfpayment.' '.dollerFa($amountApplyInstallment+$convenienceFee).' was paid by '.$input['received_from'].' and entered by '.$userData?->name;
            Logs::saveLogs(['type'=>$input['activePage'],'user_id'=>$userData?->id,'type_id'=>$input['account_id'],'message'=>$messages]);

          //  DB::commit();


            } catch (\Throwable $th) {
            //    DB::rollback();
                throw $th;
            }

    }

	/* reversePaymentInstallment */
	public static function reversePaymentInstallment($paymentData=null,$errorMsg=null){

	}

    public static function getData(array $array=null){

        $model = new self;
        if(GateAllow('isAdminCompany')){
            $model = $model->on('company_mysql');
        }

        if(!empty($array['id'])){
            $model = $model->where('id',$array['id']);
        }

        if(!empty($array['accountId'])){
            $model = $model->where('account_id',$array['accountId']);
        }

        if(isset($array['status'])){
            $model = $model->where('payments.status',$array['status']);
        }
        if(isset($array['payoff_status'])){
            $model = $model->where('payments.payoff_status',$array['payoff_status']);
        }


        if(!empty($array['users'])){

            if(is_array($array['users'])){
                $model = $model->whereIn('user_id',$array['users']);
            }else{
                $model = $model->where('user_id',$array['users']);
            }
            
        }

        return $model;
     }

}
