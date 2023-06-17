<x-app-layout>
    <x-jet-form-section :buttonGroup="['logs']" :activePageName="$activePage" class="validationForm editForm" :title="$pageTitle" novalidate
        action="{{ routeCheck($route) }}" method="post">
        @slot('form')
            <input type="hidden" name="logsArr">
            <!--<div class="mb-3">
                <p class="fw-600">Minimums/Maximums</p>
            </div>-->
            <div class="form-group row">
                <label for="maximum_write_off_amount" class="col-sm-4 col-form-label">@lang('labels.maximum_write_off_amount')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="amount  w-100" name="maximum_write_off_amount" placeholder="$" />
                </div>
            </div>
            <div class="form-group row">
                <label for="payment_thershold_amount" class="col-sm-4 col-form-label">@lang('labels.payment_thershold_amount')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="amount  w-100" name="payment_thershold_amount" placeholder="$" />
                </div>
            </div>
            <div class="form-group row">
                <label for="setup_Percent" class="col-sm-4 col-form-label">@lang('labels.payment_thershold')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="percentageInput  w-100" name="payment_thershold" placeholder="%" />
                </div>
            </div>
            <div class="form-group row">
                <label for="maximum_notices_to_process" class="col-sm-4 col-form-label">@lang('labels.maximum_notices_to_process')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="digitLimit  w-100" data-limit="6" name="maximum_notices_to_process" />

                </div>
            </div>
            <div class="form-group row">
                <label for="minimum_due_date_intent_cancel" class="col-sm-4 col-form-label">@lang('labels.minimum_days_from_due_date_to_intent_to_cancel')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="digitLimit w-100" data-limit="6"
                        name="minimum_due_date_intent_cancel" />
                </div>
            </div>
            <div class="form-group row">
                <label for="minimum_due_date_intent_cancel" class="col-sm-4 col-form-label">@lang('labels.maximum_days_from_due_date_to_intent_to_cancel')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="digitLimit w-100" data-limit="6"
                        name="maximum_due_date_intent_cancel" />
                </div>
            </div>
            <div class="form-group row">
                <label for="minimum_due_date_intent_cancel" class="col-sm-4 col-form-label">@lang('labels.minimum_days_from_intent_to_cancel_to_cancel')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="digitLimit w-100" data-limit="3" name="minimum_days_intent_cancel" />
                </div>
            </div>
            <div class="form-group row">
                <label for="minimum_due_date_intent_cancel" class="col-sm-4 col-form-label">@lang('labels.maximum_days_from_intent_to_cancel_to_cancel')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="digitLimit w-100" data-limit="3" name="maxium_days_intent_cancel" />
                </div>
            </div>

            <!--<div class="mb-3">
                <p class="fw-600">Account Status</p>
            </div>-->


            <div class="form-group row align-items-center">
                <label for="shortage_cancellation_status_enable" class="col-sm-4 col-form-label ">@lang('labels.shortage_without_cancellation_status')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="shortage_cancellation_status_enable" name="shortage_cancellation_status" type="radio"
                             class="form-check-input" value="1">
                        <label for="shortage_cancellation_status_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="shortage_cancellation_status_disable" name="shortage_cancellation_status" type="radio"
                             class="form-check-input" value="0">
                        <label for="shortage_cancellation_status_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label for="cancel_status_enable" class="col-sm-4 col-form-label ">@lang('labels.cancel_0_status')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="cancel_status_enable" name="cancel_status" type="radio"
                            class="form-check-input" value="1">
                        <label for="cancel_status_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="cancel_status_disable" name="cancel_status" type="radio"
                            class="form-check-input" value="0">
                        <label for="cancel_status_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>


            <div class="form-group row align-items-center">
                <label for="cancel_scheduled_cancellation_enable" class="col-sm-4 col-form-label ">
                    @lang('labels.cancel_after_scheduled_cancellation_date') </label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="cancel_scheduled_cancellation_enable" name="cancel_scheduled_cancellation"
                            type="radio"  class="form-check-input" value="1">
                        <label for="cancel_scheduled_cancellation_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="cancel_scheduled_cancellation_disable" name="cancel_scheduled_cancellation"
                            type="radio"  class="form-check-input" value="0">
                        <label for="cancel_scheduled_cancellation_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label for="cancel_rp_warning_enable" class="col-sm-4 col-form-label ">@lang('labels.cancel_0_rp_warning')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="cancel_rp_warning_enable" name="cancel_rp_warning" type="radio"
                            class="form-check-input" value="1">
                        <label for="cancel_rp_warning_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="cancel_rp_warning_disable" name="cancel_rp_warning" type="radio"
                            class="form-check-input" value="0">
                        <label for="cancel_rp_warning_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label for="cancel_criteria_enable" class="col-sm-4 col-form-label ">
                    @lang('labels.consider_fee_receipts_as_principal_and_interest_for_cancel_criteria') </label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="cancel_criteria_enable" name="cancel_criteria" type="radio"
                            class="form-check-input" value="1">
                        <label for="cancel_criteria_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="cancel_criteria_disable" name="cancel_criteria" type="radio"
                            class="form-check-input" value="0">
                        <label for="cancel_criteria_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>



            <!--<div class="mb-3">
                <p class="fw-600">Defaults</p>
            </div>-->

            <div class="form-group row">
                <label for="days_late_reinstate" class="col-sm-4 col-form-label">@lang('labels.days_late_to_reinstate')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="digitLimit w-100" data-limit="3" name="days_late_reinstate" />

                </div>
            </div>
            <div class="form-group row">
                <label for="installment_due_date_payoff" class="col-sm-4 col-form-label">@lang('labels.days_before_last_installment_due_date_to_allow_payoff')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="digitLimit w-100" data-limit="3"
                        name="installment_due_date_payoff" />
                </div>
            </div>
            <div class="form-group row">
                <label for="monthly_statements" class="col-sm-4 col-form-label">@lang('labels.days_before_due_date_for_monthly_statements')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="digitLimit w-100" data-limit="3" name="monthly_statements" />
                </div>
            </div>
            <div class="form-group row">
                <label for="notice_cancellation" class="col-sm-4 col-form-label">@lang('labels.days_to_allow_agency_control_over_notice_of_cancellation')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="digitLimit w-100" data-limit="3" name="notice_cancellation" />
                </div>
            </div>
            <div class="form-group row">
                <label for="notice_premium_finance" class="col-sm-4 col-form-label">@lang('labels.days_between_mailings_of_notice_of_premium_finance_nfp')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="digitLimit w-100" data-limit="3" name="notice_premium_finance" />
                </div>
            </div>
            <div class="form-group row">
                <label for="days_due_date_automatic" class="col-sm-4 col-form-label">@lang('labels.days_after_due_date_for_automatic_write_off')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="digitLimit w-100" data-limit="3" name="days_due_date_automatic" />
                </div>
            </div>
            <div class="form-group row">
                <label for="fiscal_year" class="col-sm-4 col-form-label">@lang('labels.fiscal_year_start_month')</label>
                <div class="col-sm-8">
                    {!! form_dropdown('fiscal_year', monthsDropDown(), '', [
                        'class' => "ui dropdown input-sm
                                    w-100",
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="payment_processing_order" class="col-sm-4 col-form-label">@lang('labels.payment_processing_order')</label>
                <div class="col-sm-8">
                    {!! form_dropdown(
                        'payment_processing_order',
                        ['Pay fee first' => 'Pay fee first', 'Pay fee last' => 'Pay fee last'],
                        '',
                        ['class' => 'ui dropdown input-sm w-100'],
                    ) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="days_due_date_automatic" class="col-sm-4 col-form-label">
                    @lang('labels.days_between_activation_date_and_setup_fee_due_date')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" class="digitLimit w-100" data-limit="2"
                        name="days_between_activation_date" />

                </div>
            </div>
            <div class="form-group row">
                <label for="days_due_date_automatic" class="col-sm-4 col-form-label">
                    @lang('labels.days_until_generation_of_past_due_warning_notice')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" name="days_until_generation" />
                </div>
            </div>
            <!--<div class="mb-3">
                <p class="fw-600">Enable/Disable Options</p>
            </div>-->
            <div class="form-group row align-items-center">
                <label for="include_unearned_interest_amount_enable" class="col-sm-4 col-form-label ">
                    @lang('labels.include_unearned_interest_in_the_current_amount_due_on_the_last_installment')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount"
                            type="radio"  class="form-check-input" value="1">
                        <label for="include_unearned_interest_amount_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount"
                            type="radio"  class="form-check-input" value="0">
                        <label for="include_unearned_interest_amount_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label for="earn_fees" class="col-sm-4 col-form-label ">@lang('labels.earn_fees_when_assessed')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="earn_fees_enable" name="earn_fees" type="radio"  class="form-check-input"
                            value="1">
                        <label for="earn_fees_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="earn_fees_disable" name="earn_fees" type="radio"  class="form-check-input"
                            value="0">
                        <label for="earn_fees_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="earn_interest_enable" class="col-sm-4 col-form-label ">@lang('labels.earn_interest_on_effective_day_of_month')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="earn_interest_enable" name="earn_interest" type="radio"
                            class="form-check-input" value="1">
                        <label for="earn_interest_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="earn_interest_disable" name="earn_interest" type="radio"
                            class="form-check-input" value="0">
                        <label for="earn_interest_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="verify_policy_information_enable" class="col-sm-4 col-form-label ">@lang('labels.verify_policy_information')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="verify_policy_information_enable" name="verify_policy_information" type="radio"
                             class="form-check-input" value="1">
                        <label for="verify_policy_information_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="verify_policy_information_disable" name="verify_policy_information" type="radio"
                             class="form-check-input" value="0">
                        <label for="verify_policy_information_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="confirm_carrier_acknowledgement_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.confirm_carrier_acknowledgement')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="confirm_carrier_acknowledgement_enable" name="confirm_carrier_acknowledgement"
                            type="radio"  class="form-check-input" value="1">
                        <label for="confirm_carrier_acknowledgement_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="confirm_carrier_acknowledgement_disable" name="confirm_carrier_acknowledgement"
                            type="radio"  class="form-check-input" value="0">
                        <label for="confirm_carrier_acknowledgement_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="verify_cancel_confirmations_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.verify_cancel_confirmations')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="verify_cancel_confirmations_enable" name="verify_cancel_confirmations"
                            type="radio"  class="form-check-input" value="1">
                        <label for="verify_cancel_confirmations_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="verify_cancel_confirmations_disable" name="verify_cancel_confirmations"
                            type="radio"  class="form-check-input" value="0">
                        <label for="verify_cancel_confirmations_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="send_notice_policy_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.send_cancel_and_reinstatement_notices_to_insured_agent_per_policy')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="send_notice_policy_enable" name="send_notice_policy"
                            type="radio"  class="form-check-input" value="1">
                        <label for="send_notice_policy_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="send_notice_policy_disable" name="send_notice_policy"
                            type="radio"  class="form-check-input" value="0">
                        <label for="send_notice_policy_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="insured_notices_bankruptcy_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.do_not_send_insured_notices_when_they_are_in_bankruptcy')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="insured_notices_bankruptcy_enable" name="insured_notices_bankruptcy"
                            type="radio"  class="form-check-input" value="1">
                        <label for="insured_notices_bankruptcy_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="insured_notices_bankruptcy_disable" name="insured_notices_bankruptcy"
                            type="radio"  class="form-check-input" value="0">
                        <label for="insured_notices_bankruptcy_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="insured_notices_bankruptcy_noexceptions_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.do_not_send_insured_notices_when_they_are_in_bankruptcy_no_exceptions')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="insured_notices_bankruptcy_noexceptions_enable" name="insured_notices_bankruptcy_noexceptions"
                            type="radio"  class="form-check-input" value="1">
                        <label for="insured_notices_bankruptcy_noexceptions_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="insured_notices_bankruptcy_noexceptions_disable" name="insured_notices_bankruptcy_noexceptions"
                            type="radio"  class="form-check-input" value="0">
                        <label for="insured_notices_bankruptcy_noexceptions_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="company_notices_bankruptcy_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.do_not_send_company_notices_when_they_are_in_bankruptcy')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="company_notices_bankruptcy_enable" name="company_notices_bankruptcy"
                            type="radio"  class="form-check-input" value="1">
                        <label for="company_notices_bankruptcy_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="company_notices_bankruptcy_disable" name="company_notices_bankruptcy"
                            type="radio"  class="form-check-input" value="0">
                        <label for="company_notices_bankruptcy_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="company_notices_bankruptcy_noexceptions_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.do_not_send_company_notices_when_they_are_in_bankruptcy_no_exceptions')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="company_notices_bankruptcy_noexceptions_enable" name="company_notices_bankruptcy_noexceptions"
                            type="radio"  class="form-check-input" value="1">
                        <label for="company_notices_bankruptcy_noexceptions_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="company_notices_bankruptcy_noexceptions_disable" name="company_notices_bankruptcy_noexceptions"
                            type="radio"  class="form-check-input" value="0">
                        <label for="company_notices_bankruptcy_noexceptions_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="send_collection_letters_insured_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.send_collection_letters_to_the_insured')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="send_collection_letters_insured_enable" name="send_collection_letters_insured"
                            type="radio"  class="form-check-input" value="1">
                        <label for="send_collection_letters_insured_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="send_collection_letters_insured_disable" name="send_collection_letters_insured"
                            type="radio"  class="form-check-input" value="0">
                        <label for="send_collection_letters_insured_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="notices_financed_premium_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.send_notice_of_financed_premium_on_new_policy')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="notices_financed_premium_enable" name="notices_financed_premium"
                            type="radio"  class="form-check-input" value="1">
                        <label for="notices_financed_premium_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="notices_financed_premium_disable" name="notices_financed_premium"
                            type="radio"  class="form-check-input" value="0">
                        <label for="notices_financed_premium_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="custom_account_number_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.allow_user_to_enter_a_custom_account_number')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="custom_account_number_enable" name="custom_account_number"
                            type="radio"  class="form-check-input" value="1">
                        <label for="custom_account_number_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="custom_account_number_disable" name="custom_account_number"
                            type="radio"  class="form-check-input" value="0">
                        <label for="custom_account_number_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="allow_instant_payments_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.allow_instant_payments')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="allow_instant_payments_enable" name="allow_instant_payments"
                            type="radio"  class="form-check-input" value="1">
                        <label for="allow_instant_payments_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="allow_instant_payments_disable" name="allow_instant_payments"
                            type="radio"  class="form-check-input" value="0">
                        <label for="allow_instant_payments_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
           {{--  <div class="form-group row align-items-center">
                <label for="include_unearned_interest_amount_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.earn_interest_on_effective_day_of_month')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount"
                            type="radio"  class="form-check-input" value="1">
                        <label for="include_unearned_interest_amount_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount"
                            type="radio"  class="form-check-input" value="0">
                        <label for="include_unearned_interest_amount_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div> --}}
            <div class="form-group row align-items-center">
                <label for="allow_active_spread_rp_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.allow_active_spread_rp')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="allow_active_spread_rp_enable" name="allow_active_spread_rp"
                            type="radio"  class="form-check-input" value="1">
                        <label for="allow_active_spread_rp_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="allow_active_spread_RP_disable" name="allow_active_spread_rp"
                            type="radio"  class="form-check-input" value="0">
                        <label for="allow_active_spread_RP_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="allow_active_current_rp_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.allow_active_current_rp')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="allow_active_current_rp_enable" name="allow_active_current_rp"
                            type="radio"  class="form-check-input" value="1">
                        <label for="allow_active_current_rp_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="allow_active_current_rp_disable" name="allow_active_current_rp"
                            type="radio"  class="form-check-input" value="0">
                        <label for="allow_active_current_rp_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="allow_cancel_rp_net_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.allow_cancel_rp_net')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="allow_cancel_rp_net_enable" name="allow_cancel_rp_net"
                            type="radio"  class="form-check-input" value="1">
                        <label for="allow_cancel_rp_net_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="allow_cancel_rp_net_disable" name="allow_cancel_rp_net"
                            type="radio"  class="form-check-input" value="0">
                        <label for="allow_cancel_rp_net_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="allow_cancel_rp_gross_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.allow_cancel_rp_gross')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="allow_cancel_rp_gross_enable" name="allow_cancel_rp_gross"
                            type="radio"  class="form-check-input" value="1">
                        <label for="allow_cancel_rp_gross_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="allow_cancel_rp_gross_disable" name="allow_cancel_rp_gross"
                            type="radio"  class="form-check-input" value="0">
                        <label for="allow_cancel_rp_gross_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="allow_agent_return_commission_rp_disable_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.allow_agent_return_commission_rp')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="allow_agent_return_commission_rp_disable_enable" name="allow_agent_return_commission_rp"
                            type="radio"  class="form-check-input" value="1">
                        <label for="allow_agent_return_commission_rp_disable_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="allow_agent_return_commission_rp_disable" name="allow_agent_return_commission_rp"
                            type="radio"  class="form-check-input" value="0">
                        <label for="allow_agent_return_commission_rp_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="align_due_date_payable_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.rp_align_due_date_with_unpaid_payable')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="align_due_date_payable_enable" name="align_due_date_payable"
                            type="radio"  class="form-check-input" value="1">
                        <label for="align_due_date_payable_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="align_due_date_payable_disable" name="align_due_date_payable"
                            type="radio"  class="form-check-input" value="0">
                        <label for="align_due_date_payable_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="write_off_last_earn_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.write_off_default_last_earn_date_to_today')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="write_off_last_earn_enable" name="write_off_last_earn"
                            type="radio"  class="form-check-input" value="1">
                        <label for="write_off_last_earn_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="write_off_last_earn_disable" name="write_off_last_earn"
                            type="radio"  class="form-check-input" value="0">
                        <label for="write_off_last_earn_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="write_off_fees_pi_1"
                    class="col-sm-4 col-form-label ">@lang('labels.reapply_write_off_fees_to_principal_and_interest')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="write_off_fees_pi_1" name="write_off_fees_pi"
                            type="radio"  class="form-check-input" value="1">
                        <label for="write_off_fees_pi_1"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="write_off_fees_pi_0" name="write_off_fees_pi"
                            type="radio"  class="form-check-input" value="0">
                        <label for="write_off_fees_pi_0"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="installment_payments_information_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.show_only_installment_payments_in_payment_information')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="installment_payments_information_enable" name="installment_payments_information"
                            type="radio"  class="form-check-input" value="1">
                        <label for="installment_payments_information_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="installment_payments_information_disable" name="installment_payments_information"
                            type="radio"  class="form-check-input" value="0">
                        <label for="installment_payments_information_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="unearned_compensation_disable_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.adjust_unearned_compensation_on_close')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="unearned_compensation_disable_enable" name="unearned_compensation"
                            type="radio"  class="form-check-input" value="1">
                        <label for="unearned_compensation_disable_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="unearned_compensation_disable" name="unearned_compensation"
                            type="radio"  class="form-check-input" value="0">
                        <label for="unearned_compensation_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="payables_SSN_FEIN_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.automatically_hold_payables_for_no_ssn_fein')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="payables_SSN_FEIN_enable" name="payables_SSN_FEIN"
                            type="radio"  class="form-check-input" value="1">
                        <label for="payables_SSN_FEIN_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="payables_SSN_FEIN_disable" name="payables_SSN_FEIN"
                            type="radio"  class="form-check-input" value="0">
                        <label for="payables_SSN_FEIN_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="principal_payoffs_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.default_payment_option_for_principal_payoffs')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="principal_payoffs_enable" name="principal_payoffs"
                            type="radio"  class="form-check-input" value="1">
                        <label for="principal_payoffs_enable"
                            class="form-check-label">@lang('labels.waive_all_interest')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="principal_payoffs_disable" name="principal_payoffs"
                            type="radio"  class="form-check-input" value="0">
                        <label for="principal_payoffs_disable"
                            class="form-check-label">@lang('labels.reverse_only_unearned')</label>
                    </div>
                </div>

            </div>
            <div class="form-group row align-items-center">
                <label for="distribution_payment_schedule_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.setup_fee_distribution_in_payment_schedule')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="distribution_payment_schedule_enable" name="distribution_payment_schedule"
                            type="radio"  class="form-check-input" value="1">
                        <label for="distribution_payment_schedule_enable"
                            class="form-check-label">@lang('labels.first_payment_only')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="distribution_payment_schedule_disable" name="distribution_payment_schedule"
                            type="radio"  class="form-check-input" value="0">
                        <label for="distribution_payment_schedule_disable"
                            class="form-check-label">@lang('labels.spread')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="generate_notes_disabled_notices_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.generate_notes_for_disabled_notices')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="generate_notes_disabled_notices_enable" name="generate_notes_disabled_notices"
                            type="radio"  class="form-check-input" value="1">
                        <label for="generate_notes_disabled_notices_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="generate_notes_disabled_notices_disable" name="generate_notes_disabled_notices"
                            type="radio"  class="form-check-input" value="0">
                        <label for="generate_notes_disabled_notices_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="require_certified_funds_reinstate_disable_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.require_certified_funds_to_reinstate')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="require_certified_funds_reinstate_disable_enable" name="require_certified_funds_reinstate"
                            type="radio"  class="form-check-input" value="1">
                        <label for="require_certified_funds_reinstate_disable_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="require_certified_funds_reinstate_disable" name="require_certified_funds_reinstate"
                            type="radio"  class="form-check-input" value="0">
                        <label for="require_certified_funds_reinstate_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="allow_uncertified_agent_reinstate_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.allow_uncertified_funds_from_agent_to_reinstate')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="allow_uncertified_agent_reinstate_enable" name="allow_uncertified_agent_reinstate"
                            type="radio"  class="form-check-input" value="1">
                        <label for="allow_uncertified_agent_reinstate_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="allow_uncertified_agent_reinstate_disable" name="allow_uncertified_agent_reinstate"
                            type="radio"  class="form-check-input" value="0">
                        <label for="allow_uncertified_agent_reinstate_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="policy_payables_account_disable_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.align_due_dates_for_policy_payables_to_agent_on_account')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="policy_payables_account_disable_enable" name="policy_payables_account"
                            type="radio"  class="form-check-input" value="1">
                        <label for="policy_payables_account_disable_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="policy_payables_account_disable" name="policy_payables_account"
                            type="radio"  class="form-check-input" value="0">
                        <label for="policy_payables_account_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="hold_reinstatement_requests_funds_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.hold_reinstatement_requests_for_non_certified_funds')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="hold_reinstatement_requests_funds_enable" name="hold_reinstatement_requests_funds"
                            type="radio"  class="form-check-input" value="1">
                        <label for="hold_reinstatement_requests_funds_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="hold_reinstatement_requests_funds_disable" name="hold_reinstatement_requests_funds"
                            type="radio"  class="form-check-input" value="0">
                        <label for="hold_reinstatement_requests_funds_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="generate_billing_statements_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.generate_billing_statements_after_last_payment_due_date')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="generate_billing_statements_enable" name="generate_billing_statements"
                            type="radio"  class="form-check-input" value="1">
                        <label for="generate_billing_statements_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="generate_billing_statements_disable" name="generate_billing_statements"
                            type="radio"  class="form-check-input" value="0">
                        <label for="generate_billing_statements_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="categorize_refunds_due_enable"
                    class="col-sm-4 col-form-label ">@lang('labels.categorize_refunds_due_to_flat_cancel_as_general_ledger_text')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="categorize_refunds_due_enable" name="categorize_refunds_due"
                            type="radio"  class="form-check-input" value="1">
                        <label for="categorize_refunds_due_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="categorize_refunds_due_disable" name="categorize_refunds_due"
                            type="radio"  class="form-check-input" value="0">
                        <label for="categorize_refunds_due_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>



             <x-button-group cancel='{{ routeCheck("company.dashboard") }}'/>
        @endslot
        @slot('logContent')
            <x-bootstrap-table :data="[
                'table' => 'logs',
                'cookieid' => true,
                'id' => $activePage . '-logs',
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
