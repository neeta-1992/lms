<form class="validationForm editForm" novalidate action="{{ routeCheck('company.agents.other-settings',$id) }}"
    method="post">
    <input type="hidden" name="logsArr">
    <div class="form-group row">
        <label for="down_payment_increase"
            class="col-sm-3 col-form-label ingnorTitleCase">@lang('labels.down_paymen_percent_increase')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" class="digitLimit w-25" data-limit="2" name="down_payment_increase"
                value="{{ $data['down_payment_increase'] ?? '' }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="loan_origination_state"
            class="col-sm-3 col-form-label ">@lang('labels.default_loan_origination_state')</label>
        <div class="col-sm-9">
            {!! form_dropdown('loan_origination_state', stateDropDown(), ($data['loan_origination_state'] ?? ''),
            ['class' => 'w-100']) !!}
        </div>
    </div>

    <div class="form-group row">
        <label for="program" class="col-sm-3 col-form-label ">@lang('labels.program')</label>
        <div class="col-sm-9">
            @php
                $program = !empty($data['program']) ? json_decode($data['program'],true) : [] ;
            @endphp
            {!! form_dropdown('program[]', stateProgramSetting(), $program , ['class' => 'w-100 multiple','multiple'=>'multiple']) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="state" class="col-sm-3 col-form-label ">@lang('labels.origination_state_override')</label>
        <div class="col-sm-9">
            {!! form_dropdown('origination_state_override', stateDropDown(), ($data['origination_state_override'] ??
            ''), ['class' => 'w-100']) !!}
        </div>
    </div>

    <div class="form-group row">
        <label for="state"
            class="col-sm-3 col-form-label ">@lang('labels.down_payment_rule_for_original_quoting')</label>
        <div class="col-sm-9">

            {!! form_dropdown('down_payment_rule_original_quoting', downPaymentDropDown(),
            ($data['down_payment_rule_original_quoting'] ?? ''), ['class' => 'w-100']) !!}
        </div>
    </div>

    <div class="form-group row">
        <label for="down_payment_rule_ap_quoting"
            class="col-sm-3 col-form-label ">@lang('labels.down_payment_rule_for_ap_quoting')</label>
        <div class="col-sm-9">
            {!! form_dropdown('down_payment_rule_ap_quoting', downPaymentDropDown(), ($data['down_payment_rule_ap_quoting'] ??
            ''), ['class' => 'w-100']) !!}
        </div>
    </div>

    <div class="form-group row">
        <label for="name"
            class="col-sm-3 col-form-label ">@lang('labels.restrict_pfa_printing_below_this_amount_financed')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" class="amount" name="printing_below_amount_financed"
                value="{{ $data['printing_below_amount_financed'] ?? '' }}" />
        </div>
    </div>
    </div>

    <div class="form-group row">
        <label for="name"
            class="col-sm-3 col-form-label ">@lang('labels.restrict_pfa_printing_above_this_amount_financed')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" class="amount" name="printing_above_amount_financed"
                value="{{ $data['printing_above_amount_financed'] ?? '' }}" />
        </div>
    </div>

    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label ">@lang('labels.modify_quote_interest_rate')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" class="percentageInput" name="modify_quote_interest_rate"
                value="{{ $data['modify_quote_interest_rate'] ?? '' }}" />
        </div>
    </div>

    <div class="form-group row">
        <label for="state" class="col-sm-3 col-form-label ">@lang('labels.quotes_point_of_responsibility_user')</label>
        <div class="col-sm-9">
            {!! form_dropdown('quote_point', agentUsers(['agencyId'=>$id]), ($data['quote_point'] ?? ''), ['class' => 'w-100']) !!}
        </div>
    </div>
    {{--<div class="form-group row">
        <label for="state"
            class="col-sm-3 col-form-label ">@lang('labels.quotes_point_of_responsibility_user_group')</label>
        <div class="col-sm-9">
        </div> --}}

        <div class="form-group row">
            <label for="state"
                class="col-sm-3 col-form-label ">@lang('labels.accounts_point_of_responsibility_user')</label>
            <div class="col-sm-9">
                {!! form_dropdown('account_point', agentUsers(['agencyId'=>$id]), ($data['account_point'] ?? ''), ['class' =>
                'w-100']) !!}
            </div>
        </div>

        {{-- <div class="form-group row">
            <label for="state"
                class="col-sm-3 col-form-label ">@lang('labels.accounts_point_of_responsibility_user_group')</label>
            <div class="col-sm-9">

            </div>
        </div> --}}

        <div class="form-group row">
            <label for="state"
                class="col-sm-3 col-form-label ">@lang('labels.marketing_point_of_responsibility_user')</label>
            <div class="col-sm-9">
                {!! form_dropdown('marketing_point', agentUsers(['agencyId'=>$id]), ($data['marketing_point'] ?? ''), ['class' =>
                'w-100']) !!}
            </div>
        </div>
        {{--
        <div class="form-group row">
            <label for="state"
                class="col-sm-3 col-form-label ">@lang('labels.marketing_point_of_responsibility_user_group')</label>
            <div class="col-sm-9">

            </div>
        </div> --}}

        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label ">@lang('labels.processing_fee_table')</label>
            <div class="col-sm-9">
                {!! form_dropdown('processing_fee_table', processingTableDropDown(), ($data['processing_fee_table'] ?? ''),
                ['class' => 'w-100']) !!}
            </div>
        </div>

        <div class="mb-3">
            <p class="fw-600">E-Signature Workflow Settings</p>
        </div>

        <div class="form-group row">
            <label for="default_email_subject"
                class="col-sm-3 col-form-label ">@lang('labels.default_email_subject')</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="default_email_subject"
                    value="{{ $data['default_email_subject'] ?? '' }}" />

            </div>
        </div>

        <div class="form-group row">
            <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.default_email_message')</label>
            <div class="col-sm-9">
                <textarea name="default_email_message" id='default_email_message' cols="30" class="form-control"
                    rows="3"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="name"
                class="col-sm-3 col-form-label ">@lang('labels.make_email_message_read_only_so_the_default_must_be_used')</label>
            <div class="col-sm-9">
                <x-jet-checkbox for="email_message_read_only" name="email_message_read_only"
                    id="email_message_read_only" value="email_message_read_only" />

            </div>
        </div>

        <div class="form-group row">
            <label for="name"
                class="col-sm-3 col-form-label ">@lang('labels.make_email_subject_read_only_so_the_default_must_be_used')</label>
            <div class="col-sm-9">
                <x-jet-checkbox for="email_subject_read_only" name="email_subject_read_only"
                    id="email_subject_read_only" value="email_subject_read_only" />

            </div>
        </div>

        <div class="mb-3">
            <p class="fw-600">Signing Order</p>
        </div>

        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label ">@lang('labels.agent_signs')</label>
            <div class="col-sm-9">
                <?= form_dropdown('agent_signs', ['First' => 'First', 'Second' => 'Second'],  ($data['agent_signs'] ?? ''), ['class' => 'ui dropdown input-sm w-100']) ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label ">@lang('labels.insured_signs')</label>
            <div class="col-sm-9">
                <?= form_dropdown('insured_signs', ['yes' => 'Yes', 'no' => 'No'], ($data['insured_signs'] ?? ''), ['class' => 'ui dropdown input-sm w-100']) ?>
            </div>
        </div>

        <div class="mb-3">
            <p class="fw-600">Approval Step</p>
        </div>

        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label ">@lang('labels.require_approval_step')</label>
            <div class="col-sm-9">
                <x-jet-checkbox for="require_approval_step" name="require_approval_step" id="require_approval_step"
                    value="require_approval_step" />

            </div>
        </div>
        <div class="form-group row">
            <label for="approver_label" class="col-sm-3 col-form-label ">@lang('labels.approver_label')</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="approver_label" value="{{ $data['approver_label'] ?? '' }}" />
            </div>
        </div>
        <x-button-group class="saveData" />
</form>
