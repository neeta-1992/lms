<x-app-layout>
    <x-jet-form-section  :buttonGroup="['logs']" :activePageName="$activePage" class="validationForm editForm" :title="$pageTitle" novalidate action="{{ routeCheck($route . 'quotes-settings') }}" method="post">
        @slot('form')
            <input type="hidden" name="logsArr">
            <div class="">
                <p class="fw-600">Defaults</p>
            </div>
            <div class="row">
                <label for="" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.loan_origination_state')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="insured_physical" name="loan_origination_state" type="radio" required
                            class="form-check-input" value="insured_physical">
                        <label for="insured_physical" class="form-check-label ml-0">
                            @lang('labels.insured_physical')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="insured_mailing" name="loan_origination_state" type="radio" required
                            class="form-check-input" value="insured_mailing">
                        <label for="insured_mailing" class="form-check-label ml-0">
                            @lang('labels.insured_mailing')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="loan_origination_state_agent" name="loan_origination_state" type="radio" required
                            class="form-check-input" value="agent">
                        <label for="loan_origination_state_agent" class="form-check-label ml-0">
                            @lang('labels.agent')
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <label for="" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.line_business')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="line_business_commercial" name="line_business" type="radio" required
                            class="form-check-input" value="commercial">
                        <label for="line_business_commercial" class="form-check-label ml-0">
                            @lang('labels.commercial')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="line_business_personal" name="line_business" type="radio" required
                            class="form-check-input" value="personal">
                        <label for="line_business_personal" class="form-check-label ml-0">
                            @lang('labels.personal')
                        </label>
                    </div>

                </div>
            </div>


            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.policy_minium_earned_percent')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="policy_minium_earned_percent" required class="percentageInput" />
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.number_until_first_payment')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="until_first_payment" required class="digitLimit" data-limit="3"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.number_first_due_date')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="first_due_date" required class="digitLimit" data-limit="3"/>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.number_new_quote_expiration')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="new_quote_expiration" required class="digitLimit" data-limit="3"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.renewal_quote_expiration')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="renewal_quote_expiration" required class="digitLimit" data-limit="3"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.insured_payment_type_commercial')</label>
                <div class="col-sm-8">
                    {!! form_dropdown(
                        'payment_type_commercial',
                        ['Coupons', 'ACH', 'Statement'],
                        '',
                        ['class' => 'w-100', 'required' => 1],
                        1,
                    ) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.insured_payment_type_personal')</label>
                <div class="col-sm-8">
                    {!! form_dropdown(
                        'payment_type_personal',
                        ['Coupons', 'ACH', 'Statement'],
                        '',
                        ['class' => 'w-100', 'required' => 1],
                        1,
                    ) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.company_stamp_fees')</label>
                <div class="col-sm-8">
                    {!! form_dropdown('stamp_fees', [], '', ['class' => 'w-100',], 1) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label">@lang('labels.doc_stamp_fees')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="doc_stamp_fees" class="amount" />

                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.down_percent')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="down_percent" class="percentageInput" />
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.quick_quote')</label>
                <div class="col-sm-8">
                    {!! form_dropdown('quick_quote', ['6' => '6 Months', '12' => '12 Months'], '', [
                        'class' => 'w-100',
                        'required' => 1,
                    ]) !!}
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.ofac_compliance')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="ofac_compliance_pass" name="ofac_compliance" type="radio" class="form-check-input"
                            value="pass">
                        <label for="ofac_compliance_pass" class="form-check-label ml-0">
                            @lang('labels.pass')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="ofac_compliance_fail" name="ofac_compliance" type="radio" class="form-check-input"
                            value="fail">
                        <label for="ofac_compliance_fail" class="form-check-label ml-0">
                            @lang('labels.fail')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.billing_schedule') (Other than monthly)</label>
                <div class="col-sm-8">
                    <x-jet-checkbox for="billing_schedule_quarterly" labelText="{{ __('labels.quarterly') }}"
                        name="billing_schedule[]" id="billing_schedule_quarterly" value="quarterly" />
                    <x-jet-checkbox for="billing_schedule_semi_annually" labelText="{{ __('labels.semi_annually') }}"
                        name="billing_schedule[]" id="billing_schedule_semi_annually" value="semi_annually" />
                    <x-jet-checkbox for="billing_schedule_annually" labelText="{{ __('labels.annually') }}"
                        name="billing_schedule[]" id="billing_schedule_annually" value="annually" />
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.quote_type')</label>
                <div class="col-sm-8">
                    {!! form_dropdown('quote_type', ['New', 'Renewal'], '', ['class' => 'w-100', 'required' => 1], 1) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.email_notification')</label>
                <div class="col-sm-8">
                    {!! form_dropdown('email_notification', ['insured' => 'Insured', 'agent' => 'Agent'], '', [
                        'class' => 'w-100',
                        'required' => 1,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.personal_maximum_finance_amount')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="personal_maximum_finance_amount" class="amount w-25" />
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.commercial_maximum_finance_amount')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="commercial_maximum_finance_amount" class="amount w-25" />
                </div>
            </div>
            <div class="mb-3">
                <p class="fw-600">Required Fields Options</p>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.short_rate')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="short_rate_required" name="short_rate" required type="radio"
                            class="form-check-input" value="1">
                        <label for="short_rate_required" class="form-check-label ml-0">
                            @lang('labels.required')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="short_rate_not_required" name="short_rate" required type="radio"
                            class="form-check-input" value="0">
                        <label for="short_rate_not_required" class="form-check-label ml-0">
                            @lang('labels.not_required')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.require_insured_phone')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="require_insured_phone_required" required name="require_insured_phone" type="radio"
                            class="form-check-input" value="1">
                        <label for="require_insured_phone_required" class="form-check-label ml-0">
                            @lang('labels.required')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="require_insured_phone_not_required" required name="require_insured_phone"
                            type="radio" class="form-check-input" value="0">
                        <label for="require_insured_phone_not_required" class="form-check-label ml-0">
                            @lang('labels.not_required')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.proprietor_require')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="proprietor_require_required" required name="proprietor_require" type="radio"
                            class="form-check-input" value="1">
                        <label for="proprietor_require_required" class="form-check-label ml-0">
                            @lang('labels.required')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="proprietor_require_not_required" required name="proprietor_require" type="radio"
                            class="form-check-input" value="0">
                        <label for="proprietor_require_not_required" class="form-check-label ml-0">
                            @lang('labels.not_required')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.puc_filings')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="puc_filings_required" required name="puc_filings" type="radio"
                            class="form-check-input" value="1">
                        <label for="puc_filings_required" class="form-check-label ml-0">
                            @lang('labels.required')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="puc_filings_not_required" required name="puc_filings" type="radio"
                            class="form-check-input" value="0">
                        <label for="puc_filings_not_required" class="form-check-label ml-0">
                            @lang('labels.not_required')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.auditable')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="auditable_required" required name="auditable" type="radio" class="form-check-input"
                            value="1">
                        <label for="auditable_required" class="form-check-label ml-0">
                            @lang('labels.required')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="auditable_not_required" required name="auditable" type="radio"
                            class="form-check-input" value="0">
                        <label for="auditable_not_required" class="form-check-label ml-0">
                            @lang('labels.not_required')
                        </label>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <p class="fw-600">Enable/Disable Options</p>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.personal_lines')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="personal_lines_required" required name="personal_lines" type="radio"
                            class="form-check-input" value="1">
                        <label for="personal_lines_required" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="personal_lines_not_required" required name="personal_lines" type="radio"
                            class="form-check-input" value="0">
                        <label for="personal_lines_not_required" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.coupon_payment')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="coupon_payment_required" required name="coupon_payment" type="radio"
                            class="form-check-input" value="1">
                        <label for="coupon_payment_required" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="coupon_payment_not_required" required name="coupon_payment" type="radio"
                            class="form-check-input" value="0">
                        <label for="coupon_payment_not_required" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.credit_card_payment')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="credit_card_payment_required" required name="credit_card_payment" type="radio"
                            class="form-check-input" value="1">
                        <label for="credit_card_payment_required" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="credit_card_payment_not_required" required name="credit_card_payment" type="radio"
                            class="form-check-input" value="0">
                        <label for="credit_card_payment_not_required" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.ach_payment')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="ach_payment_required" required name="ach_payment" type="radio"
                            class="form-check-input" value="1">
                        <label for="ach_payment_required" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="ach_payment_not_required" required name="ach_payment" type="radio"
                            class="form-check-input" value="0">
                        <label for="ach_payment_not_required" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.request_activation')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="request_activation_required" required name="request_activation" type="radio"
                            class="form-check-input" value="1">
                        <label for="request_activation_required" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="request_activation_not_required" required name="request_activation" type="radio"
                            class="form-check-input" value="0">
                        <label for="request_activation_not_required" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.quote_activation')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="quote_activation_required" required name="quote_activation" type="radio"
                            class="form-check-input" value="1">
                        <label for="quote_activation_required" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="quote_activation_not_required" required name="quote_activation" type="radio"
                            class="form-check-input" value="0">
                        <label for="quote_activation_not_required" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.broker_field')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="broker_field_required" required name="broker_field" type="radio"
                            class="form-check-input" value="1">
                        <label for="broker_field_required" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="broker_field_not_required" required name="broker_field" type="radio"
                            class="form-check-input" value="0">
                        <label for="broker_field_not_required" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.policy_fee_commercial')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="policy_fee_commercial_financed" required name="policy_fee_commercial" type="radio"
                            class="form-check-input" value="financed">
                        <label for="policy_fee_commercial_financed" class="form-check-label ml-0">
                            @lang('labels.financed')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="policy_fee_commercial_included_down_payment" required name="policy_fee_commercial"
                            type="radio" class="form-check-input" value="down_payment">
                        <label for="policy_fee_commercial_included_down_payment" class="form-check-label ml-0">
                            @lang('labels.included_down_payment')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.policy_fee_personal')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="policy_fee_personal_financed" required name="policy_fee_personal" type="radio"
                            class="form-check-input" value="financed">
                        <label for="policy_fee_personal_financed" class="form-check-label ml-0">
                            @lang('labels.financed')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="policy_fee_personal_included_down_payment" required name="policy_fee_personal"
                            type="radio" class="form-check-input" value="down_payment">
                        <label for="policy_fee_personal_included_down_payment" class="form-check-label ml-0">
                            @lang('labels.included_down_payment')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.unearned_fees')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="unearned_fees_financed" required name="unearned_fees" type="radio"
                            class="form-check-input" value="financed">
                        <label for="unearned_fees_financed" class="form-check-label ml-0">
                            @lang('labels.financed')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="unearned_fees_included_down_payment" required name="unearned_fees" type="radio"
                            class="form-check-input" value="down_payment">
                        <label for="unearned_fees_included_down_payment" class="form-check-label ml-0">
                            @lang('labels.included_down_payment')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.tax_stamp_commercial')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="tax_stamp_commercial_financed" required name="tax_stamp_commercial" type="radio"
                            class="form-check-input" value="financed">
                        <label for="tax_stamp_commercial_financed" class="form-check-label ml-0">
                            @lang('labels.financed')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="tax_stamp_commercial_included_down_payment" required name="tax_stamp_commercial"
                            type="radio" class="form-check-input" value="down_payment">
                        <label for="tax_stamp_commercial_included_down_payment" class="form-check-label ml-0">
                            @lang('labels.included_down_payment')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.tax_stamp_personal')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="tax_stamp_personal_financed" required name="tax_stamp_personal" type="radio"
                            class="form-check-input" value="financed">
                        <label for="tax_stamp_personal_financed" class="form-check-label ml-0">
                            @lang('labels.financed')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="tax_stamp_personal_included_down_payment" required name="tax_stamp_personal"
                            type="radio" class="form-check-input" value="down_payment">
                        <label for="tax_stamp_personal_included_down_payment" class="form-check-label ml-0">
                            @lang('labels.included_down_payment')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.broker_fee_commercial')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="broker_fee_commercial_financed" required name="broker_fee_commercial" type="radio"
                            class="form-check-input" value="financed">
                        <label for="broker_fee_commercial_financed" class="form-check-label ml-0">
                            @lang('labels.financed')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="broker_fee_commercial_included_down_payment" required name="broker_fee_commercial"
                            type="radio" class="form-check-input" value="down_payment">
                        <label for="broker_fee_commercial_included_down_payment" class="form-check-label ml-0">
                            @lang('labels.included_down_payment')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.broker_fee_personal')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="broker_fee_personal_financed" required name="broker_fee_personal" type="radio"
                            class="form-check-input" value="financed">
                        <label for="broker_fee_personal_financed" class="form-check-label ml-0">
                            @lang('labels.financed')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="broker_fee_personal_included_down_payment" required name="broker_fee_personal"
                            type="radio" class="form-check-input" value="down_payment">
                        <label for="broker_fee_personal_included_down_payment" class="form-check-label ml-0">
                            @lang('labels.included_down_payment')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.inspection_fee_commercial')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="inspection_fee_commercial_financed" required name="inspection_fee_commercial"
                            type="radio" class="form-check-input" value="financed">
                        <label for="inspection_fee_commercial_financed" class="form-check-label ml-0">
                            @lang('labels.financed')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="inspection_fee_commercial_included_down_payment" required
                            name="inspection_fee_commercial" type="radio" class="form-check-input"
                            value="down_payment">
                        <label for="inspection_fee_commercial_included_down_payment" class="form-check-label ml-0">
                            @lang('labels.included_down_payment')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.inspection_fee_personal')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="inspection_fee_personal_financed" required name="inspection_fee_personal"
                            type="radio" class="form-check-input" value="financed">
                        <label for="inspection_fee_personal_financed" class="form-check-label ml-0">
                            @lang('labels.financed')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="inspection_fee_personal_included_down_payment" required name="inspection_fee_personal"
                            type="radio" class="form-check-input" value="down_payment">
                        <label for="inspection_fee_personal_included_down_payment" class="form-check-label ml-0">
                            @lang('labels.included_down_payment')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.calculating_agency')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="calculating_agency_enable" required name="calculating_agency" type="radio"
                            class="form-check-input" value="1">
                        <label for="calculating_agency_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="calculating_agency_included_down_payment" required name="calculating_agency"
                            type="radio" class="form-check-input" value="0">
                        <label for="calculating_agency_included_down_payment" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.insured_existing_balance')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="insured_existing_balance_enable" required name="insured_existing_balance"
                            type="radio" class="form-check-input" value="1">
                        <label for="insured_existing_balance_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="insured_existing_balance_included_down_payment" required
                            name="insured_existing_balance" type="radio" class="form-check-input" value="0">
                        <label for="insured_existing_balance_included_down_payment" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.first_due_dates')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="first_due_dates_enable"  name="first_due_dates" type="radio"
                            class="form-check-input" value="1">
                        <label for="first_due_dates_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="first_due_dates_included_down_payment"  name="first_due_dates" type="radio"
                            class="form-check-input" value="0">
                        <label for="first_due_dates_included_down_payment" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.bank_risk_rating')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="bank_risk_rating_enable"  name="bank_risk_rating" type="radio"
                            class="form-check-input" value="1">
                        <label for="bank_risk_rating_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="bank_risk_rating_disable"  name="bank_risk_rating"
                            type="radio" class="form-check-input" value="0">
                        <label for="bank_risk_rating_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.limit_company')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="limit_company_enable" required name="limit_company" type="radio"
                            class="form-check-input" value="1">
                        <label for="limit_company_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="limit_company_disable" required name="limit_company" type="radio"
                            class="form-check-input" value="0">
                        <label for="limit_company_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.recourse_amount')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="recourse_amount_enable"  name="recourse_amount" type="radio"
                            class="form-check-input" value="1">
                        <label for="recourse_amount_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="recourse_amount_disable"  name="recourse_amount" type="radio"
                            class="form-check-input" value="0">
                        <label for="recourse_amount_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.ap_interest_starts_fixed_days')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="ap_interest_enable"  name="ap_interest" type="radio"
                            class="form-check-input" value="1">
                        <label for="ap_interest_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="ap_interest_disable"  name="ap_interest" type="radio"
                            class="form-check-input" value="0">
                        <label for="ap_interest_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>



            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.ap_endorsement_default_expiration_to_original_policy')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="ap_endorsement_enable"  name="ap_endorsement" type="radio"
                            class="form-check-input" value="1">
                        <label for="ap_endorsement_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="ap_endorsement_disable"  name="ap_endorsement" type="radio"
                            class="form-check-input" value="0">
                        <label for="ap_endorsement_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.default_endorsement_setup_fee_to_state_maximum')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="endorsement_setup_fee_enable" required name="endorsement_setup_fee" type="radio"
                            class="form-check-input" value="1">
                        <label for="endorsement_setup_fee_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="endorsement_setup_fee_disable" required name="endorsement_setup_fee"
                            type="radio" class="form-check-input" value="0">
                        <label for="endorsement_setup_fee_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>



            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.agency_name_e_signature')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="agency_name_sig_enable"  name="agency_name_sig" type="radio"
                            class="form-check-input" value="1">
                        <label for="agency_name_sig_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="agency_name_sig_disable"  name="agency_name_sig" type="radio"
                            class="form-check-input" value="0">
                        <label for="agency_name_sig_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.include_sales_organizations_user_on_request_authorization')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="salesexecs_enable"  name="salesexecs" type="radio" class="form-check-input"
                            value="1">
                        <label for="salesexecs_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="salesexecs_disable"  name="salesexecs" type="radio"
                            class="form-check-input" value="0">
                        <label for="salesexecs_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.include_ach_option_down_payment_receipt_method')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="ach_receipt_enable"  name="ach_receipt" type="radio"
                            class="form-check-input" value="1">
                        <label for="ach_receipt_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="ach_receipt_disable"  name="ach_receipt" type="radio"
                            class="form-check-input" value="0">
                        <label for="ach_receipt_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.distribute_setup_payment_schedule_and_down_payment')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="payment_schedule_enable"  name="payment_schedule" type="radio"
                            class="form-check-input" value="1">
                        <label for="payment_schedule_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="payment_schedule_disable"  name="payment_schedule"
                            type="radio" class="form-check-input" value="0">
                        <label for="payment_schedule_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>


            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.add_products')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="add_products_enable"  name="add_products" type="radio"
                            class="form-check-input" value="1">
                        <label for="add_products_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="add_products_disable"  name="add_products" type="radio"
                            class="form-check-input" value="0">
                        <label for="add_products_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>


            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.company_tax_validation')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="company_tax_validation_enable" required name="company_tax_validation" type="radio"
                            class="form-check-input" value="1">
                        <label for="company_tax_validation_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="company_tax_validation_disable" required name="company_tax_validation"
                            type="radio" class="form-check-input" value="0">
                        <label for="company_tax_validation_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.agent_rate_table')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="agent_rate_table_enable" required name="agent_rate_table" type="radio"
                            class="form-check-input" value="1">
                        <label for="agent_rate_table_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="agent_rate_table_disable" required name="agent_rate_table"
                            type="radio" class="form-check-input" value="0">
                        <label for="agent_rate_table_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.view_quote_exposure')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="view_quote_exposure_enable" required name="view_quote_exposure" type="radio"
                            class="form-check-input" value="1">
                        <label for="view_quote_exposure_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="view_quote_exposure_disable" required name="view_quote_exposure"
                            type="radio" class="form-check-input" value="0">
                        <label for="view_quote_exposure_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.view_agent_compensation')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="view_agent_compensation_enable" required name="view_agent_compensation"
                            type="radio" class="form-check-input" value="1">
                        <label for="view_agent_compensation_enable" class="form-check-label ml-0">
                            @lang('labels.enable')
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                        <input id="view_agent_compensation_disable" required
                            name="view_agent_compensation" type="radio" class="form-check-input" value="0">
                        <label for="view_agent_compensation_disable" class="form-check-label ml-0">
                            @lang('labels.disable')
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.patriot_message')</label>
                <div class="col-sm-8">
                    <textarea name="patriot_message" id="patriot_message" cols="30" class="form-control"
                    rows="3"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.e_signature')</label>
                <div class="col-sm-8">
                    <textarea name="e_signature" id="e_signature" cols="30" class="form-control"
                    rows="3"></textarea>
                </div>
            </div>
             <div class="mb-3">
                <p class="fw-600">OFAC Compliance</p>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.ofac_url')</label>
                <div class="col-sm-8">
                    <x-jet-input type="url" name="ofac_url"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.accuity_client')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="nonactive" name="accuity_client"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.accuity_service_url')</label>
                <div class="col-sm-8">
                    <x-jet-input type="url" name="accuity_service_url"/>
                </div>
            </div>
             <div class="mb-3">
                <p class="fw-600">Other Options</p>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.warning_inception_date')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="warning_inception_date" class="nonactive"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.warning_first_due_date')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="warning_first_due_date" class="nonactive"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.warning_first_due_date_number')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="warning_first_due_date_number" class="nonactive"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.allow_inception_date')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="allow_inception_date" class="nonactive"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="comp_name" class="col-sm-4 col-form-label ">@lang('labels.text_signature')</label>
                <div class="col-sm-8">
                    <textarea name="text_signature" id="text_signature" cols="30" class="form-control"
                    rows="3"></textarea>
                </div>
            </div>
                    <x-button-group cancel='{{ routeCheck("company.dashboard") }}'/>
        @endslot
        @slot('logContent')
            <x-bootstrap-table :data="[
                'table' => 'logs',
                'cookieid' => true,
                 'id' => $activePage.'-logs',
                'sortorder' => 'desc',
                'sortname' => 'created_at',
                'type' => 'serversides',
                'ajaxUrl' => routeCheck('company.logs', ['type' => $activePage]),
            ]">
                <thead>
                    <tr>
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">Created Date
                        </th>

                        <th class="" data-sortable="true" data-field="username" data-width="200">
                            User Name
                        </th>
                        <th class="" data-sortable="true" data-field="message">Description</th>
                    </tr>
                </thead>
            </x-bootstrap-table>
        @endslot
    </x-jet-form-section>

    @push('page_script')
        <script>
            let editArr = @json($data ?? []);
        </script>
    @endpush
</x-app-layout>
