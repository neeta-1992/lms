 <table id="account_view" class="table table-bordered table-hover">
     <thead style="display: none;">
         <tr>
             <th class="align-middle" style="width: 300px; font-size: 14px;" data-field="Title" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">
                 <div class="th-inner " data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;"></div>
                 <div class="fht-cell" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;"></div>
             </th>
             <th class="align-middle" style="width: 200px; font-size: 14px;" data-field="Value" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">
                 <div class="th-inner " data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;"></div>
                 <div class="fht-cell" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;"></div>
             </th>
             <th class="align-middle" style="width: 300px; font-size: 14px;" data-field="Titles" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">
                 <div class="th-inner " data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;"></div>
                 <div class="fht-cell" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;"></div>
             </th>
             <th class="align-middle" style="width: 200px; font-size: 14px;" data-field="Values" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">
                 <div class="th-inner " data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;"></div>
                 <div class="fht-cell" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;"></div>
             </th>
         </tr>
     </thead>
     @php
     $qt = $data?->quote_term ?? null;
     $tP = !empty($qt->total_premium) ? $qt->total_premium : 0.00;
     $eF = !empty($qt->earned_fees) ? $qt->earned_fees : 0.00;
     $uF = !empty($qt->unearned_fees) ? $qt->unearned_fees : 0.00;
     $aF = !empty($qt->amount_financed) ? $qt->amount_financed : 0.00;
     $rps = !empty($qt->amount_financed) ? $qt->amount_financed : 0.00;
     $dP = !empty($qt->down_payment) ? $qt->down_payment : 0.00;
     $dPP = !empty($qt->down_percent) ? $qt->down_percent : 0;
     $tSf = !empty($qt->setup_fee) ? $qt->setup_fee : 0;
     $eApr = !empty($qt->effective_apr) ? $qt->effective_apr : 0;


     $tpRps = $tP + $rps;
     $tPIncFee = $tP + $eF + $uF;

     $firstData = App\Models\QuoteAccountExposure::getData(['accountId'=>$data?->id ])->orderBy('payment_number','asc')->first();
     $pendingPayment = App\Models\PendingPayment::getData(['accountId'=>$data?->id])
                                            ->selectRaw('payment_number,SUM(due_installment) as amount,SUM(due_late_fee) as lateFee,SUM(due_cancel_fee) as cancelFee,SUM(due_nsf_fee) as nsfFee,SUM(due_convient_fee) as convientFee')
                                            ->orderBy('created_at','desc')->first();

     $nextPayment        = !empty($data?->next_payment)  ? $data?->next_payment : null;
     $pendingAmount      = !empty($pendingPayment?->amount) ? floatval($pendingPayment?->amount) : 0 ;
     $pendingLateFee     = !empty($pendingPayment?->lateFee) ? floatval($pendingPayment?->lateFee) : 0 ;
     $totalDuePayment    = floatval($nextPayment->monthly_payment ?? 0) + $pendingAmount;
     $late_fee           = floatval($nextPayment->late_fee ?? 0) + $pendingLateFee;
     @endphp
     <tbody>
         <tr data-index="0">
             <td class="align-middle" style="width: 300px; font-size: 14px;" colspan="4" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">Activated on {{ changeDateFormat($data->created_at) }} by {{ $data?->user?->name }}</td>
         </tr>
         <tr data-index="1">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.total_pure_premium_policies_and_aps')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ dollerFA($tP) }}</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.payment_type')</td>
             <td class="align-middle payMenthodModel" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0"> <a href="javascript:void(0)" class="linkButton">{{ $data->payment_method }}<a> </td>
         </tr>
         <tr data-index="2">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.total_earned_fees')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ dollerFA($eF) }}</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.installment')</td>

             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{  !empty($data->next_payment?->payment_number) ? ($data->next_payment?->payment_number.'/'.$data->quote_term?->number_of_payment) : '' }}</td>
         </tr>
         <tr data-index="3">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.total_unearned_fees')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ dollerFA($uF) }}</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.first_payment_due')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ changeDateFormat($firstData->payment_due_date ?? '',true) }}</td>
         </tr>
         <tr data-index="4">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.total_premium_including_fees')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ dollerFA($tPIncFee) }}</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.next_payment_due_date')</td>

             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ changeDateFormat($data?->next_payment?->payment_due_date,true) }}</td>
         </tr>
         <tr data-index="5">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.return_premium_adjustments')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ dollerFA($rps) }}</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.total_amount_due')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{  dollerFA($totalDuePayment ?? 0) }}</td>
         </tr>
         <tr data-index="6">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.total_premium_including_rps')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ dollerFA($tpRps) }}</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.next_payment_late')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{  dollerFA($totalDuePayment +  $late_fee + $pendingLateFee) }}</td>
         </tr>
         <tr data-index="7">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.total_unearned_premium_amount_financed')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ dollerFA($aF) }}</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.down_payment_due')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 0.00</td>
         </tr>
         <tr data-index="8">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.total_down_payment')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ dollerFA($dP) }} / {{ pFormat($dPP) }}</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.current_earned_interest')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 7.60</td>
         </tr>
         <tr data-index="9">
             <td class="align-middle" style="width: 300px; font-size: 14px;" rowspan="3" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.finance_charge')
                 <div class="ml-2" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;">@lang('labels.at_account_activation')</div>
                 <div class="ml-2" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;">@lang('labels.additional_premium')</div>
                 <div class="ml-2" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;">@lang('labels.return_premium')</div>
                 <div class="ml-2" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;">@lang('labels.actual')</div>
             </td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" rowspan="3" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">
                 <div class="mt-3" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;">$ 25.06</div>
                 <div data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;">$ 12.53</div>
                 <div data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;">$ 0.00</div>
                 <div data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0" style="font-size: 14px;">$ 37.59</div>
             </td>
             <td class="text-vertical-top" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.current_unearned_interest')</td>
             <td class="text-vertical-top" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 29.99</td>
         </tr>
         <tr data-index="10">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.next_month_payoff')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 0.00</td>
         </tr>
         <tr data-index="11">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.current_balance_including_fees_write_offs')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 0.00</td>
         </tr>
         <tr data-index="12">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.total_setup_fee')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ dollerFA($tSf) }}</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.late_fee')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 0.00</td>
         </tr>
         <tr data-index="13">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.effective_aPR')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ pFormat($eApr) }}</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.administrative_fee')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 0.00</td>
         </tr>
         <tr data-index="14">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.recurring_processing_fee')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 0.00</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.nsf_fees')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 0.00</td>
         </tr>
         <tr data-index="15">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.installment_amount_monthly')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 86.12</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.cancel_fees')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 0.00</td>
         </tr>
         <tr data-index="16">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.loan_maturity_date')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">10/14/2023</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.convenience_fees')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 0.00</td>
         </tr>
         <tr data-index="17">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.expected_funding_date')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">03/17/2023</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.processing_fees')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 0.00</td>
         </tr>
         <tr data-index="18">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.date_intent_to_cancel_notice_will_be_generated')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">04/27/2023</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.direct_bill_fee')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 0.00</td>
         </tr>
         <tr data-index="19">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.effective_date')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">03/03/2023</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.total_of_payments')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 775.06</td>
         </tr>
         <tr data-index="20">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.next_cancellation_date')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">05/07/2023</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.date_last_payment_received')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">04/18/2023</td>
         </tr>
         <tr data-index="21">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.line_of_business')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ ucfirst($data->account_type ?? '')}}</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.amount_of_last_payment')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">$ 1,100.00</td>
         </tr>
         <tr data-index="22">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.origination_state')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">{{ ucfirst($data->originationstate ?? '')}}</td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.last_payment_type')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.check')</td>
         </tr>
         <tr data-index="23">
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.reinstatement_date')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0"></td>
             <td class="align-middle" style="width: 300px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0">@lang('labels.no_of_reinstatements')</td>
             <td class="align-middle" style="width: 200px; font-size: 14px;" data-orginal-font-size="14" data-orginal-line-height="21" data-orginal-letter-spacing="0"></td>
         </tr>
     </tbody>
 </table>
