<x-app-layout :class="['datepicker']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post" autocomplete="off" x-data="{ resetPassword : '' }">
        @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.name')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="fw-600" name="name" required />
                </div>
            </div>

            <div class="form-group row">
                <label for="legal_name" class="col-sm-3 col-form-label ingnorTitleCase">@lang('labels.d_b_a')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="legal_name" />

                </div>
            </div>
            <div class="form-group row">
                <label for="entity_type" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.entity_type')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('entity_type', entityType(), '', ['class' => 'w-100','required'=>true]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="tin" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.tin')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="w-25 tin" name="tin" required/>
                </div>
            </div>





            <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email')</label>
                <div class="col-sm-9">
                    <x-jet-input type="email" name="email" class="email " required/>
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
                                'required' => true,'placeholder'=>"Select State"
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="zip" class="zip_mask" required />

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
                                'class' => 'ui dropdown input-sm w-100','placeholder'=>"Select State"
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="mailing_zip" class="zip_mask" />

                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="" class="col-sm-3 col-form-label fw-600">Contacts</label>
                {{-- <div class="col-sm-9">
                    <small class="fw-300">**This is The Agency Adminstrator</small>
                </div> --}}
            </div>


            <div class="cloneBox">
                <div class="row">
                    <label for="primary_address" class="col-sm-3 col-form-label requiredAsterisk">
                        @lang('labels.contact_name_first_name_m_i_last_name')</label>
                    <div class="col-sm-9">
                        <div class="form-group row">

                            <div class="col-md-5">
                                <x-jet-input type="text" required name="owner[first_name][]" id="first_name_1"
                                    placeholder="First Name" />
                            </div>
                            <div class="col-md-2">
                                <x-jet-input type="text" name="owner[middle_name][]" id="middle_name_1"
                                    placeholder="M/I" />
                            </div>
                            <div class="col-md-5">
                                <x-jet-input type="text" required name="owner[last_name][]" id="last_name_1"
                                    placeholder="Last Name" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="owner_emai_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.title')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" required name="owner[title][]" id="owner_title_1" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="month_1" class="col-sm-3 col-form-label ">@lang('labels.dob')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-6">

                                {!! form_dropdown('owner[month][]', monthsDropDown($type = 'number'), '', [
                                    'class' => 'ui dropdown monthsNumber input-sm w-100',
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
                    <label for="owner_emai_1" class="col-sm-3 col-form-label ">@lang('labels.email')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="email" name="owner[email][]" id="owner_emai_1" />
                    </div>
                </div>


                <div class="row">
                    <label for="officelocation" class="col-sm-3 col-form-label ">
                        @lang('labels.email_information')</label>
                    <div class="col-sm-9">
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="row form-group">
                                    <label for="quote_activation_outgoing_server" class="col-sm-12 col-form-label">
                                        @lang('labels.outgoing_server')</label>
                                    <div class="col-sm-12">
                                         <x-jet-input type="text" name="owner[email_information][server]" id="email_information_server_id"/>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row form-group">
                                    <label for="" class="col-sm-12 col-form-label">@lang('labels.authentication')</label>
                                    <div class="col-sm-12">
                                        <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                            <input id="quote_activation_authentication_yes" class="form-check-input"
                                                name="owner[email_information][authentication]" type="radio"
                                                value="yes">
                                            <label for="quote_activation_authentication_yes"
                                                class="form-check-label">@lang('labels.yes')</label>
                                        </div>
                                        <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                            <input id="quote_activation_authentication_no" class="form-check-input"
                                                name="owner[email_information][authentication]" type="radio"
                                                value="no">
                                            <label for="quote_activation_authentication_no"
                                                class="form-check-label">@lang('labels.no')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <label for="quote_activation_username"
                                        class="col-sm-12 col-form-label">@lang('labels.username')</label>
                                    <div class="col-sm-12">
                                        <x-jet-input type="text" name="owner[email_information][username]" />

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <label for="quote_activation_passward"
                                        class="col-sm-12 col-form-label">@lang('labels.password')</label>
                                    <div class="col-sm-12">
                                        <x-jet-input type="password" name="owner[email_information][password]" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="" class="col-sm-12 col-form-label"
                                            style="opacity:0;"></label>
                                    </div>
                                    <div class="col-sm-4">
                                        {!! form_dropdown('owner[email_information][imap]', emailImapDropDown(), '', [
                                            'class' => 'form-control input-sm',

                                        ]) !!}


                                    </div>
                                    <div class="col-sm-4">
                                        {!! form_dropdown('owner[email_information][port]', emailPortDropDown(), '', [
                                            'class' => 'form-control input-sm',

                                        ]) !!}

                                    </div>
                                    <div class="col-sm-4">
                                        {!! form_dropdown('owner[email_information][encryption]', encryptionTypeDropDown(), '', [
                                            'class' => 'form-control input-sm',

                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                <x-jet-input type="tel" name="owner[alternate_telephone_extenstion][]" placeholder="Extenstion"
                                    id="owner_alternate_extenstion_1" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    <label for="" class="col-sm-3 col-form-label requiredAsterisk">
                        @lang('labels.send_email_password_reset_to_user')</label>
                    <div class="col-sm-9">
                        <div class="zinput zradio zradio-sm  zinput-inline">
                            <input id="reset_password_enable" name="owner[reset_password][]" type="radio" required
                                class="form-check-input" value="yes"
                                @change="resetPassword = $event.target.checked ? 'yes' : '';">
                            <label for="reset_password_enable" class="form-check-label">@lang('labels.yes')</label>
                        </div>
                        <div class="zinput zradio  zradio-sm   zinput-inline">
                            <input id="reset_password_disable" name="owner[reset_password][]" type="radio" required
                                class="form-check-input" value="no"
                                @change="resetPassword = $event.target.checked ? 'no' : '';">
                            <label for="reset_password_disable" class="form-check-label">@lang('labels.no')</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row" x-show='resetPassword == "no"'>
                    <label for="licence_no_1" class="col-sm-3 col-form-label ">@lang('labels.password')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="password" name="owner[password][]" placeholder="Password" />
                    </div>
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
