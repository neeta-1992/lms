<x-app-layout :class="['datepicker']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post">
        @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">@lang('labels.lienholder_general_information')</label>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.name')</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="name" id="name" required placeholder="">
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.tax_id')</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm w-25" name="name" id="name" required
                        placeholder="">
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
                                'required' => true,
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="zip" class="zip_mask" required />

                        </div>
                    </div>
                </div>
            </div>

            <div class="row mailing_address_box">
                <label for="mailing_address" class="col-sm-3 col-form-label ">@lang('labels.mailing_address_please_leave_mailing_address_blank_if_the_same_as_physical_address') </label>
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        input-sm w-100',
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="mailing_zip" class="zip_mask" />

                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <h6 class="fw-600">@lang('labels.lienholder_contacts')</h6>
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
                        <x-jet-input type="text" name="owner[middle_name][]" id="middle_name_1" class="middle_name" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="last_name_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.last_name')</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" required name="owner[last_name][]" id="last_name_1" class="last_name" />
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
                                <x-jet-input type="tel" required name="owner[extenstion][]" placeholder="Extenstion"
                                    id="owner_extenstion_1" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label ">@lang('labels.fax')</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control input-sm telephone " name="primary_telephone"
                            id="primary_telephone" placeholder="" required>
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
