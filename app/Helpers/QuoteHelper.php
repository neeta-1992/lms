<?php
namespace App\Helpers;
use App\Models\{
    AgentOtherSetting,DownPayment,DownPaymentRule,Quote,QuoteVersion,QuotePolicy,RateTable,QuoteSetting,Entity,CompensationTableFee,RateTableFee,QuoteTerm,StateSettingInterestRate,State,StateSettings,StateProgramSettingOverride
};
use Illuminate\Support\Str;
use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Sheet\Calculations\Financial;
class QuoteHelper {




    public static function quotePolicyData(array $array)
    {
        $quote    = !empty($array['quote']) ? $array['quote'] : "null" ;
        $version  = !empty($array['version']) ? $array['version'] : "null" ;
        $data     = QuotePolicy::getData(['qId'=>$quote,'version'=>$version])
                                ->selectRaw('
                                SUM(pure_premium) as pure_premium,SUM(unearned_fees) as unearned_fees,SUM(earned_fees) as earned_fees,
                                (SUM(policy_fee) + SUM(taxes_and_stamp_fees) +  SUM(broker_fee) + SUM(inspection_fee)) as total_fee,
                                SUM(policy_fee) as policy_fee,SUM(taxes_and_stamp_fees) as taxes_and_stamp_fees,SUM(policy_fee) as policy_fee,
                                SUM(broker_fee) as broker_fee,SUM(inspection_fee) as inspection_fee,SUM(doc_stamp_fees) as doc_stamp_fees,min(inception_date) as inception_date,max(minimum_earned) as minimum_earned')->first()?->toArray();

        return $data ;
    }


    public static function quoteNumberOfPayment($agency =null,$billing_schedule=null){
        return config('custom.quote.number_fo_payment');
    }



    public static function quoteInterestRate($agency =null,$billing_schedule=null)
    {
        return config('custom.quote.interest_rate');
    }
	public static function getInterestRate($pure_premium,$numberOfPayment,$amountFinanced,$setupFee,$rate_table=null){
		$interest_rate = config('custom.quote.interest_rate') ?? 0;
		$interest_type = 'fixed';
		if(!empty($rate_table)){
			$rate_table_data  = RateTable::getData(['id'=>$rate_table])->first();
			$rate_table_fee_data = RateTableFee::getData()
			->where(function ($query) use ($pure_premium,$rate_table) {
				$query->where('from', '<=', $pure_premium)
					->where('to', '>=', $pure_premium);
			})
			->where('rate_table_id','=', $rate_table)
			->first();
			if(!empty($rate_table_fee_data) && !empty($rate_table_data)){
				 $interest_type	= $rate_table_data->type;
				 $interest_rate = $rate_table_fee_data->rate;
			}
		}
		return QuoteHelper::calculatePaymentAmountInterest($interest_type,$interest_rate,$pure_premium,$numberOfPayment,$amountFinanced,$setupFee);
	}
	public static function calculatePaymentAmountInterest($interest_type,$interest_rate,$pure_premium,$numberOfPayment,$amountFinanced,$setupFee){
		if($interest_type == 'rate'){
			$totalInterest = ($amountFinanced*($interest_rate/100)*$numberOfPayment)/12;
			$payMentAmount = ($amountFinanced + $totalInterest + $setupFee) / $numberOfPayment;	
		}else{
			$payMentamountFinanced  = QuoteHelper::calculatePmt($interest_rate,$numberOfPayment,$amountFinanced);
			/**
			  @formula
			  Total Interest        = Payment on Amount Financed*Number of Payments - Amount Financed
			*/
			$totalInterest          = $payMentamountFinanced*$numberOfPayment - $amountFinanced;
			/**
			  @formula
			  Payment Amount        = (Amount Financed + Total Interest + Setup Fee)/Number of Payments
			*/
			$payMentAmount          = ($amountFinanced + $totalInterest + $setupFee)/$numberOfPayment ;
		}
		return array('paymentAmount'=>$payMentAmount,'totalInterest'=>$totalInterest,'interestRate'=>$interest_rate,'interestType'=>$interest_type);
	}	
	public static function getDocStampFee($pure_premium,$insured){
		$insured_data = Entity::getData(['id'=>$insured])->first();
		$doc_stamp_fees = 0;
		if(!empty($insured_data->state) && strtolower($insured_data->state) == 'florida'){
			$quoteSettings = QuoteSetting::getData()->first();
			$quote_doc_stamp_fees  = isset($quoteSettings) && !empty($quoteSettings->doc_stamp_fees)  ? $quoteSettings->doc_stamp_fees : '';
			$DOCSTAMPTAXper = $pure_premium/100;
			$doc_stamp_fees =!empty($DOCSTAMPTAXper) && !empty($quote_doc_stamp_fees) ? ($DOCSTAMPTAXper * $quote_doc_stamp_fees)  : 0;
		}
		return $doc_stamp_fees;
	}
	public static function getNumberOfPayment($agencyId,$billing_schedule){
		$number_of_payment = config('custom.quote.number_of_payment') ?? 0;
		if (!empty($agencyId)) {
			$agentOtherSetting = AgentOtherSetting::getData(['entityId'=>$agencyId])->first();
			$down_payment_id = !empty($agentOtherSetting) ? $agentOtherSetting->down_payment_rule_original_quoting : null;
			if(!empty($down_payment_id)){
				$downPayment = DownPayment::getData(['id'=>$down_payment_id])->first();
			}else{
				$downPayment = DownPayment::getData()->whereLike('name','default')->first();
			}
			if(!empty($downPayment)){
				if($billing_schedule == 'Monthly'){
					$number_of_payment = $downPayment->monthly_deafult_installment;
				}else if($billing_schedule == 'Quarterly'){
					$number_of_payment = $downPayment->quarterly_deafult_installment;
				}else if($billing_schedule == 'Annually'){
					$number_of_payment = $downPayment->annually_deafult_installment;
				}
				$downPaymentRule = DownPaymentRule::getData(['down_payment_id'=>$downPayment->id])->first();
				if(!empty($downPaymentRule)){
					$number_of_payment = $downPaymentRule->deafult_installment;
				}
			}
		}
		return $number_of_payment;
	}
	public static function getDownPaymentBiling($agencyId,$billing_schedule,$minimum_earned){
		$down_payment_increase = $minimum_down_payment_policies = $round_down_payment = '';
		$down_payment_id = $down_payment_rule_id = '';
		$number_of_payment = config('custom.quote.number_of_payment') ?? 0;
		if(!empty($minimum_earned)){
			$down_payment_percent = $min_down_payment_percent = $minimum_earned;
		}else{
			$down_payment_percent = $min_down_payment_percent = config('custom.quote.down_percent') ?? 0;
		}
		$min_number_of_payment = $max_number_of_payment = $number_of_payment;
		if (!empty($agencyId)) {
			$agentOtherSetting = AgentOtherSetting::getData(['entityId'=>$agencyId])->first();
			$down_payment_increase = !empty($agentOtherSetting) ? $agentOtherSetting->down_payment_increase : null;
			$down_payment_id = !empty($agentOtherSetting) ? $agentOtherSetting->down_payment_rule_original_quoting : null;
			if(!empty($down_payment_id)){
				$downPayment = DownPayment::getData(['id'=>$down_payment_id])->first();
			}else{
				$downPayment = DownPayment::getData()->whereLike('name','default')->first();
			}
			if(!empty($downPayment)){
				$minimum_down_payment_policies = !empty($downPayment) && !empty($downPayment->minimum_down_payment_policies) ? $downPayment->minimum_down_payment_policies : '';
				$round_down_payment = !empty($downPayment) && !empty($downPayment->round_down_payment) ? $downPayment->round_down_payment : '';
				if($billing_schedule == 'Monthly'){
					$number_of_payment = $downPayment->monthly_deafult_installment;
					$min_number_of_payment = $downPayment->monthly_minimum_installment;
					$max_number_of_payment = $downPayment->monthly_maximum_installment;
				}else if($billing_schedule == 'Quarterly'){
					$number_of_payment = $downPayment->quarterly_deafult_installment;
					$min_number_of_payment = $downPayment->quarterly_minimum_installment;
					$max_number_of_payment = $downPayment->quarterly_maximum_installment;
				}else if($billing_schedule == 'Annually'){
					$number_of_payment = $downPayment->annually_deafult_installment;
					$min_number_of_payment = $downPayment->annually_minimum_installment;
					$max_number_of_payment = $downPayment->annually_maximum_installment;
				}
				
				$downPaymentRule = DownPaymentRule::getData(['down_payment_id'=>$downPayment->id])->first();
				if(!empty($downPaymentRule)){
					$down_payment_rule_id = $downPaymentRule->id;
					$down_payment_increase = $downPaymentRule->down_payment_increase;
					$number_of_payment = $downPaymentRule->deafult_installment;
					$min_number_of_payment = $downPaymentRule->minimum_installment;
					$max_number_of_payment = $downPaymentRule->maximumm_installment;
					$round_down_payment =  !empty($downPaymentRule) && !empty($downPaymentRule->round_down_payment) ? $downPaymentRule->round_down_payment : '';
					$down_payment_percent = !empty($downPaymentRule) && !empty($downPaymentRule->deafult_down_payment) ? $downPaymentRule->deafult_down_payment : $down_payment_percent;
					$min_down_payment_percent = !empty($downPaymentRule) && !empty($downPaymentRule->minimum_down_payment) ? $downPaymentRule->minimum_down_payment : $min_down_payment_percent; 
					$minimum_down_payment_policies = !empty($downPaymentRule) && !empty($downPaymentRule->dollar_down_payment) ? $downPaymentRule->dollar_down_payment : '';
				}
			}
		}
		return array('number_of_payment'=>$number_of_payment,'min_number_of_payment'=>$min_number_of_payment,'max_number_of_payment'=>$max_number_of_payment,'round_down_payment'=>$round_down_payment,'down_payment_percent'=>$down_payment_percent,'min_down_payment_percent'=>$min_down_payment_percent,'down_payment_increase'=>$down_payment_increase,'minimum_down_payment_policies'=>toFloat($minimum_down_payment_policies),'down_payment_id'=>$down_payment_id,'down_payment_rule_id' => $down_payment_rule_id);
	}
	public static function getAgentCompensation($pure_premium,$agency,$main_finance_charge,$old_finance_charge,$amountFinanced,$totalPremium){
		$agency_data = Entity::getData(['id'=>$agency])->first();
		$compensation_table = !empty($agency_data) && !empty($agency_data->compensation_table) ? $agency_data->compensation_table : '';
		$compensation = 0;
		$compensation_table_fee_data = array();
		if(!empty($compensation_table)){
			$compensation_table_fee_data = CompensationTableFee::getData()
			->where(function ($query) use ($pure_premium,$compensation_table) {
				$query->where('from', '<=', $pure_premium)
					->where('to', '>=', $pure_premium);
			})->where('compensation_id', '=', $compensation_table)
			->first()?->toArray();
			
			if(!empty($compensation_table_fee_data)){
				 $compensation += isset($compensation_table_fee_data['fee']) && !empty($compensation_table_fee_data['fee']) ? toFloat($compensation_table_fee_data['fee']) : 0;
				 $compensation += isset($compensation_table_fee_data['add_on_points']) && !empty($compensation_table_fee_data['add_on_points']) ? toFloat($compensation_table_fee_data['add_on_points']) : 0;
				 
				 if(isset($compensation_table_fee_data['financed_rate']) && !empty($compensation_table_fee_data['financed_rate'])){
					 $compensation += ($amountFinanced*toFloat($compensation_table_fee_data['financed_rate']))/100;
				 }else if(isset($compensation_table_fee_data['markup']) && !empty($compensation_table_fee_data['markup'])){
					 $financecharge = ($main_finance_charge-$old_finance_charge);
					 $compensation += ($financecharge*toFloat($compensation_table_fee_data['markup']))/100;
				 }else if(isset($compensation_table_fee_data['total_premium']) && !empty($compensation_table_fee_data['total_premium'])){
					 $compensation += ($totalPremium*toFloat($compensation_table_fee_data['total_premium']))/100;
				 }
			}
		}
		return array('compensation'=>$compensation,'compensation_table_fee_data'=>$compensation_table_fee_data);
	}
    public static function effectiveAPR($no_of_payment,$payment_amount,$amount_finance)
    {
		$error = 0.0000001; $high = 1.00; $low = 0.00;
		$rate = (2.0 * ($no_of_payment * $payment_amount - $amount_finance)) / ($amount_finance * $no_of_payment);

		while(true) {
		   // check for error margin
		   $calc = pow(1 + $rate, $no_of_payment);
		   $calc = ($rate * $calc) / ($calc - 1.0);
		   $calc -= $payment_amount / $amount_finance;

		   if ($calc > $error) {
			 // guess too high, lower the guess
			 $high = $rate;
			 $rate = ($high + $low) / 2;
		   } elseif ($calc < -$error) {
			 // guess too low, higher the guess
			 $low = $rate;
			 $rate = ($high + $low) / 2;
		   } else {
			 // acceptable guess
			 break;
		   }
		 }
		 $rateVal = $rate * 12 * 100;
		 return $rateVal;
    }


    public static function calculatePmt($interest_rate,$no_of_payment,$amount_finance)
    {
        try {
			$interest_rate=$interest_rate/100/12;
			return (($interest_rate * $amount_finance)) / (1 - pow(1 + $interest_rate, -$no_of_payment));
	   } catch (\Throwable $th) {
		  return 0;
	   }
    }


    public static function Quote_deafult_down_payment($agencyId)
    {
        $deafult_down_payment = $down_payment_round = '';
		if (!empty($agencyId)) {
			$down_payment_id = AgentOtherSetting::getData(['entityId'=>$agencyId])->first()?->down_payment_rule_original_quoting ?? null;
			if(!empty($down_payment_id)){
				$downPaymentRule        = DownPaymentRule::getData(['downPaymentId'=>$down_payment_id])->first();
				$deafult_down_payment   = !empty($downPaymentRule) && !empty($downPaymentRule->deafult_down_payment) ? $downPaymentRule->deafult_down_payment : '';
				$down_payment_round     = !empty($downPaymentRule) && !empty($downPaymentRule->override_minimum_earned) ? $downPaymentRule->override_minimum_earned : '';
				$downPayment            = DownPayment::getData(['id'=>$down_payment_id])->first();
				if(empty($deafult_down_payment)){
					$deafult_down_payment =  !empty($downPayment) && !empty($downPayment->minimum_down_payment_policies) ? $downPayment->minimum_down_payment_policies : '';
				}
				if(empty($down_payment_round)){
					$down_payment_round =  !empty($downPayment) && !empty($downPayment->round_down_payment) ? $downPayment->round_down_payment : '';
				}
			}else{
				$downPayment = DownPayment::getData()->whereLike('name','default')->first();
				if(!empty($downpaymentdatas)){
					$deafult_down_payment = !empty($downpaymentdatas) && !empty($downpaymentdatas->minimum_down_payment_policies) ? $downpaymentdatas->minimum_down_payment_policies : '';
					$down_payment_round =  !empty($downpaymentdatas) && !empty($downpaymentdatas->round_down_payment) ? $downpaymentdatas->round_down_payment : '';
				}
			}
		}
		return array('default_down_payment'=>$deafult_down_payment,'down_payment_round'=>$down_payment_round);
    }

	public static function getMaxInterestRate($purePremium,$quoteDatas,$programData){
		$max_interest_rate = 0;
		$quoteoriginationstate = isset($quoteDatas->quoteoriginationstate) && !empty($quoteDatas->quoteoriginationstate) ? $quoteDatas->quoteoriginationstate : '';
		$line_of_business = !empty($quoteDatas->account_type) ? $quoteDatas->account_type : '';
		if(!empty($quoteoriginationstate)){
			$state = State::getData()->whereEn('state',$quoteoriginationstate)->first();
			$stateSettings = StateSettings::getData()->where('state',$state->id)->first();
			$maximum_setup_fee = $downsetupfeepersent = $Setupfee_downpayment = $setupfee = 0;
			if(!empty($stateSettings) && isset($stateSettings->id)){
				if($line_of_business == 'commercial'){
					$max_interest_rate = !empty($stateSettings->comm_maximum_rate) ? toFloat($stateSettings->comm_maximum_rate) : 0;
					if(isset($stateSettings->personal_multiple_comm_maximum_rate) && $stateSettings->personal_multiple_comm_maximum_rate){
						$state_settings_fee_data = StateSettingInterestRate::getData()
						->where(function ($query) use ($purePremium) {
							$query->where('from', '<=', $purePremium)
								->where('to', '>=', $purePremium);
						})
						->where('type','=', 'personal_multiple_comm_maximum_rate')
						->where('state_setting_id','=', $stateSettings->id)
						->first();
						if(!empty($state_settings_fee_data) && !empty($state_settings_fee_data)){
							 $max_interest_rate	= toFloat($state_settings_fee_data->rate);
						}
					}
				}else if($line_of_business == 'personal'){
					$max_interest_rate = !empty($stateSettings->maximum_rate) ? toFloat($stateSettings->maximum_rate) : 0;
					if(isset($stateSettings->personal_multiple_maximum_rate) && $stateSettings->personal_multiple_maximum_rate){
						$state_settings_fee_data = StateSettingInterestRate::getData()
						->where(function ($query) use ($purePremium) {
							$query->where('from', '<=', $purePremium)
								->where('to', '>=', $purePremium);
						})
						->where('type','=', 'personal_multiple_maximum_rate')
						->where('state_setting_id','=', $stateSettings->id)
						->first();
						if(!empty($state_settings_fee_data) && !empty($state_settings_fee_data)){
							 $max_interest_rate	= toFloat($state_settings_fee_data->rate);
						}
					}
				}
			}
		}
		if(!empty($programData)){
			$programId = $programData[0];
			if($line_of_business == 'commercial'){
				$maximumInterestRateId = 36;
			}else{
				$maximumInterestRateId = 15;
			}
			$stateProgram_data = StateProgramSettingOverride::getData()
			->where('state_program_id','=', $programId)
			->where('override_settings','=', $maximumInterestRateId)
			->first();		
			if(!empty($stateProgram_data)){
				$max_interest_rate = $stateProgram_data->value;
			}
		}
		return $max_interest_rate;
	}

	public static function GetSetupfee($rate_table,$pure_premium,$downPayment,$line_of_business,$origination_state,$programData){
		$maximum_setup_fee = $downsetupfeepersent = $Setupfee_downpayment = $setupfee = 0;
		$state = State::getData()->whereEn('state',$origination_state)->first();
		$stateSettings = StateSettings::getData()->where('state',$state->id)->first();
		
		if(!empty($stateSettings) && isset($stateSettings->id)){
			if($line_of_business == 'commercial'){
				$maximum_setup_fee_lesser_greater =  !empty($stateSettings->maximum_comm_setup_fee_lesser_greater) ? toFloat($stateSettings->maximum_comm_setup_fee_lesser_greater) : 0;
				$percentage_maximum_setup_fee =  !empty($stateSettings->percentage_comm_maximum_setup_fee) ? toFloat($stateSettings->percentage_comm_maximum_setup_fee) : 0;
				$maximum_setup_fee =  !empty($stateSettings->comm_maximum_setup_fee) ? toFloat($stateSettings->comm_maximum_setup_fee) : 0;
				$percentageFee = 0;
				if($percentage_maximum_setup_fee >0){
					$percentageFee = toFloat(($pure_premium * $percentage_maximum_setup_fee)/100);
				}
				
				if(empty($maximum_setup_fee_lesser_greater)){
					$maximum_setup_fee += $percentageFee;
				}else if($maximum_setup_fee_lesser_greater == 'lesser'){
					$maximum_setup_fee = ($maximum_setup_fee < $percentageFee) ? $maximum_setup_fee : $percentageFee;
				}else if($maximum_setup_fee_lesser_greater == 'greater'){
					$maximum_setup_fee = ($maximum_setup_fee > $percentageFee) ? $maximum_setup_fee : $percentageFee;
				}
				$downsetupfeepersent = !empty($stateSettings->comm_setup_Percent) ? toFloat($stateSettings->comm_setup_Percent) : 0;
			}else if($line_of_business == 'personal'){
				$maximum_setup_fee_lesser_greater =  !empty($stateSettings->maximum_setup_fee_lesser_greater) ? toFloat($stateSettings->maximum_setup_fee_lesser_greater) : 0;
				$percentage_maximum_setup_fee =  !empty($stateSettings->percentage_maximum_setup_fee) ? toFloat($stateSettings->percentage_maximum_setup_fee) : 0;
				$maximum_setup_fee =  !empty($stateSettings->maximum_setup_fee) ? toFloat($stateSettings->maximum_setup_fee) : 0;
				$percentageFee = 0;
				if($percentage_maximum_setup_fee >0){
					$percentageFee = toFloat(($pure_premium * $percentage_maximum_setup_fee)/100);
				}
				
				if(empty($maximum_setup_fee_lesser_greater)){
					$maximum_setup_fee += $percentageFee;
				}else if($maximum_setup_fee_lesser_greater == 'lesser'){
					$maximum_setup_fee = ($maximum_setup_fee < $percentageFee) ? $maximum_setup_fee : $percentageFee;
				}else if($maximum_setup_fee_lesser_greater == 'greater'){
					$maximum_setup_fee = ($maximum_setup_fee > $percentageFee) ? $maximum_setup_fee : $percentageFee;
				}
				
				$downsetupfeepersent =  !empty($stateSettings->setup_Percent) ? toFloat($stateSettings->setup_Percent) : 0;
			}
		}
		
		$rate_table_fee_data = RateTableFee::getData()
		->where(function ($query) use ($pure_premium,$rate_table) {
			$query->where('from', '<=', $pure_premium)
				->where('to', '>=', $pure_premium);
		})
		->where('rate_table_id','=', $rate_table)
		->first();
		if(!empty($rate_table_fee_data) && !empty($rate_table_fee_data)){
			 if($rate_table_fee_data->is_state_maximun){
				  
			 }else{
				 $maximum_setup_fee = $rate_table_fee_data->setup_fee;
			 }
		}
		
		if(!empty($programData)){
			$programId = $programData[0];
			if($line_of_business == 'commercial'){
				$maximumSetupFeeId = 37;
				$maximumSetupFeePercentId = 38;
			}else{
				$maximumSetupFeeId = 16;
				$maximumSetupFeePercentId = 17;
			}
			$stateProgramFee_data = StateProgramSettingOverride::getData()
			->where('state_program_id','=', $programId)
			->where('override_settings','=', $maximumSetupFeeId)
			->first();
			$stateProgramFeePercent_data = StateProgramSettingOverride::getData()
			->where('state_program_id','=', $programId)
			->where('override_settings','=', $maximumSetupFeePercentId)
			->first();			
			if(!empty($stateProgramFee_data)){
				$maximum_setup_fee = $stateProgramFee_data->value;
			}
			if(!empty($stateProgramFeePercent_data)){
				$downsetupfeepersent = $stateProgramFeePercent_data->value;
			}
		}
		if($downsetupfeepersent >0 && $maximum_setup_fee>0){
			$Setupfee_downpayment = $maximum_setup_fee * $downsetupfeepersent/100;
			$setupfee = ($maximum_setup_fee - $Setupfee_downpayment);
		}
		return (array("total_setupfee"=>$setupfee,"setupfee_percentage"=>$downsetupfeepersent,"Setupfee_downpayment"=>$Setupfee_downpayment,"Setup_Fee"=>$maximum_setup_fee));
	}


	public static function versionTermsUpdate($quote_id,$version_id){
		$quoteDatas = Quote::getData()->where('id',$quote_id)->firstOrFail();
		$status = !empty($quoteDatas) ? $quoteDatas->status : '';
		$agent_id = !empty($quoteDatas) ? $quoteDatas->agent : '';
		$agency = !empty($quoteDatas) ? $quoteDatas->agency : '';
		$insured_id = !empty($quoteDatas) ? $quoteDatas->insured : '';
		$insured_uid = !empty($quoteDatas) ? $quoteDatas->insured_uid : '';
		$account_type = !empty($quoteDatas) ? $quoteDatas->account_type : '';
		if($status == '1'){
			$Quote_deafult_down_payment = Quote_deafult_down_payment($agency);
			$deafult_down_payment = !empty($Quote_deafult_down_payment) && !empty($Quote_deafult_down_payment['deafult_down_payment']) ? $Quote_deafult_down_payment['deafult_down_payment'] : '';
			$down_payment_round = !empty($Quote_deafult_down_payment) && !empty($Quote_deafult_down_payment['down_payment_round']) ? $Quote_deafult_down_payment['down_payment_round'] : '';
			$quotesettingDatas = QuoteSetting::getData()->first();
			$quote_doc_stamp_fees  = isset($quotesettingDatas) && !empty($quotesettingDatas->doc_stamp_fees)  ? $quotesettingDatas->doc_stamp_fees : '';

			$insured_data = Entity::getData(['id'=>$insured_id])->first();
			$insured_state = !empty($insured_data) && !empty($insured_data->state) ? ucwords($insured_data->state) : '';
			$allowedNewQuote = false;
			$notallowedMsg = '';
			$quoteVersion = QuoteVersion::getData(['quote_parent_id'=>$quote_id,'id'=>$version_id])->first();
			if(!empty($quoteVersion)){
				$versionmaintermdata = VersionMainTerm::getData(['version_id'=>$version_id])->first();
				$total_setupfee = $setupfee_percentage = $Setupfee_downpayment = $Setup_Fee = '';
				if($status != '1'){
					$deafult_down_payment = !empty($versionmaintermdata) && !empty($versionmaintermdata->deafult_down_payment) ? $versionmaintermdata->deafult_down_payment : '';
					$down_payment_round = !empty($versionmaintermdata) && !empty($versionmaintermdata->down_payment_round) ? $versionmaintermdata->down_payment_round : '';
					$quote_doc_stamp_fees  = isset($versionmaintermdata) && !empty($versionmaintermdata->quote_doc_stamp_fees)  ? $versionmaintermdata->quote_doc_stamp_fees : '';
					$insured_state  = isset($versionmaintermdata) && !empty($versionmaintermdata->insured_state)  ? $versionmaintermdata->insured_state : '';
					$total_setupfee = !empty($versionmaintermdata) && !empty($versionmaintermdata->total_setupfee) ? $versionmaintermdata->total_setupfee : '';
					$setupfee_percentage = !empty($versionmaintermdata) && !empty($versionmaintermdata->setupfee_percentage) ? $versionmaintermdata->setupfee_percentage : '';
					$Setupfee_downpayment = !empty($versionmaintermdata) && !empty($versionmaintermdata->Setupfee_downpayment) ? $versionmaintermdata->Setupfee_downpayment : '';
					$Setup_Fee = !empty($versionmaintermdata) && !empty($versionmaintermdata->Setup_Fee) ? $versionmaintermdata->Setup_Fee : '';
				}
				$policyversiondatas = QuotePolicy::getData(['version'=>$version_id,'quote'=>$quote_id])->orderBy('created_at','desc')->toArray();
				if(!empty($policyversiondatas)){
					$Premium_financed = $total = $pure_premium = $down_payment = 0;
					foreach($policyversiondatas as $policyversiondata){
						$minimum_earned = $policyversiondata['minimum_earned'];
						$policydownpayment = $policyversiondata['pure_premium']*$minimum_earned/100 + $policyversiondata['policy_fee'] + $policyversiondata['broker_fee'] + $policyversiondata['inspection_fee'] + $policyversiondata['taxes_and_stamp_fees'] ;

						if(!empty($deafult_down_payment) && $deafult_down_payment > $policydownpayment){
							$policydownpayment = $deafult_down_payment;
						}
						if(!empty($down_payment_round)){
							$policydownpayment = round($policydownpayment);
						}
						$down_payment += $policydownpayment;
						$pure_premium += $policyversiondata['pure_premium'];
						$total += $policyversiondata['total'];
						$Premiumfinanced = $policyversiondata['total'] - $policydownpayment;
						$Premium_financed += $Premiumfinanced;

						$updateuserarry = array(
							'down_payment'=>$policydownpayment,
						);
						$userwhere = array(
							'id' => $policyversiondata['id']
						);
						$this->multipleupdateData('policies',$updateuserarry,$userwhere);
					}
				}
				$DOCSTAMPTAXper = $pure_premium/100;
				$doc_stamp_fees =!empty($DOCSTAMPTAXper) && !empty($quote_doc_stamp_fees) ? ($DOCSTAMPTAXper * $quote_doc_stamp_fees)  : 0;
				$amount_financed = !empty($insured_state) && ($insured_state == 'Florida') ? $Premium_financed + $doc_stamp_fees : $Premium_financed;
				if($status == '1'){
					$rate_table = $quoteDatas->rate_table;
					$rate_table_fee_data = RateTableFee::getData(['rate_table_id'=>$rate_table])->where('froms','<= ',$amount_financed)->where('tos','>= ',$amount_financed)->first();
					if(!empty($rate_table_fee_data)){
						 $GetSetupfeeArr = GetSetupfee($rate_table_fee_data->setup_fee,$rate_table,$account_type,$insured_state);
						 $total_setupfee = !empty($GetSetupfeeArr) && !empty($GetSetupfeeArr['total_setupfee']) ? $GetSetupfeeArr['total_setupfee'] : '';
						 $setupfee_percentage = !empty($GetSetupfeeArr) && !empty($GetSetupfeeArr['setupfee_percentage']) ? $GetSetupfeeArr['setupfee_percentage'] : '';
						 $Setupfee_downpayment = !empty($GetSetupfeeArr) && !empty($GetSetupfeeArr['Setupfee_downpayment']) ? $GetSetupfeeArr['Setupfee_downpayment'] : '';
						 $Setup_Fee = !empty($GetSetupfeeArr) && !empty($GetSetupfeeArr['Setup_Fee']) ? $GetSetupfeeArr['Setup_Fee'] : '';
					}
				}
				$Setupfee_downpayment = !empty($versionmaintermdata) && !empty($versionmaintermdata->Setupfee_downpayment) ? $versionmaintermdata->Setupfee_downpayment : '';
				//$down_payment =  $versionmaintermdata->down_payment;

				$totals = $total + $down_payment;
				$main_down_payment = !empty($Setupfee_downpayment) ? ($down_payment + $Setupfee_downpayment)  : $down_payment;

				$policyDatass = $this->getResponse("select minimum_earned from policies where version = ? order by id asc LIMIT 1",array($versionData['id']),'s');
				$main_down_payment_persent = $policyDatass[0]['minimum_earned'];

				$new_version_main_term= array(
					'premium_financed'=>$Premium_financed,
					'quote_doc_stamp_fees'=>$quote_doc_stamp_fees,
					'doc_stamp_fees'=>$doc_stamp_fees,
					'amount_financed'=>$amount_financed,
					'down_payment'=>$down_payment,
					'pure_premium'=>$pure_premium,
					'total'=>$totals,
					'total_setupfee'=>$total_setupfee,
					'setupfee_percentage'=>$setupfee_percentage,
					'Setupfee_downpayment'=>$Setupfee_downpayment,
					'Setup_Fee'=>$Setup_Fee,
					'insured_state'=>$insured_state,
				);

				if(!empty($not_allow_version) && !empty($type) && ($type == 'downpercent'  || $type == 'downamount')){
				}else{
					$new_version_main_term['main_down_payment_persent'] = $main_down_payment_persent;
					$new_version_main_term['main_down_payment'] = $main_down_payment;
				}

				$userwheres = array(
					'version_id' => $versionData['id']
				);
				$this->multipleupdateData('version_main_term',$new_version_main_term,$userwheres);
				$pre_version_main_term = array(
					'premium_financed'=>$versionmaintermdata['premium_financed'],
					/* 'doc_stamp_fees'=>$versionmaintermdata['doc_stamp_fees'], */
					'amount_financed'=>$versionmaintermdata['amount_financed'],
					'Setup_Fee'=>$versionmaintermdata['Setup_Fee'],
					'Setupfee_downpayment'=>$versionmaintermdata['Setupfee_downpayment'],
				);
				$newversionmainterm = array(
					'premium_financed'=>$Premium_financed,
					/* 'doc_stamp_fees'=>$doc_stamp_fees, */
					'amount_financed'=>$amount_financed,
					'Setup_Fee'=>$Setup_Fee,
					'Setupfee_downpayment'=>$Setupfee_downpayment,
				);
				$differentresult = array_diff_assoc($pre_version_main_term, $newversionmainterm);
				if(isset($differentresult) && !empty($differentresult)){
					$and = $policymessage = "";
					foreach ($differentresult as $key =>$value){
						$replace = str_replace("_"," ",$key);
						$replace = ucfirst($replace);
						$fromValue = $value;
						$toValue = $newversionmainterm[$key];
						if($key  == 'Setup_Fee'){
							$replace = 'Setup fee(unpaid)';
						}else if($key  == 'Setupfee_downpayment'){
							$replace = 'Setup fee in down payment';
						}
						if(($fromValue != $toValue)){
							if(!empty($fromValue) && $fromValue != 'NULL'){
								$toValue = !empty($toValue) ? '$'.number_format($toValue,2) : 'None';
								$policymessage .=$and.' <b>'.$replace.'</b> was changed from <b>$'.number_format($fromValue,2).'</b> to <b>'.$toValue.'</b>' ;
								$and  =' and ';
							}else if(!empty($toValue) && $toValue != 'NULL'){
								$policymessage .=$and .' <b>'.$replace.'</b> '.'was updated to <b>$'.number_format($toValue,2).'</b>' ;
								$and  =' and ';
							}
						}
					}
					if(!empty($policymessage)){
						$versionids = $this->GetusersData('new_quote_version',$versionData['id'],'quote_id');
						$quoteversionid = str_replace('-','.',$versionids);
						$policymesss = $policymessage.' for Quote # '.$quoteversionid;
						$log= array(
							'type'=>'quote-version',
							'type_id'=>$versionData['id'],
							'message'=>$policymesss,
							'ip'=>$this->get_client_ip(),
							'country'=>$this->get_country(),
							'user_id'=>$_SESSION['user']['id'],
							'created_at' => date('Y-m-d H:i:s'),
						);
						$this->insertData('logs',$log);
					}
				}
				if(!empty($not_allow_version) && !empty($type) && ($type == 'downpercent'  || $type == 'downamount')){
					$this->Onlyversiontermschanges($versionData['id'],$type);
				}else{
					$this->Allversiontermschanges($versionData['id']);
				}
			}
		}
    }
	public static function getLoanPaymentSchedule($quoteId,$vId){
		$quoteTerm =   QuoteTerm::getData(['qId'=>$quoteId,'vId'=>$vId])->first();
		if(empty($quoteTerm))
			throw new Error("Invalid Quote and Version Id");
		$quoteSetting = QuoteSetting::getData()->first();
		$Firstpaymentdate = $quoteTerm?->first_payment_due_date;
		$new_payment_date = $quoteTerm?->first_payment_due_date;
		$no_of_Payments = $quoteTerm?->number_of_payment;
		$payment_due_days = $quoteSetting?->until_first_payment ;
		$totalinterest = $quoteTerm?->total_interest;
		$Setup_Fee = $quoteTerm?->setup_fee;
		$payment_amount = $quoteTerm?->payment_amount;
		$total_interest_inc_setup_fee = $quoteTerm?->total_interest_with_setup_fee;
		$html = '';
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
			$html .= '<tr class="mt-5">
						<td class="ml-5" style="text-align: center !important;">'.$payment_no.'</td>
						<td class="ml-5">'.$payment_due_date.'</td>
						<td class="ml-5">$ '.number_format($amount_financed,2).'</td>';
						if($Setup_Fee == 0){
							$totalmonthly += $payment_on_amount;
							$totalint += $total_interest;
							$totalprin += $no_inc_setup_fee;
			$html .=	'<td class="ml-2">'.($payment_on_amount == 0 ? '' : '$ '.number_format($payment_on_amount,2)).'</td>
						<td class="ml-2">'.($total_interest == 0 ? '' : '$ '.number_format($total_interest,2)).'</td>
						<td class="ml-2">'.($no_inc_setup_fee == 0 ? '' : '$ '.number_format($no_inc_setup_fee,2)).'</td>';
						}else {
							$totalmonthly += $pay_on_amount;
							$totalint += $tot_interest;
							$totalprin += $inc_setup_fee;
							
			$html .=	'<td class="ml-2">'.(!empty($pay_on_amount) ? '$ '.number_format($pay_on_amount,2) : '' ).'</td>
						<td class="ml-2">'.(!empty($tot_interest) ? '$ '.number_format($tot_interest,2) : '').'</td>
						<td class="ml-2">'.(!empty($inc_setup_fee) ? '$ '.number_format($inc_setup_fee,2) : '').'</td>';
						}
			$html .=	'<td class="ml-2">$ '.number_format($principal_balances,2).'</td>
						<td class="mr-2">$ '.number_format($payoff_balance,2).'</td>
						<td class="mr-2">$ '.number_format($interest_refund,2).'</td>
						</tr>';
			$UnearnedPremium = $difference = '';
			$cancellationdate = changeDateFormat(date('Y-m-d',strtotime("+".$totaldayscanceldays." day",strtotime($payment_due_date))));
			$PrincipalBalanceDue = ($i == 1) ? $amount_financed : $paymentArr[$i-1]['principal_balances'];
			$UnearnedPremium = ($i == 1 || $i == 2) ? $paymentArr[1]['amount_financed'] : 0;
			$difference = ($i == 1 || $i == 2) ?  $UnearnedPremium - $PrincipalBalanceDue : 0;
			$i++;
			$sum++;
		} 
		$html .= '<tr class="mt-5"><td colspan="3"></td>
		   <td>$ '.number_format($totalmonthly,2).'</td>
		   <td>$ '.number_format($totalint,2).'</td>
		   <td>$ '.number_format($totalprin,2).'</td>
			<td colspan="3"></td><tr>';
			
			
		$loanScheduleHtml = '<table class="table table-bordered table-hover mt-3">
			<thead class="theadbackground">
				<tr>';
		if($Setup_Fee == 0){ 
			$loanScheduleHtml .='<th colspan="12" class="text-center">Loan Payment Schedule (Excluding setup fee)</th>';
		} else { 
			$loanScheduleHtml .='<th colspan="12" class="text-center">Loan Payment Schedule (Including setup fee)</th>';
		}
		$loanScheduleHtml .='</tr>
		<tr>
		   <th scope="col" style="text-align: center !important;">Payment no.</th>
		   <th scope="col" class="text-center">Payment Due Date</th>
		   <th scope="col" class="text-center">Amount Financed</th>';
		 if($Setup_Fee == 0){ 
		   $loanScheduleHtml .='<th scope="col" class="text-center">Monthly Payment</th>
		   <th scope="col" class="text-center">Interest</th>
		   <th scope="col" class="text-center">Principal</th>';
		} else {
		  $loanScheduleHtml .=' <th scope="col" class="text-center">Monthly Payment</th>
		   <th scope="col" class="text-center">Interest</th>
		   <th scope="col" class="text-center">Principal</th>';
		} 
		$loanScheduleHtml .='<th scope="col" class="text-center">Principal Balance</th>
		   <th scope="col" class="text-center">Payoff Balance</th>
		   <th scope="col" class="text-center">Interest Refund</th>
		</tr>
		</thead>
		<tbody>
		'.$html.'					
		</tbody>
	</table>
	
	';
		return $loanScheduleHtml;
	}
	public static function getQuoteExposure($quoteId,$vId){
		$quoteTerm =   QuoteTerm::getData(['qId'=>$quoteId,'vId'=>$vId])->first();
		if(empty($quoteTerm))
			throw new Error("Invalid Quote and Version Id");
		$quoteSetting = QuoteSetting::getData()->first();
		$Firstpaymentdate = $quoteTerm?->first_payment_due_date;
		$new_payment_date = $quoteTerm?->first_payment_due_date;
		$no_of_Payments = $quoteTerm?->number_of_payment;
		$payment_due_days = $quoteSetting?->until_first_payment ;
		$totalinterest = $quoteTerm?->total_interest;
		$Setup_Fee = $quoteTerm?->setup_fee;
		$payment_amount = $quoteTerm?->payment_amount;
		$total_interest_inc_setup_fee = $quoteTerm?->total_interest_with_setup_fee;
		$quotehtml = '';
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
			$quotehtml .= '<tr class="mt-5">
						<td class="ml-5" style="text-align: center !important;">'.$payment_no.'</td>
						<td class="ml-5" style="text-align: center !important;">'.$payment_due_date.'</td>
						<td class="ml-5" style="text-align: center !important;">'.$cancellationdate.'</td>
						<td class="ml-5" style="text-align: center !important;">$ '.number_format($UnearnedPremium,2).'</td>';
					$quotehtml .= '<td class="ml-5" style="text-align: center !important;">$ '.number_format($PrincipalBalanceDue,2).'</td>';
					$quotehtml .= '<td class="ml-5" style="text-align: center !important;">$ '.number_format($difference,2).'</td>
						</tr>';
			
			$i++;
			$sum++;
		} 
			
			
		$loanScheduleHtml = '
	<table class="table table-bordered table-hover mt-3 View_quote_exposure">
		<thead class="theadbackground">
			<tr>';
				$loanScheduleHtml .='<th colspan="12" class="text-center">Quote Exposure';
			$loanScheduleHtml .='</tr>
			<tr>
			   <th scope="col" style="text-align: center !important;">Payment #</th>
			   <th scope="col" class="text-center">Due Date</th>
			   <th scope="col" class="text-center">Cancel Date</th>
			   <th scope="col" class="text-center">Unearned Premium</th>
			   <th scope="col" class="text-center">Principal Balance Due </th>
			   <th scope="col" class="text-center">Difference </th>';
			$loanScheduleHtml .='</tr>
		</thead>
		<tbody>'.$quotehtml.'</tbody>
	</table>
	
