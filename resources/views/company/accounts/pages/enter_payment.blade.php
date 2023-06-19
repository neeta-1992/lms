 <x-form class="validation text-left enterPayment" action="{{ routeCheck($route.'getPaymentChart',$accountId) }}" method="post">
     <input type="hidden" name="account_id" value="{{ $accountId ?? '' }}">
     <input type="hidden" name="payment_number" value="{{ $data->next_payment->payment_number ?? '' }}">
     <x-table id="{{ $activePage ?? '' }}-enter-payment" class="enter-payment-table">
         <thead class="d-none">
             <tr>
                 <th class="align-middle"></th>
                 <th class="align-middle"></th>
             </tr>
         </thead>
         @php
         $nextPayment = !empty($data?->next_payment) ? $data?->next_payment : null;
         $pendingAmount = !empty($pendingPayment?->amount) ? floatval($pendingPayment?->amount) : 0 ;
         $pendingLateFee = !empty($pendingPayment?->lateFee) ? floatval($pendingPayment?->lateFee) : 0 ;
         $pendingcancelFee = !empty($pendingPayment?->cancelFee) ? floatval($pendingPayment?->cancelFee) : 0 ;
         $pendingNsfFee = !empty($pendingPayment?->nsfFee) ? floatval($pendingPayment?->nsfFee) : 0 ;
         $pendingConvientFee = !empty($pendingPayment?->convientFee) ? floatval($pendingPayment?->convientFee) : 0 ;
         $paymentNumber = !empty($nextPayment->payment_number) ? $nextPayment->payment_number : $pendingPayment?->payment_number ;
         $monthly_payment = floatval($data->next_payment->monthly_payment ?? 0) + $pendingAmount;
         $late_fee = floatval($data->next_payment->late_fee ?? 0) + $pendingLateFee;
         $cancel_fee = floatval($data->next_payment->cancel_fee ?? 0) + $pendingcancelFee;
         $nsf_fee = floatval($data->next_payment->nsf_fee ?? 0) + $pendingNsfFee;
         $payoffBalance = floatval($data->next_payment->payoff_balance ?? 0);
         $totalAmount = $monthly_payment + $late_fee + $cancel_fee + $nsf_fee ;
         $payoffBalancetotalAmount = $payoffBalance + $late_fee + $cancel_fee + $nsf_fee + $pendingAmount + $pendingLateFee + $pendingcancelFee + $pendingNsfFee ;

         @endphp
         <input type="hidden" name="due_payment" value="{{ $totalAmount ?? 0 }}">
         <tbody>
             <tr>
                 <td> @lang('labels.payment_number') </td>
                 <td>{{ $paymentNumber."/".$data?->quote_term?->number_of_payment }}</td>
             </tr>
             <tr>
                 <td> @lang('labels.payment_type') </td>
                 <td>
                     <div class="form-group w-50">
                         <x-select class="ui dropdown w-50 payment_type" :options="['installment'=>'Installment','payoff'=>'Payoff']" name="payment_type" />
                     </div>
                 </td>
             </tr>
             <tr class="installmentAmountShow">
                 <td> @lang('labels.installment_amount_due') </td>
                 <td class="installment_amount_due">{{ dollerFA($monthly_payment ?? '0.00') }}</td>
             </tr>
             <tr class="d-none payoffAmountShow">
                 <td> @lang('labels.payoff_amount')</td>
                 <td class="payoff_amount">{{ dollerFA($payoffBalance  ?? '0.00') }}</td>
             </tr>
             <tr>
                 <td> @lang('labels.late_fee') </td>
                 <td class="late_fee">{{ dollerFA($late_fee ?? '0.00') }}</td>
             </tr>
             <tr>
                 <td> @lang('labels.cancel_fee') </td>
                 <td class="cancel_fee">{{ dollerFA($cancel_fee ?? '0.00') }}</td>
             </tr>
             <tr>
                 <td> @lang('labels.nsf_fee') </td>
                 <td class="nsf_fee">{{ dollerFA($nsf_fee ?? '0.00') }}</td>
             </tr>
             <tr class="installmentAmountShow">
                 <td> @lang('labels.total_amount_due') </td>
                 <td class="total_amount_due">{{ dollerFA($totalAmount ?? '0.00') }}</td>
             </tr>
             <tr class="payoffAmountShow d-none">
                 <td> @lang('labels.total_amount_due') </td>
                 <td class="total_amount_due">{{ dollerFA($payoffBalancetotalAmount ?? '0.00') }}</td>
             </tr>
             <tr>
                 <td class="requiredAsterisk"> @lang('labels.payment_method') </td>
                 <td class="payment_method">
                     <div class="form-group w-50">
                         <x-select class="ui dropdown w-50 payment_method" required :options="accountPaymentMethod()" name="payment_method" placeholder="Select {{  __('labels.payment_method') }}" />
                     </div>
                 </td>
             </tr>
             <tr class="installmentAmountShow">
                 <td class="requiredAsterisk"> @lang('labels.amount_apply_installment') </td>
                 <td class="amount_apply_installment">
                     <x-jet-input type="text" class="amount w-50" value="{{ formatAmount($totalAmount ?? '0.00') }}" required name="amount_apply_installment" />
                 </td>
             </tr>
             <tr class="d-none">
                 <td class=""> @lang('labels.convenience_fee') </td>
                 <td class="convenience_fee">
                     <x-jet-input type="text" name="convenience_fee" class="amount w-50" value="{{ $data->convenience_fee ?? '' }}" placeholder="$" />
                 </td>
             </tr>
             <tr>
                 <td> @lang('labels.total_amount_paid') </td>
                 <td class="total_amount_paid">{{ dollerFA($totalAmount ?? '0.00') }}</td>
             </tr>

             <tr class="echeck  d-none">
                 <td class="requiredAsterisk"> @lang('labels.account_holder_name') </td>
                 <td>
                     <x-jet-input type="text" class="required" name="account_holder_name" />
                 </td>
             </tr>
             <tr class="echeck  d-none">
                 <td class="requiredAsterisk"> @lang('labels.bank_name') </td>
                 <td>
                     <x-jet-input type="text" class="required" name="bank_name" />
                 </td>
             </tr>
             <tr class="echeck  d-none">
                 <td class="requiredAsterisk"> @lang('labels.bank_details') </td>
                 <td>
                     <div class="row">
                         <div class="col-md-6">
                             <x-jet-input type="text" class="required" name="routing_number" placeholder="Bank Routing Number" />
                         </div>
                         <div class="col-md-6">
                             <x-jet-input type="text" class="required" name="account_number" placeholder="Bank Account Number" />
                         </div>
                     </div>
                 </td>
             </tr>

             @if(!empty($EPS->payment_gateway) && $EPS->payment_gateway != 'square')
                <tr class="credit_card_box  d-none">
                    <td class="requiredAsterisk"> @lang('labels.card_number') </td>
                    <td>
                        <x-jet-input type="text" name="card_number" class="digitLimit cardNumber required" maxlenght="18" data-limit="18" value="" />
                    </td>
                </tr>
             @endif
             <tr class="credit_card_box d-none">
                 <td class="requiredAsterisk"> @lang('labels.card_details') </td>
                 <td>
                    @if(!empty($EPS->payment_gateway) && $EPS->payment_gateway == 'square')
                        <div class="">
                            <x-jet-input name="sqtoken" type="hidden"  />
                            <div id="card-container" class="sqcard__payment"></div>
                        </div>
                    @else
                         <div class="row">
                         <div class="col-md-3 form-group">
                             <x-select :options="monthsDropDown('shortname')" name="month" class="ui dropdown w-25 required" placeholder="Months" />
                         </div>
                         <div class="col-md-3  form-group">
                             @php
                             $yearOption = [];
                             @endphp
                             @for ($year = date('Y'); $year
                             <= date('Y') + 8; $year++) @php $yearOption[$year]=$year; @endphp @endfor <x-select :options="$yearOption" name="year" class="ui dropdown  w-25 required" placeholder="Year" />
                         </div>
                         <div class="col-md-3">
                             <x-jet-input type="text" name="cvv" class="digitLimit required cardCVV" data-limit="4" maxlenght="4" placeholder="CVV" />
                         </div>
                         <div class="col-md-3">
                             <x-jet-input type="text" name="zip" class="zip_mask required" placeholder="Zip" value="" />
                         </div>
                     </div>
                    @endif
                    
                 </td>
             </tr>
             <tr>
                 <td class="requiredAsterisk"> @lang('labels.received_from') </td>
                 <td class="received_from">
                     <div class="form-group w-50">
                         <x-select class="ui dropdown w-50" name="received_from" required :options="['insured'=>'Insured','agent'=>'Agent']" placeholder="Select {{  __('labels.received_from') }}" />
                     </div>
                 </td>
             </tr>
             <tr>
                 <td> @lang('labels.reference') </td>
                 <td>
                     <x-jet-input type="text" name="reference" value="" class="w-50" />
                 </td>
             </tr>
             <tr>
                 <td> @lang('labels.deposit_to_bank_account') </td>
                 <td>
                     <div class="form-group w-50">
                         <x-select class="ui dropdown w-50" :options="$bankAccount ?? []" name="bank_account" placeholder="Select {{  __('labels.deposit_to_bank_account') }}" />
                     </div>
                 </td>
             </tr>
             <tr>
                 <td> @lang('labels.notes') </td>
                 <td>
                     <x-jet-input type="text" name="notes" value="" />
                 </td>
             </tr>
             <tr>
                 <td> </td>
                 <td>
                     <x-button-group class="saveData" :notlabel="true" />
                 </td>
             </tr>
         </tbody>
     </x-table>

 </x-form>

