<x-app-layout :class="['datepicker']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post">
        @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">Broker General Information</label>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.agency_name')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="fw-600" name="name" required />

                </div>
            </div>

            <div class="form-group row">
                <label for="legal_name" class="col-sm-3 col-form-label ingnorTitleCase">@lang("labels.d_b_a")</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="legal_name" />

                </div>
            </div>
            <div class="form-group row">
                <label for="entity_type" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.entity_type')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('entity_type', entityType(), '', ['class' => 'w-100', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="tin" class="col-sm-3 col-form-label ">@lang('labels.tin')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="w-25 tin" name="tin"  />
                </div>
            </div>


            <div class="form-group row">
                <label for="sales_excustive" class="col-sm-3 col-form-label">@lang('labels.agency_state_resident')</label>
                <div class="col-sm-9">
                     {!! form_dropdown('license_state', stateDropDown(['keyType'=>'id']), '', [
                        'class' => "ui dropdown input-sm
                         w-100",'placeholder'=> 'Select State'
                    ]) !!}
                </div>
            </div>

            <div class="form-group row">
                <label for="legal_name" class="col-sm-3 col-form-label ">@lang('labels.agency_state_resident_license')</label>
                <div class="col-sm-9">
                     <x-jet-input type="text" name="license_no" />
                </div>
            </div>

            <div class="form-group row">
                <label for="legal_name" class="col-sm-3 col-form-label ">@lang('labels.agency_license_expiration_date')</label>
                <div class="col-sm-9">
                     <x-jet-input type="text" name="licence_expiration_date" class="singleDatePicker"
                        placeholder="mm/dd/yyyy" />
                </div>
            </div>


            <div class="form-group row">
                <label for="year_established" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.telephone')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="telephone" required class="telephone" />

                </div>
            </div>
            <div class="form-group row">
                <label for="year_established" class="col-sm-3 col-form-label ">@lang('labels.fax')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="fax" class="fax" />

                </div>
            </div>
            <div class="form-group row">
                <label for="year_established" class="col-sm-3 col-form-label ">@lang('labels.agency_website')</label>
                <div class="col-sm-9">
                    <x-jet-input type="url" name="website" class="website" />

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
                                'class' => 'ui dropdown
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            input-sm w-100',
                                'required' => true,'placeholder'=> 'Select State'
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="zip" class="zip_mask" required  placeholder="Zip"  />

                        </div>
                    </div>
                </div>
            </div>

            <div class="row mailing_address_box">
                <label for="mailing_address" class="col-sm-3 col-form-label ">Mailing Address </label>
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
                                'class' => 'ui dropdown input-sm w-100', 'placeholder'=> 'Select State'
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="mailing_zip" class="zip_mask" placeholder="Zip"  />

                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <h6 class="fw-600">Broker Contacts</h6>
                <small>We often work with many individuals within a single agency. Based on your business operation you may
                    have multiple contacts should you need to. For example, controller, accountant, CSR, etc...</small>
            </div>

            <div class="cloneBox">
                 <div class="row">
                    <label for="primary_address" class="col-sm-3 col-form-label requiredAsterisk">
                        @lang('labels.contact_name_first_name_m_i_last_name')</label>
                    <div class="col-sm-9">
                        <div class="form-group row">

                            <div class="col-md-5">
                                 <x-jet-input type="text" required name="entityContact[first_name][]" id="first_name_1" placeholder="First Name"/>
                            </div>
                            <div class="col-md-2">
                                <x-jet-input type="text" name="entityContact[middle_name][]" id="middle_name_1"  placeholder="M/I"/>
                            </div>
                            <div class="col-md-5">
                                 <x-jet-input type="text" required name="entityContact[last_name][]" id="last_name_1"  placeholder="Last Name"/>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="title_1" class="col-sm-3 col-form-label ">@lang('labels.title')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="entityContact[title][]" id="title_1" />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="month_1" class="col-sm-3 col-form-label ">@lang('labels.dob')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-6">

                                {!! form_dropdown('entityContact[month][]', monthsDropDown($type = 'number'), '', [
                                    'class' => "ui dropdown
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    monthsNumber input-sm w-100",
                                    'placeholder' => 'Month',
                                    'id' => 'month_1',
                                ]) !!}
                            </div>
                            <div class="col-sm-6">
                                {!! form_dropdown('entityContact[day][]', [], '', ['id' => 'day_1', 'class' => ' daysList', 'placeholder' => 'Day']) !!}

                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="contact_email_1" class="col-sm-3 col-form-label ">@lang('labels.email')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="email"  name="entityContact[email][]" id="contact_email_1" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="contact_telephone_1"
                        class="col-sm-3 col-form-label ">@lang('labels.primary_telephone')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-md-6">
                                <x-jet-input type="tel"  name="entityContact[telephone][]" id="contact_telephone_1" />
                            </div>
                            <div class="col-md-3">
                                <x-jet-input type="tel"  name="entityContact[extenstion][]" placeholder="Extenstion"
                                    id="contact_extenstion_1" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tin" class="col-sm-3 col-form-label ">@lang('labels.fax')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" class="w-25 tin" name="tin"  />
                    </div>
                </div>

    {{--             <div class="form-group row">
                    <label for="contact_percent" class="col-sm-3 col-form-label "></label>
                    <div class="col-sm-9">
                        <div class="">
                            <a href="javascript:void(0);" class="cloneAdd"><span class="fa-thin fa-user-plus fw-600"
                                    title="Add contact"></span></a>
                            &nbsp;&nbsp;
                            <a href="javascript:void(0);" class="cloneRemove d-none"><span
                                    class="fa-thin fa-user-minus fw-600" title="Remove contact"></span></a>
                        </div>
                    </div>
                </div> --}}

            </div>

            <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>
</x-app-layout>
