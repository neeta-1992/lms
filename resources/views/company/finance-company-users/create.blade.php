<x-app-layout>
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post" x-data="{ resetPassword: '' }">
        @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.first_name')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="first_name" required />

                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label ">@lang('labels.m_i')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="middle_name" />
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.last_name')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="last_name" required />
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.title')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="title" required />
                </div>
            </div>
            <div class="form-group row">
                <label for="max_setup_fee" class="col-sm-3 col-form-label">
                    @lang('labels.dob')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-sm-6">

                            {!! form_dropdown('month', monthsDropDown($type = 'number'), '', [
                                'class' => 'ui dropdown monthsNumber input-sm w-100',
                                'placeholder' => 'Month',
                            ]) !!}
                        </div>
                        <div class="col-sm-6">
                            {!! form_dropdown('day', [], '', ['class' => ' daysList', 'placeholder' => 'Day']) !!}

                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email')</label>
                <div class="col-sm-9">
                    <x-jet-input type="email" name="email" required />
                </div>
            </div>
            <div class="row">
                <label for="tin_select" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.primary_telephone')</label>
                <div class="col-sm-9">
                    <div class="form-group row">
                        <div class="col-sm-8">
                            <x-jet-input type="tel" required name="mobile" class="telephone"
                                placeholder="(000) 000-000" />
                        </div>
                        <div class="col-sm-4">
                            <x-jet-input type="text" required name="extenstion" placeholder="Extenstion" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="owner_alternate_telephone_1" class="col-sm-3 col-form-label ">@lang('labels.alternate_telephone')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-md-8">
                            <x-jet-input type="tel" name="alternate_telephone" class="telephone"  placeholder="(000) 000-000"/>
                        </div>
                        <div class="col-md-4">
                            <x-jet-input type="text" name="alternate_telephone_extenstion" placeholder="Extenstion" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.fax')</label>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="fax" class="fax" />
                </div>
            </div>
            <div class="form-group row">
                <label for="type" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.user_role')</label>
                <div class="col-sm-9 ">
                    {!! form_dropdown('type', ['' => '', '2' => 'Adminstrator', '3' => 'User'], '', [
                        'class' => 'ui dropdown input-sm w-100',
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row align-items-center">
                <label for="" class="col-sm-3 col-form-label requiredAsterisk">
                    @lang('labels.user_login')</label>
                <div class="col-sm-9">
                    <div class="zinput zradio zradio-sm  zinput-inline">
                        <input id="status_enable" name="status" type="radio" required class="form-check-input"
                            value="1">
                        <label for="status_enable" class="form-check-label">@lang('labels.enable')</label>
                    </div>
                    <div class="zinput zradio  zradio-sm   zinput-inline">
                        <input id="status_disable" name="status" type="radio" required class="form-check-input"
                            value="0">
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
            <x-button-group :cancel="routeCheck($route . 'index')" />
        @endslot
    </x-jet-form-section>
</x-app-layout>
