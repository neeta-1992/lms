<x-form action="{{ routeCheck($route.'policy-details',['id'=>$data->id,'accountId'=>$accountId]) }}" method="post" class="quoteEditForm">
    {{-- <x-jet-input type="hidden" name="account_type" value="{{ $data?->quote_data?->account_type }} " /> --}}
    <div class="row form-group">
        <label for="insurance_companyDropdown" class="col-sm-3 col-form-label">@lang('labels.insurance_company')</label>
        <div class="col-sm-9">
            <x-semantic-dropdown placeholder="Search Insurance Company" class="insurance_companyDropdown disabled">
                <input type="hidden" @change="insurance_company = $el.value;entityId =$el.value" required>
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
                    <x-jet-input type="text" name="policy_number" id="policy_numbers" value="{{ $data->policy_number ??  '' }}" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="inception_date" class="col-sm-5 col-form-label ">@lang('labels.inception_date')</label>
                        <div class="col-sm-7">
                          <x-jet-input type="text" disabled value="{{ !empty($data->inception_date) ? changeDateFormat($data->inception_date,true) : '' }}" />

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="coverage_type" class="col-sm-3 col-form-label">@lang('labels.coverage_type')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-input type="text" disabled value="{{ $data->coverage_type_data->name ?? '' }}" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="policy_term" class="col-sm-5 col-form-label ">@lang('labels.policy_term')</label>
                        <div class="col-sm-7">
                            <x-jet-input type="text" disabled value="{{ $data->policy_term ?? '' }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">@lang('labels.pure_premium') ($)</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-input class="amount" type="text" disabled value="{{ $data->pure_premium ?? '' }}" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="expiration_date" class="col-sm-5 col-form-label">@lang('labels.expiration_date')</label>
                        <div class="col-sm-7">
                            <x-jet-input type="text" disabled value="{{ !empty($data->expiration_date) ? changeDateFormat($data->expiration_date,true) : '' }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">@lang('labels.effective_cancel_date')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-input  type="text" class="singleDatePicker" name="effective_cancel_date" value="{{ !empty($data->effective_cancel_date) ? changeDateFormat($data->effective_cancel_date,true) : '' }}" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="expiration_date" class="col-sm-5 col-form-label">@lang('labels.effective_cancel_date_radio_button_account')</label>
                        <div class="col-sm-7">
                            <x-input-radio name="required_earning_interest" inline id="required_earning_interest_yes" for="required_earning_interest_yes" value="Yes" label="{{ __('labels.yes') }}" :checked="($data?->required_earning_interest == 'Yes' ? true : false)" />
                            <x-input-radio name="required_earning_interest" inline id="required_earning_interest_no" for="required_earning_interest_yes" value="No"  label="{{ __('labels.no') }}" :checked="($data?->required_earning_interest == 'No' ? true : false)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">@lang('labels.minimum_earned')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-input type="text" class="percentageInput" disabled value="{{ !empty($data->minimum_earned) ? $data->minimum_earned :  '' }}" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="first_installment_date" class="col-sm-5 col-form-label ">@lang('labels.first_installment_date')</label>
                        <div class="col-sm-7">
                            <x-jet-input type="text" disabled value="{{  !empty($data->first_installment_date) ? changeDateFormat($data->first_installment_date,true) : '' }}" />
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
                            <x-jet-input disabled  value="{{ $data->policy_fee ?? '' }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">@lang('labels.short_rate')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-checkbox disabled labelText="{{ __('labels.yes') }}" id="short_rate_yes{{ !empty($data?->id) ? '_'.$data?->id : ''  }}"  class="checkboxradio" value="yes" :checked="($data?->short_rate == 'yes' ? true : false)" />
                    <x-jet-checkbox disabled labelText="{{ __('labels.no') }}" id="short_rate_no{{ !empty($data?->id) ? '_'.$data?->id : ''  }}"  value="no" class="checkboxradio" :checked="($data?->short_rate == 'no' ? true : false)" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="taxes_and_stamp_fees" class="col-sm-5 col-form-label">@lang('labels.taxes_stamp_fees')
                            ($)</label>
                        <div class="col-sm-7">
                            <x-jet-input class="amount" disabled value="{{ $data->taxes_and_stamp_fees ?? '' }}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="auditable" class="col-sm-3 col-form-label">@lang('labels.auditable')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-checkbox disabled labelText="{{ __('labels.yes') }}" id="auditable_yes{{ !empty($data?->id) ? '_'.$data?->id : ''  }}" name="auditable" value="yes" class="checkboxradio" :checked="($data?->auditable  == 'yes' ? true : false)" />
                    <x-jet-checkbox disabled labelText="{{ __('labels.no') }}" id="auditable_no{{ !empty($data?->id) ? '_'.$data?->id : ''  }}" name="auditable" value="no" class="checkboxradio" :checked="($data?->auditable == 'no' ? true : false)" />
                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="broker_fee" class="col-sm-5 col-form-label"> @lang('labels.broker_fee')
                            ($)</label>
                        <div class="col-sm-7">
                            <x-jet-input class="amount" disabled value="{{ $data->broker_fee ?? '' }}" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group row">
        <label for="puc_filings" class="col-sm-3 col-form-label">@lang('labels.puc_filings')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-4">
                    <x-jet-checkbox  disabled labelText="{{ __('labels.yes') }}" id="PUC_Filings_yes{{ !empty($data?->id) ? '_'.$data?->id : ''  }}" name="puc_filings" value="no" class="checkboxradio" value="yes" />
                    <x-jet-checkbox  disabled labelText="{{ __('labels.no') }}" id="PUC_Filings_no{{ !empty($data?->id) ? '_'.$data?->id : ''  }}" name="puc_filings" value="no" class="checkboxradio" value="no" :checked="($data?->puc_filings == 'no' ? true : false)" />

                </div>
                <div class="col-sm-8">
                    <div class="form-group row">
                        <label for="inspection_fee" class="col-sm-5 col-form-label"> @lang('labels.inspection_fee')
                            ($)</label>
                        <div class="col-sm-7">
                            <x-jet-input class="amount" type="text" disabled value="{{ $data->inspection_fee ?? '' }}" />
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="form-group row">
        <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
        <div class="col-sm-9">
            <textarea  disabled cols="30" class="form-control dark" rows="3">{{ $data->notes ?? '' }}</textarea>
        </div>
    </div>
    <x-button-group class="saveData" xclick="open = 'policies_endorsments'" cancelClass='cancelList' />
</x-form>
