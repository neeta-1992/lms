  @php
      $amount =$totalAmountPay          = 0;
      $quoteData        = $data?->q_data; //Quote Data
      $quoteTerm        = $data?->quote_term; //Quote Trem Data
      $numberOfpayment  = $quoteTerm?->number_of_payment ?? 0;
      $nextPayment      = $data?->next_payment; // Next Payment Data
      $accountType      = $quoteData?->account_type;
      $duePayment       = $nextPayment?->monthly_payment;
      $paymentNumber    = $nextPayment?->payment_number;

      $late_fee = !empty($nextPayment->late_fee) ? floatval($nextPayment->late_fee) : 0;
      $cancel_fee = !empty($nextPayment->cancel_fee) ? floatval($nextPayment->cancel_fee) : 0;
      $nsf_fee = !empty($nextPayment->nsf_fee) ? floatval($nextPayment->nsf_fee) : 0;



      if (!empty($amountApplyInstallment) && $paymentType == 'installment') {
            $totalAmountPaid = $amountApplyInstallment;
            $totalAmountPay  = $totalAmountPaid +  $convenienceFee;
      } else {
            $amount          = $nextPayment?->payoff_balance;
            $totalAmountPaid = $amount;
            $totalAmountPay  = $totalAmountPaid +  $convenienceFee;
      }

      $totalAmountPaid        = floatval($totalAmountPaid);
      $totalAmountPay         = floatval($totalAmountPay);

      $chartStatus = [];
      $amount_paid = toFloat($amountApplyInstallment);
		if(!empty($quoteAccountExposure)){
			   foreach($quoteAccountExposure as $exposureRow){
				   $qPaymentNumber  = $exposureRow?->payment_number ?? 0;
				   $qMonthlyPayment = $exposureRow?->monthly_payment ?? 0;
				   $qInterest       = $exposureRow?->interest ?? 0;
				   $qPayoffBalance  = $exposureRow?->payoff_balance ?? 0;
				   $qLateFee        = $exposureRow?->late_fee ?? 0;
				   $qCancelFee      = $exposureRow?->cancel_fee ?? 0;
				   $qNsfFee         = $exposureRow?->nsf_fee ?? 0;
				   $qConvientFee    = $exposureRow?->convient_fee ?? 0;
				   $qConvientFee    = $exposureRow?->convient_fee ?? 0;
				   $qStatus         = $exposureRow?->status ?? 0;

				   $qTotalPayment = toRound(toFloat($qMonthlyPayment) + toFloat($qLateFee) + toFloat($qCancelFee) + toFloat($qNsfFee));
				  if($qStatus == 0){
					   if($paymentType == 'payoff'){
						   $chartStatus[$qPaymentNumber] = ['color'=>'#008000','completed'=>'100','due'=>'0'];
					   }else{
							if($amount_paid >0){
								if($amount_paid >= $qTotalPayment){
									$amount_paid = $amount_paid - $qTotalPayment;
									$chartStatus[$qPaymentNumber] = ['color'=>'#008000','completed'=>'100','due'=>'0'];
								}else if($amount_paid < $qTotalPayment){
									$precentamounts = ($amount_paid/$qTotalPayment * 100);
									$precentamounts = round($precentamounts,2);
									$duepercent = 100 - $precentamounts;
									$chartStatus[$qPaymentNumber] = ['color'=>'#008000','completed'=>$precentamounts,'due'=>$duepercent];
									$amount_paid = 0;
								}
							}else{
								$chartStatus[$qPaymentNumber] = ['color'=>'#ff0000','completed'=>'100','due'=>'0'];
							}
					   }
				   }else{
						$chartStatus[$qPaymentNumber] = ['color'=>'#fd7e14','completed'=>'100','due'=>'0'];
				   }

			   }
		}

      $chartHtml = $radioHtml =  ''; $styleCss  = "background-color:red;";
      if (!empty($numberOfpayment)) {
          for ($i = 1; $i <= $numberOfpayment; $i++) {
				if(isset($chartStatus[$i]['completed']) && $chartStatus[$i]['completed'] == 100){
					$styleCss  = isset($chartStatus[$i]['color']) ? "background-color:{$chartStatus[$i]['color']};" : '';
				}else if(isset($chartStatus[$i])){
					$styleCss  = "background: -webkit-linear-gradient(left, {$chartStatus[$i]['color']} {$chartStatus[$i]['completed']}%,#ff0000 100%);
					background: -moz-linear-gradient(left, {$chartStatus[$i]['color']} {$chartStatus[$i]['completed']}%, #ff0000 {$chartStatus[$i]['due']}%);
					background: -ms-linear-gradient(left, {$chartStatus[$i]['color']} {$chartStatus[$i]['completed']}%,#ff0000 {$chartStatus[$i]['due']}%);
					background: -o-linear-gradient(left, {$chartStatus[$i]['color']} {$chartStatus[$i]['completed']}%,#ff0000 {$chartStatus[$i]['due']}%);
					background: linear-gradient(to right, {$chartStatus[$i]['color']} {$chartStatus[$i]['completed']}%,#ff0000 {$chartStatus[$i]['due']}%);";
				}
            
              
              $chartHtml .= "<div style='border:1px solid black;width:75px;text-align: center;vertical-align: top;height: 35px;{$styleCss}'>{$i}</div>";

              $radioHtml .= '<div class="zinput zradio zradio-sm  p-0  zinput-inline" >
                                <input name="payment_number_radio" type="radio" '.($paymentNumber == $i ? 'checked' : '').' disabled value="'.$i.'" class="form-check-input" id="radio_'.$i.'" />   <label for="radio_'.$i.'" class="form-check-label"></label>
                            </div>';
          }
      }

  @endphp

  <x-table id="{{ $activePage ?? '' }}-enter-payment-proccess" class="enter-payment-table">
      <thead class="d-none">
          <tr>
              <th class="align-middle"></th>
              <th class="align-middle"></th>
          </tr>
      </thead>

      <tbody>
          <tr>
              <td colspan="2">The payment has been saved. The account will <b>Not</b> be updated until the payment is
                  processed. </td>

          </tr>
          <tr>
              <td colspan="2">To process this payment and update the account now, please review the information below
                  and click the Process button.</td>

          </tr>
          <tr>
              <td> <b>@lang('labels.account_number') </b> : {{ $data->account_number }} </td>
              <td>
                  <div class="d-flex">
                      <div style="width:20px;border: 1px solid #fd7e14;background-color:#fd7e14;"> </div>
                      <div class="ml-1">Prior Payments</div>
                      <div class="ml-3" style="width:20px;border: 1px solid green;background-color:green;"></div>
                      <div class="ml-1">This Payment</div>
                      <div class="ml-3" style="width:20px;border: 1px solid red;background-color:red"></div>
                      <div class="ml-1">Amt Due</div>
                  </div>
              </td>
          </tr>
          <tr class="installmentAmountShow">
              <td> <b> @lang('labels.account_paid_due')</b> : {{ dollerFA($totalAmountPaid ?? '0.00') }} /  {{ dollerFA($duePayment ?? '0.00') }}  </td>
              <td>
                  <div class="d-flex">
                      {!! $chartHtml ?? '' !!}
                  </div>
              </td>
          </tr>
          <tr class="installmentAmountShow">
              <td> <b> @lang('labels.advance_due_date_to_installment')</b> : </td>
              <td>
                  <div class="d-flex">
                      {!! $radioHtml ?? '' !!}
                  </div>
              </td>
          </tr>

          <tr>
              <td> </td>
              <td>
                  <x-button-group class="savePayment" :notlabel="true"
                      cancel="{{ routeCheck($route . 'show', $data->id) }}" />
              </td>
          </tr>
      </tbody>
  </x-table>
