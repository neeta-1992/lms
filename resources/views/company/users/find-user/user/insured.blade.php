<div class="row">
    <label for="primary_address" class="col-sm-3 col-form-label requiredAsterisk">
        @lang('labels.contact_name_first_name_m_i_last_name')</label>
    <div class="col-sm-9">
        <div class="form-group row">

            <div class="col-md-5">
                <x-jet-input type="text" required name="first_name" id="first_name" placeholder="First Name" />
            </div>
            <div class="col-md-2">
                <x-jet-input type="text" name="middle_name" id="middle_name" placeholder="M/I" />
            </div>
            <div class="col-md-5">
                <x-jet-input type="text" required name="last_name" id="last_name" placeholder="Last Name" />
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="month" class="col-sm-3 col-form-label ">@lang('labels.dob')</label>
    <div class="col-sm-9">
        <div class="row">
            <div class="col-sm-6">

                {!! form_dropdown('month', monthsDropDown($type = 'number'), '', [
                'class' => "ui dropdown monthsNumber input-sm w-100",
                'placeholder' => 'Month',
                'id' => 'month',
                ]) !!}
            </div>
            <div class="col-sm-6">
                {!! form_dropdown('day', [], '', ['id' => 'day', 'class' => ' daysList', 'placeholder' =>
                'Day']) !!}

            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="owner_emai" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email')</label>
    <div class="col-sm-9">
        <x-jet-input type="email" name="email" required />
    </div>
</div>


<div class="form-group row">
    <label for="inmail_service_enable"
        class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.use_inMail_service')</label>
    <div class="col-sm-9">
        <div class="zinput zradio zradio-sm  zinput-inline  p-0">
            <input id="inmail_service_enable" name="inmail_service" type="radio" required class="form-check-input"
                value="1">
            <label for="inmail_service_enable" class="form-check-label">@lang('labels.yes')</label>
        </div>
        <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
            <input id="inmail_service_disable" name="inmail_service" type="radio" required class="form-check-input"
                value="0">
            <label for="inmail_service_disable" class="form-check-label">@lang('labels.no')</label>
        </div>
        <small class="ml-2">@lang('labels.must_have_an_email_address')</small>
    </div>
</div>

<div class="form-group row">
    <label for="owner_telephone"
        class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.primary_telephone')</label>
    <div class="col-sm-9">
        <div class="row">
            <div class="col-md-8">
                <x-jet-input type="tel" required name="mobile" class="telephone" id="owner_telephone" />
            </div>
            <div class="col-md-4">
                <x-jet-input type="tel" required name="extenstion" placeholder="Extenstion" id="owner_extenstion" />
            </div>
        </div>
    </div>
</div>
<div class="form-group row">
    <label for="owner_alternate_telephone"
        class="col-sm-3 col-form-label ">@lang('labels.alternate_telephone')</label>
    <div class="col-sm-9">
        <div class="row">
            <div class="col-md-8">
                <x-jet-input type="tel" name="alternate_telephone" id="owner_alternate_telephone" class="telephone" />
            </div>
            <div class="col-md-4">
                <x-jet-input type="tel" name="alternate_telephone" placeholder="Extenstion"
                    id="owner_alternate_extenstion" />
            </div>
        </div>
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="" class="col-sm-3 col-form-label requiredAsterisk">
        @lang('labels.user_login')</label>
    <div class="col-sm-9">
        <div class="zinput zradio zradio-sm  zinput-inline">
            <input id="status_enable" name="status" type="radio" required class="form-check-input" value="1">
            <label for="status_enable" class="form-check-label">@lang("labels.enable")</label>
        </div>
        <div class="zinput zradio  zradio-sm   zinput-inline">
            <input id="status_disable" name="status" type="radio" required class="form-check-input" value="0">
            <label for="status_disable" class="form-check-label">@lang("labels.disable")</label>
        </div>
    </div>
</div>
<div class="form-group row align-items-center">
    <label for="" class="col-sm-3 col-form-label ">
        @lang('labels.reset_password')</label>
    <div class="col-sm-9">
        <div class="zinput zradio zradio-sm  zinput-inline">
            <input id="reset_password_enable" name="reset_password" type="radio"  class="form-check-input"
                value="yes" @change="resetPassword = $event.target.checked ? 'yes' : '';">
            <label for="reset_password_enable" class="form-check-label">@lang("labels.yes")</label>
        </div>
        <div class="zinput zradio  zradio-sm   zinput-inline">
            <input id="reset_password_disable" name="reset_password" type="radio"  class="form-check-input"
                value="no" @change="resetPassword = $event.target.checked ? 'no' : '';">
            <label for="reset_password_disable" class="form-check-label">@lang("labels.no")</label>
        </div>
    </div>
</div>
<div class="form-group row" x-show='resetPassword == "no"'>
    <label for="licence_no" class="col-sm-3 col-form-label ">@lang('labels.password')</label>
    <div class="col-sm-9">
        <x-jet-input type="password" name="password" placeholder="Password" />
    </div>
</div>
<div class="form-group row align-items-center">
    <label for="" class="col-sm-3 col-form-label ">
        @lang('labels.email_notification')</label>
    <div class="col-sm-9">
        <div class="zinput zradio zradio-sm  zinput-inline">
            <input id="email_notification_enable" disabled name="email_notification" type="radio"
                class="form-check-input" value="yes">
            <label for="email_notification_enable" class="form-check-label">@lang("labels.yes")</label>
        </div>
        <div class="zinput zradio  zradio-sm   zinput-inline">
            <input id="email_notification_disable" disabled name="email_notification" type="radio"
                class="form-check-input" value="no">
            <label for="email_notification_disable" class="form-check-label">@lang("labels.no")</label>
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
    <div class="col-sm-9">
        <textarea name="notes" id="notes" cols="30" class="form-control" rows="3"></textarea>
    </div>
</div>
