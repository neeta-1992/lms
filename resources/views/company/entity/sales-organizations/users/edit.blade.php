<form class="validationForm editForm" novalidate action="{{ routeCheck($route . '.edit', $id) }}" method="post"
    x-data="{ resetPassword: '' }">
    <input type="hidden" name="logsArr">
    <input type="hidden" name="userId" value="{{ $id ?? '' }}">
    <div class="row">
        <label for="primary_address" class="col-sm-3 col-form-label requiredAsterisk">
            @lang('labels.contact_name_first_name_m_i_last_name')</label>
        <div class="col-sm-9">
            <div class="form-group row">

                <div class="col-md-5">
                    <x-jet-input type="text" required name="first_name" id="first_name_1" placeholder="First Name"
                        value="{{ $data['first_name'] }}" />
                </div>
                <div class="col-md-2">
                    <x-jet-input type="text" name="middle_name" id="middle_name_1" placeholder="M/I"
                        value="{{ $data['middle_name'] }}" />
                </div>
                <div class="col-md-5">
                    <x-jet-input type="text" required name="last_name" id="last_name_1" placeholder="Last Name"
                        value="{{ $data['last_name'] }}" />
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="owner_emai_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.title')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" required name="title" value="{{ $data['title'] }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="month_1" class="col-sm-3 col-form-label ">@lang('labels.dob')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-6">

                    {!! form_dropdown('month', monthsDropDown($type = 'number'), $data['profile']['month'] ?? '', [
                        'class' => 'ui dropdown monthsNumber input-sm w-100',
                        'placeholder' => 'Month',
                        'id' => 'month_1',
                    ]) !!}
                </div>
                <div class="col-sm-6">
                    {!! form_dropdown('day', [], $data['profile']['day'] ?? '', [
                        'id' => 'day_1',
                        'class' => ' daysList',
                        'placeholder' => 'Day',
                    ]) !!}

                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="owner_emai_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email')</label>
        <div class="col-sm-9">
            <x-jet-input type="email" name="email" required value="{{ $data['email'] ?? '' }}" />
        </div>
    </div>
    @php
        $email_information = !empty($data['email_information']) ? json_decode($data['email_information'], true) : '';

    @endphp
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
                            <x-jet-input type="text" name="email_information[server]"
                                value="{{ $email_information['server'] ?? '' }}" />

                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row form-group">
                        <label for="" class="col-sm-12 col-form-label">@lang('labels.authentication')</label>
                        <div class="col-sm-12">
                            <div class="zinput zradio zradio-sm  zinput-inline p-0">
                                <input id="quote_activation_authentication_yes" class="form-check-input"
                                    name="email_information[authentication]" type="radio" value="yes"
                                    @checked(!empty($email_information['authentication']) && $email_information['authentication'] == 'yes')>
                                <label for="quote_activation_authentication_yes"
                                    class="form-check-label">@lang('labels.yes')</label>
                            </div>
                            <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                <input id="quote_activation_authentication_no" class="form-check-input"
                                    name="email_information[authentication]" type="radio" value="no"
                                    @checked(!empty($email_information['authentication']) && $email_information['authentication'] == 'no')>
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
                            <x-jet-input type="text" name="email_information[username]"
                                value="{{ $email_information['username'] ?? '' }}" />

                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row form-group">
                        <label for="quote_activation_passward"
                            class="col-sm-12 col-form-label">@lang('labels.password')</label>
                        <div class="col-sm-12">
                            <x-jet-input type="password" name="email_information[password]"
                                value="{{ $email_information['password'] ?? '' }}" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row form-group">
                        <div class="col-sm-12">
                            <label for="" class="col-sm-12 col-form-label" style="opacity:0;"></label>
                        </div>
                        <div class="col-sm-4">
                            {!! form_dropdown('email_information[imap]', emailImapDropDown(), $email_information['imap'] ?? '', [
                                'class' => 'form-control input-sm',
                            ]) !!}


                        </div>
                        <div class="col-sm-4">
                            {!! form_dropdown('email_information[port]', emailPortDropDown(), $email_information['port'] ?? '', [
                                'class' => 'form-control input-sm',
                            ]) !!}

                        </div>
                        <div class="col-sm-4">
                            {!! form_dropdown(
                                'email_information[encryption]',
                                encryptionTypeDropDown(),
                                $email_information['encryption'] ?? '',
                                [
                                    'class' => 'form-control input-sm',
                                ],
                            ) !!}
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
                    <x-jet-input type="tel" required name="mobile" class="telephone"
                        value="{{ $data['mobile'] ?? '' }}" id="owner_telephone_1" />
                </div>
                <div class="col-md-4">
                    <x-jet-input type="tel" required name="extenstion" placeholder="Extenstion"
                        id="owner_extenstion_1" value="{{ $data['extenstion'] ?? '' }}" />
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
                        class="telephone" value="{{ $data['alternate_telephone'] ?? '' }}" />
                </div>
                <div class="col-md-4">
                    <x-jet-input type="tel" name="alternate_telephone_extenstion" placeholder="Extenstion"
                        value="{{ $data['alternate_telephone_extenstion'] ?? '' }}" />
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
                    value="true" {{ $data['status'] == true ? 'checked' : '' }}>
                <label for="status_enable" class="form-check-label">@lang('labels.enable')</label>
            </div>
            <div class="zinput zradio  zradio-sm   zinput-inline">
                <input id="status_disable" name="status" type="radio" required class="form-check-input"
                    value="false" {{ $data['status'] == false ? 'checked' : '' }}>
                <label for="status_disable" class="form-check-label">@lang('labels.disable')</label>
            </div>
        </div>
    </div>
    <div class="form-group row align-items-center">
        <label for="" class="col-sm-3 col-form-label ">
            @lang('labels.reset_password')</label>
        <div class="col-sm-9">
            <div class="zinput zradio zradio-sm  zinput-inline">
                <input id="reset_password_enable" name="reset_password" type="radio" class="form-check-input"
                    value="yes" @change="resetPassword = $event.target.checked ? 'yes' : '';">
                <label for="reset_password_enable" class="form-check-label">@lang('labels.yes')</label>
            </div>
            <div class="zinput zradio  zradio-sm   zinput-inline">
                <input id="reset_password_disable" name="reset_password" type="radio" class="form-check-input"
                    value="no" @change="resetPassword = $event.target.checked ? 'no' : '';">
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
    <div class="form-group row" x-show='resetPassword == "email"'>
        <label for="licence_no_1" class="col-sm-3 col-form-label ">@lang('labels.reset_password_email_address')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" name="reset_password_email" placeholder="Email" />
        </div>
    </div>



    <x-button-group class="saveData" xclick="open = 'users'" />

    <script>
        var editFormArr = @json($data ?? []);
    </script>
</form>
