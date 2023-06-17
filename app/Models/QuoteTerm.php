<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelAttribute;
use DB,Error,Arr;
use App\Models\{
    AgentOtherSetting,Quote,QuoteSetting
};
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Helpers\QuoteHelper;
class QuoteTerm extends Model
{
    use HasFactory;
    use ModelAttribute;
    use HasUuids;

    protected $fillable = [
        'quote','version','billing_schedule',
        'first_payment_due_date','interest_rate','interest_type',
        'buy_rate','setup_fee','taxes_and_stamp_fees','inspection_fee',
        'down_percent','number_of_payment','pure_premium',
        'broker_fee','policy_fee','doc_stamp_fees','down_payment','inception_date',
        'pure_premium','amount_financed','payment_amount_financed',
        'total_interest','total_fee','total_premium',
        'payment_amount','total_payment','total_interest_with_setup_fee','effective_apr',
        'compensation','term_other_data',
        'agent_compensation_data','main_finance_charge','setupfee_downpayment'
    ];



    public static function insertOrUpdate(array $array){
		$term_other_data = array();
		$id                 = !empty($array['id']) ? $array['id'] : '';
        $user_id            = !empty($array['user_id']) ? $array['user_id'] : auth()->user()->id;
        $logId              = !empty($array['logId']) ? $array['logId'] : '' ;
        $onDB               = !empty($array['onDB']) ? $array['onDB'] : null ;
        $quote              = !empty($array['quote']) ? $array['quote'] : null ;
        $version            = !empty($array['version']) ? $array['version'] : null ;
        $activePage         = !empty($array['activePage']) ? $array['activePage'] : null ;
        $numberOfpayment    = !empty($array['number_of_payment']) ? $array['number_of_payment'] : null ;
        $downPayment        = !empty($array['down_amount']) ? $array['down_amount'] : null ;
        $downPercent        = !empty($array['down_percent']) ? $array['down_percent'] : null ;
        $first_payment_due_date        = !empty($array['first_payment_due_date']) ? date("Y-m-d",strtotime($array['first_payment_due_date'])) : null ;
        $billingSchedule    = !empty($array['billing_schedule']) ? $array['billing_schedule'] : config('custom.quote.billing_schedule') ;
		$quoteSettings      = QuoteSetting::getData()->first();
		$quoteDatas         = Quote::getData()->where('id',$quote)->firstOrFail();

		$quotePolicyData    =  QuoteHelper::quotePolicyData($array);  // All Quote Policy Amount SUM

		$agentOtherSetting = AgentOtherSetting::getData(['entityId'=>$quoteDatas->agencyagency])->first();
		$program   = !empty($agentOtherSetting) && isset($agentOtherSetting->program) && !empty($agentOtherSetting->program) ? $agentOtherSetting->program : '';
		$programData = !empty($program) ? json_decode($program,true) : array();

        $minimum_earned        = !empty($quotePolicyData['minimum_earned']) ? toFloat($quotePolicyData['minimum_earned']) : 0;
        $purePremium        = !empty($quotePolicyData['pure_premium']) ? toFloat($quotePolicyData['pure_premium']) : 0;
        $brokerFee          = !empty($quotePolicyData['broker_fee']) ? toFloat($quotePolicyData['broker_fee']) :0;
        $policyFee          = !empty($quotePolicyData['policy_fee']) ? toFloat($quotePolicyData['policy_fee']) : 0;
        $taxes              = !empty($quotePolicyData['taxes_and_stamp_fees']) ? toFloat($quotePolicyData['taxes_and_stamp_fees']) : 0;
        $inspectionFee      = !empty($quotePolicyData['inspection_fee']) ? toFloat($quotePolicyData['inspection_fee']) : 0;
        //$docStampFees       = !empty($quotePolicyData['doc_stamp_fees']) ? toFloat($quotePolicyData['doc_stamp_fees']) : 0;
        $totalFee           = !empty($quotePolicyData['total_fee'])      ? toFloat($quotePolicyData['total_fee']) : 0;
        $unearnedFees           = !empty($quotePolicyData['unearned_fees'])      ? toFloat($quotePolicyData['unearned_fees']) : 0;
        $earnedFees           = !empty($quotePolicyData['earned_fees'])      ? toFloat($quotePolicyData['earned_fees']) : 0;
        $inceptionDate      = !empty($quotePolicyData['inception_date']) ? date('Y-m-d',strtotime($quotePolicyData['inception_date'])) : '';

		$docStampFees 			= QuoteHelper::getDocStampFee($purePremium,$quoteDatas->insured);
		$downPaymentBillingData = QuoteHelper::getDownPaymentBiling($quoteDatas->agency,$billingSchedule,$minimum_earned);
		$term_other_data['down_payment_id'] = $downPaymentBillingData['down_payment_id'];
		$term_other_data['down_payment_rule_id'] = $downPaymentBillingData['down_payment_rule_id'];
		$term_other_data['min_number_of_payment'] = $downPaymentBillingData['min_number_of_payment'];
		$term_other_data['max_number_of_payment'] = $downPaymentBillingData['max_number_of_payment'];
	    $term_other_data['round_down_payment'] = $downPaymentBillingData['round_down_payment'];
	    $term_other_data['deafult_down_payment'] = $downPaymentBillingData['down_payment_percent'];

		$down_percent           = !empty($downPercent) ? $downPercent : $downPaymentBillingData['down_payment_percent'];
		$numberOfPayment        = !empty($numberOfpayment) ? $numberOfpayment : $downPaymentBillingData['number_of_payment'] ?? config('custom.quote.number_of_payment');

        /**
          @formula
          Total Premium  = (Gross (Pure) Premium + Policy Fee + Broker Fee + Inspection Fee + Taxes);
        */
        $totalPremium           = $purePremium + $totalFee;
        /**
           @formula
           Down Payment = ((Gross (Pure) Premium + Taxes)*Down Payment %  + Policy Fee + Broker Fee + Inspection Fee);
        */
		if(!empty($downPaymentBillingData['down_payment_increase'])){
			$down_percent = $down_percent + $downPaymentBillingData['down_payment_increase'];
		}
		$downPayment = ($purePremium + $taxes)*($down_percent/100) + $brokerFee + $inspectionFee + $policyFee;


		if(!empty($downPaymentBillingData['minimum_down_payment_policies'])){
			if($downPayment < $downPaymentBillingData['minimum_down_payment_policies']){
				$downPayment = $downPaymentBillingData['minimum_down_payment_policies'];
				$down_percent = (($downPayment - ($brokerFee + $inspectionFee + $policyFee)) / ($purePremium+$taxes))*100;
			}
		}
		if(!empty($downPaymentBillingData['round_down_payment'])){
			$downPayment = toRound($downPayment);
		}

		$setupFeeData = QuoteHelper::GetSetupfee($quoteDatas->rate_table,$purePremium,$downPayment,$quoteDatas->account_type,$quoteDatas->quoteoriginationstate,$programData);
		$setupFee               = isset($setupFeeData['total_setupfee']) ? $setupFeeData['total_setupfee'] : 0;
		$Setupfee_downpayment               = isset($setupFeeData['Setupfee_downpayment']) ? $setupFeeData['Setupfee_downpayment'] : 0;
		if($Setupfee_downpayment >0){
			$downPayment += $Setupfee_downpayment;
		}
		$term_other_data['Setupfee_downpayment'] = $Setupfee_downpayment;
		$term_other_data['setupfee_percentage'] = isset($setupFeeData['setupfee_percentage']) ? $setupFeeData['setupfee_percentage'] : 0;
		$term_other_data['Setup_Fee'] = isset($setupFeeData['Setup_Fee']) ? $setupFeeData['Setup_Fee'] : 0;
		/**
          @formula
          Amount Financed = (Total Premium  - Down Payment  + FL Doc Stamp Fee)
        */
        $amountFinanced         = $totalPremium - $downPayment + $docStampFees;
        /**
          @formula
          Payment on Amount Financed = -PMT(Interest Rate/12,Number of Payments ,Amount Financed)
        */
		$term_other_data['rate_table'] = $quoteDatas->rate_table;
		$paymentAmountInterest           = QuoteHelper::getInterestRate($purePremium,$numberOfPayment,$amountFinanced,$setupFee,$quoteDatas->rate_table);
		$max_interest_rate           = QuoteHelper::getMaxInterestRate($purePremium,$quoteDatas,$programData);
		$term_other_data['max_interest_rate'] = $max_interest_rate;

		/**
          @formula
          Total Interest        = Payment on Amount Financed*Number of Payments - Amount Financed
        */
        $interestRate = $paymentAmountInterest['interestRate'];
        $interestType = $paymentAmountInterest['interestType'];
        $totalInterestWithSetupFee = $paymentAmountInterest['totalInterest'];
		$totalInterest          = $totalInterestWithSetupFee - $setupFee;
        /**
          @formula
          Payment Amount        = (Amount Financed + Total Interest + Setup Fee)/Number of Payments
        */
        $payMentAmount          = $paymentAmountInterest['paymentAmount'];
        /**
          @formula
          Total Payments        = (Payment Amount*Number of Payments)
        */
        $totalPayMent           = $payMentAmount*$numberOfPayment;
        /**
          @formula
          Total Interest Inc Setup Fee = (Total Interest + Setup Fee)
        */

         /**
          @formula
          Eeffective APR        = RATE(Number of Payments, -Payment Amount,Amount Financed)*12
        */
        $effectiveApr           = QuoteHelper::effectiveAPR($numberOfPayment,$payMentAmount,$amountFinanced);

		$first_payment_due_date = !empty($first_payment_due_date) ? $first_payment_due_date :  date('Y-m-d',strtotime('+'.$quoteSettings->until_first_payment.' days',strtotime($inceptionDate)));

		$agentCompensationData      = QuoteHelper::getAgentCompensation($purePremium,$quoteDatas->agency,$totalInterestWithSetupFee,$totalInterestWithSetupFee,$amountFinanced,$totalPremium);
		$compensation = $agentCompensationData['compensation'];
		$agent_compensation_data = $agentCompensationData['compensation_table_fee_data'];
		$model                   = new self; //Load Model

        $inserArr = [
            'quote'                     => $quote,
            'version'                   => $version,
            'billing_schedule'          => $billingSchedule,
			'first_payment_due_date'    => $first_payment_due_date,
            'interest_rate'             => $interestRate,
            'interest_type'             => $interestType,
            'buy_rate'                   => $interestRate,
            'setup_fee'                 => $setupFee,
            'setupfee_downpayment'      => $Setupfee_downpayment,
            'taxes_and_stamp_fees'      => $taxes,
            'inspection_fee'            => $inspectionFee,
            'down_percent'              => $down_percent,
            'number_of_payment'         => $numberOfPayment,
            'pure_premium'              => $purePremium,
            'broker_fee'                => $brokerFee,
            'policy_fee'                => $policyFee,
            'doc_stamp_fees'            => $docStampFees,
            'down_payment'              => $downPayment,
            'inception_date'            => $inceptionDate,
            'total_premium'             => $totalPremium,
            'amount_financed'           => $amountFinanced,
            'total_interest'            => $totalInterest,
            'total_fee'                 => $totalFee,
            'payment_amount'            => $payMentAmount,
            'total_payment'             => $totalPayMent,
            'total_interest_with_setup_fee'=> $totalInterestWithSetupFee,
            'main_finance_charge'       => $totalInterestWithSetupFee,
            'effective_apr'             => $effectiveApr,
			'compensation'              => $compensation,
			'unearned_fees'              => $unearnedFees,
			'earned_fees'                => $earnedFees,
			'compensation'              => $compensation,
            'term_other_data'           => json_encode($term_other_data),
            'agent_compensation_data'   => json_encode($agent_compensation_data),
        ];


/* dd( $inserArr); */

        if(GateAllow('isAdminCompany') || !empty($onDB)){
            $model = $model->on('company_mysql');
        }



        DB::beginTransaction();
        try {
        if(!empty($id)){
                $inserArr  = arrFilter($inserArr);
                $getdata     = $model->updateOrCreate(['quote'=>$quote,'version'=>$version],$inserArr);
            }else{
                $getdata  =    $model->updateOrCreate(['quote'=>$quote,'version'=>$version],$inserArr);
            }

           /*  if($getdata->wasRecentlyCreated == true){
                $msg = "<li>".__('logs.quote_policy.add',['id'=> "# {$getdata->quote_data->qid}"])." </li>";
                }else{
                    if(!empty($logsmsg)){
                        $changesArr = $getdata?->changesArr ?? [];
                        $msg = logsMsgCreate($changesArr, $titleArr);
                    }
                }
                $logId = !empty($logId) ? $logId : $getdata->id;
                !empty($msg) && Logs::saveLogs(['type'=>$activePage,'onDB'=>$onDB,'user_id'=>$user_id,'type_id'=>$logId,'message'=>$msg]);
            */

        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            throw new Error($th->getMessage());
        }



        DB::commit();
        return $getdata;

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

        if (!empty($array['qId'])) {
            $model = $model->whereQuote($array['qId']);
        }

        if (!empty($array['id'])) {
            $model = $model->whereId($array['id']);
        }
        if (!empty($array['vId'])) {
            $model = $model->whereVersion($array['vId']);
        }

        return $model;
    }

