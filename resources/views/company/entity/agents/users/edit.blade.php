<form class="validationForm editForm" novalidate action="{{ routeCheck('company.agents.users.edit',$id) }}" method="post"
 x-data="{ resetPassword : '' }">
 <input type="hidden" name="logsArr">
    <input type="hidden" name="userId" value="{{ $id ?? '' }}">
    <div class="row">
        <label for="primary_address" class="col-sm-3 col-form-label requiredAsterisk">
            @lang('labels.contact_name_first_name_m_i_last_name')</label>
        <div class="col-sm-9">
            <div class="form-group row">

                <div class="col-md-5">
                    <x-jet-input type="text" required name="first_name" id="first_name_1"
                        placeholder="First Name" value="{{ $data['first_name'] }}"/>
                </div>
                <div class="col-md-2">
                    <x-jet-input type="text" name="middle_name" id="middle_name_1" placeholder="M/I" value="{{ $data['middle_name'] }}"/>
                </div>
                <div class="col-md-5">
                    <x-jet-input type="text" required name="last_name" id="last_name_1"
                        placeholder="Last Name" value="{{ $data['last_name'] }}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="month_1" class="col-sm-3 col-form-label ">@lang('labels.dob')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-sm-6">

                    {!! form_dropdown('month', monthsDropDown($type = 'number'), $data['profile']['month'] ?? '', [
                    'class' => "ui dropdown monthsNumber input-sm w-100",
                    'placeholder' => 'Month',
                    'id' => 'month_1',
                    ]) !!}
                </div>
                <div class="col-sm-6">
                    {!! form_dropdown('day', [], $data['profile']['day'] ?? '', ['id' => 'day_1', 'class' => ' daysList', 'placeholder' =>
                    'Day','dataSelected'=>  $data['profile']['day'] ?? '']) !!}

                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="owner_emai_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email')</label>
        <div class="col-sm-9">
            <x-jet-input type="email" name="email" required value="{{ $data['email'] ?? '' }}"/>
        </div>
    </div>


    <div class="form-group row">
        <label for="inmail_service_enable_1"
            class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.use_inMail_service')</label>
        <div class="col-sm-9">
            <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                <input id="inmail_service_enable_1" name="inmail_service" {{ $data['inmail_service'] == true ? 'checked' : '' }} type="radio" required
                    class="form-check-input" value="true">
                <label for="inmail_service_enable_1" class="form-check-label">@lang('labels.yes')</label>
            </div>
            <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                <input id="inmail_service_disable_1" name="inmail_service" {{ $data['inmail_service'] == false ? 'checked' : '' }} type="radio" required
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
                    <x-jet-input type="tel" required name="mobile" class="telephone"  value="{{ $data['mobile'] ?? '' }}"
                        id="owner_telephone_1" />
                </div>
                <div class="col-md-4">
                    <x-jet-input type="tel" required name="extenstion" placeholder="Extenstion"
                        id="owner_extenstion_1"  value="{{ $data['extenstion'] ?? '' }}"/>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="owner_alternate_telephone_1"
            class="col-sm-3 col-form-label ">@lang('labels.alternate_telephone')</label>
        <div class="col-sm-9">
            <div class="row">
                <div class="col-md-8">
                    <x-jet-input type="tel" name="alternate_telephone" id="owner_alternate_telephone_1"
                        class="telephone" value="{{ $data['alternate_telephone'] ?? '' }}"/>
                </div>
                <div class="col-md-4">
                    <x-jet-input type="tel" name="alternate_telephone_extenstion" placeholder="Extenstion"  value="{{ $data['alternate_telephone_extenstion'] ?? '' }}"/>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label for="office" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.office')</label>
        <div class="col-sm-9">
            {!! form_dropdown('office', $office, ($data['office'] ?? ''), [
            'class' => 'ui dropdown input-sm w-100 office_select','required' => true
            ]) !!}
        </div>
    </div>
 {{--    <div class="form-group row">
        <label for="office" class="col-sm-3 col-form-label ">@lang('labels.user_groups')</label>
        <div class="col-sm-9">
            {!! form_dropdown('user_groups', stateDropDown(), '', [
            'class' => 'ui dropdown input-sm w-100',
            ]) !!}
        </div>
    </div> --}}
    <div class="form-group row">
        <label for="role" class="col-sm-3 col-form-label ">@lang('labels.user') @lang("labels.role")</label>
        <div class="col-sm-9">
            {!! form_dropdown('role', [1=>'Adminstrator',2 =>'User'], ($data['role'] ?? "0"), [
            'class' => 'ui dropdown input-sm w-100 role_select','dataSelected' => ($data['role'] ?? "0")
            ]) !!}
        </div>
    </div>

    <div class="form-group row">
        <label for="state_resident" class="col-sm-3 col-form-label ">@lang('labels.state_resident')</label>
        <div class="col-sm-9">
            {!! form_dropdown('state_resident', stateDropDown(['keyType'=>'id']), ($data['profile']['state_resident'] ?? ''), [
            'class' => 'ui dropdown input-sm w-100', 'id' => 'state_resident_1',
            ]) !!}
        </div>
    </div>
    <div class="form-group row">
        <label for="licence_no_1" class="col-sm-3 col-form-label ">@lang('labels.state_resident_license')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" name="licence_no" id="licence_no_1" value="{{ $data['profile']['licence_no'] ?? '' }}"/>
        </div>
    </div>
    <div class="form-group row">
        <label for="expiration_date_1" class="col-sm-3 col-form-label ">@lang('labels.license_expiration_date')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" name="expiration_date" class="singleDatePicker" id="expiration_date_1"
                placeholder="mm/dd/yyy" value="{{ changeDateFormat($data['profile']['expiration_date'] ?? '',true) }}"/>
        </div>
    </div>
     <div class="form-group row align-items-center">
        <label for="" class="col-sm-3 col-form-label requiredAsterisk">
            @lang('labels.allow_user_to_e_signature')</label>
        <div class="col-sm-9">
            <div class="zinput zradio zradio-sm  zinput-inline">
                <input id="esignature_enable" name="esignature" type="radio"
                    required class="form-check-input" value="allowed" {{ $data['esignature'] == 'allowed' ? 'checked' : '' }}>
                <label for="esignature_enable" class="form-check-label">@lang("labels.allowed")</label>
            </div>
            <div class="zinput zradio  zradio-sm   zinput-inline">
                <input id="esignature_disable" name="esignature" type="radio"
                    required class="form-check-input" value="prohibited"  {{ $data['esignature'] == 'prohibited' ? 'checked' : '' }}>
                <label for="esignature_disable" class="form-check-label">@lang("labels.prohibited")</label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label for="owner_percent_1"
            class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.owner_percent')</label>
        <div class="col-sm-1">
            <x-jet-input type="text" required name="owner_percent" id="owner_percent_1"
                class="percentageInput" value="{{ $data['owner_percent']  ?? '' }}"/>
        </div>
    </div>
     <div class="form-group row">
    <label for="owner" class="col-sm-3 col-form-label ">@lang("labels.owner")</label>
        <div class="col-sm-9">

            <x-jet-checkbox for="owner" name="owner"  id="owner" value="true" :checked="(!empty($data['owner']) ? true : false)" />
        </div>
    </div>
     <div class="form-group row align-items-center">
        <label for="" class="col-sm-3 col-form-label requiredAsterisk">
            @lang('labels.convicted_text')</label>
        <div class="col-sm-9">
            <div class="zinput zradio zradio-sm  zinput-inline">
                <input id="convicted_enable" name="convicted" type="radio"
                    required class="form-check-input" value="yes"   {{ $data['profile']['convicted'] == 'yes' ? 'checked' : '' }}>
                <label for="convicted_enable" class="form-check-label">@lang("labels.yes")</label>
            </div>
            <div class="zinput zradio  zradio-sm   zinput-inline">
                <input id="convicted_disable" name="convicted" type="radio" required class="form-check-input" value="no"   {{ $data['profile']['convicted'] == 'no' ? 'checked' : '' }}>
                <label for="convicted_disable" class="form-check-label">@lang("labels.no")</label>
            </div>
        </div>
    </div>
     <div class="form-group row align-items-center">
        <label for="" class="col-sm-3 col-form-label requiredAsterisk">
            @lang('labels.insurance_department_text')</label>
        <div class="col-sm-9">
            <div class="zinput zradio zradio-sm  zinput-inline">
                <input id="insurance_department_enable" name="insurance_department" type="radio"
                    required class="form-check-input" value="yes"  {{ $data['profile']['insurance_department'] == 'yes' ? 'checked' : '' }}>
                <label for="insurance_department_enable" class="form-check-label">@lang("labels.yes")</label>
            </div>
            <div class="zinput zradio  zradio-sm   zinput-inline">
                <input id="insurance_department_disable" name="insurance_department" type="radio"
                    required class="form-check-input" value="no" {{ $data['profile']['insurance_department'] == 'no' ? 'checked' : '' }}>
                <label for="insurance_department_disable" class="form-check-label">@lang("labels.no")</label>
            </div>
        </div>
    </div>
     <div class="form-group row align-items-center">
        <label for="" class="col-sm-3 col-form-label requiredAsterisk">
            @lang('labels.user_login')</label>
        <div class="col-sm-9">
            <div class="zinput zradio zradio-sm  zinput-inline">
                <input id="status_enable" name="status" type="radio"
                    required class="form-check-input" value="true" {{ $data['status'] == true ? 'checked' : '' }}>
                <label for="status_enable" class="form-check-label">@lang("labels.enable")</label>
            </div>
            <div class="zinput zradio  zradio-sm   zinput-inline">
                <input id="status_disable" name="status" type="radio"
                    required class="form-check-input" value="false" {{ $data['status'] == false ? 'checked' : '' }}>
                <label for="status_disable" class="form-check-label">@lang("labels.disable")</label>
            </div>
        </div>
    </div>
     <div class="form-group row align-items-center">
        <label for="" class="col-sm-3 col-form-label">@lang('labels.reset_password')</label>
        <div class="col-sm-9">
            <div class="zinput zradio zradio-sm  zinput-inline">
                <input id="reset_password_enable" name="reset_password" type="radio"
                    class="form-check-input" value="email" @change="resetPassword = $event.target.checked ? 'email' : '';">
                <label for="reset_password_enable" class="form-check-label">@lang("labels.via_email")</label>
            </div>
            <div class="zinput zradio  zradio-sm   zinput-inline">
                <input id="reset_password_disable" name="reset_password" type="radio"
                     class="form-check-input" value="manually"
                    @change="resetPassword = $event.target.checked ? 'manually' : '';">
                <label for="reset_password_disable" class="form-check-label">@lang("labels.manually")</label>
            </div>
        </div>
    </div>
     <div class="form-group row" x-show='resetPassword == "manually"'>
        <label for="licence_no_1" class="col-sm-3 col-form-label ">@lang('labels.password')</label>
        <div class="col-sm-9">
            <x-jet-input type="password" name="password" placeholder="Password"/>
        </div>
    </div>
     <div class="form-group row" x-show='resetPassword == "email"'>
        <label for="licence_no_1" class="col-sm-3 col-form-label ">@lang('labels.reset_password_email_address')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" name="reset_password_email" placeholder="Email"/>
        </div>
    </div>



    <x-button-group class="saveData" xclick="open = 'users'"/>

 <script>
            var editFormArr = @json($data ?? []);
        </script>
</form>
