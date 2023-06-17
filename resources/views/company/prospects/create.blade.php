<x-app-layout :class="['datepicker']">
    <x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}" method="post" enctype="multipart/form-data">
        @slot('form')
        <div class="row form-group">
            <label for="agencyList" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.agency')</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="agency" required />
            </div>
        </div>
        <div class="form-group row">
            <label for="legal_name" class="col-sm-3 col-form-label ingnorTitleCase">@lang('labels.d_b_a')</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="legal_name" />
            </div>
        </div>
        <div class="form-group row">
            <label for="legal_name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
            <div class="col-sm-9">
                <x-select :options="[1=>'Prospect']" name="status" class="ui dropdown" required placeholder="Select Status" />
            </div>
        </div>
        <div class="row form-group">
            <label for="quote_id" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.sales_organization')</label>
            <div class="col-sm-9">
                <x-select class="ui dropdown input-sm" name="sales_organization" placeholder="Select Sales Organization" :options="salesOrganizationType(['default'=>true])" data-selected="{{ $data['sales_organization'] ?? '' }}" />
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label ">@lang('labels.website')</label>
            <div class="col-sm-9">
                <x-jet-input type="url" name="website" class="url" placeholder="http://www.domain.com" />
            </div>
        </div>
        <div class="row">
            <label for="payment_coupons_address" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.physical_address')</label>
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
                        'required' => true,'placeholder'=>'Select State'
                        ]) !!}
                    </div>
                    <div class="col-md-2">
                        <x-jet-input type="text" name="zip" class="zip_mask" required placeholder="Zip" />

                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <label for="notes" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
            <div class="col-sm-9">
                <textarea name="notes" id="notes" cols="30" class="form-control" rows="4"></textarea>
            </div>
        </div>
        <div class="mb-3">
            <h6 class="fw-600"> Contacts</h6>
        </div>
        <div class="cloneBox">
            <div class="row">
                <label for="primary_address" class="col-sm-3 col-form-label requiredAsterisk">
                    @lang('labels.contact_name_first_name_m_i_last_name')</label>
                <div class="col-sm-9">
                    <div class="form-group row">

                        <div class="col-md-5">
                            <x-jet-input type="text" required name="entityContact[first_name][]" id="first_name_1" placeholder="First Name" />
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="entityContact[middle_name][]" id="middle_name_1" placeholder="M/I" />
                        </div>
                        <div class="col-md-5">
                            <x-jet-input type="text" required name="entityContact[last_name][]" id="last_name_1" placeholder="Last Name" />
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
                <label for="contact_email_1" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email')</label>
                <div class="col-sm-9">
                    <x-jet-input type="email" name="entityContact[email][]" id="contact_email_1" required/>
                </div>
            </div>
            <div class="form-group row">
                <label for="contact_telephone_1" class="col-sm-3 col-form-label ">@lang('labels.primary_telephone')</label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-md-6">
                            <x-jet-input type="tel" class="telephone" name="entityContact[telephone][]" id="contact_telephone_1" />
                        </div>
                        <div class="col-md-3">
                            <x-jet-input type="tel" name="entityContact[extenstion][]" placeholder="Extenstion" id="contact_extenstion_1" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="notes" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
                <div class="col-sm-9">
                    <textarea name="entityContact[notes][]" id="notes" cols="30" class="form-control" rows="4"></textarea>
                </div>
            </div>
        </div>

        <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>
</x-app-layout>
