<div>
    @php
    $payment_type = '';
    $policy_term = '';
    $data = !empty($data) ? $data : null ;
    @endphp

    @if($quoteSettings?->quick_quote == '6')
    @php
    $policy_term = '6 Months'
    @endphp
    @elseif($quoteSettings?->quick_quote == '12')
    @php
    $policy_term = '12 Months'
    @endphp
    @endif

    @if($quoteSettings?->line_business == 'commercial')
    @php
        $payment_type = strtolower($quoteSettings?->payment_type_commercial)
    @endphp
    @elseif($quoteSettings?->line_business == 'personal')
    @php
        $payment_type = strtolower($quoteSettings?->payment_type_personal)
    @endphp
    @endif

    @php
    $payment_type = ($payment_type == 'coupons' || $payment_type == 'ach') ? $payment_type : 'coupons';
    @endphp


    <div class="row form-group">
        <label for="insurance_companyDropdown"
            class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.insurance_company')</label>
        <div class="col-sm-9">
            <x-semantic-dropdown placeholder="Search Insurance Company" class="insurance_companyDropdown">
                <input type="hidden" name="insurance_company"
                    @change="insurance_company = $el.value;entityId =$el.value" required>
            </x-semantic-dropdown>
        </div>
    </div>

    <div class="row form-group">
        <label for="general_agent" class="col-sm-3 col-form-label">@lang('labels.general_agent')</label>
        <div class="col-sm-9">
            <x-semantic-dropdown placeholder="Search General Agent" class="general_agentDropdown">
                <input type="hidden" name="general_agent" @change="general_agent = $el.value;entityId =$el.value">
            </x-semantic-dropdown>
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">@lang('labels.policy_number')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-input type="text" name="policy_number" id="policy_numbers"
                        value="{{ $data->policy_number ??  '' }}" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="inception_date"
                            class="col-sm-5 col-form-label requiredAsterisk">@lang('labels.inception_date')</label>
                        <div class="col-sm-7">
                            <x-jet-input type="text" class="singleDatePicker" name="inception_date" required
                                value="{{ $data->inception_date ??  date('m/d/Y') }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="coverage_type"
            class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.coverage_type')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-select :options="$coverage_types ?? []" class="ui dropdown input-sm w-100" id="coverage_type"
                        name="coverage_type" data-selected="{{ $data->coverage_type ?? '' }}" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="policy_term"
                            class="col-sm-5 col-form-label requiredAsterisk">@lang('labels.policy_term')</label>
                        <div class="col-sm-7">
                            <x-select :options="policyTermDropDown() ?? []" required class="ui dropdown input-sm w-100"
                                id="policy_term" name="policy_term" selected="{{ $data->coverage_type ?? '' }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.pure_premium') ($)</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-input class="amount" type="text" name="pure_premium" required
                        value="{{ $data->pure_premium ?? '' }}" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="expiration_date"
                            class="col-sm-5 col-form-label requiredAsterisk">@lang('labels.expiration_date')</label>
                        <div class="col-sm-7">
                            <x-jet-input type="text" name="expiration_date" id="expiration_date"
                                value="{{ !empty($data->expiration_date) ? $data->expiration_date :  date('m/d/Y', strtotime('+' . $quoteSettings?->quick_quote . ' month')) }}"
                                required readonly />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.minimum_earned')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-input type="text" class="percentageInput" name="minimum_earned" id="minimum_earned" required
                        value="{{ !empty($data->minimum_earned) ? $data->minimum_earned :  (!empty($policy_minium_earned_percent) && $policy_minium_earned_percent != 'NULL' ? $policy_minium_earned_percent : '') }}" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="first_installment_date"
                            class="col-sm-5 col-form-label requiredAsterisk">@lang('labels.first_installment_date')</label>
                        <div class="col-sm-7">
                            <x-jet-input type="text" class="singleDatePicker" name="first_installment_date"
                                id="first_installment_date" required
                                value="{{  !empty($data->first_installment_date) ? $data->first_installment_date : date('m/d/Y', strtotime('+' . $quoteSettings?->until_first_payment . ' days')) }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">@lang('labels.cancel_term_in_days')</label>
        <div class="col-sm-9">
            <div class="row">

                <div class="col-sm-4">
                    <x-select :options="(policyTermsOption() ?? [])" class="ui dropdown input-sm w-100" required
                        name="cancel_terms" selected="{{ $data->cancel_terms ?? '' }}" />

                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="policy_fee" class="col-sm-5 col-form-label"> @lang('labels.policy_fee')
                            ($)</label>
                        <div class="col-sm-7">
                            <x-jet-input class="amount" type="text" name="policy_fee" id="policy_fee"
                                value="{{ $data->policy_fee ?? '' }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="email"
            class="col-sm-3 col-form-label {{$quoteSettings?->short_rate ? 'requiredAsterisk' : ''}}">@lang('labels.short_rate')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-checkbox  labelText="{{ __('labels.yes') }}" id="short_rate_yes{{ !empty($data?->id) ? '_'.$data?->id : ''  }}" name="short_rate" class="checkboxradio"
                        value="yes"  :checked="($data?->short_rate == 'yes' ? true : false)"   :required="( $quoteSettings?->short_rate ? true : false)" />
                    <x-jet-checkbox  labelText="{{ __('labels.no') }}" id="short_rate_no{{ !empty($data?->id) ? '_'.$data?->id : ''  }}" :required="( $quoteSettings?->short_rate ? true : false)"  name="short_rate" value="no" class="checkboxradio" :checked="($data?->short_rate == 'no' ? true : false)" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="taxes_and_stamp_fees"
                            class="col-sm-5 col-form-label">@lang('labels.taxes_stamp_fees')
                            ($)</label>
                        <div class="col-sm-7">
                            <x-jet-input class="amount" type="text" name="taxes_and_stamp_fees"
                                value="{{ $data->taxes_and_stamp_fees ?? '' }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="auditable"
            class="col-sm-3 col-form-label {{$quoteSettings?->auditable ? 'requiredAsterisk' : ''}}">@lang('labels.auditable')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-checkbox  labelText="{{ __('labels.yes') }}" id="auditable_yes{{ !empty($data?->id) ? '_'.$data?->id : ''  }}" name="auditable" value="yes"  class="checkboxradio"
                    :required="( $quoteSettings?->auditable ? true : false)"
                        :checked="($data?->auditable  == 'yes' ? true : false)" />
                    <x-jet-checkbox  labelText="{{ __('labels.no') }}" id="auditable_no{{ !empty($data?->id) ? '_'.$data?->id : ''  }}" name="auditable" value="no"  class="checkboxradio"
                    :required="( $quoteSettings?->auditable ? true : false)"
                        :checked="($data?->auditable == 'no' ? true : false)" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="broker_fee" class="col-sm-5 col-form-label"> @lang('labels.broker_fee')
                            ($)</label>
                        <div class="col-sm-7">
                            <x-jet-input class="amount" type="text" name="broker_fee"
                                value="{{ $data->broker_fee ?? '' }}" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group row">
        <label for="puc_filings"
            class="col-sm-3 col-form-label  {{$quoteSettings?->puc_filings ? 'requiredAsterisk' : ''}}">@lang('labels.puc_filings')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-checkbox  labelText="{{ __('labels.yes') }}" id="PUC_Filings_yes{{ !empty($data?->id) ? '_'.$data?->id : ''  }}" name="puc_filings" value="no" class="checkboxradio"
                        value="yes" :required="($quoteSettings?->puc_filings ? 'required' : '')"
                        :required="( $quoteSettings?->puc_filings ? true : false)" />
                    <x-jet-checkbox  labelText="{{ __('labels.no') }}" id="PUC_Filings_no{{ !empty($data?->id) ? '_'.$data?->id : ''  }}" name="puc_filings" value="no" class="checkboxradio"
                        value="no"  :required="( $quoteSettings?->puc_filings ? true : false)"
                        :checked="($data?->puc_filings == 'no' ? true : false)" />

                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="inspection_fee" class="col-sm-5 col-form-label"> @lang('labels.inspection_fee')
                            ($)</label>
                        <div class="col-sm-7">
                            <x-jet-input class="amount" type="text" name="inspection_fee"
                                value="{{ $data->inspection_fee ?? '' }}" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group row">
        <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
        <div class="col-sm-9">
            <textarea name="notes" id="notes" cols="30" class="form-control dark"
                rows="3">{{ $data->notes ?? '' }}</textarea>
        </div>
    </div>
    <script>
        var allowminimumearned = '{{$policy_minium_earned_percent}}';
        var minimum_earnedvalue = '{{$policy_minium_earned_percent}}';
        var expirationdateterm = '{{$quoteSettings?->quick_quote}}';
        var until_first_payment = "{{$quoteSettings?->until_first_payment}}";
        var type_until_first_payment = until_first_payment == '30' ? 'month' : 'days';
    </script>
</div>

