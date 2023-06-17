@php
    $currentpayment_method = $html = '';
    $n = $p = $totalamounts = 0;
    $accountStatusArr = accountStatus();
    $paymentData = !empty($paymentData) ? $paymentData : null ;
    $payoffpaymentsdatas = !empty($payoffpaymentsdatas) ? $payoffpaymentsdatas : null ;
    $type = !empty($type) ? $type : '' ;
@endphp
 <x-table id="{{ $activePage ?? '' }}{{ $type == 'commit' ? '-commit' : '' }}-find-payment" :pagination="false" >
     <thead>
         <tr>
             @empty($type)
                <th class="" data-width="10" data-field="check"></th>
             @endempty

             <th class="" data-width="150" data-field="account_number">Account #</th>
             <th class="" data-width="" data-field="insured_name">Insured Name</th>
             <th class="" data-width="100" data-field="installment_number">Payment #</th>
             <th class="" data-width="100" data-field="payment_due_date">Next Due</th>
             <th class="" data-width="100" data-field="installment_pay">Installment</th>
             <th class="" data-width="100" data-field="total_due">Total Due</th>
             <th class="" data-width="100" data-field="amount">Total Paid</th>
         </tr>
     </thead>
     <tbody>
         @if (!empty($paymentData) || !empty($payoffpaymentsdatas))
         @if (!empty($paymentData?->toArray()))
         @if($type !== 'commit')
            <tr class="bg-light">
                <td colspan="8"><b>Regular Installment</b></td>
            </tr>
         @endif
         @foreach ($paymentData as $key => $installmentRow)
         @php $p++; @endphp

         @if ($p == 1)

         <tr class="bg-light">
            @empty($type)
              <td colspan="8">
                 <x-jet-checkbox id="{{ $installmentRow?->payment_method ?? '' }}_{{ $p ?? '' }}" labelText="{{ $installmentRow?->payment_method ?? '' }}" name="paymentmethod[]" class="paymentmethod" data-type="installment" value="{{ $installmentRow?->payment_method ?? '' }}" />
             </td>
             @else
              <td colspan="7">
                 {{ $installmentRow?->payment_method ?? '' }}</td>
             @endempty
         </tr>

         @endif
         @if ($currentpayment_method != $installmentRow?->payment_method && $p != 1)
         <tr>
             <td class="" colspan="2"><b>Number of Payments</b></td>
             <td class="" colspan="4"><b>{{ $n }}</b></td>
             <td class=""><b>Total</b></td>
             <td class=""><b>{{ dollerFA($totalamounts ?? '') }}</b></td>
         </tr>
         @php
         $n = $totalamounts = 0; @endphp
         <tr class="bg-light ">
            @empty($type)
             <td colspan="8">
                 <x-jet-checkbox id="{{ $installmentRow?->payment_method ?? '' }}_{{ $p ?? '' }}" labelText="{{ $installmentRow?->payment_method ?? '' }}" name="paymentmethod[]" class="paymentmethod" data-type="installment" value="{{ $installmentRow?->payment_method ?? '' }}" />
             </td>
              @else
               <td colspan="7">
                 {{ !empty($installmentRow?->payment_method) ? $installmentRow?->payment_method : '' }}</td>
              @endempty
         </tr>
         @endif
         @php

         $currentpayment_method = $installmentRow?->payment_method;
         $totalamounts += $installmentRow?->amount;

         $transactionHistory = \App\Models\TransactionHistory::getData(['accountId' => $installmentRow?->account_id, 'paymentId' => $installmentRow?->id])->first();
         $installmentnumber = !empty($transactionHistory?->new_payment_number) ? $transactionHistory?->new_payment_number : $transactionHistory?->payment_number;
         $accountQuoteExposure = \App\Models\QuoteAccountExposure::getData(['accountId' => $installmentRow?->account_id, 'paymentNumber' => $installmentnumber])->first();
         $nextPayment = !empty($installmentRow?->account_data?->next_payment) ? $installmentRow?->account_data?->next_payment : '';
         $nextinstallment = $nextPayment?->payment_number ?? '';
         $quoteTermData = $installmentRow?->account_data?->quote_term ?? null;
         $accountStatus = $installmentRow?->account_data?->status ?? 0;
         $numberOfPayment = !empty( $quoteTermData->number_of_payment) ?  $quoteTermData->number_of_payment : '' ;

         $text = '';
         if ($installmentRow?->payment_number == $numberOfPayment && $accountQuoteExposure->status == 2) {
            $text = '';
         } else {
            $text = 'Update to installment #' . $nextinstallment . ' of ' . $numberOfPayment;
         }

         if (($accountQuoteExposure->status == 2 || $accountQuoteExposure->status == 3) && $accountStatus != 1) {
         $text .= !empty($text) ? ', ' : '';
         $text .= 'Change status from ' . $accountStatusArr[$accountStatus]['text'] . ' to ' . $accountStatusArr[1]['text'];
         }
         if (!empty($installmentRow?->partial_letter)) {
         $text .= !empty($text) ? ', ' : '';
         $text .= 'Send partial payment letter';
         }

         if ($accountStatus == 3 || $accountStatus == 4 || $accountStatus == 5) {
         $text .= !empty($text) ? ', ' : '';
         $text .= 'Send Reinstatement letter';
         }

         $installment_number = !empty($installmentRow?->payment_number) ? $installmentRow?->payment_number . ' / ' . $numberOfPayment : '';
         @endphp


         <tr class="">
            @empty($type)
                <td class="">
                    <x-jet-checkbox id="{{ $installmentRow?->payment_method ?? '' }}_checkpayment_{{ $p ?? '' }}" value="{{ $installmentRow?->id }}" data-type="installment" data-method="{{ $installmentRow?->payment_method }}" name="checkpayment[]" class="checkpayment" />
                </td>
            @endempty
            
             <td class=""><span class="{{ $accountStatusArr[$accountStatus]['colorclass'] }}">{{ $installmentRow?->account_data?->account_number }}</span>
             @if($type !== 'commit')
             <br>
                 <div class="mt-2"><b>Actions</b></div> @endif
             </td>
             <td class=""><span>{{ $installmentRow?->account_data?->insur_data?->name }}</span>
                @if($type !== 'commit')
                <br>
                 <div class="{{ $accountStatusArr[$accountStatus]['colorclass'] }} mt-2">
                     {{ $text }}</div>
                 @endif
             </td>
             <td class="">{{ $installment_number ?? '' }}</td>
             <td class="">
                 {{ !empty($nextPayment?->payment_due_date) ? changeDateFormat($nextPayment?->payment_due_date ?? '', true) : '' }}
             </td>
             <td class="">{{ dollerFA($installmentRow?->installment_pay ?? 0) }}</td>
             <td class="">{{ dollerFA($installmentRow?->total_due ?? 0) }}</td>
             <td class=""><span class="{{ $accountStatusArr[$accountStatus]['colorclass'] }}">{{ dollerFA($installmentRow?->amount ?? 0) }}</span>
             </td>
         </tr>
         @php
         $n++;
         @endphp
         @endforeach
         @endif



         @if (!empty($payoffpaymentsdatas?->toArray()))
         <tr class="bg-light ">
             <td colspan="8"><b>Payoff</b></td>
         </tr>
         @foreach ($payoffpaymentsdatas as $key => $payoff)
         @php $p++; @endphp

         @if ($p == 1)

         <tr class="bg-light">
             <td colspan="8">
                 @empty($type)
                 <x-jet-checkbox id="{{ $payoff->payment_method ?? '' }}_{{ $p ?? '' }}" labelText="{{ $payoff->payment_method ?? '' }}" name="paymentmethod[]" class="paymentmethod" data-type="payoff" value="{{ $payoff->payment_method ?? '' }}" />
                 @else
                 {{ $payoff->payment_method ?? '' }}
                 @endempty
             </td>
         </tr>

         @endif
         @if ($currentpayment_method != $payoff->payment_method && $p != 1)
         <tr>
             <td class="" colspan="2"><b>Number of Payments</b></td>
             <td class="" colspan="4"><b>{{ $n }}</b></td>
             <td class=""><b>Total</b></td>
             <td class=""><b>{{ dollerFA($totalamounts ?? '') }}</b></td>
         </tr>
         @php
         $n = $totalamounts = 0; @endphp

         <tr class="bg-light ">
             <td colspan="8">
                 @empty($type)
                 <x-jet-checkbox id="{{ $payoff->payment_method ?? '' }}_{{ $p ?? '' }}" labelText="{{ $payoff->payment_method ?? '' }}" name="paymentmethod[]" class="paymentmethod" data-type="payoff" value="{{ $payoff->payment_method ?? '' }}" />

                 @else
                 {{ $payoff->payment_method ?? '' }}
                 @endempty
             </td>
         </tr>

         @endif
         @php

         $currentpayment_method = $payoff?->payment_method;
         $totalamounts += $payoff?->amount;

         $transactionHistory = \App\Models\TransactionHistory::getData(['accountId' => $payoff?->account_id, 'paymentId' => $payoff?->id])->first();
         $installmentnumber = !empty($transactionHistory?->new_payment_number) ? $transactionHistory?->new_payment_number : $transactionHistory?->payment_number;
         $accountQuoteExposure = \App\Models\QuoteAccountExposure::getData(['accountId' => $payoff?->account_id, 'paymentNumber' => $installmentnumber])->first();
         $nextPayment = !empty($payoff?->account_data?->next_payment) ? $payoff?->account_data?->next_payment : '';
         $nextinstallment = $nextPayment?->payment_number ?? '';
         $quoteTermData = $payoff?->account_data?->quote_term ?? null;
         $accountStatus = $payoff?->account_data?->status ?? 0;
        $numberOfPayment = !empty( $quoteTermData->number_of_payment) ?  $quoteTermData->number_of_payment : '' ;
         $text = '';
         if ($payoff?->payment_number == $numberOfPayment && $accountQuoteExposure->status == 2) {
         $text = '';
         } else {
         $text = 'Update to installment #' . $nextinstallment . ' of ' . $numberOfPayment;
         }

         if (($accountQuoteExposure->status == 2 || $accountQuoteExposure->status == 3) && $accountStatus != 1) {
         $text .= !empty($text) ? ', ' : '';
         $text .= 'Change status from ' . $accountStatusArr[$accountStatus]['text'] . ' to ' . $accountStatusArr[1]['text'];
         }
         if (!empty($payoff?->partial_letter)) {
         $text .= !empty($text) ? ', ' : '';
         $text .= 'Send partial payment letter';
         }

         if ($accountStatus == 3 || $accountStatus == 4 || $accountStatus == 5) {
         $text .= !empty($text) ? ', ' : '';
         $text .= 'Send Reinstatement letter';
         }

         $installment_number = !empty($payoff?->payment_number) ? $payoff?->payment_number . ' / ' .$numberOfPayment : '';
         @endphp


         <tr class="">
             @empty($type)
             <td class="">
                 <x-jet-checkbox id="{{ $payoff?->payment_method ?? '' }}_checkpayment_{{ $p ?? '' }}" value="{{ $payoff?->id }}" data-method="'{{ $payoff?->payment_method }}" name="checkpayment[]" data-type="payoff" class="checkpayment" />
             </td>
             @endempty
             <td class=""><span class="{{ $accountStatusArr[$accountStatus]['colorclass'] }}">{{ $payoff?->account_data?->account_number }}</span><br>
                 <div class="mt-2"><b>Actions</b></div>
             </td>
             <td class=""><span>{{ $payoff?->account_data?->insur_data?->name }}</span><br>
                 <div class="{{ $accountStatusArr[$accountStatus]['colorclass'] }} mt-2">
                     {{ $text }}</div>
             </td>
             <td class="">{{ $installment_number ?? '' }}</td>
             <td class="">
                 {{ !empty($nextPayment?->payment_due_date) ? changeDateFormat($nextPayment?->payment_due_date ?? '', true) : '' }}
             </td>
             <td class="">{{ dollerFA($payoff?->installment_pay ?? 0) }}</td>
             <td class="">{{ dollerFA($payoff?->total_due ?? 0) }}</td>
             <td class=""><span class="{{ $accountStatusArr[$accountStatus]['colorclass'] }}">{{ dollerFA($payoff?->amount ?? 0) }}</span>
             </td>
         </tr>
         @php
         $n++;
         @endphp
         @endforeach
         @endif
         @if(!empty($paymentData?->toArray()) || !empty($payoffpaymentsdatas?->toArray()))
         <tr>
             <td class="" colspan="{{ !empty($type) ? 1 : 2 }}"><b>Number of Payments</b></td>
             <td class="" colspan="4"><b>{{ $n ?? '' }}</b></td>
             <td class=""><b>Total</b></td>
             <td class=""><b>{{ dollerFA($totalamounts ?? 0) }}</b></td>
         </tr>
        
        @if($type !== 'commit')
         <tr>
             <td class="" colspan="{{ !empty($type) ? 1 : 2 }}"></td>
             <td class="" colspan="6">
               @if(!empty($type) && $type == 'process')
                  <x-button-group btnText="Commit Entered Payments"  :notlabel="true" x-on:click="open = 'commitProcessEntered'" class="commit_process_entered" xclick="open = 'isForm'" />
                @else
                  <x-button-group btnText="Process Entered Payments" x-on:click="open= 'processEnteredFn'" :notlabel="true" class="process_entered" xclick="open = 'isForm'" />
               @endif
               

             </td>
         </tr>
          @endif
           @endif
         @endif
     </tbody>
 </x-table>
