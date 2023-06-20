<x-app-layout>
    <section class="font-1 pt-5 hq-full">
        <div class="container">
            <div class="row justify-content-center" x-data="{ open: 'one' }">
                <div class="col-lg-12">
                    <h4>{{ dynamicPageTitle('page') ?? '' }}</h4>
                    <div class="my-4"></div>

                    <form class="validationForm" novalidate method="POST" action="{{ routeCheck($route.'store')  }}">
                        @csrf


                        <div class="mb-3">
                            <p class="fw-600">@lang('labels.minimums_maximums')</p>
                        </div>

                        <div class="tab-one">
                            <div class="form-group row">
                                <label for="minimum_write_amount" class="col-sm-3 col-form-label">@lang("labels.minimum_write_off_amount")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm amount w-50" name="minimum_write_amount" id="minimum_write_amount" placeholder="$">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="payment_thershold_amount" class="col-sm-3 col-form-label">@lang("labels.payment_thershold_amount")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm amount w-50" name="payment_thershold_amount" id="payment_thershold_amount" placeholder="$">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="setup_Percent" class="col-sm-3 col-form-label">@lang("labels.payment_thershold")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm percentage_input w-50" name="setup_Percent" id="setup_Percent"
                                        placeholder="%">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Maximum_notices_process" class="col-sm-3 col-form-label">@lang("labels.maximum_notices_to_process")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="Maximum_notices_process" id="Maximum_notices_process"
                                        placeholder="">

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="minimum_due_date_intent_cancel" class="col-sm-3 col-form-label">@lang("labels.minimum_days_from_due_date_to_intent_to_cancel")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="minimum_due_date_intent_cancel" id="minimum_due_date_intent_cancel"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="minimum_due_date_intent_cancel" class="col-sm-3 col-form-label">@lang("labels.maximum_days_from_due_date_to_intent_to_cancel")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="minimum_due_date_intent_cancel"
                                        id="minimum_due_date_intent_cancel" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="minimum_due_date_intent_cancel" class="col-sm-3 col-form-label">@lang("labels.minimum_days_from_intent_to_cancel_to_cancel")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="minimum_due_date_intent_cancel"
                                        id="minimum_due_date_intent_cancel" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="minimum_due_date_intent_cancel" class="col-sm-3 col-form-label">@lang("labels.maximum_days_from_intent_to_cancel_to_cancel")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="minimum_due_date_intent_cancel"
                                        id="minimum_due_date_intent_cancel" placeholder="">
                                </div>
                            </div>

                            <div class="mb-3">
                                <p class="fw-600">@lang("labels.account_status")</p>
                            </div>


                            <div class="form-group row align-items-center">
                                <label for="shortage_cancellation_status_enable" class="col-sm-3 col-form-label ">@lang("labels.shortage_without_cancellation_status")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="shortage_cancellation_status_enable" name="shortage_cancellation_status" type="radio" required
                                            class="form-check-input" value="true">
                                        <label for="shortage_cancellation_status_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="shortage_cancellation_status_disable" name="shortage_cancellation_status" type="radio" required
                                            class="form-check-input" value="false">
                                        <label for="shortage_cancellation_status_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="cancel_status_enable" class="col-sm-3 col-form-label ">@lang("labels.cancel_0_status")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="cancel_status_enable" name="cancel_status" type="radio" required
                                            class="form-check-input" value="true">
                                        <label for="cancel_status_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="cancel_status_disable" name="cancel_status" type="radio" required
                                            class="form-check-input" value="false">
                                        <label for="cancel_status_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row align-items-center">
                                <label for="cancel_scheduled_cancellation_enable" class="col-sm-3 col-form-label ">
                                    @lang("labels.cancel_after_scheduled_cancellation_date") </label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="cancel_scheduled_cancellation_enable" name="cancel_scheduled_cancellation" type="radio" required
                                            class="form-check-input" value="true">
                                        <label for="cancel_scheduled_cancellation_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="cancel_scheduled_cancellation_disable" name="cancel_scheduled_cancellation" type="radio" required
                                            class="form-check-input" value="false">
                                        <label for="cancel_scheduled_cancellation_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="cancel_rp_warning_enable" class="col-sm-3 col-form-label ">@lang("labels.cancel_0_rp_warning")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="cancel_rp_warning_enable" name="cancel_rp_warning" type="radio" required class="form-check-input"
                                            value="true">
                                        <label for="cancel_rp_warning_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="cancel_rp_warning_disable" name="cancel_rp_warning" type="radio" required
                                            class="form-check-input" value="false">
                                        <label for="cancel_rp_warning_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="cancel_criteria_enable" class="col-sm-3 col-form-label ">
                                    @lang("labels.consider_fee_receipts_as_principal_and_interest_for_cancel_criteria")  </label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="cancel_criteria_enable" name="cancel_criteria" type="radio" required class="form-check-input"
                                            value="true">
                                        <label for="cancel_criteria_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="cancel_criteria_disable" name="cancel_criteria" type="radio" required class="form-check-input"
                                            value="false">
                                        <label for="cancel_criteria_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>



                            <div class="mb-3">
                                <p class="fw-600">@lang('labels.defaults')</p>
                            </div>

                            <div class="form-group row">
                                <label for="days_late_reinstate" class="col-sm-3 col-form-label">@lang("labels.days_late_to_reinstate")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="days_late_reinstate"
                                        id="days_late_reinstate" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="installment_due_date_payoff" class="col-sm-3 col-form-label">@lang("labels.days_before_last_installment_due_date_to_allow_payoff")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="installment_due_date_payoff"
                                        id="installment_due_date_payoff" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="monthly_statements" class="col-sm-3 col-form-label">@lang("labels.days_before_due_date_for_monthly_statements")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="monthly_statements"
                                        id="monthly_statements" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="notice_cancellation" class="col-sm-3 col-form-label">@lang("labels.days_to_allow_agency_control_over_notice_of_cancellation")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="notice_cancellation" id="notice_cancellation"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="notice_premium_finance" class="col-sm-3 col-form-label">@lang("labels.days_between_mailings_of_notice_of_premium_finance_nfp")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="notice_premium_finance" id="notice_premium_finance"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="days_due_date_automatic" class="col-sm-3 col-form-label">@lang("labels.days_after_due_date_for_automatic_write_off")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="days_due_date_automatic" id="days_due_date_automatic"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fiscal_year" class="col-sm-3 col-form-label">@lang("labels.fiscal_year_start_month")</label>
                                <div class="col-sm-9">
                                    {!! form_dropdown('fiscal_year', monthsDropDown(), '', ["class"=>"ui dropdown input-sm w-50","required"=>true,'id'=>'primary_address_state']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fiscal_year" class="col-sm-3 col-form-label">@lang("labels.payment_processing_order")</label>
                                <div class="col-sm-9">
                                    {!! form_dropdown('fiscal_year',['Pay fee first'=>"Pay fee first",'Pay fee last'=>"Pay fee last"], '', ["class"=>"ui dropdown input-sm w-50","required"=>true,'id'=>'primary_address_state']) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="days_due_date_automatic" class="col-sm-3 col-form-label">
                                    @lang("labels.days_between_activation_date_and_setup_fee_due_date")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="days_due_date_automatic"
                                        id="days_due_date_automatic" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="days_due_date_automatic" class="col-sm-3 col-form-label"> @lang("labels.days_until_generation_of_past_due_warning_notice")</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control input-sm  w-50" name="days_due_date_automatic"
                                        id="days_due_date_automatic" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">
                                    @lang("labels.include_unearned_interest_in_the_current_amount_due_on_the_last_installment")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.earn_fees_when_assessed")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.earn_interest_on_effective_day_of_month")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label">@lang("labels.verify_policy_information")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.confirm_carrier_acknowledgement")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.verify_cancel_confirmations")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.send_cancel_and_reinstatement_notices_to_insured_agent_per_policy")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.do_not_send_insured_notices_when_they_are_in_bankruptcy")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.do_not_send_insured_notices_when_they_are_in_bankruptcy_no_exceptions")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.do_not_send_company_notices_when_they_are_in_bankruptcy")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.do_not_send_company_notices_when_they_are_in_bankruptcy_no_exceptions")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.send_collection_letters_to_the_insured")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.send_notice_of_financed_premium_on_new_policy")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.allow_user_to_enter_a_custom_account_number")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.allow_instant_payments")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.earn_interest_on_effective_day_of_month")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.allow_active_spread_rp")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.allow_active_current_rp")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.allow_cancel_rp_net")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.allow_cancel_rp_gross")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.allow_agent_return_commission_rp")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.rp_align_due_date_with_unpaid_payable")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.write_off_default_last_earn_date_to_today")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.reapply_write_off_fees_to_principal_and_interest")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.show_only_installment_payments_in_payment_information")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.adjust_unearned_compensation_on_close")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.automatically_hold_payables_for_no_ssn_fein")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.default_payment_option_for_principal_payoffs")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.waive_all_interest")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.reverse_only_unearned")</label>
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.setup_fee_distribution_in_payment_schedule")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.first_payment_only")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.spread")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.generate_notes_for_disabled_notices")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.require_certified_funds_to_reinstate")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.allow_uncertified_funds_from_agent_to_reinstate")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.align_due_dates_for_policy_payables_to_agent_on_account")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.hold_reinstatement_requests_for_non_certified_funds")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.generate_billing_statements_after_last_payment_due_date")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="include_unearned_interest_amount_enable" class="col-sm-3 col-form-label ">@lang("labels.categorize_refunds_due_to_flat_cancel_as_general_ledger_text")</label>
                                <div class="col-sm-9">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="include_unearned_interest_amount_enable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="true">
                                        <label for="include_unearned_interest_amount_enable" class="form-check-label">@lang("labels.enable")</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="include_unearned_interest_amount_disable" name="include_unearned_interest_amount" type="radio"
                                            required class="form-check-input" value="false">
                                        <label for="include_unearned_interest_amount_disable" class="form-check-label">@lang("labels.disable")</label>
                                    </div>
                                </div>
                            </div>



                            <div class="form-group row">
                                <label for="esignature" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button type="button" class=" button-loading btn btn-primary nextTab">
                                        <span class="button--loading d-none"></span> <span
                                            class="button__text">Submit</span>
                                    </button>


                                </div>
                            </div>
                        </div>

                    </form>



                </div><!-- /.col-*-->
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>
    <!--/.section-->
</x-app-layout>
