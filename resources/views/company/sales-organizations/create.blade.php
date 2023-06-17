<x-app-layout :class="['datepicker']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post">
        @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label"> General Information</label>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.name')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="fw-600" name="name" required />

                </div>
            </div>

            <div class="form-group row">
                <label for="legal_name" class="col-sm-3 col-form-label ingnorTitleCase">
                    @lang('labels.d_b_a_legal_name_if_different_than_insured_name') </label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="legal_name" />

                </div>
            </div>
            <div class="form-group row">
                <label for="max_setup_fee" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.entity_type')
                </label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">
                            <select class="form-control input-sm ui dropdown " name="max_setup_fee">
                                <option value=""></option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <label for="tin_select" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.tin')</label>
                <div class="col-sm-9">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <select class="ui dropdown input-sm w-100" name='tin_select'>
                                <option value=""></option>
                                <option value="Social security">Social Security Number (SSN) </option>
                                <option value="EIN">Employer Identification Number (EIN/EFIN)
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" class="form-control input-sm tin " name="tin" id="tin"
                                placeholder="">
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-group row">
                <label for="primary_telephone" class="col-sm-3 col-form-label requiredAsterisk">
                    @lang('labels.telephone')</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control input-sm telephone " name="primary_telephone"
                        id="primary_telephone" placeholder="" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="primary_telephone" class="col-sm-3 col-form-label requiredAsterisk">
                    @lang('labels.fax')</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control input-sm telephone " name="primary_telephone"
                        id="primary_telephone" placeholder="" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="primary_telephone" class="col-sm-3 col-form-label requiredAsterisk">
                    @lang('labels.email')</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control input-sm  " name="primary_telephone" id="primary_telephone"
                        placeholder="">
                </div>
            </div>

            <div class="row">
                <label for="primary_address" class="col-sm-3 col-form-label requiredAsterisk">
                    @lang('labels.physical_address')</label>
                <div class="col-sm-9">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control input-sm" name="address" id="address"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control input-sm" id="primary_address_city" placeholder=""
                                name="primary_address_city" required>
                        </div>
                        <div class="col-md-4">
                            {!! form_dropdown('primary_address_state', stateDropDown(), '', [
                                'class' => "ui dropdown input-sm
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        w-100",
                                'required' => true,
                                'id' => 'primary_address_state',
                            ]) !!}


                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control input-sm zip_mask" id="primary_address_zip"
                                name="primary_address_zip" placeholder="" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <label for="primary_address" class="col-sm-3 col-form-label requiredAsterisk">
                    @lang('labels.mailing_address')</label>
                <div class="col-sm-9">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control input-sm" name="address" id="address"
                                    placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control input-sm" id="primary_address_city" placeholder=""
                                name="primary_address_city" required>
                        </div>
                        <div class="col-md-4">
                            {!! form_dropdown('primary_address_state', stateDropDown(), '', [
                                'class' => "ui dropdown input-sm
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            w-100",
                                'required' => true,
                                'id' => 'primary_address_state',
                            ]) !!}


                        </div>
                        <div class="col-md-4">
                            <input type="text" class="form-control input-sm zip_mask" id="primary_address_zip"
                                name="primary_address_zip" placeholder="" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <p>Contacts</p>
            </div>



            <div class="cloneBox">
                <div class="form-group row">
                    <label for="first_name_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.first_name')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" required name="owner[first_name][]" id="first_name_1"
                            class="first_name" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="middle_name_1" class="col-sm-3 col-form-label ">@lang('labels.m_i')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="owner[middle_name][]" id="middle_name_1"
                            class="middle_name" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="last_name_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.last_name')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" required name="owner[last_name][]" id="last_name_1"
                            class="last_name" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="title_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.title')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="owner[title][]" id="title_1" />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="month_1" class="col-sm-3 col-form-label ">@lang('labels.dob')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-sm-6">

                                {!! form_dropdown('owner[month][]', monthsDropDown($type = 'number'), '', [
                                    'class' => "ui dropdown
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    monthsNumber input-sm w-100",
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
                    <label for="owner_email_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="email" required name="owner[email][]" id="owner_email_1" />
                    </div>
                </div>
                <div class="row">
                    <label for="administrator_email" class="col-sm-3 col-form-label ">@lang('labels.email_information')
                    </label>
                    <div class="col-sm-9">
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="row form-group">
                                    <label for="administrator_email_outgoing_server"
                                        class="col-sm-12 col-form-label">@lang('labels.outgoing_server')</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control input-sm"
                                            name="email_setting[administrator][server]"
                                            id="administrator_email_outgoing_server">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row form-group">
                                    <label for="" class="col-sm-12 col-form-label">@lang('labels.authentication')</label>
                                    <div class="col-sm-12">
                                        <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                            <input id="administrator_email_authentication_yes" class="form-check-input"
                                                name="email_setting[administrator][authentication]" type="radio"
                                                required value="yes">
                                            <label for="administrator_email_authentication_yes"
                                                class="form-check-label">@lang('labels.yes')</label>
                                        </div>
                                        <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                            <input id="administrator_email_authentication_no" class="form-check-input"
                                                name="email_setting[administrator][authentication]" type="radio"
                                                required value="no">
                                            <label for="administrator_email_authentication_no"
                                                class="form-check-label">@lang('labels.no')</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="row form-group">
                                    <label for="administrator_email_username"
                                        class="col-sm-12 col-form-label">@lang('labels.username')</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control input-sm"
                                            name="email_setting[administrator][username]"
                                            id="administrator_email_username">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row form-group">
                                    <label for="administrator_email_passward"
                                        class="col-sm-12 col-form-label">@lang('labels.password')</label>
                                    <div class="col-sm-12">
                                        <input type="password" class="form-control input-sm"
                                            name="email_setting[administrator][password]"
                                            id="administrator_email_passward">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label for="" class="col-sm-12 col-form-label"
                                            style="opacity:0;">a</label>
                                    </div>
                                    <div class="col-sm-4">
                                        {!! form_dropdown('email_setting[administrator][imap]', emailImapDropDown(), '', [
                                            'class' => 'form-control input-sm',
                                        ]) !!}


                                    </div>
                                    <div class="col-sm-4">
                                        {!! form_dropdown('email_setting[administrator][port]', emailPortDropDown(), '', [
                                            'class' => 'form-control input-sm',
                                        ]) !!}

                                    </div>
                                    <div class="col-sm-4">
                                        {!! form_dropdown('email_setting[administrator][encryption]', encryptionTypeDropDown(), '', [
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
                            <div class="col-md-6">
                                <x-jet-input type="tel" required name="owner[telephone][]" id="owner_telephone_1" />
                            </div>
                            <div class="col-md-3">
                                <x-jet-input type="tel" required name="owner[extenstion][]" placeholder="Extenstion"
                                    id="owner_extenstion_1" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="owner_telephone_1"
                        class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.alternate_telephone')</label>
                    <div class="col-sm-9">
                        <div class="row">
                            <div class="col-md-6">
                                <x-jet-input type="tel" required name="owner[telephone][]" id="owner_telephone_1" />
                            </div>
                            <div class="col-md-3">
                                <x-jet-input type="tel" required name="owner[extenstion][]"
                                    placeholder="Administrator" id="owner_extenstion_1" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label for="mailing_address_yes" class="col-sm-3 col-form-label requiredAsterisk">
                        @lang('labels.user_login')</label>
                    <div class="col-sm-9">
                        <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                            <input id="mailing_address_yes" name="mailing_address_yes" type="radio" required
                                class="form-check-input" value="true">
                            <label for="mailing_address_yes" class="form-check-label">@lang('labels.enable') </label>
                        </div>
                        <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                            <input id="mailing_address_no" name="mailing_address_yes" type="radio" required
                                class="form-check-input" value="false">
                            <label for="mailing_address_no" class="form-check-label">@lang('labels.disable')</label>
                        </div>
                    </div>
                </div>

                <div class="form-group row align-items-center">
                    <label for="mailing_address_yes" class="col-sm-3 col-form-label requiredAsterisk">
                        @lang('labels.send_email_password_reset_to_user')</label>
                    <div class="col-sm-9">
                        <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                            <input id="mailing_address_yes" name="mailing_address_yes" type="radio" required
                                class="form-check-input" value="true">
                            <label for="mailing_address_yes" class="form-check-label">@lang('labels.yes') </label>
                        </div>
                        <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                            <input id="mailing_address_no" name="mailing_address_yes" type="radio" required
                                class="form-check-input" value="false">
                            <label for="mailing_address_no" class="form-check-label">@lang('labels.no')</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
                    <div class="col-sm-9">
                        <textarea name="copy_right_notice" id="copy_right_notice" cols="30" class="form-control dark" rows="3"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="owner_percent" class="col-sm-3 col-form-label "></label>
                    <div class="col-sm-9">
                        <div class="">
                            <a href="javascript:void(0);" class="cloneAdd"><span class="fa-thin fa-user-plus fw-600"
                                    title="Add owner"></span></a>
                            &nbsp;&nbsp;
                            <a href="javascript:void(0);" class="cloneRemove d-none"><span
                                    class="fa-thin fa-user-minus fw-600" title="Remove owner"></span></a>
                        </div>
                    </div>
                </div>

            </div>
            <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>
</x-app-layout>
