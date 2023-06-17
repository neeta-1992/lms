@php
        $disabled = "";
        $quoteStatus =  !empty($quoteData->status) ? $quoteData->status : '' ;
        if($quoteStatus >= 2){
            $disabled = "disabled";
        }
    @endphp
<div class="terms">
    <div class="row align-items-end page_table_menu">

        <div class="col-md-12">
            <div class="row align-items-end">
                <div class="col-md-6 ">
                </div>
                <div class="col-md-6 ">
                    <div class="columns d-flex justify-content-end ">
                        @if(!empty($quoteVersion->favourite))
                            <button class="btn btn-default borderless" type="button"> <i class="fa-solid fa-star text-warning mr-1"></i>@lang('labels.favorite') </button>
                        @else
                           @if(empty($disabled))
                            <button class="btn btn-default borderless" type="button" x-on:click="favorite('{{ $quoteVersion->id ?? '' }}',$el)"> <i class="fa-duotone fa-star mr-1"></i>@lang('labels.favorite') </button>
                           @else
                            <button class="btn btn-default borderless" type="button"> <i class="fa-duotone fa-star mr-1"></i>@lang('labels.favorite') </button>
                          @endif
                        @endif
                        @if(empty($disabled))
                            <button class="btn btn-default borderless" type="button" x-on:click="cloneVersion('{{ $quoteVersion->id ?? '' }}',$el)">@lang('labels.clone_version')</button>
                            <button class="btn btn-default borderless" type="button" x-on:click="open = 'newVersion'">@lang('labels.new_version')</button>
                            <button class="btn btn-default borderless" type="button" x-on:click="open = 'terms'">@lang('labels.delete_version')</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2"><strong>Total pure premium: @money(($quoteTerm?->pure_premium ?? 0)) Total Premium (incl. Fees): @money(($quoteTerm?->total_premium ?? 0))</strong> Entered on <strong>{{changeDateFormat($quoteData->created_at)}} by {{ $quoteData->user->name ?? '' }}</strong></td>
        </tr>
        <tr>
            <td class="w-50">
                <div class="termsPayment">
                    <input type="hidden" name="quote" value="{{ $quoteTerm?->quote ?? '' }}"/>
                    <input type="hidden" name="version" value="{{ $quoteTerm?->version ?? '' }}"/>
                    <div class="form-group row">
                        <label for="tin" class="col-sm-6 col-form-label ">@lang('labels.billing_schedule')</label>
                        <div class="col-sm-6">
                        @php
                            $billingScheduleArr = ['Monthly'=>'Monthly'];
                            $billingSchedule = !empty($quoteSetting?->billing_schedule) ? $quoteSetting?->billing_schedule : [];
                            if(!empty($billingSchedule)){
                                $billingSchedule = !empty($billingSchedule) ? explode(",",$billingSchedule) : '' ;
                                foreach ($billingSchedule as $item){
                                    $value = Str::of($item)->headline()?->value;
                                    $key   = Str::of($item)->headline()->replace(" ","-")?->value;
                                    $billingScheduleArr[$key] =  $value;
                                }
                            }
                            
                            
                        @endphp
                            <x-select :options="($billingScheduleArr ?? [])"   name="billing_schedule" id="billing_schedule" selected="{{ $quoteTerm?->billing_schedule ?? '' }}" class="ui dropdown billing_schedule {{ $disabled ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tin" class="col-sm-6 col-form-label ">@lang('labels.number_of_payments')</label>
                        <div class="col-sm-6">
                            <x-jet-input type="text" name="number_of_payment" class="digitLimit" data-limt="2" value="{{ $quoteTerm?->number_of_payment ?? '' }}"  :disabled="(!empty($disabled) ? true : false)"    />
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="tin" class="col-sm-6 col-form-label ">@lang('labels.total_down_payment')</label>
                        <div class="col-sm-6 d-flex align-items-center">
                            <x-jet-input type="text" name="down_amount" value="{{ $quoteTerm?->down_payment ?? '' }}" class="amount w-75 "  :disabled="(!empty($disabled) ? true : false)" />
                            <div class="w-10 pl-1 pr-1">/</div>
                            <x-jet-input type="text" name="down_percentage" value="{{ $quoteTerm?->down_percent  ?? '' }}" class="percentage_input w-25"  :disabled="(!empty($disabled) ? true : false)" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tin" class="col-sm-6 col-form-label ">@lang('labels.setup_fee_in_down_payment')</label>
                        <div class="col-sm-6">
							<div class="form-control  input-sm">@money($quoteTerm?->setup_fee  ?? '0.00' )</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tin" class="col-sm-6 col-form-label ">@lang('labels.inception_date')</label>
                        <div class="col-sm-6">
                          <div class="form-control  input-sm">{{ !empty($quoteTerm?->inception_date) ? date('m/d/Y',strtotime($quoteTerm?->inception_date)) : '' }} </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tin" class="col-sm-6 col-form-label ">@lang('labels.first_payment_due_date')</label>
                        <div class="col-sm-6">
                            <x-jet-input type="text" name="first_payment_due_date"   class="singleDatePicker"  value="{{ !empty($quoteTerm?->first_payment_due_date) ? date('m/d/Y',strtotime($quoteTerm?->first_payment_due_date)) : '' }}" :disabled="(!empty($disabled) ? true : false)" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tin" class="col-sm-6 col-form-label ">@lang('labels.interest_rate')</label>
                        <div class="col-sm-6">
                            <x-jet-input type="text" name="interest_rate"   class="percentage_input" value="{{ $quoteTerm?->interest_rate ?? '' }}" :disabled="(!empty($disabled) ? true : false)" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tin" class="col-sm-6 col-form-label ">@lang('labels.total_setup_fee')</label>
                        <div class="col-sm-6">
                           <div class="form-control  input-sm">@money($quoteTerm?->total_setup_fee  ?? '0.00' )</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tin" class="col-sm-6 col-form-label ">@lang('labels.monthly_due_date')</label>
                        <div class="col-sm-6">
                          <div class="form-control  input-sm">{{date("jS",strtotime($quoteTerm?->first_payment_due_date))}}</div>
                        </div>
                    </div>
                </div>
				
            </td>
            <td class="w-50">
                <div class="form-group row">
                    <label for="tin" class="col-sm-12 col-form-label ">@lang('labels.account_summary')</label>
                </div>
                <div class="row">
                    <label for="tin" class="col-sm-7 col-form-label">@lang('labels.payment_amount')</label>
                    <span class="col-sm-5">@money($quoteTerm?->payment_amount ?? 0)</span>
                </div>
                <div class="row">
                    <label for="tin" class="col-sm-7 col-form-label">@lang('labels.effective_apr')</label>
                    <span class="col-sm-5">{{ $quoteTerm?->effective_apr ?? '' }}%</span>
                </div>
                <div class="row">
                    <label for="tin" class="col-sm-7 col-form-label">@lang('labels.number_of_payments')</label>
                    <span class="col-sm-5">{{ $quoteTerm?->number_of_payment ?? '' }}</span>
                </div>
                <div class="row">
                    <label for="tin" class="col-sm-7 col-form-label">@lang('labels.amount_financed')</label>
                    <span class="col-sm-5">@money(($quoteTerm?->amount_financed+$quoteTerm?->doc_stamp_fees) ?? 0)</span>
                </div>
                <div class="row  shift_from_left">
                    <label for="tin" class="col-sm-4 col-form-label">@lang('labels.premium_financed')</label>
                    <span class="col-sm-8">@money($quoteTerm?->amount_financed ?? 0)</span>
                </div>
                <div class="row shift_from_left">
                    <label for="tin" class="col-sm-4 col-form-label">@lang('labels.doc_stamp_fee')</label>
                    <span class="col-sm-8">@money($quoteTerm?->doc_stamp_fees ?? 0)</span>
                </div>
                <div class="row">
                    <label for="tin" class="col-sm-7 col-form-label">@lang('labels.finance_charge')</label>
                    <span class="col-sm-5">@money($quoteTerm?->total_interest_with_setup_fee ?? 0)</span>
                </div>
                <div class="row shift_from_left">
                    <label for="tin" class="col-sm-4 col-form-label">@lang('labels.interest')</label>
                    <span class="col-sm-8">@money($quoteTerm?->total_interest ?? 0)</span>
                </div>
                <div class="row shift_from_left">
                    <label for="tin" class="col-sm-4 col-form-label">@lang('labels.setup_fee_unpaid')</label>
                    <span class="col-sm-8">@money($quoteTerm?->setup_fee ?? 0)</span>
                </div>
				<div class="row">
                    <label for="tin" class="col-sm-7 col-form-label">@lang('labels.total_payments')</label>
                    <span class="col-sm-5">@money($quoteTerm?->total_payment ?? 0)</span>
                </div>
				<div class="row">
                    <label for="tin" class="col-sm-7 col-form-label">@lang('labels.agent_compensation')</label>
                    <span class="col-sm-5">@money($quoteTerm?->compensation ?? 0)</span>
                </div>
            </td>
        </tr>
		<tr>
			<td colspan="2">
				<div class="d-flex">
					<div class="mt-1">
						<x-jet-checkbox for="loan_payment_schedule" labelText="Loan Payment Schedule"
						name="loan_payment_schedule" id="loan_payment_schedule"/>
					</div>
					<div class="mt-1">
						<x-jet-checkbox for="quote_exposure" labelText="Quote Exposure"
						name="quote_exposure" id="quote_exposure"/>
					</div>
					<div class="mt-1 ml-2">
						<x-jet-checkbox for="view_agent_compensation" labelText="View Agent Compensation"
						name="view_agent_compensation" id="view_agent_compensation"/>
					</div>
					<div class="mt-1 ml-2">
						<x-jet-checkbox for="view_down_payment_rule" labelText="View Down Payment Rule"
						name="view_down_payment_rule" id="view_down_payment_rule"/>
					</div>
				</div>
			</td>
		</tr>
    </table>
	
	<div class="loan_payment_schedule_box" style="display:none;">
		{!! \App\Helpers\QuoteHelper::getLoanPaymentSchedule($quoteTerm?->quote,$quoteTerm?->version) !!}
	</div>
	<div class="quote_exposure_box" style="display:none;">
		{!! \App\Helpers\QuoteHelper::getQuoteExposure($quoteTerm?->quote,$quoteTerm?->version) !!}
	</div>
	<div class="agent_compensation_box" style="display:none;">
		{!! \App\Helpers\QuoteHelper::getAgentCompensationDetails($quoteTerm?->quote,$quoteTerm?->version) !!}
	</div>
	<div class="down_payment_rule_box" style="display:none;">
		{!! \App\Helpers\QuoteHelper::getDownPaymentRuleDetails($quoteTerm?->quote,$quoteTerm?->version) !!}
	</div>
</div>
