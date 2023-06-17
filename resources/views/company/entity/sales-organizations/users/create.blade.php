<form class="validationForm" novalidate action="{{ routeCheck($route . '.create', $id) }}" method="post"
    x-data="{ resetPassword: '' }">
    @csrf

    <input type="hidden" name="entity_id" value="{{ $id ?? '' }}">
    <div class="row">
        <label for="primary_address" class="col-sm-3 col-form-label requiredAsterisk">
            @lang('labels.contact_name_first_name_m_i_last_name')</label>
        <div class="col-sm-9">
            <div class="form-group row">

                <div class="col-md-5">
                    <x-jet-input type="text" required name="first_name" id="first_name_1" placeholder="First Name" />
                </div>
                <div class="col-md-2">
                    <x-jet-input type="text" name="middle_name" id="middle_name_1" placeholder="M/I" />
                </div>
                <div class="col-md-5">
                    <x-jet-input type="text" required name="last_name" id="last_name_1" placeholder="Last Name" />
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="owner_emai_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.title')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" required name="title" />
        </div>
    </div>
    <div class="form-group row">
        <label for="month_1" class="col-sm-3 col-form-label ">@lang('labels.dob')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-6">

                    {!! form_dropdown('month', monthsDropDown($type = 'number'), '', [
                        'class' => 'ui dropdown monthsNumber input-sm w-100',
                        'placeholder' => 'Month',
                        'id' => 'month_1',
                    ]) !!}
                </div>
                <div class="col-sm-6">
                    {!! form_dropdown('day', [], '', ['id' => 'day_1', 'class' => ' daysList', 'placeholder' => 'Day']) !!}

                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="owner_emai_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email')</label>
        <div class="col-sm-9">
            <x-jet-input type="email" name="email" required />
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
                            <x-jet-input type="text" name="email_information[server]" />

                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row form-group">
                        <label for="" class="col-sm-12 col-form-label">@lang('labels.authentication')</label>
                        <div class="col-sm-12">
                            <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                <input id="quote_activation_authentication_yes" class="form-check-input"
                                    name="email_information[authentication]" type="radio" value="yes">
                                <label for="quote_activation_authentication_yes"
                                    class="form-check-label">@lang('labels.yes')</label>
                            </div>
                            <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                <input id="quote_activation_authentication_no" class="form-check-input"
                                    name="email_information[authentication]" type="radio" value="no">
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
                            <x-jet-input type="text" name="email_information[username]" />

                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row form-group">
                        <label for="quote_activation_passward"
                            class="col-sm-12 col-form-label">@lang('labels.password')</label>
                        <div class="col-sm-12">
                            <x-jet-input type="password" name="email_information[password]" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label for="" class="col-sm-12 col-form-label" style="opacity:0;"></label>
                        </div>
                        <div class="col-sm-4">
                            {!! form_dropdown('email_information[imap]', emailImapDropDown(), '', [
                                'class' => 'form-control input-sm',
                            ]) !!}


                        </div>
                        <div class="col-sm-4">
                            {!! form_dropdown('email_information[port]', emailPortDropDown(), '', [
                                'class' => 'form-control input-sm',
                            ]) !!}

                        </div>
                        <div class="col-sm-4">
                            {!! form_dropdown('email_information[encryption]', encryptionTypeDropDown(), '', [
                                'class' => 'form-control input-sm',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="form-group row">
        <label for="owner_telephone_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.primary_telephone')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-md-8">
                    <x-jet-input type="tel" required name="mobile" class="telephone" id="owner_telephone_1" />
                </div>
                <div class="col-md-4">
                    <x-jet-input type="tel" required name="extenstion" placeholder="Extenstion"
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
                    <x-jet-input type="tel" name="alternate_telephone" id="owner_alternate_telephone_1"
                        class="telephone" />
                </div>
                <div class="col-md-4">
                    <x-jet-input type="tel" name="alternate_telephone" placeholder="Extenstion"
                        id="owner_alternate_extenstion_1" />
                </div>
            </div>
        </div>
    </div>


    <div class="form-group row align-items-center">
        <label for="" class="col-sm-3 col-form-label requiredAsterisk">
            @lang('labels.user_login')</label>
        <div class="col-sm-9">
            <div class="zinput zradio zradio-sm  zinput-inline">
                <input id="status_enable" name="status" type="radio" required class="form-check-input"
                    value="yes">
                <label for="status_enable" class="form-check-label">@lang('labels.enable')</label>
            </div>
            <div class="zinput zradio  zradio-sm   zinput-inline">
                <input id="status_disable" name="status" type="radio" required class="form-check-input"
                    value="no">
                <label for="status_disable" class="form-check-label">@lang('labels.disable')</label>
            </div>
        </div>
    </div>
      <div class="form-group row align-items-center">
                    <label for="" class="col-sm-3 col-form-label requiredAsterisk">
                        @lang('labels.send_email_password_reset_to_user')</label>
                    <div class="col-sm-9">
                        <div class="zinput zradio zradio-sm  zinput-inline">
                            <input id="reset_password_enable" name="reset_password" type="radio" required
                                class="form-check-input" value="yes"
                                @change="resetPassword = $event.target.checked ? 'yes' : '';">
                            <label for="reset_password_enable" class="form-check-label">@lang('labels.yes')</label>
                        </div>
                        <div class="zinput zradio  zradio-sm   zinput-inline">
                            <input id="reset_password_disable" name="reset_password" type="radio" required
                                class="form-check-input" value="no"
                                @change="resetPassword = $event.target.checked ? 'no' : '';">
                            <label for="reset_password_disable" class="form-check-label">@lang('labels.no')</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row" x-show='resetPassword == "no"'>
                    <label for="licence_no_1" class="col-sm-3 col-form-label ">@lang('labels.password')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="password" name="password" placeholder="Password" />
                    </div>
                </div>
    <div class="form-group row">
        <label for="notes" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
        <div class="col-sm-9">
            <textarea name="notes" id="notes" cols="30" class="form-control" rows="4"></textarea>
        </div>
    </div>


    <x-button-group class="saveData" />


</form>
