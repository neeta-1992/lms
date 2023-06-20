<x-app-layout :class="['datepicker']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post">
        @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label fw-600">@lang('labels.general_agent_information')</label>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.general_agency_name')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="fw-600" name="name" required />

                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label ingnorTitleCase">@lang('labels.d_b_a_g')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="legal_name" />

                </div>
            </div>
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label ">@lang('labels.entity_type')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('entity_type', entityType(), '', ['class' => 'w-100']) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label ">@lang('labels.tin')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="w-25 tin" name="tin" />
                </div>
            </div>

            <div class="form-group row">
                <label for="license_state" class="col-sm-3 col-form-label ">@lang('labels.general_agency_state_resident')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('license_state', stateDropDown(), '', [
                        'class' => "ui dropdown input-sm w-100"
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="license_no" class="col-sm-3 col-form-label ">@lang('labels.general_agency_state_resident_license')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="license_no" />
                </div>
            </div>
            <div class="form-group row">
                <label for="licence_expiration_date" class="col-sm-3 col-form-label ">
                    @lang('labels.general_agency_license_expiration_date') </label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="singleDatePicker" name="licence_expiration_date"
                        placeholder="mm/dd/yyyy" />
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">@lang('labels.email')</label>
                <div class="col-sm-9">
                    <x-jet-input type="email" class="email" name="email" />
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.telephone')</label>
                <div class="col-sm-9">
                    <x-jet-input type="tel" name="telephone" class="telephone" required />

                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label ">@lang('labels.fax')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="fax" class="fax" />

                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label ">@lang('labels.general_agent_website')</label>
                <div class="col-sm-9">
                    <x-jet-input type="url" name="website" class="url" placeholder="http://www.domain.com" />
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label ">@lang('labels.maximum_reinstate_allowed')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="maximum_reinstate_allowed" class="onlyNumber w-25"
                        data-maxlength="2" />
                </div>
            </div>

            <div class="row">
                <label for="payment_coupons_address" class="col-sm-3 col-form-label requiredAsterisk">
                    @lang('labels.physical_address') </label>
                <div class="col-sm-9">
                    <div class="form-group row">
                        <div class="col-md-12 mb-1">
                            <div class="form-group">
                                <x-jet-input type="text" name="address" required />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-jet-input type="text" name="city" required placeholder="City" />

                        </div>
                        <div class="col-md-4">
                            {!! form_dropdown('state', stateDropDown(), '', [
                                'class' => 'w-100',
                                'required' => true,'placeholder'=>'Select State'
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="zip" class="zip_mask" required placeholder="Zip"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mailing_address_box">
                <label for="mailing_address" class="col-sm-3 col-form-label ">@lang('labels.mailing_address')   </label>
                <div class="col-sm-9">
                    <div class="form-group row">
                        <div class="col-md-12 mb-1">
                            <div class="form-group">
                                <x-jet-input type="text" name="mailing_address" />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-jet-input type="text" name="mailing_city" placeholder="City" />

                        </div>
                        <div class="col-md-4">
                            {!! form_dropdown('mailing_state', stateDropDown(), '', [
                                'class' => 'ui dropdown w-100', 'placeholder'=>'Select State'
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="mailing_zip" class="zip_mask" placeholder="Zip"/>

                        </div>
                    </div>
                </div>
            </div>
            <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>
</x-app-layout>
