<x-app-layout :class="['datepicker']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post" x-data="{ domiciliary: 'no' }">
        @slot('form')
            <div class="mb-3">
                <p class="fw-600">@lang('labels.general_information')  </p>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.name')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="name" required />
                </div>
            </div>
            <div class="form-group row">
                <label for="tax_id" class="col-sm-3 col-form-label ingnorTitleCase">@lang('labels.fein')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="taxId" name="tax_id" />
                </div>
            </div>
            <div class="form-group row">
                <label for="telephone" class="col-sm-3 col-form-label requiredAsterisk">
                    @lang('labels.telephone')</label>
                <div class="col-sm-9">
                    <x-jet-input type="tel" class="telephone" name="telephone" required
                        placeholder="(000) 000-000" />
                </div>
            </div>
            <div class="form-group row">
                <label for="fax" class="col-sm-3 col-form-label ">
                    @lang('labels.fax')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="fax" name="fax" />
                </div>
            </div>
            <div class="row">
                <label for="address" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.mailing_address')</label>
                <div class="col-sm-9">
                    <div class="form-group row">
                        <div class="col-md-12 mb-1">
                            <div class="form-group">
                                <x-jet-input type="text" name="address" required />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-jet-input type="text" name="city" required  placeholder="City"/>
                        </div>
                        <div class="col-md-4">
                            {!! form_dropdown('state', stateDropDown(), '', [
                                'class' => 'ui dropdown input-sm w-100',
                                'required' => true,
                                'id' => 'primary_address_state','placeholder'=>'Select State'
                            ]) !!}


                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" class="zip_mask" name="zip" required placeholder="Zip"/>
                        </div>
                    </div>
                </div>
            </div>
           <!-- <div class="form-group row align-items-center">
                <label for="mailing_address_yes" class="col-sm-3 col-form-label requiredAsterisk">
                    @lang('labels.additional_address_information')</label>
                <div class="col-sm-9">
                    <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                        <input id="mailing_address_yes" @change="domiciliary = 'yes'" name="mailing_address_radio"
                            type="radio" required class="form-check-input" value="yes">
                        <label for="mailing_address_yes" class="form-check-label">@lang('labels.yes')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                        <input id="mailing_address_no" @change="domiciliary = 'no'" name="mailing_address_radio"
                            type="radio" required class="form-check-input" value="no">
                        <label for="mailing_address_no" class="form-check-label">@lang('labels.no')</label>
                    </div>
                </div>
            </div>-->
            <div class="row">
                <label for="mailing_address" class="col-sm-3 col-form-label ">@lang('labels.domiciliary_address')</label>
                <div class="col-sm-9 ">
                    <div class="form-group row">
                        <div class="col-md-12 mb-1">
                            <div class="form-group">
                                <x-jet-input type="text" name="mailing_address" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-jet-input type="text" name="mailing_city" placeholder="City"/>
                        </div>
                        <div class="col-md-4">
                            {!! form_dropdown('mailing_state', stateDropDown(), '', [
                                'class' => 'ui dropdown input-sm w-100',
                                    'placeholder'=>'Select State',
                                'id' => 'mailing_state',
                            ]) !!}


                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" class="zip_mask" name="mailing_zip" placeholder="Zip"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="current_aggregate_outstandings" class="col-sm-3 col-form-label">
                    @lang('labels.current_aggregate_outstandings')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" disabled class="amount" name="current_aggregate_outstandings"
                        placeholder="$" />
                </div>
            </div>
            <div class="form-group row">
                <label for="limit_of_aggregate_outstandings" class="col-sm-3 col-form-label">
                    @lang('labels.limit_of_aggregate_outstandings')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="amount" name="aggregate_limit" placeholder="$" />
                </div>
            </div>



            {{--   <div class="form-group row">
                    <label for="website" class="col-sm-3 col-form-label ">Website</label>
                    <div class="col-sm-9">
                        <x-jet-input type="url" class="w-50" name="website" placeholder="http://www.domain.com" />

                    </div>
                </div> --}}


            {{--  <div class="mb-3">
                    <p class="fw-600">A.M. Best</p>
                </div> --}}

            <div class="form-group row">
                <label for="AM_best_rating" class="col-sm-3 col-form-label ">@lang('labels.a_m_best_rating')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="" name="json[rating]" />
                </div>
            </div>
            <div class="form-group row">
                <label for="NAIC_number" class="col-sm-3 col-form-label ">@lang('labels.naic_number')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="" name="json[naic_number]" />

                </div>
            </div>
            <div class="form-group row">
                <label for="AM_best_financial_size" class="col-sm-3 col-form-label ">@lang('labels.a_m_best_financial_size')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="" name="json[financial_size]" />
                </div>
            </div>
            <div class="form-group row ">
                <label for="AM_best_rating_date" class="col-sm-3 col-form-label ">@lang('labels.a_m_best_rating_date')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="singleDatePicker" name="json[rating_date]" placeholder="mm/dd/YYY"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="AM_best_number" class="col-sm-3 col-form-label ">@lang('labels.a_m_best_number')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="am_best_number" name="json[number]" />

                </div>
            </div>
            <div class="form-group row">
                <label for="AM_best_group_number" class="col-sm-3 col-form-label ">@lang('labels.a_m_best_group_number')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="" name="json[group_number]" />
                </div>
            </div>
            <div class="form-group row">
                <label for="AM_best_group_name" class="col-sm-3 col-form-label ">@lang('labels.a_m_best_group_name')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="" name="json[group_name]" />
                </div>
            </div>
            <div class="form-group row">
                <label for="aggregation_code" class="col-sm-3 col-form-label ">@lang('labels.aggregation_code')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="" name="json[aggregation_code]" />

                </div>
            </div>
            <div class="form-group row">
                <label for="AM_best_url" class="col-sm-3 col-form-label ">@lang('labels.a_m_best_url')</label>
                <div class="col-sm-9">
                    <x-jet-input type="url" name="json[url]" class="am_best_url" readonly="readonly" />
                </div>
            </div>
            <div class="form-group row">
                <label for="notes" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
                <div class="col-sm-9">
                    <textarea name="notes" id="notes" cols="30" class="form-control" rows="4"></textarea>
                </div>
            </div>

            <x-button-group :cancel="routeCheck($route . 'index')" />
        @endslot
    </x-jet-form-section>
    @push('page_script_code')
        <script>
            const AB_BEST_WEBSITE_URL = "{{ env('AB_BEST_WEBSITE_URL') ?? '' }}";
        </script>
    @endpush
</x-app-layout>
