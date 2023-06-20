<x-app-layout>
    <x-jet-form-section :buttonGroup="['logs', 'other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index')]]]" class="validationForm editForm" novalidate
        action="{{ routeCheck($route . 'update', $id) }}" method="post">


        @slot('form')
            @method('put')
            <input type="hidden" name="logsArr">
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.state_name')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('state', stateDropDown(['keyType' => 'id', 'onDB' => true]), '', [
                        'class' => 'ui dropdown input-sm w-100 disabled',
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('status', [1 => 'Enable', 2 => 'Disable'], '', [
                        'class' => "ui dropdown input-sm
                                    w-100",
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('status', [1 => 'Enable', 2 => 'Disable'], '', [
                        'class' => "ui dropdown input-sm
                                    w-100",
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="refund_send_check" class="col-sm-3 col-form-label">@lang('labels.refund_send_check_to') <i
                        class="ml-1 large fw-600 color-info fa-regular fa-circle-info tooltipPopup"
                        data-sm-title="@lang('tooltip.state_setting.refund_send_check.title')" data-sm-content="@lang('tooltip.state_setting.refund_send_check.content')"></i></label>
                <div class="col-sm-9">
                    {!! form_dropdown('refund_send_check', ['' => '', 'Insured' => 'Insured', 'Agent' => 'Agent'], '', [
                        'class' => "ui dropdown input-sm
                                    w-100",
                    ]) !!}

                </div>
            </div>
            <div class="form-group row">
                <label for="spread_method" class="col-sm-3 col-form-label">@lang('labels.interest_spread_method') <i
                        class="ml-1 large fw-600 color-info fa-regular fa-circle-info tooltipPopup"
                        data-sm-title="@lang('tooltip.state_setting.spread_method.title')" data-sm-content="@lang('tooltip.state_setting.spread_method.content')"></i></label>
                <div class="col-sm-9">
                    {!! form_dropdown('spread_method', rateTableDropDown(), '', [
                        'class' => "ui dropdown input-sm
                                    w-100",
                    ]) !!}

                </div>
            </div>
            <div class="form-group row">
                <label for="refund_required" class="col-sm-3 col-form-label">@lang('labels.no_refund_required_if_less_than')</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm twodigitno" name="refund_required"
                        id="refund_required" placeholder="$">
                </div>
            </div>
            <div class="form-group row">
                <label for="interest_earned_start_date" class="col-sm-3 col-form-label">@lang('labels.interest_earned_start_date') <i
                        class="ml-1 large fw-600 color-info fa-regular fa-circle-info tooltipPopup"
                        data-sm-title="@lang('tooltip.state_setting.interest_earned_start_date.title')" data-sm-content="@lang('tooltip.state_setting.interest_earned_start_date.content')"></i></label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'interest_earned_start_date',
                        [
                            'Not regulated',
                            'Effective date',
                            'The earlier of the effective
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
                <label for="interest_earned_stop_date" class="col-sm-3 col-form-label">@lang('labels.interest_earned_stop_date') <i
                        class="ml-1 large fw-600 color-info fa-regular fa-circle-info tooltipPopup"
                        data-sm-title="@lang('tooltip.state_setting.interest_earned_stop_date.title')" data-sm-content="@lang('tooltip.state_setting.interest_earned_stop_date.content')"></i></label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'interest_earned_stop_date',
                        ['Not regulated', 'Cancellation date', 'Nearest due date'],
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
                <label for="licensed_personal" class="col-sm-3 col-form-label">@lang('labels.licensed_for_personal')</label>
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
            <div class="form-group row" x-data="{ dropdown: '{{ !empty($data['nsf_fee_lesser_greater']) ? true : false }}' }">
                <label for="nsf_fees" class="col-sm-3 col-form-label">@lang('labels.nsf_fees')</label>
                <div class="col-sm-9">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <x-jet-input type="text" class="percentage_input" name="percentage_nsf_fee"
                                placeholder="%" />
                        </div>
                        <div class="col-md-1" x-text="(dropdown == false ? '+' : 'OR')"></div>
                        <div class="col-md-2">
                            <x-jet-input type="text" class="amount" name="nsf_fees" placeholder="$" />
                        </div>
                        <div class="col-md-2" x-show="dropdown">
                            <x-select :options="['' => '', 'lesser' => 'Lesser', 'greater' => 'Greater']" class="ui dropdown" name="nsf_fee_lesser_greater" />
                        </div>
                        <div class="col-md-5">
                            <x-jet-checkbox x-on:change="dropdown = $el.checked" :checked="!empty($data['nsf_fee_lesser_greater']) ? true : false"
                                name="nsf_fee_lesser_greater_checkbox" id="nsf_fee_lesser_greater_checkbox"
                                labelText="Lesser/Greater" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="licensed_commercial" class="col-sm-3 col-form-label">@lang('labels.licensed_for_commercial')</label>
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
                <label for="maximum_charge" class="col-sm-3 col-form-label">@lang('labels.maximum_charge_off')</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm amount" name="maximum_charge" id="maximum_charge"
                        placeholder="$">
                </div>
            </div>
            <div class="form-group row">
                <label for="agent_authority" class="col-sm-3 col-form-label">@lang('labels.agent_authority_to_sign_contracts')</label>
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
                <label for="late_fees" class="col-sm-3 col-form-label">@lang('labels.can_late_fees_accrue')</label>
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
                <label for="refund_payable" class="col-sm-3 col-form-label">@lang('labels.refund_payable_to')</label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'refund_payable',
                        ['Insured' => 'Insured', 'Agent' => 'Agent', 'Insured_Agent' => 'Insured or Agent'],
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
                        <div class="col-sm-6"><label>@lang('labels.personal_account') </label></div>
                        <div class="col-sm-6"><label>@lang('labels.commercial_account') </label></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="personal_maximum_finance_amount" class="col-sm-3 col-form-label">
                    @lang('labels.maximum_finance_amount')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6"><input type="text" class="form-control input-sm amount"
                                name="personal_maximum_finance_amount" id="personal_maximum_finance_amount"
                                placeholder="$"></div>
                        <div class="col-sm-6"><input type="text" class="form-control input-sm amount"
                                name="commercial_maximum_finance_amount" id="commercial_maximum_finance_amount"
                                placeholder="$"></div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="minimum_interest" class="col-sm-3 col-form-label">@lang('labels.minimum_earned_interest')</label>
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
                <label for="maximum_rate" class="col-sm-3 col-form-label">@lang('labels.maximum_interest_rate')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6 mainRow" x-data="{ table: '{{ !empty($data['personal_multiple_maximum_rate']) ? true : false }}' }">
                            <div class="row">
                                <div class="col-md-6" x-show="!table">
                                    <x-jet-input type="text" class="percentage_input" name="maximum_rate"
                                        placeholder="%" />
                                </div>
                                <div class="col-md-6">
                                    <x-jet-checkbox x-on:change="table = $el.checked" class="no_editd" :checked="!empty($data['personal_multiple_maximum_rate']) ? true : false"
                                        name="personal_multiple_maximum_rate" value="1"
                                        id="personal_multiple_maximum_rate" labelText="Multiple Interest Rate" />
                                </div>
                                <div class="col-md-6" x-show="table">
                                    <div class="columns d-flex justify-content-end ">
                                        <button
                                            class="btn btn-default borderless deleteRowTableFee linkButton pl-0 pr-0 p-0 pt-2"
                                            type="button" name="Delete Range">Delete Range</button>
                                        <button
                                            class="btn btn-default borderless addRowTableFee linkButton pl-0 pr-0 p-0 pt-2"
                                            type="button" name="Add Range">Add Range</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row" x-show="table">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table addRateTable" id="addRateTable">
                                            <thead>
                                                <tr>
                                                    <th width="9"></th>
                                                    <th> @lang('labels.from')</th>
                                                    <th> @lang('labels.to')</th>
                                                    <th> @lang('labels.rate')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($personalMultipleMaximumRate?->toArray()))
                                                    @foreach ($personalMultipleMaximumRate as $key => $value)
                                                        <tr>
                                                            <x-jet-input type="hidden" class="no_editd type"
                                                                name="personal_multiple_maximum_rate_table[interest_rate_type]"
                                                                value="personal_multiple_maximum_rate" />
                                                            <x-jet-input type="hidden" class="feeTableRowId"
                                                                data-name="personal_multiple_maximum_rate_table"
                                                                name="personal_multiple_maximum_rate_table[feeId][]"
                                                                value="{{ $value['id'] }}" />
                                                            <td>
                                                                <x-jet-checkbox
                                                                    for="personal_multiple_maximum_rate_row_{{ $loop->iteration }}"
                                                                    id="personal_multiple_maximum_rate_row_{{ $loop->iteration }}"
                                                                    class="fee_amount_row deleteCheckBoxFee"
                                                                    value="personal_multiple_maximum_rate" />
                                                            </td>
                                                            <td>
                                                                <x-jet-input type="text" class="amount from_amount"
                                                                    name="personal_multiple_maximum_rate_table[from][]"
                                                                    value="{{ $value['from'] }}"
                                                                    id="from_{{ $loop->iteration }}"
                                                                    x-bind:required="(table ? true : false)"
                                                                    placeholder="$" />
                                                            </td>
                                                            <td>
                                                                <x-jet-input type="text" class="amount to_amount"
                                                                    name="personal_multiple_maximum_rate_table[to][]"
                                                                    id="to_{{ $loop->iteration }}"
                                                                    value="{{ $value['to'] }}"
                                                                    x-bind:required="(table ? true : false)"
                                                                    placeholder="$" />
                                                            </td>
                                                            <td>
                                                                <x-jet-input type="text"
                                                                    class="percentageInput rate_tab"
                                                                    name="personal_multiple_maximum_rate_table[rate][]"
                                                                    id="rate_{{ $loop->iteration }}"
                                                                    value="{{ $value['rate'] }}"
                                                                    x-bind:required="(table ? true : false)"
                                                                    placeholder="%" />
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <x-jet-input type="hidden" class="no_editd type"
                                                            name="personal_multiple_maximum_rate_table[interest_rate_type]"
                                                            value="personal_multiple_maximum_rate" />
                                                        <td>
                                                            <x-jet-checkbox for="personal_multiple_maximum_rate_row_1"
                                                                id="personal_multiple_maximum_rate_row_1"
                                                                class="fee_amount_row deleteCheckBoxFee" value="" />
                                                        </td>
                                                        <td>
                                                            <x-jet-input type="text" class="amount from_amount"
                                                                name="personal_multiple_maximum_rate_table[from][]"
                                                                id="name" x-bind:required="(table ? true : false)"
                                                                placeholder="$" />
                                                        </td>
                                                        <td>
                                                            <x-jet-input type="text" class="amount to_amount"
                                                                name="personal_multiple_maximum_rate_table[to][]"
                                                                id="name" x-bind:required="(table ? true : false)"
                                                                placeholder="$" />
                                                        </td>
                                                        <td>
                                                            <x-jet-input type="text" class="percentageInput"
                                                                name="personal_multiple_maximum_rate_table[rate][]"
                                                                id="name" x-bind:required="(table ? true : false)"
                                                                placeholder="%" />
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mainRow" x-data="{ table: '{{ !empty($data['personal_multiple_comm_maximum_rate']) ? true : false }}' }">
                            <div class="row">
                                <div class="col-md-6" x-show="!table">
                                    <x-jet-input type="text" class="percentage_input" name="comm_maximum_rate"
                                        placeholder="%" />
                                </div>
                                <div class="col-md-6">
                                    <x-jet-checkbox x-on:change="table = $el.checked" class="no_editd" :checked="!empty($data['personal_multiple_comm_maximum_rate']) ? true : false"
                                        name="personal_multiple_comm_maximum_rate" value="1"
                                        id="personal_multiple_comm_maximum_rate" labelText="Multiple Interest Rate" />
                                </div>
                                <div class="col-md-6" x-show="table">
                                    <div class="columns d-flex justify-content-end ">
                                        <button
                                            class="btn btn-default borderless deleteRowTableFee linkButton pl-0 pr-0 p-0 pt-2"
                                            type="button" name="Delete Range">Delete Range</button>
                                        <button
                                            class="btn btn-default borderless addRowTableFee linkButton pl-0 pr-0 p-0 pt-2"
                                            type="button" name="Add Range">Add Range</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row" x-show="table">
                                <div class="col-md-12">
                                    <div class="table-responsive">

                                        <table class="table addRateTable" id="addRateTable">
                                            <thead>
                                                <tr>
                                                    <th width="9"></th>
                                                    <th> @lang('labels.from')</th>
                                                    <th> @lang('labels.to')</th>
                                                    <th> @lang('labels.rate')</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (!empty($personalMultipleCommMaximumRate?->toArray()))
                                                    @foreach ($personalMultipleCommMaximumRate as $key => $value)
                                                        <tr>
                                                            <x-jet-input type="hidden" class="no_editd type"
                                                                name="personal_multiple_comm_maximum_rate_table[interest_rate_type]"
                                                                value="personal_multiple_comm_maximum_rate" />
                                                            <x-jet-input type="hidden" class="feeTableRowId no_editd"
                                                                data-name="personal_multiple_comm_maximum_rate_table"
                                                                name="personal_multiple_comm_maximum_rate_table[feeId][]"
                                                                value="{{ $value['id'] }}" />
                                                            <td>
                                                                <x-jet-checkbox
                                                                    for="personal_multiple_comm_maximum_rate_{{ $loop->iteration }}"
                                                                    id="personal_multiple_comm_maximum_rate_{{ $loop->iteration }}"
                                                                    class="fee_amount_row deleteCheckBoxFee"
                                                                    value="personal_multiple_comm_maximum_rate" />
                                                            </td>
                                                            <td>
                                                                <x-jet-input type="text" class="amount from_amount"
                                                                    name="personal_multiple_comm_maximum_rate_table[from][]"
                                                                    value="{{ $value['from'] }}"
                                                                    id="from_{{ $loop->iteration }}"
                                                                    x-bind:required="(table ? true : false)"
                                                                    placeholder="$" />
                                                            </td>
                                                            <td>
                                                                <x-jet-input type="text" class="amount to_amount"
                                                                    name="personal_multiple_comm_maximum_rate_table[to][]"
                                                                    value="{{ $value['to'] }}"
                                                                    id="to_{{ $loop->iteration }}"
                                                                    x-bind:required="(table ? true : false)"
                                                                    placeholder="$" />
                                                            </td>
                                                            <td>
                                                                <x-jet-input type="text"
                                                                    class="percentageInput rate_tab"
                                                                    name="personal_multiple_comm_maximum_rate_table[rate][]"
                                                                    value="{{ $value['rate'] }}"
                                                                    id="rate_{{ $loop->iteration }}"
                                                                    x-bind:required="(table ? true : false)"
                                                                    placeholder="%" />
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <x-jet-input type="hidden" class="no_editd type"
                                                            name="personal_multiple_comm_maximum_rate_table[interest_rate_type]"
                                                            value="personal_multiple_comm_maximum_rate" />
                                                        <td>
                                                            <x-jet-checkbox for="personal_multiple_comm_maximum_rate_1"
                                                                id="personal_multiple_comm_maximum_rate_1"
                                                                class="fee_amount_row deleteCheckBoxFee" value="" />
                                                        </td>
                                                        <td>
                                                            <x-jet-input type="text" class="amount from_amount"
                                                                name="personal_multiple_comm_maximum_rate_table[from][]"
                                                                id="name" x-bind:required="(table ? true : false)"
                                                                placeholder="$" />
                                                        </td>
                                                        <td>
                                                            <x-jet-input type="text" class="amount to_amount"
                                                                name="personal_multiple_comm_maximum_rate_table[to][]"
                                                                id="name" x-bind:required="(table ? true : false)"
                                                                placeholder="$" />
                                                        </td>
                                                        <td>
                                                            <x-jet-input type="text" class="percentageInput"
                                                                name="personal_multiple_comm_maximum_rate_table[rate][]"
                                                                id="name" x-bind:required="(table ? true : false)"
                                                                placeholder="%" />
                                                        </td>
                                                    </tr>
                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>


                        </div>


                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="maximum_setup_fee" class="col-sm-3 col-form-label">@lang('labels.maximum_setup_fee')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6 align-items-center">
                            <div class="row" x-data="{ dropdown: '{{ !empty($data['maximum_setup_fee_lesser_greater']) ? true : false }}' }">

                                <div class="col-md-2">
                                    <x-jet-input type="text" class="percentage_input"
                                        name="percentage_maximum_setup_fee" placeholder="%" />
                                </div>
                                <div class="col-md-1" x-text="(dropdown == false ? '+' : 'OR')"></div>
                                <div class="col-md-2">
                                    <x-jet-input type="text" class="amount" name="maximum_setup_fee"
                                        placeholder="$" />
                                </div>
                                <div class="col-md-2" x-show="dropdown">
                                    <x-select :options="['' => '', 'lesser' => 'Lesser', 'greater' => 'Greater']" class="ui dropdown"
                                        name="maximum_setup_fee_lesser_greater" />
                                </div>
                                <div class="col-md-5">
                                    <x-jet-checkbox x-on:change="dropdown = $el.checked" :checked="!empty($data['maximum_setup_fee_lesser_greater']) ? true : false"
                                        name="maximum_setup_feelesser_greater_checkbox"
                                        id="maximum_setup_feelesser_greater_checkbox" labelText="Lesser/Greater" />
                                </div>

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="row align-items-center" x-data="{ dropdown: '{{ !empty($data['maximum_comm_setup_fee_lesser_greater']) ? true : false }}' }">


                                <div class="col-md-2">
                                    <x-jet-input type="text" class="percentage_input"
                                        name="percentage_comm_maximum_setup_fee" placeholder="%" />
                                </div>
                                <div class="col-md-1" x-text="(dropdown == false ? '+' : 'OR')"></div>
                                <div class="col-md-2">
                                    <x-jet-input type="text" class="amount" name="comm_maximum_setup_fee"
                                        placeholder="$" />
                                </div>
                                <div class="col-md-2" x-show="dropdown">
                                    <x-select :options="['' => '', 'lesser' => 'Lesser', 'greater' => 'Greater']" class="ui dropdown"
                                        name="maximum_comm_setup_fee_lesser_greater" />
                                </div>
                                <div class="col-md-5">
                                    <x-jet-checkbox x-on:change="dropdown = $el.checked" :checked="!empty($data['maximum_comm_setup_fee_lesser_greater']) ? true : false"
                                        name="maximum_comm_setup_fee_lesser_greater_checkbox"
                                        id="maximum_comm_setup_fee_lesser_greater_checkbox" labelText="Lesser/Greater" />
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="setup_Percent" class="col-sm-3 col-form-label">@lang('labels.setup_fee_percent_in_down')</label>
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
                <label for="due_date_intent_cancel" class="col-sm-3 col-form-label">
                    @lang('labels.days_from_due_date_to_intent_to_cancel')</label>
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
                <label for="intent_cancel" class="col-sm-3 col-form-label">@lang('labels.days_from_intent_to_cancel_to_cancel')</label>
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
                <label for="effective_cancel" class="col-sm-3 col-form-label">
                    @lang('labels.days_from_cancel_to_effective_cancel')</label>
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
                <label for="max_setup_fee" class="col-sm-3 col-form-label">@lang('labels.compute_max_setup_fee_per_account')</label>
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
                <label for="percentage_late_fee" class="col-sm-3 col-form-label">@lang('labels.late_fee')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class=" row align-items-center" x-data="{ dropdown: '{{ !empty($data['late_fee_lesser_greater']) ? true : false }}' }">

                                <div class="col-md-2">
                                    <x-jet-input type="text" class="percentage_input" name="percentage_late_fee"
                                        placeholder="%" />
                                </div>
                                <div class="col-md-1" x-text="(dropdown == false ? '+' : 'OR')"></div>
                                <div class="col-md-2">
                                    <x-jet-input type="text" class="amount" name="late_fee" placeholder="$" />
                                </div>
                                <div class="col-md-2" x-show="dropdown">
                                    <x-select :options="['' => '', 'lesser' => 'Lesser', 'greater' => 'Greater']" class="ui dropdown" name="late_fee_lesser_greater" />
                                </div>
                                <div class="col-md-5">
                                    <x-jet-checkbox x-on:change="dropdown = $el.checked" :checked="!empty($data['late_fee_lesser_greater']) ? true : false"
                                        name="late_fee_lesser_greater_checke" id="late_fee_lesser_greater_checke"
                                        labelText="Lesser/Greater" />
                                </div>

                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class=" row align-items-center" x-data="{ dropdown: '{{ !empty($data['late_fee_lesser_greater_comm']) ? true : false }}' }">

                                <div class="col-md-2">
                                    <x-jet-input type="text" class="percentage_input" name="percentage_comm_late_fee"
                                        placeholder="%" />
                                </div>
                                <div class="col-md-1" x-text="(dropdown == false ? '+' : 'OR')"></div>
                                <div class="col-md-2">
                                    <x-jet-input type="text" class="amount" name="comm_late_fee" placeholder="$" />
                                </div>
                                <div class="col-md-2" x-show="dropdown">
                                    <x-select :options="['' => '', 'lesser' => 'Lesser', 'greater' => 'Greater']" class="ui dropdown"
                                        name="late_fee_lesser_greater_comm" />
                                </div>
                                <div class="col-md-5">
                                    <x-jet-checkbox x-on:change="dropdown = $el.checked" :checked="!empty($data['late_fee_lesser_greater_comm']) ? true : false"
                                        name="late_fee_lesser_greater_comm_chec" id="late_fee_lesser_greater_comm_chec"
                                        labelText="Lesser/Greater" />
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="percentage_minimum_late_fee" class="col-sm-3 col-form-label">@lang('labels.minimum_late_fee')</label>
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
                <label for="percentage_maximum_late_fee" class="col-sm-3 col-form-label">@lang('labels.maximum_late_fee')</label>
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
                <label for="day_before_late_fee" class="col-sm-3 col-form-label">@lang('labels.days_before_late_fee')</label>
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
                <label for="cancellation_fee" class="col-sm-3 col-form-label">@lang('labels.cancellation_fee')</label>
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
                <label for="percentage_fee_credit_card" class="col-sm-3 col-form-label">
                    @lang('labels.other_fee_for_credit_card')</label>
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
                <label for="percentage_check_credit_card" class="col-sm-3 col-form-label">
                    @lang('labels.other_fee_for_echecks_ach')</label>
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
                <label for="percentage_recurring_credit_card" class="col-sm-3 col-form-label">
                    @lang('labels.other_fee_for_recurring_credit_card')</label>
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
                <label for="percentage_recurring_credit_card_check" class="col-sm-3 col-form-label">
                    @lang('labels.other_fee_for_recurring_echecks_ach')</label>
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
                <label for="agent_rebates" class="col-sm-3 col-form-label"> @lang('labels.agent_rebates') <i
                        class="ml-1 large fw-600 color-info fa-regular fa-circle-info tooltipPopup"
                        data-sm-title="@lang('tooltip.state_setting.agent_rebates.title')" data-sm-content="@lang('tooltip.state_setting.agent_rebates.content')"></i></label>
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
                <label for="policies_short_rate" class="col-sm-3 col-form-label">@lang('labels.default_policies_to_short_rate')<i
                        class="ml-1 large fw-600 color-info fa-regular fa-circle-info tooltipPopup"
                        data-sm-title="@lang('tooltip.state_setting.policies_short_rate.title')" data-sm-content="@lang('tooltip.state_setting.policies_short_rate.content')"></i></label>
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


            <x-slot name="saveOrCancel"></x-slot>
        @endslot
        @slot('logContent')
            <x-table id="{{ $activePage ?? '' }}-logs"
                ajaxUrl="{{ routeCheck('company.logs', ['type' => $activePage, 'id' => $id]) }}">
                <thead>
                    <tr>
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">
                            @lang('labels.created_date')
                        </th>

                        <th class="" data-sortable="true" data-field="username" data-width="200">
                            @lang('labels.user_name')
                        </th>
                        <th class="" data-sortable="true" data-field="message">@lang('labels.description')</th>
                    </tr>
                </thead>
            </x-table>
        @endslot
    </x-jet-form-section>
    @push('page_script')
        <script>
            let editArr = @json($data ?? []);
        </script>
    @endpush
</x-app-layout>
