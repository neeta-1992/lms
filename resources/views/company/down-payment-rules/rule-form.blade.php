<div class="row">
    <div class="col-md-12 page_table_menu">
        <div class="columns d-flex justify-content-end ">
            <button class="btn btn-default" type="button" name="Add"
                x-on:click="ruleTable = 'table'">@lang("labels.exit")</button>
        </div>
    </div>
</div>
<input type="hidden" name="ruleid" value="{{ $data['id'] ?? '' }}">
<div class="form-group row">
    <label for="rule_name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.rule_set_name')</label>
    <div class="col-sm-9">
        <input type="text" class="form-control input-sm" name="rule_name" id="rule_name" required
            value="{{ $data['rule_name'] ?? '' }}">
    </div>
</div>
<div class="form-group row">
    <label for="rule_description" class="col-sm-3 col-form-label">@lang('labels.description')</label>
    <div class="col-sm-9">
        <textarea name="rule_description" id="rule_description" cols="30" class="form-control" rows="3">{{ $data['rule_description'] ?? '' }}</textarea>
    </div>
</div>
{{-- <div class="row form-group">
    <label for="checkallagencies" class="col-sm-3 col-form-label ">
        @lang('labels.agency')</label>
    <div class="col-sm-9">
        <x-jet-checkbox for="check_all_agencies" name="agency" id="check_all_agencies" value="true"
            labelText="Check all agencies" :checked="($data['agency'] ?? '') == true ? 'checked' : ''" />
    </div>
</div> --}}

<div class="row">
    <div class="col-md-3">
        <div class="form-group row">
            <label for="down_payment" class="col-sm-6 col-form-label ">@lang('labels.down_payment')</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group row">
            <label for="monthly_minimum_installment" class="col-sm-6 col-form-label">@lang('labels.minimum')%</label>
            <div class="col-sm-6">
                <x-jet-input type="text" class="digitLimit" maxlength="2" name="minimum_down_payment"
                    value="{{ $data['minimum_down_payment'] ?? '' }}" />
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group row">
            <label for="monthly_deafult_installment" class="col-sm-6 col-form-label">@lang('labels.default')%</label>
            <div class="col-sm-6">
                <x-jet-input type="text" class="digitLimit" maxlength="2" name="deafult_down_payment"
                    value="{{ $data['deafult_down_payment'] ?? '' }}" />

            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group row">
            <label for="monthly_maximum_installment" class="col-sm-6 col-form-label">@lang('labels.dollar') ($)</label>
            <div class="col-sm-6">
                <x-jet-input type="text" class="amount" maxlength="5" name="dollar_down_payment"
                    value="{{ $data['dollar_down_payment'] ?? '' }}" />
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group row">
            <label for="quote_id" class="col-sm-6 col-form-label ">@lang('labels.installments')</label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group row">
            <label for="minimum_installment" class="col-sm-6 col-form-label">@lang('labels.minimum')</label>
            <div class="col-sm-6">
                <x-jet-input type="text" class="digitLimit" maxlength="2" name="minimum_installment"
                    value="{{ $data['minimum_installment'] ?? '' }}" />
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group row">
            <label for="maximumm_installment" class="col-sm-6 col-form-label">@lang('labels.maximum')</label>
            <div class="col-sm-6">
                <x-jet-input type="text" class="digitLimit" maxlength="2" name="maximumm_installment"
                    value="{{ $data['maximumm_installment'] ?? '' }}" />
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group row">
            <label for="deafult_installment" class="col-sm-6 col-form-label">@lang('labels.default')</label>
            <div class="col-sm-6">
                <x-jet-input type="text" class="digitLimit" maxlength="2" name="deafult_installment"
                    value="{{ $data['deafult_installment'] ?? '' }}" />
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group row">
            <label for="quote_id" class="col-sm-6 col-form-label "></label>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group row">
            <label for="first_due_date" class="col-sm-6 col-form-label">@lang('labels.first_due_date')</label>
            <div class="col-sm-6">
                <x-jet-input type="text" class="digitLimit" maxlength="2" name="first_due_date"
                    value="{{ $data['first_due_date'] ?? '' }}" />
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group row">
            <label for="days" class="col-sm-6 col-form-label">@lang('labels.days')</label>
            <div class="col-sm-6">

            </div>
        </div>
    </div>

</div>


<div class="row">
    <div class="col-md-3">
        <div class="form-group row">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group row">
            <label for="round_down_payment" class="col-sm-12 col-form-label">@lang('labels.round_down_payment_to_nearest_dollar')</label>
        </div>
    </div>
    <div class="col-md-6">
        <x-jet-checkbox for="round_down_paymen_1" name="round_down_payment_2" class="permissionCheckBox" id="round_down_paymen_1"  
         value="yes" :checked="( !empty($data['round_down_payment']) && $data['round_down_payment'] == 'yes' ? true : false )" />
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group row">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group row">
            <label for="override_minimum_earned" class="col-sm-12 col-form-label">@lang('labels.override_minimum_earned')</label>
        </div>
    </div>
   
    <div class="col-md-6">
        <x-jet-checkbox for="override_minimum_earned" name="override_minimum_earned_2"  class="permissionCheckBox" id="override_minimum_earned"
            value="yes" :checked="( !empty($data['override_minimum_earned']) && $data['override_minimum_earned'] == 'yes' ? true : false )" />
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group row">
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group row">
            <label for="down_payment_increase" class="col-sm-12 col-form-label">@lang('labels.down_paymen_percent_increase')</label>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group row">
            <div class="col-sm-4">
                <x-jet-input type="text" class="digitLimit" maxlength="2" name="down_payment_increase" placeholder="%"
                    value="{{ $data['down_payment_increase'] ?? '' }}" />

            </div>
        </div>
    </div>
</div>
