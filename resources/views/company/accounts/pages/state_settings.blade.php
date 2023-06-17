<x-table id="viewstatesettings" class="table table-bordered table-hover" :noToggle="true">
    <thead style="display: none;">
        <tr>
            <th class="align-middle" style="width: 300px; font-size: 14px;" data-field="Title">
                <div class="th-inner "></div>
                <div class="fht-cell"></div>
            </th>
            <th>
                <div class="th-inner "></div>
                <div class="fht-cell"></div>
            </th>
            <th data-field="Titles">
                <div class="th-inner "></div>
                <div class="fht-cell"></div>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr data-index="0">
            <td>@lang('labels.state_name')</td>
            <td colspan="2">{{ $stateData?->state_name ?? '' }}</td>
        </tr>
        <tr data-index="1">
            <td>@lang('labels.interest_spread_method') </td>
            <td colspan="2">
                {{ !empty($stateData?->spread_method) ? rateTableDropDown($stateData?->spread_method) : '' }}</td>
        </tr>
        <tr data-index="2">
            <td>@lang('labels.no_refund_required_if_less_than')</td>
            <td colspan="2"> @money($stateData?->refund_required ?? '0.00')</td>
        </tr>
        <tr data-index="3">
            <td>@lang('labels.interest_earned_start_date')</td>
            <td colspan="2">{{ $stateData?->interest_earned_start_date ?? '' }}</td>
        </tr>
        <tr data-index="4">
            <td>@lang('labels.interest_earned_stop_date') </td>
            <td colspan="2">{{ $stateData?->interest_earned_stop_date ?? '' }}</td>
        </tr>
        <tr data-index="5">
            <td>@lang('labels.licensed_for_personal')</td>
            <td colspan="2">{{ $stateData?->licensed_personal ?? '' }}</td>
        </tr>


        <tr data-index="6">
            <td>@lang('labels.nsf_fees')</td>
            <td>{{ $stateData?->percentage_nsf_fee ?? '' }}% <span class="ml-5" style="font-size: 14px;">{{ !empty($stateData->nsf_fee_lesser_greater) ? 'OR' : '+' }}</span> <span class="ml-5" style="font-size: 14px;">@money($stateData?->nsf_fees ?? '0.00')</span>
                {{ !empty($stateData->nsf_fee_lesser_greater) ? ucfirst($stateData->nsf_fee_lesser_greater) : '' }}
            </td>
        </tr>
        <tr data-index="7">
            <td>@lang('labels.licensed_for_commercial')</td>
            <td colspan="2">{{ $stateData?->licensed_commercial ?? '' }}</td>
        </tr>
        <tr data-index="8">
            <td>@lang('labels.maximum_charge_off')</td>
            <td colspan="2">@money($stateData?->maximum_charge ?? '0.00')</td>
        </tr>
        <tr data-index="9">
            <td>@lang('labels.agent_authority_to_sign_contracts')</td>
            <td colspan="2">{{ $stateData?->agent_authority ?? '' }} </td>

        </tr>
        <tr data-index="10">
            <td>@lang('labels.can_late_fees_accrue')</td>
            <td colspan="2">{{ $stateData?->late_fees ?? '' }}</td>
        </tr>
        <tr data-index="11">
            <td>@lang('labels.refund_payable_to')</td>
            <td colspan="2">{{ $stateData?->refund_payable ?? '' }}</td>
        </tr>
        <tr data-index="12">
            <td>@lang('labels.refund_send_check_to')</td>
            <td colspan="2">{{ $stateData?->refund_send_check ?? '' }}</td>
        </tr>
        <tr data-index="13">
            <td></td>
            <td><b data-orginal-line-height="21">@lang('labels.personal_account')
                </b></td>
            <td><b data-orginal-line-height="21">
                    @lang('labels.commercial_account') </b></td>
        </tr>
        <tr data-index="14">
            <td>@lang('labels.maximum_finance_amount')</td>
            <td>@money($stateData?->personal_maximum_finance_amount ?? '0.00')</td>
            <td>@money($stateData?->commercial_maximum_finance_amount ?? '0.00')</td>
        </tr>
        <tr data-index="14">
            <td>@lang('labels.minimum_earned_interest')</td>
            <td>@money($stateData?->minimum_interest ?? '0.00')</td>
            <td>@money($stateData?->comm_minimum_interest ?? '0.00')</td>
        </tr>
        <tr data-index="15">
            <td>@lang('labels.maximum_interest_rate')</td>
            <td>@empty($stateData->personal_multiple_maximum_rate)
                {{ $stateData->maximum_rate ?? '0' }}%
                @else
                <ul>
                    @if(!empty($stateData->interest_rate['personal_multiple_maximum_rate'] ))
                        @foreach($stateData->interest_rate['personal_multiple_maximum_rate'] as $key => $personalrate)
                            <li>@money($personalrate['from'] ?? '0.00') - @money($personalrate['to'] ?? '0.00') , {{ $personalrate['rate'] ?? 0 }}%</li>
                        @endforeach
                    @endif
                </ul>
                @endempty</td>
            <td>@empty($stateData->personal_multiple_comm_maximum_rate)
                {{ $stateData->comm_maximum_rate ?? '0' }}%
                @else
                <ul>
                    @if(!empty($stateData->interest_rate['personal_multiple_comm_maximum_rate']))
                        @foreach($stateData->interest_rate['personal_multiple_comm_maximum_rate'] as $key => $personalrate)
                            <li> @money($personalrate['from'] ?? '0.00') - @money($personalrate['to'] ?? '0.00') , {{ $personalrate['rate'] ?? 0 }}%</li>
                        @endforeach
                    @endif
                </ul>
                @endempty</td>
        </tr>
        <tr data-index="16">
            <td>@lang('labels.maximum_setup_fee')</td>
            <td>{{ $stateData?->percentage_maximum_setup_fee ?? '' }}% <span class="ml-5" style="font-size: 14px;">{{ !empty($stateData->maximum_setup_fee_lesser_greater) ? 'OR' : '+' }}</span> <span class="ml-5" style="font-size: 14px;">@money($stateData?->maximum_setup_fee ?? '0.00')</span>
                {{ !empty($stateData->maximum_setup_fee_lesser_greater) ? ucfirst($stateData->maximum_setup_fee_lesser_greater) : '' }}</td>
            <td>{{ $stateData?->percentage_comm_maximum_setup_fee ?? '' }}% <span class="ml-5" style="font-size: 14px;">{{ !empty($stateData->maximum_comm_setup_fee_lesser_greater) ? 'OR' : '+' }}</span> <span class="ml-5" style="font-size: 14px;">@money($stateData?->comm_maximum_setup_fee ?? '0.00')</span>
                {{ !empty($stateData->maximum_comm_setup_fee_lesser_greater) ? ucfirst($stateData->maximum_comm_setup_fee_lesser_greater) : '' }}</td>
        </tr>
        <tr data-index="17">
            <td>@lang('labels.setup_fee_percent_in_down')</td>
            <td>{{ $stateData?->setup_Percent ?? '' }}</td>
            <td>{{ $stateData?->comm_setup_Percent ?? '' }}</td>
        </tr>
        <tr data-index="18">
            <td>@lang('labels.days_from_due_date_to_intent_to_cancel')</td>
            <td>{{ $stateData?->due_date_intent_cancel ?? '' }}</td>
            <td>{{ $stateData?->comm_due_date_intent_cancel ?? '' }}</td>
        </tr>
        <tr data-index="19">
            <td>@lang('labels.days_from_intent_to_cancel_to_cancel')
            </td>
            <td>{{ $stateData?->intent_cancel ?? '' }}</td>
            <td>{{ $stateData?->comm_intent_cancel ?? '' }}</td>
        </tr>
        <tr data-index="20">
            <td>@lang('labels.days_from_cancel_to_effective_cancel')
            </td>
            <td>{{ $stateData?->effective_cancel ?? '' }}</td>
            <td>{{ $stateData?->comm_effective_cancel ?? '' }}</td>
        </tr>
        <tr data-index="21">
            <td>@lang('labels.compute_max_setup_fee_per_account')</td>
            <td>{{ $stateData?->max_setup_fee ?? '' }}</td>
            <td>{{ $stateData?->comm_max_setup_fee ?? '' }}</td>
        </tr>
        <tr data-index="22">
            <td>@lang('labels.late_fee')</td>
            <td>{{ $stateData->state_setting['percentage_late_fee'] ?? '0' }}% <span class="ml-5" style="font-size: 14px;">{{ !empty($stateData->state_setting['late_fee_lesser_greater']) ? 'OR' : '+' }}</span> <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['late_fee'] ?? '0.00')</span>
                {{ !empty($stateData->state_setting['late_fee_lesser_greater']) ? ucfirst($stateData->state_setting['late_fee_lesser_greater']) : '' }}</td>
             <td>{{ $stateData?->percentage_comm_maximum_setup_fee ?? '' }}% <span class="ml-5" style="font-size: 14px;">{{ !empty($stateData->state_setting['late_fee_lesser_greater']) ? 'OR' : '+' }}</span> <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['comm_late_fee']  ?? '0.00')</span>
                {{ !empty($stateData->late_fee_lesser_greater_comm) ? ucfirst($stateData->late_fee_lesser_greater_comm) : '' }}</td>
        </tr>
        <tr data-index="23">
            <td>@lang('labels.minimum_late_fee')</td>
            <td>{{ $stateData->state_setting['percentage_minimum_late_fee'] ?? '0' }}% <span class="ml-5" style="font-size: 14px;">+</span> <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['minimum_late_fee'] ?? '0.00')</span></td>
            <td>{{ $stateData->state_setting['percentage_comm_minimum_late_fee'] ?? '' }}%<span class="ml-5" style="font-size: 14px;">+</span> <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['comm_minimum_late_fee'] ?? '0.00')</span></td>
        </tr>
        <tr data-index="24">
            <td>@lang('labels.maximum_late_fee')</td>
            <td>{{ $stateData->state_setting['percentage_maximum_late_fee'] ?? '0' }}% <span class="ml-5" style="font-size: 14px;">+</span> <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['percentage_comm_maximum_late_fee'] ?? '0.00')</span></td>
            <td>{{ $stateData->state_setting['percentage_comm_maximum_late_fee'] ?? '0' }}% <span class="ml-5" style="font-size: 14px;">+</span> <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['comm_maximum_late_fee'] ?? '0.00')</span></td>
        </tr>
        <tr data-index="25">
            <td>@lang('labels.days_before_late_fee')</td>
            <td>{{ $stateData->state_setting['day_before_late_fee'] ?? '0' }}</td>
            <td>{{ $stateData->state_setting['comm_day_before_late_fee'] ?? '0' }}</td>
        </tr>
        <tr data-index="26">
            <td>@lang('labels.cancellation_fee')</td>
            <td>@money($stateData->state_setting['cancellation_fee'] ?? '0.00')</td>
            <td>@money($stateData->state_setting['comm_cancellation_fee'] ?? '0.00')</td>
        </tr>
        <tr data-index="27">
            <td>@lang('labels.other_fee_for_credit_card')</td>
            <td>{{ $stateData->state_setting['percentage_fee_credit_card'] ?? '0' }}% <span class="ml-5" style="font-size: 14px;">+</span> 
            <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['fee_credit_card'] ?? '0.00')</span></td>
            <td>{{ $stateData->state_setting['percentage_comm_fee_credit_card'] ?? '0' }}% <span class="ml-5" style="font-size: 14px;">+</span>
             <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['comm_fee_credit_card'] ?? '0.00')</span></td>
        </tr>
        <tr data-index="28">
            <td>@lang('labels.other_fee_for_echecks_ach')</td>
            <td>{{ $stateData->state_setting['percentage_check_credit_card'] ?? '0' }}% <span class="ml-5" style="font-size: 14px;">+</span> 
            <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['check_credit_card'] ?? '0.00')</span></td>
            <td>{{ $stateData->state_setting['percentage_comm_check_credit_card'] ?? '0' }}% <span class="ml-5" style="font-size: 14px;">+</span> 
            <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['comm_check_credit_card'] ?? '0.00')</span></td>
        </tr>
        <tr data-index="29">
            <td>@lang('labels.other_fee_for_recurring_credit_card')</td>
            <td>{{ $stateData->state_setting['percentage_recurring_credit_card'] ?? '0' }}% <span class="ml-5" style="font-size: 14px;">+</span> 
            <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['check_credit_card'] ?? '0.00')</span></td>
            <td>{{ $stateData->state_setting['percentage_check_credit_card'] ?? '0' }}% <span class="ml-5" style="font-size: 14px;">+</span> 
            <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['comm_recurring_credit_card'] ?? '0.00')</span></td>
        </tr>
        <tr data-index="30">
            <td>@lang('labels.other_fee_for_recurring_echecks_ach')</td>
            <td>{{ $stateData->state_setting['percentage_check_credit_card'] ?? '0' }}% <span class="ml-5" style="font-size: 14px;">+</span> 
            <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['recurring_credit_card'] ?? '0.00')</span></td>
            <td>{{ $stateData->state_setting['percentage_comm_recurring_credit_card'] ?? '0' }}% <span class="ml-5" style="font-size: 14px;">+</span> 
            <span class="ml-5" style="font-size: 14px;">@money($stateData->state_setting['comm_recurring_credit_card'] ?? '0.00')</span></td>
        </tr>
        <tr data-index="31">
            <td>@lang('labels.agent_rebates')</td>
            <td>{{ $stateData->state_setting['agent_rebates'] ?? '0' }}</td>
            <td>{{ $stateData->state_setting['comm_agent_rebates'] ?? '0' }}</td>
        </tr>
        <tr data-index="32">
            <td>@lang('labels.default_policies_to_short_rate')</td>
            <td>{{ $stateData->state_setting['policies_short_rate'] ?? '0' }}</td>
            <td>{{ $stateData->state_setting['comm_policies_short_rate'] ?? '0' }}</td>
        </tr>
    </tbody>
</x-table>
