@php
    $userType = auth()->user()?->id ?? null;
@endphp
<x-app-layout :class="['dateDropdown', 'datepicker']">
    <x-jet-form-section title="{!! $pageTitle ?? '' !!}" class="validationForm mainForm" novalidate
        action="{{ routeCheck($route . 'quote-policy',['qId'=>$quoteData?->id,'vId'=>$vId]) }}" method="post" x-data="quotePolicy"
        data-ajax-url="{{ routeCheck($route . 'index') }}">
        @slot('form')
            @php
                $payment_type = '';
                $policy_term = '';
            @endphp

            @if ($quoteSettings->quick_quote == '6')
                @php
                    $policy_term = '6 Months';
                @endphp
            @elseif($quoteSettings->quick_quote == '12')
                @php
                    $policy_term = '12 Months';
                @endphp
            @endif
            <div>
                <x-jet-input type="hidden" name="account_type" value="{{ $quoteData?->account_type }} " />

                <div class="row form-group">
                    <label for="insurance_companyDropdown"
                        class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.insurance_company')</label>
                    <div class="col-sm-9">
                        <div class="ui search selection dropdown insurance_companyDropdown notUi input-sm">
                            <input type="hidden" name="insurance_company"
                                @change="insurance_company = $el.value;entityId =$el.value" required>
                            <i class="dropdown icon"></i>
                            <input type="text" class="search">
                            <div class="default text">@lang('labels.search_insurance_company')</div>
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <label for="general_agent" class="col-sm-3 col-form-label">@lang('labels.general_agent')</label>
                    <div class="col-sm-9">
                        <div class="ui search selection dropdown general_agentDropdown notUi input-sm">
                            <input type="hidden" name="general_agent"
                                @change="general_agent = $el.value;entityId =$el.value">
                            <i class="dropdown icon"></i>
                            <input type="text" class="search">
                            <div class="default text">@lang('labels.search_general_agent')</div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">@lang('labels.policy_number')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-4">
                                <x-jet-input type="text" name="policy_number" id="policy_numbers" />
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <label for="inception_date"
                                        class="col-sm-5 col-form-label requiredAsterisk">@lang('labels.inception_date')</label>
                                    <div class="col-sm-7">
                                        <x-jet-input type="text" class="singleDatePicker" name="inception_date"
                                            id="inception_date" required value="{{ date('m/d/Y') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="coverage_type" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.coverage_type')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-4">
                                <x-select :options="$coverage_types ?? []" class="ui dropdown input-sm w-100" id="coverage_type"
                                    name="coverage_type" />

                            </div>
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <label for="policy_term"
                                        class="col-sm-5 col-form-label requiredAsterisk">@lang('labels.policy_term')</label>
                                    <div class="col-sm-7">
                                        {!! form_dropdown('policy_term', policyTermDropDown(), $policy_term, [
                                            'class' => 'ui dropdown input-sm w-100',
                                            'required' => true,
                                            'id' => 'policy_term',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.pure_premium')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-4">
                                <x-jet-input class="amount" type="text" name="pure_premium" id="pure_premium" required />
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <label for="expiration_date"
                                        class="col-sm-5 col-form-label requiredAsterisk">@lang('labels.expiration_date')</label>
                                    <div class="col-sm-7">
                                        <x-jet-input type="text" name="expiration_date" id="expiration_date"
                                            value="{{ date('m/d/Y', strtotime('+' . $quoteSettings->quick_quote . ' month')) }}"
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
                                <x-jet-input type="text" class="percentageInput" name="minimum_earned"
                                    id="minimum_earned" required
                                    value="{{ !empty($policy_minium_earned_percent) && $policy_minium_earned_percent != 'NULL' ? $policy_minium_earned_percent : '' }}" />
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <label for="first_installment_date"
                                        class="col-sm-5 col-form-label requiredAsterisk">@lang('labels.first_installment_date')</label>
                                    <div class="col-sm-7">
                                        <x-jet-input type="text" class="singleDatePicker" name="first_installment_date"
                                            id="first_installment_date" required
                                            value="{{ date('m/d/Y', strtotime('+' . $quoteSettings->until_first_payment . ' days')) }}" />
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
                                {!! form_dropdown('cancel_terms', $policy_term_options, '', [
                                    'class' => 'ui dropdown input-sm w-100',
                                    'required' => true,
                                    'id' => 'cancel_terms',
                                ]) !!}
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <label for="policy_fee" class="col-sm-5 col-form-label"> @lang('labels.policy_fee')
                                        ($)</label>
                                    <div class="col-sm-7">
                                        <x-jet-input class="amount" type="text" name="policy_fee" id="policy_fee" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email"
                        class="col-sm-3 col-form-label {{ $quoteSettings->short_rate ? 'requiredAsterisk' : '' }}">@lang('labels.short_rate')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                    <input id="short_rate_yes" name="short_rate" type="radio" class="form-check-input"
                                        value="" {{ $quoteSettings->short_rate ? 'required' : '' }}>
                                    <label for="short_rate_yes" class="form-check-label">@lang('labels.yes')</label>
                                </div>
                                <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                    <input id="short_rate_no" name="short_rate" type="radio" class="form-check-input"
                                        value="no" {{ $quoteSettings->short_rate ? 'required' : '' }}>
                                    <label for="short_rate_no" class="form-check-label">@lang('labels.no')</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <label for="taxes_and_stamp_fees" class="col-sm-5 col-form-label">@lang('labels.taxes_stamp_fees')
                                        ($)</label>
                                    <div class="col-sm-7">
                                        <x-jet-input class="amount" type="text" name="taxes_and_stamp_fees"
                                            id="taxes_and_stamp_fees" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="auditable"
                        class="col-sm-3 col-form-label {{ $quoteSettings->auditable ? 'requiredAsterisk' : '' }}">@lang('labels.auditable')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                    <input id="auditable_yes" @change="domiciliary = 'yes'" name="auditable"
                                        type="radio" class="form-check-input" value="yes"
                                        {{ $quoteSettings->auditable ? 'required' : '' }}>
                                    <label for="auditable_yes" class="form-check-label">@lang('labels.yes')</label>
                                </div>
                                <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                    <input id="auditable_no" @change="domiciliary = 'no'" name="auditable"
                                        type="radio" class="form-check-input" value="no"
                                        {{ $quoteSettings->auditable ? 'required' : '' }}>
                                    <label for="auditable_no" class="form-check-label">@lang('labels.no')</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <label for="broker_fee" class="col-sm-5 col-form-label"> @lang('labels.broker_fee')
                                        ($)</label>
                                    <div class="col-sm-7">
                                        <x-jet-input class="amount" type="text" name="broker_fee" id="broker_fee" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-group row">
                    <label for="puc_filings"
                        class="col-sm-3 col-form-label {{ $quoteSettings->puc_filings ? 'requiredAsterisk' : '' }}">@lang('labels.puc_filings')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                    <input id="PUC_Filings_yes" name="PUC_Filings" type="radio"
                                        class="form-check-input" value="yes"
                                        {{ $quoteSettings->puc_filings ? 'required' : '' }}>
                                    <label for="PUC_Filings_yes" class="form-check-label">@lang('labels.yes')</label>
                                </div>
                                <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                    <input id="PUC_Filings_no" name="PUC_Filings" type="radio" required
                                        class="form-check-input" value="no"
                                        {{ $quoteSettings->puc_filings ? 'required' : '' }}>
                                    <label for="PUC_Filings_no" class="form-check-label">@lang('labels.no')</label>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group row">
                                    <label for="inspection_fee" class="col-sm-5 col-form-label"> @lang('labels.inspection_fee')
                                        ($)</label>
                                    <div class="col-sm-7">
                                        <x-jet-input class="amount" type="text" name="inspection_fee"
                                            id="inspection_fee" />
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="form-group row">
                    <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
                    <div class="col-sm-9">
                        <textarea name="notes" id="notes" cols="30" class="form-control dark" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9">
                        <x-button-group :cancel="routeCheck($route . 'index')" />
                    </div>
                </div>
            </div>
        @endslot
    </x-jet-form-section>

    @push('page_script_code')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('quotePolicy', () => ({
                    insuredList: null,
                    userType: "{{ Auth()->user()?->user_type }}",
                    agency: "{{ $quoteData?->agency }}",
                    insuredList: "{{ $quoteData?->insured }}",
                    draftId: "{{ $quoteData?->id }}",
                    accountType: "{{ $quoteData?->account_type }}",
                    async init() {
                        if (this.accountType) {

                            $('input[name="account_type"]').change();
                        }
                        remotelyDropDown('.insurance_companyDropdown',
                            'common/entity/insurance_company');
                        remotelyDropDown('.general_agentDropdown',
                            'common/entity/general_agent');
                    },
                    async slideEffect() {

                    }
                }))
            })
        </script>
    @endpush

</x-app-layout>
