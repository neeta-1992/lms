
<x-app-layout>
    <x-jet-form-section :buttonGroup="['logs', 'other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index') ]]]" class="validationForm editForm" novalidate action="{{ routeCheck($route . 'update', $id) }}"
        method="post">

        @slot('form')
            @method('put')
            <input type="hidden" name="logsArr">
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">State Name</label>
                <div class="col-sm-9">
                    {!! form_dropdown('state', stateDropDown(['keyType' => 'id']), '', [
                        'class' => "ui dropdown input-sm w-100 disabled",
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label requiredAsterisk">Status</label>
                <div class="col-sm-9">
                    {!! form_dropdown('status', [1 => 'Enable',2=>'Disable'], '', [
                        'class' => "ui dropdown input-sm w-100",
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="refund_send_check" class="col-sm-3 col-form-label">Refund Send Check To <i
                        class="ml-1 large fw-600 color-info fa-regular fa-circle-info  tooltipPopup" data-sm-title="@lang('tooltip.state_setting.refund_send_check.title')"
                        data-sm-content="@lang('tooltip.state_setting.refund_send_check.content')"></i></label>
                <div class="col-sm-9">
                    {!! form_dropdown('refund_send_check', ['' => '', 'Insured' => 'Insured', 'Agent' => 'Agent'], '', [
                        'class' => "ui dropdown input-sm w-100",
                    ]) !!}

                </div>
            </div>
            <div class="form-group row">
                <label for="spread_method" class="col-sm-3 col-form-label">Interest Spread Method <i
                        class="ml-1 large fw-600 color-info fa-regular fa-circle-info  tooltipPopup" data-sm-title="@lang('tooltip.state_setting.spread_method.title')"
                        data-sm-content="@lang('tooltip.state_setting.spread_method.content')"></i></label>
                <div class="col-sm-9">
                    {!! form_dropdown('spread_method', rateTableDropDown(), '', [
                        'class' => "ui dropdown input-sm
                                    w-100",
                    ]) !!}

                </div>
            </div>
            <div class="form-group row">
                <label for="refund_required" class="col-sm-3 col-form-label">No Refund Required If Less Than</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm twodigitno" name="refund_required"
                        id="refund_required" placeholder="$">
                </div>
            </div>
            <div class="form-group row">
                <label for="interest_earned_start_date" class="col-sm-3 col-form-label">Interest Earned Start Date <i
                        class="ml-1 large fw-600 color-info fa-regular fa-circle-info  tooltipPopup" data-sm-title="@lang('tooltip.state_setting.interest_earned_start_date.title')"
                        data-sm-content="@lang('tooltip.state_setting.interest_earned_start_date.content')"></i></label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'interest_earned_start_date',
                        [
                            'Not regulated',
                            'Effective date',
                            'The earlier of the
                                    effective
                                    date or first due date',
                        ],
                        '',
                        [
                            'class' => "ui dropdown input-sm
                                    w-100",
                        ],
                        $isValueKey = true,
                    ) !!}

                </div>
            </div>
            <div class="form-group row">
                <label for="interest_earned_stop_date" class="col-sm-3 col-form-label">Interest Earned Stop Date <i
                        class="ml-1 large fw-600 color-info fa-regular fa-circle-info  tooltipPopup" data-sm-title="@lang('tooltip.state_setting.interest_earned_stop_date.title')"
                        data-sm-content="@lang('tooltip.state_setting.interest_earned_stop_date.content')"></i></label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'interest_earned_stop_date',
                        [
                            'Not regulated',
                            'Cancellation date',
                            'Nearest due
                                    date',
                        ],
                        '',
                        [
                            'class' => "ui dropdown input-sm
                                    w-100",
                        ],
                        $isValueKey = true,
                    ) !!}

                </div>
            </div>
            <div class="form-group row">
                <label for="licensed_personal" class="col-sm-3 col-form-label">Licensed for Personal</label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'licensed_personal',
                        ['Yes', 'No'],
                        '',
                        [
                            'class' => "ui
                                    dropdown input-sm
                                    w-100",
                        ],
                        $isValueKey = true,
                    ) !!}

                </div>
            </div>
            <div class="form-group row">
                <label for="nsf_fees" class="col-sm-3 col-form-label">NSF Fees</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm amount" name="nsf_fees" id="nsf_fees"
                        placeholder="$">
                </div>
            </div>
            <div class="form-group row">
                <label for="licensed_commercial" class="col-sm-3 col-form-label">Licensed for Commercial</label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'licensed_commercial',
                        ['Yes', 'No'],
                        '',
                        [
                            'class' => "ui
                                    dropdown input-sm
                                    w-100",
                        ],
                        $isValueKey = true,
                    ) !!}

                </div>
            </div>
            <div class="form-group row">
                <label for="maximum_charge" class="col-sm-3 col-form-label">Maximum Charge Off</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm amount" name="maximum_charge" id="maximum_charge"
                        placeholder="$">
                </div>
            </div>
            <div class="form-group row">
                <label for="agent_authority" class="col-sm-3 col-form-label">Agent Authority to Sign Contracts</label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'agent_authority',
                        ['Allowed', 'Prohibited'],
                        '',
                        [
                            'class' => "ui
                                    dropdown input-sm
                                    w-100",
                        ],
                        $isValueKey = true,
                    ) !!}

                </div>
            </div>
            <div class="form-group row">
                <label for="late_fees" class="col-sm-3 col-form-label">Can Late Fees Accrue</label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'late_fees',
                        ['Yes', 'No'],
                        '',
                        [
                            'class' => "ui
                                    dropdown input-sm
                                    w-100",
                        ],
                        $isValueKey = true,
                    ) !!}

                </div>
            </div>
            <div class="form-group row">
                <label for="refund_payable" class="col-sm-3 col-form-label">Refund Payable To</label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'refund_payable',
                        [
                            'Insured' => 'Insured',
                            'Agent' => 'Agent',
                            'Insured_Agent' => "Insured or
                                    Agent",
                        ],
                        '',
                        [
                            'class' => "ui
                                    dropdown input-sm
                                    w-100",
                        ],
                    ) !!}

                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6"><label>Personal Account</label></div>
                        <div class="col-sm-6"><label>Commercial Account</label></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="personal_maximum_finance_amount" class="col-sm-3 col-form-label">Maximum Finance
                    Amount</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6"><input type="text" class="form-control input-sm amount"
                                name="personal_maximum_finance_amount" id="personal_maximum_finance_amount"
                                placeholder="$">
                        </div>
                        <div class="col-sm-6"><input type="text" class="form-control input-sm amount"
                                name="commercial_maximum_finance_amount" id="commercial_maximum_finance_amount"
                                placeholder="$"></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="minimum_interest" class="col-sm-3 col-form-label">Minimum Earned Interest</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6"><input type="text" class="form-control input-sm amount"
                                name="minimum_interest" id="minimum_interest" placeholder="$"></div>
                        <div class="col-sm-6"><input type="text" class="form-control input-sm amount"
                                name="comm_minimum_interest" id="comm_minimum_interest" placeholder="$"></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="maximum_rate" class="col-sm-3 col-form-label">Maximum Interest Rate</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6"><input type="text" class="form-control input-sm percentage_input"
                                name="maximum_rate" id="maximum_rate" placeholder="%"></div>
                        <div class="col-sm-6"><input type="text" class="form-control input-sm percentage_input"
                                name="comm_maximum_rate" id="comm_maximum_rate" placeholder="%"></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="maximum_setup_fee" class="col-sm-3 col-form-label">Maximum Setup Fee</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6"><input type="text" class="form-control input-sm amount"
                                name="maximum_setup_fee" id="maximum_setup_fee" placeholder="$"></div>
                        <div class="col-sm-6"><input type="text" class="form-control input-sm amount"
                                name="comm_maximum_setup_fee" id="comm_maximum_setup_fee" placeholder="$"></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="setup_Percent" class="col-sm-3 col-form-label">Setup Fee Percent In Down</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6"><input type="text" class="form-control input-sm percentage_input"
                                name="setup_Percent" id="setup_Percent" placeholder="%"></div>
                        <div class="col-sm-6"><input type="text" class="form-control input-sm percentage_input"
                                name="comm_setup_Percent" id="comm_setup_Percent" placeholder="%"></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="due_date_intent_cancel" class="col-sm-3 col-form-label">Days From Due Date To Intent To
                    Cancel</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6"><input type="text" class="form-control input-sm twodigit"
                                name="due_date_intent_cancel" id="due_date_intent_cancel" placeholder=""></div>
                        <div class="col-sm-6"><input type="text" class="form-control input-sm twodigit"
                                name="comm_due_date_intent_cancel" id="comm_due_date_intent_cancel" placeholder="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="intent_cancel" class="col-sm-3 col-form-label">Days From Intent To Cancel To Cancel</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6"><input type="text" class="form-control input-sm twodigit"
                                name="intent_cancel" id="intent_cancel" placeholder=""></div>
                        <div class="col-sm-6"><input type="text" class="form-control input-sm twodigit"
                                name="comm_intent_cancel" id="comm_intent_cancel" placeholder=""></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="effective_cancel" class="col-sm-3 col-form-label">Days From Cancel To Effective
                    Cancel</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6"><input type="text" class="form-control input-sm twodigit"
                                name="effective_cancel" id="effective_cancel" placeholder=""></div>
                        <div class="col-sm-6"><input type="text" class="form-control input-sm twodigit"
                                name="comm_effective_cancel" id="comm_effective_cancel" placeholder=""></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="max_setup_fee" class="col-sm-3 col-form-label">Compute Max Setup Fee Per Account</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">

                            {!! form_dropdown(
                                'max_setup_fee',
                                ['Yes', 'No'],
                                '',
                                [
                                    'class' => "ui
                                                    dropdown input-sm
                                                    w-100",
                                ],
                                $isValueKey = true,
                            ) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! form_dropdown(
                                'comm_max_setup_fee',
                                ['Yes', 'No'],
                                '',
                                [
                                    'class' => "ui
                                                    dropdown input-sm
                                                    w-100",
                                ],
                                $isValueKey = true,
                            ) !!}

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="percentage_late_fee" class="col-sm-3 col-form-label">Late Fee</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="w-25 d-inline form-control percentageInput input-sm" id="percentage_late_fee"
                                name="percentage_late_fee" type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="w-25 d-inline form-control amounts input-sm" id="" name="late_fee"
                                type="text">
                        </div>
                        <div class="col-sm-6">
                            <input class="d-inline w-25 form-control percentageInput input-sm" id=""
                                name="percentage_comm_late_fee" type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4  mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="d-inline w-25 form-control amounts input-sm" id=""
                                name="comm_late_fee" type="text">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="percentage_minimum_late_fee" class="col-sm-3 col-form-label">Minimum Late Fee</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="w-25 d-inline form-control percentageInput input-sm"
                                id="percentage_minimum_late_fee" name="percentage_minimum_late_fee" type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="w-25 d-inline form-control amounts input-sm" id=""
                                name="minimum_late_fee" type="text">
                        </div>
                        <div class="col-sm-6">
                            <input class="d-inline w-25 form-control percentageInput input-sm" id=""
                                name="percentage_comm_minimum_late_fee" type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="d-inline w-25 form-control amounts input-sm" id=""
                                name="comm_minimum_late_fee" type="text">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="percentage_maximum_late_fee" class="col-sm-3 col-form-label">Maximum Late Fee</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="w-25 d-inline form-control percentageInput input-sm"
                                id="percentage_maximum_late_fee" name="percentage_maximum_late_fee" type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="w-25 d-inline form-control amounts input-sm" id=""
                                name="maximum_late_fee" type="text">
                        </div>
                        <div class="col-sm-6">
                            <input class="d-inline w-25 form-control percentageInput input-sm" id=""
                                name="percentage_comm_maximum_late_fee" type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="d-inline w-25 form-control amounts input-sm" id=""
                                name="comm_maximum_late_fee" type="text">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="day_before_late_fee" class="col-sm-3 col-form-label">Days Before Late Fee</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6"><input class="form-control input-sm" id="day_before_late_fee"
                                name="day_before_late_fee" type="text"></div>
                        <div class="col-sm-6"><input class="form-control input-sm" id="comm_day_before_late_fee"
                                name="comm_day_before_late_fee" type="text"></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="cancellation_fee" class="col-sm-3 col-form-label">Cancellation Fee</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6"><input class="form-control input-sm amount" id="cancellation_fee"
                                name="cancellation_fee" type="text" placeholder="$"></div>
                        <div class="col-sm-6"><input class="form-control input-sm amount" id="comm_cancellation_fee"
                                name="comm_cancellation_fee" type="text" placeholder="$"></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="percentage_fee_credit_card" class="col-sm-3 col-form-label">Other Fee For Credit
                    Card</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="w-25 d-inline form-control percentageInput input-sm"
                                id="percentage_fee_credit_card" name="percentage_fee_credit_card" type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="w-25 d-inline form-control amounts input-sm" id=""
                                name="fee_credit_card" type="text">
                        </div>
                        <div class="col-sm-6">
                            <input class="d-inline w-25 form-control percentageInput input-sm"
                                id="percentage_comm_fee_credit_card" name="percentage_comm_fee_credit_card"
                                type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="d-inline w-25 form-control amounts input-sm" id=""
                                name="comm_fee_credit_card" type="text">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="percentage_check_credit_card" class="col-sm-3 col-form-label">Other Fee For
                    eChecks/ACH</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="w-25 d-inline form-control percentageInput input-sm"
                                id="percentage_check_credit_card" name="percentage_check_credit_card" type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="w-25 d-inline form-control amounts input-sm" id=""
                                name="check_credit_card" type="text">
                        </div>
                        <div class="col-sm-6">
                            <input class="d-inline w-25 form-control percentageInput input-sm"
                                id="percentage_comm_check_credit_card" name="percentage_comm_check_credit_card"
                                type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="d-inline w-25 form-control amounts input-sm" id=""
                                name="comm_check_credit_card" type="text">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="percentage_recurring_credit_card" class="col-sm-3 col-form-label">Other Fee For Recurring
                    Credit Card</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="w-25 d-inline form-control percentageInput input-sm"
                                id="percentage_recurring_credit_card" name="percentage_recurring_credit_card"
                                type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="w-25 d-inline form-control amounts input-sm" id=""
                                name="recurring_credit_card" type="text">
                        </div>
                        <div class="col-sm-6">
                            <input class="d-inline w-25 form-control percentageInput input-sm" id=""
                                name="percentage_comm_recurring_credit_card" type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="d-inline w-25 form-control amounts input-sm" id=""
                                name="comm_recurring_credit_card" type="text">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="percentage_recurring_credit_card_check" class="col-sm-3 col-form-label">Other Fee For
                    Recurring eChecks/ACH</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <input class="d-inline w-25 form-control percentageInput input-sm"
                                id="percentage_recurring_credit_card_check" name="percentage_recurring_credit_card_check"
                                type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="d-inline w-25 form-control amounts input-sm" id="recurring_credit_card_check"
                                name="recurring_credit_card_check" type="text">
                        </div>
                        <div class="col-sm-6">
                            <input class="d-inline w-25 form-control percentageInput input-sm"
                                id="percentage_comm_recurring_credit_card_check"
                                name="percentage_comm_recurring_credit_card_check" type="text">
                            <span class="d-inline mt-2"><label>%</label><span
                                    class="ml-4 mr-4"><label>+</label></span><span
                                    class="statemarginleft"><label>$</label></span></span>
                            <input class="d-inline w-25 form-control amounts input-sm"
                                id="comm_recurring_credit_card_check" name="comm_recurring_credit_card_check"
                                type="text">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="agent_rebates" class="col-sm-3 col-form-label">Agent Rebates <i
                        class="ml-1 large fw-600 color-info fa-regular fa-circle-info  tooltipPopup" data-sm-title="@lang('tooltip.state_setting.agent_rebates.title')"
                        data-sm-content="@lang('tooltip.state_setting.agent_rebates.content')"></i></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            {!! form_dropdown(
                                'agent_rebates',
                                ['Allowed', 'Prohibited'],
                                '',
                                [
                                    'class' => "ui
                                                    dropdown input-sm
                                                    w-100",
                                ],
                                $isValueKey = true,
                            ) !!}

                        </div>
                        <div class="col-sm-6">
                            {!! form_dropdown(
                                'comm_agent_rebates',
                                ['Allowed', 'Prohibited'],
                                '',
                                [
                                    'class' => "ui
                                                    dropdown input-sm
                                                    w-100",
                                ],
                                $isValueKey = true,
                            ) !!}

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="policies_short_rate" class="col-sm-3 col-form-label">Default Policies To Short Rate <i
                        class="ml-1 large fw-600 color-info fa-regular fa-circle-info  tooltipPopup" data-sm-title="@lang('tooltip.state_setting.policies_short_rate.title')"
                        data-sm-content="@lang('tooltip.state_setting.policies_short_rate.content')"></i></label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            {!! form_dropdown(
                                'policies_short_rate',
                                ['Yes', 'No'],
                                '',
                                [
                                    'class' => "ui
                                                    dropdown input-sm
                                                    w-100",
                                ],
                                $isValueKey = true,
                            ) !!}

                        </div>
                        <div class="col-sm-6">
                            {!! form_dropdown(
                                'comm_policies_short_rate',
                                ['Yes', 'No'],
                                '',
                                [
                                    'class' => "ui
                                                    dropdown input-sm
                                                    w-100",
                                ],
                                $isValueKey = true,
                            ) !!}

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                    <div class="row form-group align-top-radio">

                        <div class="col-sm-12">
                            <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                <input id="yes" class="form-check-input" name="save_option" checked type="radio"
                                    value="save_defaults_only">
                                <label for="yes" class="form-check-label">Save defaults only: EXISTING FINANCE
                                    COMPANIES ARE
                                    NOT AFFECTED</label>
                            </div>
                            <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                <input id="no" class="form-check-input" name="save_option" type="radio"
                                    value="save_and_reset">
                                <label for="no" class="form-check-label">Save and Reset existing FINANCE COMPANIES:
                                    Save the
                                    default coverage types values and apply the default coverage types
                                    values to all existing FINANCE COMPANIES for the coverage types. ALL EXISTING COVERAGE
                                    TYPES AND SPECIFIED VALUES FOR
                                    FINANCE COMPANIES WILL BE REPLACED.</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true"/>
        @endslot

        @slot('logContent')
            <x-bootstrap-table :data="[
                'table' => 'logs',
                'cookieid' => true,
                'sortorder' => 'desc',
                'sortname' => 'created_at',
                'type' => 'serversides',
                'ajaxUrl' => routeCheck('admin.logs', ['type' => activePageName(), 'id' => $id]),
            ]">
                <thead>
                    <tr>
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">Created Date
                        </th>

                        <th class="" data-sortable="true" data-field="username" data-width="200">User Name
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