	public static function updateTerms(array $array,array $updateData){
		$quote              = !empty($array['quote']) ? $array['quote'] : null ;
        $version            = !empty($array['version']) ? $array['version'] : null ;
		$quoteDatas         = Quote::getData()->where('id',$quote)->firstOrFail();

		$quotePolicyData    =  QuoteHelper::quotePolicyData($array);  // All Quote Policy Amount SUM

        $minimum_earned     = !empty($quotePolicyData['minimum_earned']) ? toFloat($quotePolicyData['minimum_earned']) : 0;
        $purePremium        = !empty($quotePolicyData['pure_premium']) ? toFloat($quotePolicyData['pure_premium']) : 0;
        $brokerFee          = !empty($quotePolicyData['broker_fee']) ? toFloat($quotePolicyData['broker_fee']) :0;
        $policyFee          = !empty($quotePolicyData['policy_fee']) ? toFloat($quotePolicyData['policy_fee']) : 0;
        $taxes              = !empty($quotePolicyData['taxes_and_stamp_fees']) ? toFloat($quotePolicyData['taxes_and_stamp_fees']) : 0;
        $inspectionFee      = !empty($quotePolicyData['inspection_fee']) ? toFloat($quotePolicyData['inspection_fee']) : 0;
        $totalFee           = !empty($quotePolicyData['total_fee'])      ? toFloat($quotePolicyData['total_fee']) : 0;

		$setupFee               = $array['setup_fee'] ?? 0;
        $totalPremium           = $purePremium + $totalFee;
		$term_other_data = isset($array['term_other_data']) && !empty($array['term_other_data']) ? json_decode($array['term_other_data'],true) : array();
		$billingSchedule = !empty($array['billing_schedule']) ? $array['billing_schedule'] : config('custom.quote.billing_schedule') ;
		$docStampFees = $array['doc_stamp_fees'];
		$numberOfPayment = $array['number_of_payment'];
		$down_percent  = $array['down_percent'];
		$downPayment = $array['down_payment'];
		$interestRate  = $array['interest_rate'];
		$interest_type  = isset($array['interest_type']) && !empty($array['interest_type']) ? $array['interest_type'] : 'fixed';
		$first_payment_due_date = $array['first_payment_due_date'];
		if(isset($updateData['billing_schedule'])){
			$billingSchedule = $updateData['billing_schedule'];
			$numberOfPayment = QuoteHelper::getNumberOfPayment($quoteDatas->agency,$billingSchedule);
		}
		if(isset($updateData['number_of_payment'])){
			if(isset($term_other_data['min_number_of_payment']) && $updateData['number_of_payment'] < $term_other_data['min_number_of_payment']){
				throw new Error("The number of payments you selected was less than the minimum installment of ".$term_other_data['min_number_of_payment'].".");
			}else if(isset($term_other_data['max_number_of_payment']) && $updateData['number_of_payment'] > $term_other_data['max_number_of_payment']){
				throw new Error("The number of payments you selected was greater than the maximum installment of ".$term_other_data['max_number_of_payment'].".");
			}
			$numberOfPayment = $updateData['number_of_payment'];
		}
		if(isset($updateData['down_amount'])){
			$downPayment = $updateData['down_amount'];
			$down_percent = (($downPayment - ($brokerFee + $inspectionFee + $policyFee)) / ($purePremium+$taxes))*100;
		}
		if(isset($updateData['down_percentage'])){
			$down_percent  = $updateData['down_percentage'];
			$downPayment = ($purePremium + $taxes)*($down_percent/100) + $brokerFee + $inspectionFee + $policyFee;
			$Setupfee_downpayment = isset($array['setupfee_downpayment']) ? $array['setupfee_downpayment'] : 0;
			if($Setupfee_downpayment >0){
				$downPayment += $Setupfee_downpayment;
			}
		}
		if(isset($updateData['interest_rate'])){
			if(isset($array['buy_rate']) && $updateData['interest_rate'] < $array['buy_rate']){
				throw new Error("The interest rate you selected was less than the minimum rate of ".$array['buy_rate']."%.");
			}else if(isset($term_other_data['max_interest_rate']) && $term_other_data['max_interest_rate'] >0 && $updateData['interest_rate'] > $term_other_data['max_interest_rate']){
				throw new Error("The interest rate you selected was greater than the maximum rate of ".$term_other_data['max_interest_rate'].".");
			}
			$interestRate  = $updateData['interest_rate'];
		}
		if(isset($updateData['first_payment_due_date'])){
			$first_payment_due_date  = isset($updateData['first_payment_due_date']) && !empty($updateData['first_payment_due_date']) ?  dbDateFormat($updateData['first_payment_due_date']) : $first_payment_due_date;
		}
		/**
          @formula
          Amount Financed = (Total Premium  - Down Payment  + FL Doc Stamp Fee)
        */
        $amountFinanced         = $totalPremium - $downPayment + $docStampFees;
        /**
          @formula
          Payment on Amount Financed = -PMT(Interest Rate/12,Number of Payments ,Amount Financed)
        */
		$paymentAmountInterest           = QuoteHelper::calculatePaymentAmountInterest($interest_type,$interestRate,$purePremium,$numberOfPayment,$amountFinanced,$setupFee);

		/**
          @formula
          Total Interest        = Payment on Amount Financed*Number of Payments - Amount Financed
        */
        $totalInterestWithSetupFee = $paymentAmountInterest['totalInterest'];
		$totalInterest          = $totalInterestWithSetupFee - $setupFee;
        /**
          @formula
          Payment Amount        = (Amount Financed + Total Interest + Setup Fee)/Number of Payments
        */
        $payMentAmount          = $paymentAmountInterest['paymentAmount'];
        /**
          @formula
          Total Payments        = (Payment Amount*Number of Payments)
        */
        $totalPayMent           = $payMentAmount*$numberOfPayment;
        /**
          @formula
          Total Interest Inc Setup Fee = (Total Interest + Setup Fee)
        */

         /**
          @formula
          Eeffective APR        = RATE(Number of Payments, -Payment Amount,Amount Financed)*12
        */
        $effectiveApr           = QuoteHelper::effectiveAPR($numberOfPayment,$payMentAmount,$amountFinanced);



		$agentCompensationData      = QuoteHelper::getAgentCompensation($purePremium,$quoteDatas->agency,$totalInterestWithSetupFee,$array['main_finance_charge'],$amountFinanced,$totalPremium);
		$compensation = $agentCompensationData['compensation'];
		$agent_compensation_data = $agentCompensationData['compensation_table_fee_data'];

        $model                   = new self; //Load Model

        $inserArr = [
            'billing_schedule'          => $billingSchedule,
			'first_payment_due_date'    => $first_payment_due_date,
            'interest_rate'             => $interestRate,
            'down_percent'              => $down_percent,
            'number_of_payment'         => $numberOfPayment,
            'down_payment'              => $downPayment,
            'total_premium'             => $totalPremium,
            'amount_financed'           => $amountFinanced,
            'total_interest'            => $totalInterest,
            'payment_amount'            => $payMentAmount,
            'total_payment'             => $totalPayMent,
            'total_interest_with_setup_fee'=> $totalInterestWithSetupFee,
            'effective_apr'             => $effectiveApr,
			'compensation'              => $compensation,
            'agent_compensation_data'   => json_encode($agent_compensation_data),
        ];

		if(GateAllow('isAdminCompany') || !empty($onDB)){
            $model = $model->on('company_mysql');
        }
        DB::beginTransaction();
        try {
        if(!empty($id)){
                $inserArr  = arrFilter($inserArr);
                $getdata     = $model->updateOrCreate(['quote'=>$quote,'version'=>$version],$inserArr);
            }else{
                $getdata  =    $model->updateOrCreate(['quote'=>$quote,'version'=>$version],$inserArr);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            throw new Error($th->getMessage());
        }



        DB::commit();
        return $getdata;
    }
	public static function updateCompensation(array $array,array $updateData){
		$quote              = !empty($array['quote']) ? $array['quote'] : null ;
        $version            = !empty($array['version']) ? $array['version'] : null ;
		$quoteDatas         = Quote::getData()->where('id',$quote)->firstOrFail();
		$compensation_table_fee_data = isset($array['agent_compensation_data']) && !empty($array['agent_compensation_data']) ? json_decode($array['agent_compensation_data'],true) : array();
		$compensation = 0;
		if(!empty($compensation_table_fee_data)){
			$amountFinanced = toFloat($array['amount_financed']);
			$totalPremium = toFloat($array['total_premium']);
			$fee = isset($compensation_table_fee_data['fee']) && !empty($compensation_table_fee_data['fee']) ? toFloat($compensation_table_fee_data['fee']) : 0;
			if(isset($updateData['fee'])){
				$fee = $updateData['fee'];
				$compensation_table_fee_data['fee'] = $fee;
			}
			$compensation += $fee;
			$add_on_points = isset($compensation_table_fee_data['add_on_points']) && !empty($compensation_table_fee_data['add_on_points']) ? toFloat($compensation_table_fee_data['add_on_points']) : 0;
			if(isset($updateData['add_on_points'])){
				$add_on_points = $updateData['add_on_points'];
				$compensation_table_fee_data['add_on_points'] = $add_on_points;
			}
			$compensation += $add_on_points;
			if(isset($updateData['financed_rate'])){
				$compensation_table_fee_data['financed_rate'] = $updateData['financed_rate'];
			}
			if(isset($updateData['markup'])){
				$compensation_table_fee_data['markup'] = $updateData['markup'];
			}
			if(isset($updateData['total_premium'])){
				$compensation_table_fee_data['total_premium'] = $updateData['total_premium'];
			}
			$compensationPercentage = 0;
			if(isset($compensation_table_fee_data['financed_rate']) && !empty($compensation_table_fee_data['financed_rate'])){
				 $compensationPercentage = ($amountFinanced*toFloat($compensation_table_fee_data['financed_rate']))/100;
			}else if(isset($compensation_table_fee_data['markup']) && !empty($compensation_table_fee_data['markup'])){
				if($array['buy_rate'] < $array['interest_rate']){
					$main_finance_charge = toFloat($array['total_interest_with_setup_fee']);
					$old_finance_charge = toFloat($array['main_finance_charge']);
					$financecharge = ($main_finance_charge-$old_finance_charge);
					$compensationPercentage = ($financecharge*toFloat($compensation_table_fee_data['markup']))/100;
				}
			}else if(isset($compensation_table_fee_data['total_premium']) && !empty($compensation_table_fee_data['total_premium'])){
				 $compensationPercentage = ($totalPremium*toFloat($compensation_table_fee_data['total_premium']))/100;
			}
			$compensation +=  $compensationPercentage;
		}

		$model                   = new self; //Load Model

        $inserArr = [
            'compensation'              => $compensation,
            'agent_compensation_data'   => json_encode($compensation_table_fee_data),
        ];

		if(GateAllow('isAdminCompany') || !empty($onDB)){
            $model = $model->on('company_mysql');
        }
        DB::beginTransaction();
        try {
        if(!empty($id)){
                $inserArr  = arrFilter($inserArr);
                $getdata     = $model->updateOrCreate(['quote'=>$quote,'version'=>$version],$inserArr);
            }else{
                $getdata  =    $model->updateOrCreate(['quote'=>$quote,'version'=>$version],$inserArr);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            dd($th);
            throw new Error($th->getMessage());
        }



        DB::commit();
        return $getdata;
	}
}