	';
		return $loanScheduleHtml;
	}
	
	public static function getAgentCompensationDetails($quoteId,$vId){
		$quoteTerm =   QuoteTerm::getData(['qId'=>$quoteId,'vId'=>$vId])->first();
		if(empty($quoteTerm))
			throw new Error("Invalid Quote and Version Id");
		$quoteSetting = QuoteSetting::getData()->first();
		$agent_compensation_data = isset($quoteTerm->agent_compensation_data) && !empty($quoteTerm->agent_compensation_data) ? json_decode($quoteTerm->agent_compensation_data) : '';
		$data = Quote::getData()->where('id',$quoteId)->firstOrFail();
		$View_agent_compensation_html = '';
		if(!empty($agent_compensation_data)){
			$View_agent_compensation_html = '<tr>
				<td>'.$data?->agency_data?->name.'</td>
				<td>'.$quoteTerm->buy_rate.'%</td>
				<td><input type="text" name="add_on_points" class="form-control input-sm amount" value="'.$agent_compensation_data->add_on_points.'"/></td>
				<td><input type="text" name="financed_rate" class="form-control input-sm percentage_input" value="'.$agent_compensation_data->financed_rate.'"/></td>
				<td><input type="text" name="markup" class="form-control input-sm percentage_input" value="'.$agent_compensation_data->markup.'"/></td>
				<td><input type="text" name="fee" class="form-control input-sm amount" value="'.$agent_compensation_data->fee.'"/></td>
				<td><input type="text" name="total_premium" class="form-control input-sm percentage_input" value="'.$agent_compensation_data->total_premium.'"/></td>
				<td><div class="form-control input-sm">'.formatAmount($quoteTerm->compensation,2,true).'</div></td>
			</tr>';
		}
		$compensationHtml = '<table class="table table-bordered table-hover mt-3">
	<thead class="theadbackground">
		<tr>
			<th colspan="12" class="text-center">View Agent Compensation</th>
		</tr>
		<tr>
		   <th style="width:280px;">Agency Name</th>
		   <th style="width:100px;">Buy Rate</th>
		   <th>Add-on Points</th>
		   <th>% Amt Financed</th>
		   <th>% of Markup</th>
		   <th>Fee</th>
		   <th>% Total Premium</th>
		   <th>Amount</th>
		</tr>
	</thead>
	<tbody>
	'.$View_agent_compensation_html.'
	</tbody>
</table>';
		return $compensationHtml;
	}
	public static function getDownPaymentRuleDetails($quoteId,$vId){
		$downPaymentHtml = '';
		$quoteTerm =   QuoteTerm::getData(['qId'=>$quoteId,'vId'=>$vId])->first();
		if(empty($quoteTerm))
			throw new Error("Invalid Quote and Version Id");
		$quoteSetting = QuoteSetting::getData()->first();
		$term_other_data = isset($quoteTerm->term_other_data) && !empty($quoteTerm->term_other_data) ? json_decode($quoteTerm->term_other_data) : '';
		$downPaymentRuleId = !empty($term_other_data) && isset($term_other_data->down_payment_rule_id) && !empty($term_other_data->down_payment_rule_id) ? $term_other_data->down_payment_rule_id : '';
		if(!empty($downPaymentRuleId)){
		$downPaymentRule = DownPaymentRule::getData(['id'=>$downPaymentRuleId])->first();
		if(!empty($downPaymentRule)){
			$down_payment_rule_id = $downPaymentRule->id;
			$down_payment_increase = $downPaymentRule->down_payment_increase;
			$number_of_payment = $downPaymentRule->deafult_installment;
			$min_number_of_payment = $downPaymentRule->minimum_installment;
			$max_number_of_payment = $downPaymentRule->maximumm_installment;
			$round_down_payment =  !empty($downPaymentRule) && !empty($downPaymentRule->round_down_payment) ? $downPaymentRule->round_down_payment : '';
		
		$downPaymentHtml = '<table class="table table-bordered table-hover mt-3">
	<thead class="theadbackground">
		<tr><th colspan="7" class="text-center">View Down Payment Rule</th></tr>
	</thead>
	<tbody>
	<tr>
		<td >Rule Set Name</td>
		<td colspan="6">'.$downPaymentRule->rule_name.'</td>
	</tr>
	<tr>
		<td>Description</td>
		<td colspan="6">'.$downPaymentRule->rule_description.'</td>
	</tr>
	<tr>         
		<td>Down Payment</td>
		<td>Minimum %</td>
		<td>'.$downPaymentRule->minimum_down_payment.'%</td>
		<td>Default %</td>
		<td>'.$downPaymentRule->deafult_down_payment.'%</td>
		<td>Dollar ($)</td>
		<td>'.formatAmount($downPaymentRule->dollar_down_payment,true).'</td>
	</tr>
	<tr>         
		<td>Installments</td>
		<td>Minimum</td>
		<td>'.$downPaymentRule->minimum_installment.'</td>
		<td>Maximum </td>
		<td>'.$downPaymentRule->maximumm_installment.'</td>
		<td>Default</td>
		<td>'.$downPaymentRule->deafult_installment.'</td>
	</tr>
	<tr>         
		<td></td>
		<td colspan="2">Round Down Payment to Nearest Dollar</td>
		<td colspan="4">'.(!empty($round_down_payment) ? 'Yes' : 'No').'</td>
	</tr>
	<tr>         
		<td></td>
		<td colspan="2">Down Payment Percent Increase</td>
		<td colspan="4">'.$down_payment_increase.'%</td>
	</tr>									
	</tbody>
</table>';
			}
		}
		return $downPaymentHtml;
	}
}
