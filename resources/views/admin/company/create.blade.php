<x-app-layout>
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route.'store') }}" method="post">
        @slot('form')

        <div class="mb-3">
            <p class="fw-600">Company General Information</p>
        </div>


        <div class="form-group row">
            <label for="comp_name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.name")</label>
            <div class="col-sm-9">
                <input type="text" name="comp_name" class="form-control input-sm" id="comp_name" placeholder="" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="comp_domain_name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.domain_name")</label>
            <div class="col-sm-9">
                <input type="text" name='comp_domain_name' class="form-control input-sm username" id="comp_domain_name" placeholder="" oninput="this.value = this.value.toLowerCase()" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="comp_web_address" class="col-sm-3 col-form-label ">@lang("labels.web_url")</label>
            <div class="col-sm-9">
                <input type="url" name="comp_web_address" class="form-control input-sm" id="comp_web_address" placeholder="www.domain.com">
            </div>
        </div>
        <div class="form-group row">
            <label for="comp_logo_url" class="col-sm-3 col-form-label">@lang("labels.logo_url")</label>
            <div class="col-sm-9">
                <input type="url" class="form-control input-sm" id="comp_logo_url" name="comp_logo_url" placeholder="www.domain.com">

            </div>
        </div>
        <div class="form-group row">
            <label for="privacy_page_url" class="col-sm-3 col-form-label">@lang("labels.privacy_page_url")</label>
            <div class="col-sm-9">
                <input type="url" class="form-control input-sm" id="privacy_page_url" placeholder="www.domain.com/..." name="privacy_page_url">

            </div>
        </div>
        <div class="form-group row">
            <label for="ccpa_privacy_notice" class="col-sm-3 col-form-label">@lang("labels.ccpa_privacy_notice")</label>
            <div class="col-sm-9">
                <x-jet-input type="url" name="ccpa_privacy_notice" placeholder="www.domain.com/..." />
            </div>
        </div>
        <div class="row">
            <label for="comp_nav_back_color_hex" class="col-sm-3 col-form-label">@lang("labels.navigation_background_color")
            </label>
            <div class="col-sm-9">
                <div class="form-group row">
                    <label for="comp_nav_back_color_hex" class="col-sm-1 col-form-label hex-col">@lang("labels.hex")</label>
                    <div class="col-sm-5">
                        <input type="text" name="comp_nav_back_color_hex" class="form-control input-sm" id="comp_nav_back_color_hex" placeholder="">
                    </div>
                    <div class="col-sm-2">
                        <div class="row">
                            <label for="comp_nav_back_color_rbg" class="col-sm-6 col-form-label rgb-col">@lang("labels.rgb")</label>
                            <div class="col-sm-6">
                                <input type="color" id="comp_nav_back_color_rbg" name="comp_nav_back_color_rbg" value="#ff0000" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="comp_nav_text_color_hex" class="col-sm-3 col-form-label">@lang("labels.navigation_text_color")
            </label>
            <div class="col-sm-9">
                <div class="form-group row">
                    <label for="comp_nav_text_color_hex" class="col-sm-1 col-form-label hex-col">@lang("labels.hex")</label>
                    <div class="col-sm-5">
                        <input type="text" name="comp_nav_text_color_hex" class="form-control input-sm" id="hex" placeholder="">
                    </div>

                    <div class="col-sm-2">
                        <div class="row">
                            <label for="comp_nav_text_color_rbg" class="col-sm-6 col-form-label rgb-col">@lang("labels.rgb")</label>
                            <div class="col-sm-6">
                                <input type="color" id="comp_nav_text_color_rbg" name="comp_nav_text_color_rbg" value="#ff0000" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="comp_nav_hover_color_hex" class="col-sm-3 col-form-label">
                @lang("labels.navigation_text_hover_color")</label>
            <div class="col-sm-9">
                <div class="form-group row">

                    <label for="comp_nav_hover_color_hex" class="col-sm-1 col-form-label hex-col">@lang("labels.hex")</label>
                    <div class="col-sm-5">
                        <input type="text" name="comp_nav_hover_color_hex" class="form-control input-sm" id="comp_nav_hover_color_hex" placeholder="">
                    </div>
                    <div class="col-sm-2">
                        <div class="row">
                            <label for="comp_nav_hover_color_rbg" class="col-sm-6 col-form-label rgb-col">@lang("labels.rgb")</label>
                            <div class="col-sm-6">
                                <input type="color" id="comp_nav_hover_color_rbg" name="comp_nav_hover_color_rbg" value="#ff0000" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <label for="primary_address" class="col-sm-3 col-form-label requiredAsterisk">
                @lang("labels.company_primary_address")</label>
            <div class="col-sm-9">
                <div class="form-group row">
                    <div class="col-md-12 mb-1">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" id="primary_address" placeholder="" name="primary_address" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control input-sm" id="primary_address_city" placeholder="" name="primary_address_city" required>
                    </div>
                    <div class="col-md-4">
                        {!! form_dropdown('primary_address_state', stateDropDown(), '', ["class"=>"ui dropdown input-sm
                        w-100","required"=>true,'id'=>'primary_address_state']) !!}


                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control input-sm zip_mask" id="primary_address_zip" name="primary_address_zip" placeholder="" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="primary_telephone" class="col-sm-3 col-form-label requiredAsterisk">
                @lang("labels.primary_telephone")</label>
            <div class="col-sm-4">
                <input type="text" class="form-control input-sm telephone " name="primary_telephone" id="primary_telephone" placeholder="(000) 000-000" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="alternate_telephone" class="col-sm-3 col-form-label">@lang("labels.alternate_telephone")</label>
            <div class="col-sm-4">
                <input type="text" class="form-control input-sm telephone " name="alternate_telephone" id="alternate_telephone" placeholder="(000) 000-000">
            </div>
        </div>
        <div class="form-group row">
            <label for="primary_fax" class="col-sm-3 col-form-label">@lang("labels.primary_fax")</label>
            <div class="col-sm-4">
                <input type="text" class="form-control input-sm fax" name="fax" id="primary_fax" placeholder="(000) 000-000">
            </div>
        </div>
        <div class="form-group row">
            <label for="alternate_fax" class="col-sm-3 col-form-label">@lang("labels.primary_fax")</label>
            <div class="col-sm-4">
                <input type="text" class="form-control input-sm fax" name="fax" id="alternate_fax" placeholder="(000) 000-000">
            </div>
        </div>
        <div class="row">
            <label for="tin_select" class="col-sm-3 col-form-label">@lang("labels.tin_efin_number")</label>
            <div class="col-sm-9">
                <div class="form-group row">
                    <div class="col-sm-6">
                        <select class="ui dropdown input-sm w-100" name='tin_select'>
                            <option value=""></option>
                            <option value="Social security">Social Security Number (SSN) </option>
                            <option value="EIN">Employer Identification Number (EIN/EFIN)</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" class="form-control input-sm tin " name="tin" id="tin" placeholder="">
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <label for="payment_coupons_address" class="col-sm-3 col-form-label">
                @lang("labels.coupons_invoices_statement_address")</label>
            <div class="col-sm-9">
                <div class="form-group row">
                    <div class="col-md-12 mb-1">
                        <div class="form-group">
                            <input type="text" class="form-control input-sm" name="payment_coupons_address" id="payment_coupons_address" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control input-sm" name="payment_coupons_city" id="payment_coupons_city" placeholder="">
                    </div>
                    <div class="col-md-4">
                        {!! form_dropdown('payment_coupons_state', stateDropDown(), '', ["class"=>"ui dropdown input-sm
                        w-100"]) !!}


                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control input-sm zip_mask" maxlength="5" id="payment_coupons_zip" name="payment_coupons_zip" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="comp_contact_name" class="col-sm-3 col-form-label requiredAsterisk">
                @lang("labels.company_contact_name")</label>
            <div class="col-sm-9">
                <input type="text" name="comp_contact_name" class="form-control input-sm" id="comp_contact_name" placeholder="" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="comp_contact_email" class="col-sm-3 col-form-label requiredAsterisk">
                @lang("labels.company_contact_email")</label>
            <div class="col-sm-9">
                <input type="email" class="form-control input-sm" name="comp_contact_email" id="comp_contact_email" placeholder="" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="office_location" class="col-sm-3 col-form-label">@lang("labels.office_location")</label>
            <div class="col-sm-9">
                <input type="text" class="form-control input-sm" name="office_location" id="office_location" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="comp_licenses" class="col-sm-3 col-form-label">@lang("labels.company_license")</label>
            <div class="col-sm-9">
                <input type="text" class="form-control input-sm" id="comp_licenses" name="comp_licenses" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="companyLogoURL" class="col-sm-3 col-form-label">@lang("labels.state_licensed")</label>
            <div class="col-sm-9">
                {!! form_dropdown('comp_state_licensed', stateDropDown(), [], ["class"=>"ui fluid normal dropdown
                input-sm", 'multiple'=>true]) !!}


            </div>
        </div>
        {{-- <div class="form-group row align-items-center">
            <label for="finace_comp_contact_agents" class="col-sm-3 col-form-label requiredAsterisk">Allow Contact
                Agent</label>
            <div class="col-sm-9">
                <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                    <input id="finace_comp_contact_agents_enable" name="finace_comp_contact_agents" type="radio"
                        required class="form-check-input" value="true">
                    <label for="finace_comp_contact_agents_enable" class="form-check-label">Enable</label>
                </div>
                <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                    <input id="finace_comp_contact_agents_disable" name="finace_comp_contact_agents" type="radio"
                        required class="form-check-input" value="false">
                    <label for="finace_comp_contact_agents_disable" class="form-check-label">Disable</label>
                </div>
            </div>
        </div> --}}
        {{-- <div class="form-group row align-items-center">
            <label for="" class="col-sm-3 col-form-label requiredAsterisk">Allow Contact Insured</label>
            <div class="col-sm-9">
                <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                    <input id="finace_comp_contact_insureds_enable" name="finace_comp_contact_insureds" type="radio"
                        required class="form-check-input" value="true">
                    <label for="finace_comp_contact_insureds_enable" class="form-check-label">Enable</label>
                </div>
                <div class="zinput zradio  zradio-sm  zinput-inline  p-0">
                    <input id="finace_comp_contact_insureds_disable" name="finace_comp_contact_insureds" type="radio"
                        required class="form-check-input" value="false">
                    <label for="finace_comp_contact_insureds_disable" class="form-check-label">Disable</label>
                </div>
            </div>
        </div> --}}
        <div class="row">
            <label for="" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.date_format")</label>
            <div class="col-sm-9">
                <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                    <input id="date_format_f_j_y" name="date_format" type="radio" required class="form-check-input" value="F j, Y">
                    <label for="date_format_f_j_y" class="form-check-label ml-0">
                        {{ date('F j, Y') }}
                    </label>
                </div>
                <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                    <input id="date_format_y_m_d" name="date_format" type="radio" required class="form-check-input" value="Y-m-d">
                    <label for="date_format_y_m_d" class="form-check-label ml-1">
                        {{ date('Y-m-d') }}
                    </label>
                </div>
                <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                    <input id="date_format_m_d_y" name="date_format" type="radio" required class="form-check-input" value="m/d/Y">
                    <label for="date_format_m_d_y" class="form-check-label ml-1">
                        {{ date('m/d/Y') }}
                    </label>
                </div>
                {{--
                <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                    <input id="date_format_d_m_y" name="date_format" type="radio" required class="form-check-input"
                        value="d/m/Y">
                    <label for="date_format_d_m_y" class="form-check-label ml-1">
                        {{ date('d/m/Y') }}
                </label>
            </div> --}}

            <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                <input id="date_format_M_d_Y" name="date_format" type="radio" required class="form-check-input" value="M d, Y">
                <label for="date_format_M_d_Y" class="form-check-label ml-1">
                    {{ date('M d, Y') }}
                </label>
            </div>
            <div class="zinput zradio zradio-sm zinput-inline p-0 form-group ">
                <input id="date_format_custome" name="date_format" type="radio" required class="form-check-input" value="custom">
                <label for="date_format_custome" class="form-check-label">@lang("labels.custom")
                    <input type="text" class="form-control w-25 d-inline dateformatvalue input-sm" name="date_format_value" value=""></label>
            </div>
        </div>
        </div>

        <div class="form-group row">
            <label for="" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.time_format")</label>
            <div class="col-sm-9">
                <div class="zinput zradio zradio-sm zinput-inline p-0">
                    <input id="time_format_gia" name="time_format" type="radio" required class="form-check-input" value="g:i a">
                    <label for="time_format_gia" class="form-check-label ml-0 ingnorTitleCase">
                        {{ date('g:i a') }}
                    </label>
                </div>
                <div class="zinput zradio zradio-sm zinput-inline p-0">
                    <input id="time_format_giA" name="time_format" type="radio" required class="form-check-input" value="g:i A">
                    <label for="time_format_giA" class="form-check-label ml-1 ingnorTitleCase">
                        {{ date('g:i A') }}
                    </label>
                </div>
                <div class="zinput zradio zradio-sm zinput-inline p-0">
                    <input id="time_format_Hi" name="time_format" type="radio" required class="form-check-input" value="H:i">
                    <label for="time_format_Hi" class="form-check-label ml-1 ingnorTitleCase">
                        {{ date('H:i') }}
                    </label>
                </div>
                <div class="zinput zradio zradio-sm zinput-inline p-0">
                    <input id="time_format_hiA" name="time_format" type="radio" required class="form-check-input" value="h:i A">
                    <label for="time_format_hiA" class="form-check-label ml-1 ingnorTitleCase">
                        {{ date('h:i A') }}
                    </label>
                </div>
                <div class="zinput zradio zradio-sm zinput-inline p-0">
                    <input id="time_format_custom" name="time_format" type="radio" required class="form-check-input" value="Custom">
                    <label for="time_format_custom" class="form-check-label ml-1">@lang("labels.custom")<input type="text" class="form-control w-25 d-inline timeformatvalue input-sm" name="time_format_value" value=""></label>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="stateLicensed" class="col-sm-3 col-form-label requiredAsterisk">
                @lang("labels.us_time_zone")</label>
            <div class="col-sm-4">
                {!! form_dropdown('us_time_zone', timeZoneDropDown(), '', ["class"=>"ui dropdown input-sm
                w-100","required"=>null]) !!}
            </div>
        </div>
        <div>
            <hr class="color-10 my-5">
        </div>
        <div>
            <p class="fw-600">Email Settings</p>
        </div>
        <div class="row">
            <label for="administrator_email" class="col-sm-3 col-form-label requiredAsterisk">Administrator
                Email</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="administrator_email" class="col-sm-12 col-form-label">Email
                                Address</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control input-sm" name="email_setting[administrator][email]" id="administrator_email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="administrator_email_outgoing_server" class="col-sm-12 col-form-label">Outgoing Server</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[administrator][server]" id="administrator_email_outgoing_server">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Authentication</label>
                                <div class="col-sm-12">
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                        <input id="administrator_email_authentication_yes" class="form-check-input" name="email_setting[administrator][authentication]" type="radio" required value="yes">
                                        <label for="administrator_email_authentication_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                        <input id="administrator_email_authentication_no" class="form-check-input" name="email_setting[administrator][authentication]" type="radio" required value="no">
                                        <label for="administrator_email_authentication_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Secure Type</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[administrator][encryption]', encryptionTypeDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="administrator_email_username" class="col-sm-12 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[administrator][username]" id="administrator_email_username">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="administrator_email_passward" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control input-sm" name="email_setting[administrator][password]" id="administrator_email_passward">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Protocol</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[administrator][imap]', emailImapDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Port</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[administrator][port]', emailPortDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="officelocation" class="col-sm-3 col-form-label requiredAsterisk">Quote
                Activation Email</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="quote_activation_email" class="col-sm-12 col-form-label">Email
                                Address</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control input-sm" name="email_setting[quote][email]" id="quote_activation_email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="quote_activation_outgoing_server" class="col-sm-12 col-form-label">Outgoing
                                Server</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[quote][server]" id="quote_activation_outgoing_server">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Authentication</label>
                                <div class="col-sm-12">
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                        <input id="quote_activation_authentication_yes" class="form-check-input" name="email_setting[quote][authentication]" type="radio" required value="yes">
                                        <label for="quote_activation_authentication_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                        <input id="quote_activation_authentication_no" class="form-check-input" name="email_setting[quote][authentication]" type="radio" required value="no">
                                        <label for="quote_activation_authentication_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Secure Type</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[quote][encryption]', encryptionTypeDropDown(), '', ["class"=>"form-control input-sm","required"=>null]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="quote_activation_username" class="col-sm-12 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[quote][username]" id="quote_activation_username">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="quote_activation_passward" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control input-sm" name="email_setting[quote][password]" id="quote_activation_passward">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Protocol</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[quote][imap]', emailImapDropDown(), '', ["class"=>"form-control input-sm","required"=>null]); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Port</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[quote][port]', emailPortDropDown(), '', ["class"=>"form-control input-sm","required"=>null]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <label for="officelocation" class="col-sm-3 col-form-label requiredAsterisk">Esignature
                Email</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="esignature_email" class="col-sm-12 col-form-label">Email
                                Address</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control input-sm" name="email_setting[esignature][email]" id="esignature_email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="esignature_outgoing_server" class="col-sm-12 col-form-label">Outgoing
                                Server</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[esignature][server]" id="esignature_outgoing_server">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Authentication</label>
                                <div class="col-sm-12">
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                        <input id="esignature_authentication_yes" class="form-check-input" name="email_setting[esignature][authentication]" type="radio" required value="yes">
                                        <label for="esignature_authentication_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                        <input id="esignature_authentication_no" class="form-check-input" name="email_setting[esignature][authentication]" type="radio" required value="no">
                                        <label for="esignature_authentication_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Secure Type</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[esignature][encryption]', encryptionTypeDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="esignature_username" class="col-sm-12 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[esignature][username]" id="esignature_username">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="esignature_passward" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control input-sm" name="email_setting[esignature][password]" id="esignature_passward">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Protocol</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[esignature][imap]', emailImapDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Port</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[esignature][port]', emailPortDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="officelocation" class="col-sm-3 col-form-label requiredAsterisk">From System
                Email</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="from_system_email" class="col-sm-12 col-form-label">Email
                                Address</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control input-sm" name="email_setting[from_system][email]" id="from_system_email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="from_system_outgoing_server" class="col-sm-12 col-form-label">Outgoing
                                Server</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[from_system][server]" id="from_system_outgoing_server">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Authentication</label>
                                <div class="col-sm-12">
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                        <input id="from_system_authentication_yes" class="form-check-input" name="email_setting[from_system][authentication]" type="radio" required value="yes">
                                        <label for="from_system_authentication_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                        <input id="from_system_authentication_no" class="form-check-input" name="email_setting[from_system][authentication]" type="radio" required value="no">
                                        <label for="from_system_authentication_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Secure Type</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[from_system][encryption]', encryptionTypeDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="from_system_username" class="col-sm-12 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[from_system][username]" id="from_system_username">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="from_system_passward" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control input-sm" name="email_setting[from_system][password]" id="from_system_passward">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Protocol</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[from_system][imap]', emailImapDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Port</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[from_system][port]', emailPortDropDown(), '', ["class"=>"form-control input-sm",]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="officelocation" class="col-sm-3 col-form-label requiredAsterisk">Reply-to
                Email</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="reply_to_email" class="col-sm-12 col-form-label">Email
                                Address</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control input-sm" name="email_setting[reply_to][email]" id="reply_to_email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="reply_to_outgoing_server" class="col-sm-12 col-form-label">Outgoing
                                Server</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[reply_to][server]" id="reply_to_outgoing_server">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Authentication</label>
                                <div class="col-sm-12">
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                        <input id="reply_to_authentication_yes" class="form-check-input" name="email_setting[reply_to][authentication]" type="radio" required value="yes">
                                        <label for="reply_to_authentication_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                        <input id="reply_to_authentication_no" class="form-check-input" name="email_setting[reply_to][authentication]" type="radio" required value="no">
                                        <label for="reply_to_authentication_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Secure Type</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[reply_to][encryption]', encryptionTypeDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="reply_to_username" class="col-sm-12 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[reply_to][username]" id="reply_to_username">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="reply_to_passward" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control input-sm" name="email_setting[reply_to][password]" id="reply_to_passward">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Protocol</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[reply_to][imap]', emailImapDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Port</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[reply_to][port]', emailPortDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="officelocation" class="col-sm-3 col-form-label requiredAsterisk">Notices
                Email</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="notices_email_email" class="col-sm-12 col-form-label">Email
                                Address</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control input-sm" name="email_setting[notices][email]" id="notices_email_email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="notices_email_outgoing_server" class="col-sm-12 col-form-label">Outgoing
                                Server</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[notices][server]" id="notices_email_outgoing_server">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Authentication</label>
                                <div class="col-sm-12">
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                        <input id="notices_email_authentication_yes" class="form-check-input" name="email_setting[notices][authentication]" type="radio" required value="yes">
                                        <label for="notices_email_authentication_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                        <input id="notices_email_authentication_no" class="form-check-input" name="email_setting[notices][authentication]" type="radio" required value="no">
                                        <label for="notices_email_authentication_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Secure Type</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[notices][encryption]', encryptionTypeDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="notices_email_username" class="col-sm-12 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[notices][username]" id="notices_email_username">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="notices_email_passward" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control input-sm" name="email_setting[notices][password]" id="notices_email_passward">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Protocol</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[notices][imap]', emailImapDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Port</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[notices][port]', emailPortDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="officelocation" class="col-sm-3 col-form-label requiredAsterisk">Tasks
                Email</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="tasks_email" class="col-sm-12 col-form-label">Email
                                Address</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control input-sm" name="email_setting[tasks][email]" id="tasks_email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="tasks_outgoing_server" class="col-sm-12 col-form-label">Outgoing
                                Server</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[tasks][server]" id="tasks_outgoing_server">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Authentication</label>
                                <div class="col-sm-12">
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                        <input id="tasks_authentication_yes" class="form-check-input" name="email_setting[tasks][authentication]" type="radio" required value="yes">
                                        <label for="tasks_authentication_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                        <input id="tasks_authentication_no" class="form-check-input" name="email_setting[tasks][authentication]" type="radio" required value="no">
                                        <label for="tasks_authentication_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Secure Type</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[tasks][encryption]', encryptionTypeDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="tasks_username" class="col-sm-12 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[tasks][username]" id="tasks_username">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="tasks_passward" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control input-sm" name="email_setting[tasks][password]" id="tasks_passward">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Protocol</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[tasks][imap]', emailImapDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Port</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[tasks][port]', emailPortDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="officelocation" class="col-sm-3 col-form-label requiredAsterisk">Attachments
                Email</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="attachments_email" class="col-sm-12 col-form-label">Email
                                Address</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control input-sm" name="email_setting[attachments][email]" id="attachments_email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="attachments_outgoing_server" class="col-sm-12 col-form-label">Outgoing
                                Server</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[attachments][server]" id="attachments_outgoing_server">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Authentication</label>
                                <div class="col-sm-12">
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                        <input id="attachments_authentication_yes" class="form-check-input" name="email_setting[attachments][authentication]" type="radio" required value="yes">
                                        <label for="attachments_authentication_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                        <input id="attachments_authentication_no" class="form-check-input" name="email_setting[attachments][authentication]" type="radio" required value="no">
                                        <label for="attachments_authentication_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Secure Type</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[attachments][encryption]', encryptionTypeDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="attachments_username" class="col-sm-12 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[attachments][username]" id="attachments_username">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="attachments_passward" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control input-sm" name="email_setting[attachments][password]" id="attachments_passward">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Protocol</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[attachments][imap]', emailImapDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Port</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[attachments][port]', emailPortDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="officelocation" class="col-sm-3 col-form-label requiredAsterisk">Messages
                Email</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="messages_email_email" class="col-sm-12 col-form-label">Email
                                Address</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control input-sm" name="email_setting[messages][email]" id="messages_email_email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="messages_email_outgoing_server" class="col-sm-12 col-form-label">Outgoing
                                Server</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[messages][server]" id="messages_email_outgoing_server">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Authentication</label>
                                <div class="col-sm-12">
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                        <input id="messages_email_authentication_yes" class="form-check-input" name="email_setting[messages][authentication]" type="radio" required value="yes">
                                        <label for="messages_email_authentication_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                        <input id="messages_email_authentication_no" class="form-check-input" name="email_setting[messages][authentication]" type="radio" required value="no">
                                        <label for="messages_email_authentication_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Secure Type</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[messages][encryption]', encryptionTypeDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="messages_email_username" class="col-sm-12 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[messages][username]" id="messages_email_username">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="messages_email_passward" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control input-sm" name="email_setting[messages][password]" id="messages_email_passward">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Protocol</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[messages][imap]', emailImapDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Port</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[messages][port]', emailPortDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="officelocation" class="col-sm-3 col-form-label requiredAsterisk">Sales
                Organization</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="sales_email_email" class="col-sm-12 col-form-label">Email
                                Address</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control input-sm" name="email_setting[sales][email]" id="sales_email_email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="sales_email_outgoing_server" class="col-sm-12 col-form-label">Outgoing
                                Server</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[sales][server]" id="sales_email_outgoing_server">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Authentication</label>
                                <div class="col-sm-12">
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                        <input id="sales_email_authentication_yes" class="form-check-input" name="email_setting[sales][authentication]" type="radio" required value="yes">
                                        <label for="sales_email_authentication_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                        <input id="sales_email_authentication_no" class="form-check-input" name="email_setting[sales][authentication]" type="radio" required value="no">
                                        <label for="sales_email_authentication_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Secure Type</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[sales][encryption]', encryptionTypeDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="sales_email_username" class="col-sm-12 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[sales][username]" id="sales_email_username">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="sales_email_passward" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control input-sm" name="email_setting[sales][password]" id="sales_email_passward">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Protocol</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[sales][imap]', emailImapDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Port</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[sales][port]', emailPortDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="officelocation" class="col-sm-3 col-form-label  requiredAsterisk">Email 2
                Fax</label>
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="faxl_email" class="col-sm-12 col-form-label">Email
                                Address</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control input-sm " name="email_setting[fax][email]" id="faxl_email" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="faxl_outgoing_server" class="col-sm-12 col-form-label">Outgoing
                                Server</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[fax][server]" id="faxl_outgoing_server">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Authentication</label>
                                <div class="col-sm-12">
                                    <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                        <input id="faxl_authentication_yes" class="form-check-input" class="form-check-input" name="email_setting[fax][authentication]" type="radio" required value="yes">
                                        <label for="faxl_authentication_yes" class="form-check-label">Yes</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                        <input id="faxl_authentication_no" class="form-check-input" class="form-check-input" name="email_setting[fax][authentication]" type="radio" required value="no">
                                        <label for="faxl_authentication_no" class="form-check-label">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Secure Type</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[fax][encryption]', encryptionTypeDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="faxl_username" class="col-sm-12 col-form-label">Username</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control input-sm" name="email_setting[fax][username]" id="faxl_username">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <label for="faxl_passward" class="col-sm-12 col-form-label">Password</label>
                            <div class="col-sm-12">
                                <input type="password" class="form-control input-sm" name="email_setting[fax][password]" id="faxl_passward">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row form-group">
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Protocol</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[fax][imap]', emailImapDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="" class="col-sm-12 col-form-label">Port</label>
                                <div class="col-sm-12">
                                    <?=  form_dropdown('email_setting[fax][port]', emailPortDropDown(), '', ["class"=>"form-control input-sm"]); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <hr class="color-10 my-5">
        </div>
        <div>
            <p class="fw-600">Outgoing Fax Settings</p>
        </div>
        <div class="form-group row">
            <label for="from_fax_email" class="col-sm-3 col-form-label">@lang("labels.from_fax_email")</label>
            <div class="col-sm-9">
                <input type="text" name="fax_email" class="form-control input-sm" id="from_fax_email" placeholder="">
            </div>
        </div>
        <div class="form-group row align-items-center">
            <label for="" class="col-sm-3 col-form-label requiredAsterisk">
                @lang("labels.prepend_a_1_on_to_outgoing_faxs")</label>
            <div class="col-sm-9">
                <div class="zinput zradio zradio-sm  zinput-inline">
                    <input id="rightfax_server_email_enable" name="outgoing_fax_numbers" type="radio" required class="form-check-input" value="true">
                    <label for="rightfax_server_email_enable" class="form-check-label">@lang("labels.enable")</label>
                </div>
                <div class="zinput zradio  zradio-sm   zinput-inline">
                    <input id="rightfax_server_email_disable" name="outgoing_fax_numbers" type="radio" required class="form-check-input" value="false">
                    <label for="rightfax_server_email_disable" class="form-check-label">@lang("labels.disable")</label>
                </div>
            </div>
        </div>

        <div x-data="{showFax:'',isDislable:false}">
            <div class="form-group row align-items-center">
                <label for="" class="col-sm-3 col-form-label requiredAsterisk">
                    @lang("labels.use_subject")</label>
                <div class="col-sm-9">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="use_subject_yes" name="use_subject" type="radio" required class="form-check-input" value="Yes" @change="(showFax = ($el.checked ? 'yes' : 'no'))">
                        <label for="use_subject_yes" class="form-check-label">Yes</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="use_subject_no" name="use_subject" type="radio" required class="form-check-input" value="No" @change="(showFax = ($el.checked ? 'no' : 'yes'))">
                        <label for="use_subject_no" class="form-check-label">No</label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="rightfax_server_email" class="col-sm-3 col-form-label ">@lang("labels.server_email_address")
                </label>
                <div class="col-sm-9">
                    <input type="text" name="server_email" class="form-control input-sm" id="server_email" placeholder="">
                </div>
            </div>
            <div class="form-group row align-items-center" x-show="showFax == 'yes' || isEmptyChack(showFax)">
                <label for="" class="col-sm-3 col-form-label requiredAsterisk">
                    @lang("labels.use_security_code")</label>
                <div class="col-sm-9">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="use_security_code_yes" name="use_security_code" @change="(isDislable = !$el.checked)" type="radio" required class="form-check-input" value="Yes">
                        <label for="use_security_code_yes" class="form-check-label">Yes</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="use_security_code_no" name="use_security_code" @change="(isDislable = $el.checked)" type="radio" required class="form-check-input" value="No">
                        <label for="use_security_code_no" class="form-check-label">No</label>
                    </div>
                </div>
            </div>
            <div class="form-group row" x-show="showFax == 'yes' || isEmptyChack(showFax)">
                <label for="security_code" class="col-sm-3 col-form-label ">@lang("labels.security_code") </label>
                <div class="col-sm-9">
                    <input type="text" name="security_code" class="form-control input-sm" id="security_code" placeholder="" x-bind:disabled="isDislable">
                </div>
            </div>

            <div class="form-group row fax_server_domain_box" x-show="showFax == 'no' || isEmptyChack(showFax)">
                <label for="fax_server_domain_name" class="col-sm-3 col-form-label ">@lang("labels.fax_server_domain_name")
                    Name</label>
                <div class="col-sm-9">
                    <input type="text" name="server_email_domain" class="form-control input-sm" id="server_email_domain" placeholder="">
                </div>
            </div>
        </div>

        <div>
            <hr class="color-10 my-5">
        </div>
        <div>
            <p class="fw-600">Incoming Fax</p>
        </div>
        <div class="form-group row">
            <label for="ccpa_privacy_notice" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.signed_agreement_fax")</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="signed_agreement_fax_one" class="fax w-50" required />
                <x-jet-input type="text" name="signed_agreement_fax_two" class="fax w-50 mt-2" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="ccpa_privacy_notice" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.entity_fax_numbers")</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="attachment_fax_one" class="fax w-50" required />
                <x-jet-input type="text" name="attachment_fax_two" class="fax w-50 mt-2" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="ccpa_privacy_notice" class="col-sm-3 col-form-label">@lang("labels.forward_incoming_faxes_to")</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="forward_incoming_faxes" class="fax w-50" />

            </div>
        </div>
        <div class="form-group row">
            <label for="can_spam_notice" class="col-sm-3 col-form-label">@lang("labels.can_spam_notice")</label>
            <div class="col-sm-9">
                <textarea name="can_spam_notice" id="can_spam_notice" cols="30" class="form-control dark" rows="3"></textarea>

            </div>
        </div>
        <div class="form-group row">
            <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang("labels.copy_right_notice")</label>
            <div class="col-sm-9">
                <textarea name="copy_right_notice" id="copy_right_notice" cols="30" class="form-control dark" rows="3"></textarea>
            </div>
        </div>
        <x-button-group :cancel="routeCheck($route . 'index')" />

        @endslot
    </x-jet-form-section>
</x-app-layout>
