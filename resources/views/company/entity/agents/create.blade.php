<x-app-layout :class="['datepicker']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post" enctype="multipart/form-data">
        @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.agency_name')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="fw-600" name="name" required />
                </div>
            </div>
            @php
                $aggregateLimitAllow = DBHelper::QSetting('limit_company');
            @endphp
            @if((auth()->user()->can('isAdminCompany') || auth()->user()->can('companyAdmin')) && && $aggregateLimitAllow  == 1)
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">@lang('labels.aggregate_limit')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" class="amount" name="aggregate_limit" />
                    </div>
                </div> 
            @endif

            <div class="form-group row">
                <label for="legal_name" class="col-sm-3 col-form-label ingnorTitleCase">@lang('labels.d_b_a')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="legal_name" />

                </div>
            </div>
            <div class="form-group row">
                <label for="entity_type" class="col-sm-3 col-form-label ">@lang('labels.entity_type')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('entity_type', entityType(), '', ['class' => 'w-100']) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="tin" class="col-sm-3 col-form-label ">@lang('labels.tin')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="w-25 tin" name="tin" />
                </div>
            </div>

            <div class="form-group row">
                <label for="rate_table" class="col-sm-3 col-form-label ">@lang('labels.rate_table')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('rate_table[]', rateTableDropDown(), '', [
                        'class' => "w-100",'multiple'=>'multiple'
                    ]) !!}
                </div>
            </div>
             <div class="row form-group">
                <label for="sales_organization" class="col-sm-3 col-form-label ">@lang('labels.sales_organization')</label>
                <div class="col-sm-9">
                    <x-select class="ui dropdown input-sm" name="sales_organization" placeholder="Select Sales Organization" :options="salesOrganizationType(['default'=>true])" />
                </div>
            </div>
            <div class="form-group row">
                <label for="license_no" class="col-sm-3 col-form-label ">@lang('labels.agent_compensation_table')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('compensation_table', compensationTableDropDown(), '', [
                        'class' => "ui dropdown input-sm w-100",
                    ]) !!}
                </div>
            </div>


            <div class="form-group row">
                <label for="personal_maximum_finance_amount" class="col-sm-3 col-form-label ">@lang('labels.personal_maximum_finance_amount')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="amount" name="personal_maximum_finance_amount" placeholder="$" />
                </div>
            </div>
            <div class="form-group row">
                <label for="commercial_maximum_finance_amount" class="col-sm-3 col-form-label ">@lang('labels.commercial_maximum_finance_amount')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="amount" name="commercial_maximum_finance_amount" placeholder="$" />
                </div>
            </div>
            <div class="form-group row">
                <label for="resident_license_state" class="col-sm-3 col-form-label ">@lang('labels.state_resident')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('license_state', stateDropDown(['keyType'=>'id']), '', [
                        'class' => "ui dropdown input-sm
                         w-100",
                    ]) !!}
                </div>
            </div>

            <div class="form-group row">
                <label for="license_no" class="col-sm-3 col-form-label ">@lang('labels.state_resident_license')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="license_no" />
                </div>
            </div>

            <div class="form-group row">
                <label for="licence_expiration_date" class="col-sm-3 col-form-label ">@lang('labels.license_expiration_date')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="licence_expiration_date" class="singleDatePicker"
                        placeholder="mm/dd/yyyy" />

                </div>
            </div>
            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label ">@lang('labels.email')</label>
                <div class="col-sm-9">
                    <x-jet-input type="email" name="email" class="email " />
                </div>
            </div>


            <div class="form-group row">
                <label for="telephone" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.telephone')</label>
                <div class="col-sm-9">
                    <x-jet-input type="tel" name="telephone" class="telephone" required />
                </div>
            </div>

            <div class="form-group row">
                <label for="fax" class="col-sm-3 col-form-label ">@lang('labels.fax')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="fax" class="fax " />
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label ">@lang('labels.website')</label>
                <div class="col-sm-9">
                    <x-jet-input type="url" name="website" class="url" placeholder="http://www.domain.com" />
                </div>
            </div>
            <div class="form-group row">
                <label for="maximum_reinstate_allowed" class="col-sm-3 col-form-label ">@lang('labels.maximum_reinstate_allowed')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="w-25 " name="maximum_reinstate_allowed" />
                </div>
            </div>


            <div class="row">
                <label for="payment_coupons_address"
                    class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.physical_address')</label>
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
                                'class' => 'ui dropdown input-sm w-100',
                                'required' => true,'placeholder'=>'Select State'
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="zip" class="zip_mask" required   placeholder="Zip"/>

                        </div>
                    </div>
                </div>
            </div>



            <div class="row mailing_address_box">
                <label for="mailing_address" class="col-sm-3 col-form-label ">@lang('labels.mailing_address')</label>
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
                                'class' => 'ui dropdown
                                 input-sm w-100','placeholder'=>'Select State'
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="mailing_zip" class="zip_mask" placeholder="Zip" />

                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label fw-600">Agency Adminstrator</label>
                <div class="col-sm-9">
                    <small class="fw-300">**This is The Agency Adminstrator</small>
                </div>
            </div>


            <div class="cloneBox">
                <div class="row">
                    <label for="primary_address" class="col-sm-3 col-form-label requiredAsterisk">
                        @lang('labels.contact_name_first_name_m_i_last_name')</label>
                    <div class="col-sm-9">
                        <div class="form-group row">

                            <div class="col-md-5">
                                 <x-jet-input type="text" required name="owner[first_name][]" id="first_name_1" placeholder="First Name"/>
                            </div>
                            <div class="col-md-2">
                                <x-jet-input type="text" name="owner[middle_name][]" id="middle_name_1"  placeholder="M/I"/>
                            </div>
                            <div class="col-md-5">
                                 <x-jet-input type="text" required name="owner[last_name][]" id="last_name_1"  placeholder="Last Name"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="month_1" class="col-sm-3 col-form-label ">@lang('labels.dob')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-6">

                                {!! form_dropdown('owner[month][]', monthsDropDown($type = 'number'), '', [
                                    'class' => "ui dropdown monthsNumber input-sm w-100",
                                    'placeholder' => 'Month',
                                    'id' => 'month_1',
                                ]) !!}
                            </div>
                            <div class="col-sm-6">
                                {!! form_dropdown('owner[day][]', [], '', ['id' => 'day_1', 'class' => ' daysList', 'placeholder' => 'Day']) !!}

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="owner_emai_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="email" name="owner[email][]" id="owner_emai_1" required />
                    </div>
                </div>


                <div class="form-group row">
                    <label for="inmail_service_enable_1"
                        class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.use_inMail_service')</label>
                    <div class="col-sm-9">
                        <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                            <input id="inmail_service_enable_1" name="owner[inmail_service][]" type="radio" required
                                class="form-check-input" value="true">
                            <label for="inmail_service_enable_1" class="form-check-label">@lang('labels.yes')</label>
                        </div>
                        <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                            <input id="inmail_service_disable_1" name="owner[inmail_service][]" type="radio" required
                                class="form-check-input" value="false">
                            <label for="inmail_service_disable_1" class="form-check-label">@lang('labels.no')</label>
                        </div>
                        <small class="ml-2">**must have an email address</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="owner_telephone_1"
                        class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.primary_telephone')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-md-8">
                                <x-jet-input type="tel" required name="owner[telephone][]" class="telephone"
                                    id="owner_telephone_1" />
                            </div>
                            <div class="col-md-4">
                                <x-jet-input type="tel" required name="owner[extenstion][]" placeholder="Extenstion"
                                    id="owner_extenstion_1" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="owner_alternate_telephone_1" class="col-sm-3 col-form-label ">@lang('labels.alternate_telephone')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-md-8">
                                <x-jet-input type="tel" name="owner[alternate_telephone][]"
                                    id="owner_alternate_telephone_1" class="telephone" />
                            </div>
                            <div class="col-md-4">
                                <x-jet-input type="tel" name="owner[alternate_telephone][]" placeholder="Extenstion"
                                    id="owner_alternate_extenstion_1" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="state_resident" class="col-sm-3 col-form-label ">@lang('labels.state_resident')</label>
                    <div class="col-sm-9">
                        {!! form_dropdown('owner[state][]', stateDropDown(['keyType'=>'id']), '', [
                            'class' => 'ui dropdown input-sm w-100', 'id' => 'state_resident_1',
                        ]) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="licence_no_1" class="col-sm-3 col-form-label ">@lang('labels.state_resident_license')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="owner[licence_no][]" id="licence_no_1" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="expiration_date_1" class="col-sm-3 col-form-label ">@lang('labels.license_expiration_date')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="owner[expiration_date][]" class="singleDatePicker"
                            id="expiration_date_1" placeholder="mm/dd/yyy" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="owner_percent_1"
                        class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.owner_percent')</label>
                    <div class="col-sm-1">
                        <x-jet-input type="text" required name="owner[owner_percent][]" id="owner_percent_1"
                            class="percentageInput" />
                    </div>
                </div>
               {{--  <div class="form-group row">
                <label for="owner" class="col-sm-3 col-form-label ">@lang("labels.owner")</label>
                    <div class="col-sm-9">
                        <x-jet-checkbox for="owner" name="owner[owner][]"  id="owner" value="true" />
                    </div>
                </div> --}}

              {{--   <div class="form-group row">
                    <label for="" class="col-sm-3 col-form-label cloneAdd "><a
                            href="javascript:void(0);" class="btn_link">@lang('labels.add_agency_owner')</a></label>
                    <div class="col-sm-9">
                        <a href="javascript:void(0);" class="cloneRemove d-none btn_link">@lang('labels.remove')</a>
                    </div>
                </div> --}}

            </div>

            <div class="form-group row ">
                <label for="notes" class="col-sm-3 col-form-label">@lang('labels.upload_agency_ec_insurance')</label>
                <div class="col-sm-9 ">
                    <x-input-file label="{{ __('labels.upload_copy_ec_insurance_coi') }}" name="upload_agency_ec_insurance" data-file="agent" accept=".docs,.pdf"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="notes" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
                <div class="col-sm-9">
                    <textarea name="notes" id="notes" cols="30" class="form-control" rows="4"></textarea>
                </div>
            </div>
            <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>
</x-app-layout>
