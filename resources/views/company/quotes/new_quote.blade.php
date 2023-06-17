@if($allowedNewQuote)
<div class="row form-group">
	<label for="email" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email_notification')</label>
	<div class="col-sm-9">
		{!! form_dropdown('email_notification', emailNotificationDropDown(), $quoteSettings->email_notification, [
			'class' => 'ui dropdown input-sm w-100',
			'required' => true,
			'id' => 'email_notification',
		]) !!}
	</div>
</div>
@php
	$payment_type = '';
	$policy_term = '';
@endphp

@if($quoteSettings->quick_quote == '6')
	@php
		$policy_term = '6 Months'
	@endphp
@elseif($quoteSettings->quick_quote == '12')
	@php
		$policy_term = '12 Months'
	@endphp
@endif

@if($quoteSettings->line_business == 'commercial')
	@php
		$payment_type = strtolower($quoteSettings->payment_type_commercial)
	@endphp
@elseif($quoteSettings->line_business == 'personal')
	@php
		$payment_type = strtolower($quoteSettings->payment_type_personal)
	@endphp
@endif

@php
	$payment_type = ($payment_type == 'coupons' || $payment_type == 'ach') ? $payment_type : 'coupons';
@endphp

<div class="row form-group">
	<label for="email" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.line_of_business')</label>
	<div class="col-sm-9 account_type">
		<div class="zinput zradio zradio-sm  zinput-inline  p-0">
			<input id="line_of_business_commercial" name="account_type" type="radio"
				required class="form-check-input" value="commercial" {{$quoteSettings->line_business == "commercial" ? 'checked' : ''}}>
			<label for="line_of_business_commercial" class="form-check-label">@lang('labels.commercial')</label>
		</div>
		@if($quoteSettings->personal_lines && $quoteSettings->personal_lines == 1)
		<div class="zinput zradio zradio-sm  zinput-inline  p-0">
			<input id="line_of_business_personal" name="account_type" type="radio"
				required class="form-check-input" value="personal" {{$quoteSettings->line_business == "personal" ? 'checked' : ''}}>
			<label for="line_of_business_personal" class="form-check-label">@lang('labels.personal')</label>
		</div>
		@endif
	</div>
</div>

<div class="row form-group">
	<label for="quote_type" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.quote_type')</label>
	<div class="col-sm-9">
		<div class="zinput zradio zradio-sm zinput-inline  p-0">
			<input id="quote_type_new" name="quote_type" type="radio"
				required class="form-check-input" value="new" {{$quoteSettings->quote_type == "New" ? 'checked' : ''}}>
			<label for="quote_type_new" class="form-check-label">@lang('labels.new')</label>
		</div>
		<div class="zinput zradio zradio-sm zinput-inline  p-0">
			<input id="quote_type_renewal" name="quote_type" type="radio"
				required class="form-check-input" value="renewal" {{$quoteSettings->quote_type == "Renewal" ? 'checked' : ''}}>
			<label for="quote_type_renewal" class="form-check-label">@lang('labels.renewal')</label>
		</div>
	</div>
</div>

<div class="row form-group">
	<label for="rate_table" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.rate_table')</label>
	<div class="col-sm-9">
		{!! form_dropdown('rate_table', $agent_rate_table, '', [
			'class' => 'ui dropdown input-sm w-100',
			'required' => true,
			'id' => 'rate_table',
		]) !!}
	</div>
</div>

<div class="row form-group">
	<label for="origination_state" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.origination_state')</label>
	<div class="col-sm-9">
		<div class="zinput zradio zradio-sm  zinput-inline  p-0">
			<input id="origination_state_insured_physical" name="origination_state"
				type="radio" required class="form-check-input" value="insured_physical" {{$quoteSettings->loan_origination_state == "insured_physical" ? 'checked' : ''}}>
			<label for="origination_state_insured_physical" class="form-check-label">@lang('labels.physical_risk_address_insured') </label>
		</div>
		<div class="zinput zradio zradio-sm  zinput-inline  p-0">
			<input id="origination_state_insured_mailing" name="origination_state"
				type="radio" required class="form-check-input" value="insured_mailing" {{$quoteSettings->loan_origination_state == "insured_mailing" ? 'checked' : ''}}>
			<label for="origination_state_insured_mailing" class="form-check-label">@lang('labels.mailing_address_insured')</label>
		</div>
		<div class="zinput zradio zradio-sm  zinput-inline  p-0">
			<input id="origination_state_agent" name="origination_state"
				type="radio" required class="form-check-input" value="agent" {{$quoteSettings->loan_origination_state == "agent" ? 'checked' : ''}}>
			<label for="origination_state_agent" class="form-check-label">@lang('labels.agent')</label>
		</div>
	</div>
</div>

<div class="row form-group">
	<label for="payment_method" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.payment_method')</label>
	<div class="col-sm-9">
		@if($quoteSettings->coupon_payment)
		<div class="zinput zradio zradio-sm  zinput-inline  p-0">
			<input id="payment_method_coupons" name="payment_method" checked
				type="radio" required class="form-check-input" value="coupons" {{ $payment_type == "coupons" ? 'checked' : '' }}>
			<label for="payment_method_coupons" class="form-check-label">@lang('labels.coupons')</label>
		</div>
		@endif
		@if($quoteSettings->ach_payment)
		<div class="zinput zradio zradio-sm  zinput-inline  p-0">
			<input id="payment_method_ach" name="payment_method"
				type="radio" required class="form-check-input" value="ach">
			<label for="payment_method_ach" class="form-check-label">@lang('labels.ach')</label>
		</div>
		@endif
		@if($quoteSettings->credit_card_payment)
		<div class="zinput zradio zradio-sm  zinput-inline  p-0">
			<input id="payment_method_credit_card" name="payment_method"
				type="radio" required class="form-check-input" value="credit_card">
			<label for="payment_method_credit_card" class="form-check-label">@lang('labels.credit_card')</label>
		</div>
		@endif
	</div>
</div>
<div class="version_section mt-4">
	<div class="row mb-4">
		<div class="col-md-4">
			<div class="columns">
				<div class="ui selection dropdown table-head-dropdown">
					<input type="hidden" x-bind:value=open /><i class="dropdown icon"></i>
					<div class="text" x-text="title">Version 1</div>
				</div>
			</div>
		</div>
	</div>

	<div x-show="open == 'version1'">
		<x-quote-policy :quoteSetting="$quoteSettings"/>

		<div class="form-group row">
			<div class="col-sm-3"></div>
			<div class="col-sm-9">
				<x-button-group :cancel="routeCheck($route . 'index')"/>
			</div>
		</div>
	</div>
</div>

@else
    @if (!empty($notallowedMsg))
        <div class="alert alert-danger" role="alert">
                {{$notallowedMsg}}
        </div>
    @endif
@endif
