<x-app-layout>
    <x-jet-form-section :buttonGroup="['logs']" :activePageName="$activePage" class="validationForm editForm" :title="$pageTitle" novalidate
        action="{{ routeCheck($route) }}" method="post" x-data="{providers : ''}">
        @slot('form')
            <input type="hidden" name="logsArr">
            <div class="form-group row">
                <label for="minimum_write_amount" class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.name')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" required name="name" placeholder="" />
                </div>
            </div>
			<hr>
            <div class="mb-3">
                <h6>General options</h6>
            </div>
            <div class="form-group row align-items-center">
                <label for="insured_electronic_payments_enable"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.insured_electronic_payments')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="insured_electronic_payments_enable" required name="insured_electronic_payments"
                            type="radio" class="form-check-input" value="enable">
                        <label for="insured_electronic_payments_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="insured_electronic_payments_disable" required name="insured_electronic_payments"
                            type="radio" class="form-check-input" value="disable">
                        <label for="insured_electronic_payments_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>




            <div class="form-group row align-items-center">
                <label for="one_time_payment_enable"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.insured_one_time_electronic_payment')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="one_time_payment_enable" required name="one_time_payment" type="radio"
                            class="form-check-input" value="enable">
                        <label for="one_time_payment_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="one_time_payment_disable" required name="one_time_payment" type="radio"
                            class="form-check-input" value="disable">
                        <label for="one_time_payment_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label for="recurring_payment_enable"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.insured_recurring_electronic_payment')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="recurring_payment_enable" required name="recurring_payment" type="radio"
                            class="form-check-input" value="enable">
                        <label for="recurring_payment_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="recurring_payment_disable" required name="recurring_payment" type="radio"
                            class="form-check-input" value="disable">
                        <label for="recurring_payment_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>


            <div class="form-group row align-items-center">
                <label for="certified_funds_enable" class="col-sm-4 col-form-label requiredAsterisk">
                    @lang('labels.insured_can_pay_credit_card_certified_funds_required') </label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="certified_funds_enable" required name="certified_funds" type="radio"
                            class="form-check-input" value="enable">
                        <label for="certified_funds_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="certified_funds_disable" required name="certified_funds" type="radio"
                            class="form-check-input" value="disable">
                        <label for="certified_funds_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label for="cardholder_email_address_enable"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.require_cardholder_email_address_on_line_payments')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="cardholder_email_address_enable" required name="cardholder_email_address" type="radio"
                            class="form-check-input" value="enable">
                        <label for="cardholder_email_address_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="cardholder_email_address_disable" required name="cardholder_email_address"
                            type="radio" class="form-check-input" value="disable">
                        <label for="cardholder_email_address_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label for="email_notification_enable" class="col-sm-4 col-form-label requiredAsterisk">
                    @lang('labels.send_email_notification_after_processing_payments') </label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="email_notification_enable" required name="email_notification" type="radio"
                            class="form-check-input" value="enable">
                        <label for="email_notification_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="email_notification_disable" name="email_notification" type="radio"
                            class="form-check-input" value="disable">
                        <label for="email_notification_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="email_notification_prompt" name="email_notification" type="radio"
                            class="form-check-input" value="prompt">
                        <label for="email_notification_prompt" class="form-check-label">@lang('labels.prompt')</label>
                    </div>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label for="agent_online_payments_enable" class="col-sm-4 col-form-label requiredAsterisk">
                    @lang('labels.agent_on_line_payments')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="agent_online_payments_enable" required name="agent_online_payments" type="radio"
                            class="form-check-input" value="enable">
                        <label for="agent_online_payments_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="agent_online_payments_disable" required name="agent_online_payments" type="radio"
                            class="form-check-input" value="disable">
                        <label for="agent_online_payments_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>





            <div class="form-group row align-items-center">
                <label for="agent_one_time_payment"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.one_time_electronic_payment')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="agent_one_time_payment_enable" required name="agent_one_time_payment" type="radio"
                            class="form-check-input" value="enable">
                        <label for="agent_one_time_payment_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="agent_one_time_payment_disable" required name="agent_one_time_payment" type="radio"
                            class="form-check-input" value="disable">
                        <label for="agent_one_time_payment_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="agent_recurring_payment_enable"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.recurring_electronic_payment')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="agent_recurring_payment_enable" required name="agent_recurring_payment" type="radio"
                            class="form-check-input" value="enable">
                        <label for="agent_recurring_payment_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="agent_recurring_payment_disable" required name="agent_recurring_payment"
                            type="radio" class="form-check-input" value="disable">
                        <label for="agent_recurring_payment_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="agent_cardholder_email_address_enable"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.require_cardholder_email_address_on_line_payments')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="agent_cardholder_email_address_enable" required name="agent_cardholder_email_address"
                            type="radio" class="form-check-input" value="enable">
                        <label for="agent_cardholder_email_address_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="agent_cardholder_email_address_disable" required name="agent_cardholder_email_address"
                            type="radio" class="form-check-input" value="disable">
                        <label for="agent_cardholder_email_address_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="agent_email_notification_enable"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.send_email_notification_after_processing_payments')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="agent_email_notification_enable" required name="agent_email_notification"
                            type="radio" class="form-check-input" value="enable">
                        <label for="agent_email_notification_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="agent_email_notification_disable" required name="agent_email_notification"
                            type="radio" class="form-check-input" value="disable">
                        <label for="agent_email_notification_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="agent_email_notification_prompt" required name="agent_email_notification"
                            type="radio" class="form-check-input" value="disable">
                        <label for="agent_email_notification_prompt" class="form-check-label">@lang('labels.prompt')</label>
                    </div>
                </div>
            </div>
			<hr>
            <div class="mb-3">
                <h6>Accepted card types</h6>
            </div>
            <div class="row form-group">
                <label for="open_status" class="col-sm-4 col-form-label requiredAsterisk">
                    @lang('labels.card_types_you_want_to_accept')</label>
                <div class="col-sm-8">
                    <x-jet-checkbox for="card_types_visa" required labelText="{{ __('labels.visa') }}"
                        name="card_types[]" id="card_types_visa" value="visa" />
                    <x-jet-checkbox for="card_types_mastercard" required labelText="{{ __('labels.mastercard') }}"
                        name="card_types[]" id="card_types_mastercard" value="mastercard" />
                    <x-jet-checkbox for="card_types_american_express" required
                        labelText="{{ __('labels.american_express') }}" name="card_types[]"
                        id="card_types_american_express" value="americanexpress" />
                    <x-jet-checkbox for="card_types_discover" required labelText="{{ __('labels.discover') }}"
                        name="card_types[]" id="card_types_discover" value="discover" />
                </div>
            </div>
			<hr>
            <div class="mb-3">
                <h6>Recurring options</h6>
            </div>



            <div class="form-group row align-items-center">
                <label for="calculation_method_current_amount_due"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.electronic_payments_calculation_method')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="calculation_method_current_amount_due" required name="calculation_method"
                            type="radio" class="form-check-input" value="Current amount due">
                        <label for="calculation_method_current_amount_due"
                            class="form-check-label">@lang('labels.current_amount_due')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="calculation_method_installment_amount" required name="calculation_method"
                            type="radio" class="form-check-input" value="Installment amount">
                        <label for="calculation_method_installment_amount"
                            class="form-check-label">@lang('labels.installment_amount')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="calculation_method_installment_amount_fees" required name="calculation_method"
                            type="radio" class="form-check-input" value="Installment amount fees">
                        <label for="calculation_method_installment_amount_fees"
                            class="form-check-label">@lang('labels.installment_amount_fees')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="generate_recurring_payment"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.days_before_due_date_to_generate_recurring_payment')</label>
                <div class="col-sm-8">
                    <x-jet-input type="text" required class=" w-25 digitLimit" data-maxvalue="30"
                        name="generate_recurring_payment" data-limit="2" placeholder="" />
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="recurring_payments_enable"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.recurring_electronic_payments_to_add_other_fee')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="recurring_payments_enable" required name="recurring_payments" type="radio"
                            class="form-check-input" value="enable">
                        <label for="recurring_payments_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="recurring_payments_disable" required name="recurring_payments" type="radio"
                            class="form-check-input" value="disable">
                        <label for="recurring_payments_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
			<hr>
            <div class="mb-3">
                <h6>One-time Options</h6>
            </div>
            <div class="form-group row align-items-center">
                <label for="payment_calculation_method_current_amount_due"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.payment_calculation_method')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="payment_calculation_method_current_amount_due" required
                            name="payment_calculation_method" type="radio" class="form-check-input"
                            value="Current amount due">
                        <label for="payment_calculation_method_current_amount_due"
                            class="form-check-label">@lang('labels.current_amount_due')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="payment_calculation_method_installment_amount" required
                            name="payment_calculation_method" type="radio" class="form-check-input"
                            value="Installment amount">
                        <label for="payment_calculation_method_installment_amount"
                            class="form-check-label">@lang('labels.installment_amount')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="payment_calculation_method_installment_amount_fees" required
                            name="payment_calculation_method" type="radio" class="form-check-input"
                            value="Installment amount + fees">
                        <label for="payment_calculation_method_installment_amount_fees"
                            class="form-check-label">@lang('labels.installment_amount_fees')</label>
                    </div>
                </div>
            </div>

            <div class="form-group row align-items-center">
                <label for="insured_payments_process_enable"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.Insured_one_time_payments_process_same_day')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="insured_payments_process_enable" required name="insured_payments_process"
                            type="radio" class="form-check-input" value="enable">
                        <label for="insured_payments_process_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="insured_payments_process_disable" required name="insured_payments_process"
                            type="radio" class="form-check-input" value="disable">
                        <label for="insured_payments_process_disable" class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="electronic_payment_other_fee_enable"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.electronic_payment_to_add_other_fee')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="electronic_payment_other_fee_enable" required name="electronic_payment_other_fee"
                            type="radio" class="form-check-input" value="enable">
                        <label for="electronic_payment_other_fee_enable"
                            class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="electronic_payment_other_fee_disable" required name="electronic_payment_other_fee"
                            type="radio" class="form-check-input" value="disable">
                        <label for="electronic_payment_other_fee_disable"
                            class="form-check-label">@lang('labels.disable')</label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="one_time_ach_payment" class="col-sm-4 col-form-label ">@lang('labels.one_time_ach_payment')</label>
                <div class="col-sm-8">
                    <textarea name="one_time_ach_payment" id="one_time_ach_payment" cols="30" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="recurring_ach_payment" class="col-sm-4 col-form-label ">@lang('labels.recurring_ach_payment')</label>
                <div class="col-sm-8">
                    <textarea name="recurring_ach_payment" id="recurring_ach_payment" cols="30" class="form-control"
                        rows="3"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="one_time_credit_card_payment" class="col-sm-4 col-form-label ">@lang('labels.one_time_credit_card_payment')</label>
                <div class="col-sm-8">
                    <textarea name="one_time_credit_card_payment" id="one_time_credit_card_payment" cols="30" class="form-control"
                        rows="3"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="recurring_credit_card_payment" class="col-sm-4 col-form-label ">@lang('labels.recurring_credit_card_payment')</label>
                <div class="col-sm-8">
                    <textarea name="recurring_credit_card_payment" id="recurring_credit_card_payment" cols="30"
                        class="form-control" rows="3"></textarea>
                </div>
            </div>


			<hr>

            <div class="form-group row align-items-center">
                <label for="send_collection_letters_insured_enable"
                    class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.enable_payment_gateway')</label>
                <div class="col-sm-8">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="payment_gateway_square"  required name="payment_gateway" type="radio"
                            class="form-check-input" value="square">
                        <label for="payment_gateway_square" class="form-check-label">@lang('labels.square')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="payment_gateway_paypal" required  name="payment_gateway" type="radio"
                            class="form-check-input" value="paypal">
                        <label for="payment_gateway_paypal" class="form-check-label">@lang('labels.paypal')</label>
                    </div>
                </div>
            </div>

            <div class="providers_box d-none" data-tab="square">
                <div class="form-group row align-items-center">
                    <label for="square_payment_mode_slive"
                        class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.payment_mode')</label>
                    <div class="col-sm-8">
                        <div class="zinput zradio zradio-sm  zinput-inline">
                            <input id="square_payment_mode_slive"  name="square_payment_mode" type="radio"
                                class="form-check-input" value="live">
                            <label for="square_payment_mode_slive" class="form-check-label">@lang('labels.live')</label>
                        </div>
                        <div class="zinput zradio  zradio-sm   zinput-inline">
                            <input id="square_payment_mode_test"  name="square_payment_mode" type="radio"
                                class="form-check-input" value="test">
                            <label for="square_payment_mode_test" class="form-check-label">@lang('labels.test')</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="generate_recurring_payment"
                        class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.application_name')</label>
                    <div class="col-sm-8">
                        <x-jet-input type="text"  name="square_application_name" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="generate_recurring_payment"
                        class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.application_id')</label>
                    <div class="col-sm-8">
                        <x-jet-input type="text"  name="square_application_id" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="generate_recurring_payment"
                        class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.access_token')</label>
                    <div class="col-sm-8">
                        <x-jet-input type="text"  name="square_access_token" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="generate_recurring_payment"
                        class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.location_id')</label>
                    <div class="col-sm-8">
                        <x-jet-input type="text"  name="square_location_id" />
                    </div>
                </div>
            </div>
            <div class="providers_box  d-none" data-tab="paypal">

                <div class="form-group row align-items-center">
                    <label for="paypal_payment_mode_slive"
                        class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.payment_mode')</label>
                    <div class="col-sm-8">
                        <div class="zinput zradio zradio-sm  zinput-inline">
                            <input id="paypal_payment_mode_slive"  name="paypal_payment_mode" type="radio"
                                class="form-check-input" value="live">
                            <label for="paypal_payment_mode_slive" class="form-check-label">@lang('labels.live')</label>
                        </div>
                        <div class="zinput zradio  zradio-sm   zinput-inline">
                            <input id="paypal_payment_mode_test"  name="paypal_payment_mode" type="radio"
                                class="form-check-input" value="test">
                            <label for="paypal_payment_mode_test" class="form-check-label">@lang('labels.test')</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="paypal_api_username"
                        class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.api_username')</label>
                    <div class="col-sm-8">
                        <x-jet-input type="text"  name="paypal_api_username" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="api_password"
                        class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.api_password')</label>
                    <div class="col-sm-8">
                        <x-jet-input type="text"  name="paypal_api_password" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="generate_recurring_payment"
                        class="col-sm-4 col-form-label requiredAsterisk">@lang('labels.api_signature')</label>
                    <div class="col-sm-8">
                        <x-jet-input type="text"  name="paypal_api_signature" />
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
