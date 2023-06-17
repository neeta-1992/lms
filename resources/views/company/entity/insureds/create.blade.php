<x-app-layout :class="['codemirror','datepicker']">
    <x-jet-form-section :buttonGroup="['exit'=>['url'=>routeCheck($route . 'index')]]" class="validationForm" novalidate
        action="{{ routeCheck($route . 'store') }}" method="post">
        @slot('form')

        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">
                @lang('labels.agency')</label>
            <div class="col-sm-9">
                {!! form_dropdown('agency',$agency, '', ['class' => 'w-100', 'required' =>
                true]) !!}
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.named_insured')
                <i class="ml-1 large fw-600 color-info fa-regular fa-circle-info tooltipPopup"
                    data-sm-title="Insured Name"
                    data-sm-content="The Insured Name as appeares on the finance agreement. Insured Name may include business entities in addition to individuals"></i></label>
            <div class="col-sm-9">
                <x-jet-input type="text" class="fw-600" name="name" required />
            </div>
        </div>
        <div class="row">
            <label for="primary_address" class="col-sm-3 col-form-label requiredAsterisk">
                @lang('labels.contact_name_first_name_m_i_last_name')</label>
            <div class="col-sm-9">
                <div class="form-group row">

                    <div class="col-md-5">
                        <x-jet-input type="text" required name="first_name" placeholder="First Name" />
                    </div>
                    <div class="col-md-2">
                        <x-jet-input type="text" name="middle_name" placeholder="M/I" />
                    </div>
                    <div class="col-md-5">
                        <x-jet-input type="text" required name="last_name" placeholder="Last Name" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <label for="primary_address" class="col-sm-3 col-form-label"><span class="requiredAsterisk">@lang('labels.telephone')</span> / @lang("labels.fax") / @lang("labels.email")</label>
            <div class="col-sm-9">
                <div class="form-group row">

                    <div class="col-md-4">
                         <x-jet-input type="text" class="telephone" required name="telephone" placeholder="{{ __('labels.telephone') }}" />
                    </div>
                    <div class="col-md-4">
                            <x-jet-input type="text" class="fax"  name="fax" placeholder="{{ __('labels.fax') }}" />
                    </div>
                    <div class="col-md-4">
                           <x-jet-input type="email" class=""  name="email" placeholder="{{ __('labels.email') }}" />
                    </div>
                    <div class="col-md-12">
                        <span style="font-size: .7rem;"> ** If an email address is provided, the
                            system will send courtesy notices to the insured when the payment is
                            late.</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <label for="primary_address"
                class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.physical_risk_address') <i
                    class="ml-1 large fw-600 color-info fa-regular fa-circle-info tooltipPopup"
                    data-sm-title="Physical/Risk Address"
                    data-sm-content="Physical/Risk address describes a location. If you receive postal mail at your home, your residential address is a physical address and a mailing address. However, some people or businesses maintain a physical address separate from a mailing address. While a physical address can be a mailing address, that's not always the case."></i></label>
            <div class="col-sm-9">
                <div class="form-group row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <x-jet-input type="text"  required name="address"  />
                        </div>
                    </div>
                    <div class="col-md-4">
                           <x-jet-input type="text"  required name="city"  placeholder="City"/>
                    </div>
                    <div class="col-md-4">
                        {!! form_dropdown('state', stateDropDown(), '', [
                        'class' => "ui dropdown input-sm
                        w-100",
                        'required' => true,  'placeholder' => 'Select State',
                        ]) !!}
                    </div>
                    <div class="col-md-4">
                         <x-jet-input type="text"  required name="zip" class="zip_mask" placeholder="Zip" />

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
                                'class' => 'ui dropdown
                                 input-sm w-100',
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="mailing_zip" class="zip_mask"  placeholder="Zip"/>
                        </div>
                    </div>
                </div>
            </div>
        <div class="form-group row">
            <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
            <div class="col-sm-9">
                <textarea name="notes" id="notes" cols="30" class="form-control"
                    rows="3"></textarea>
            </div>
        </div>
        <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>
</x-app-layout>
