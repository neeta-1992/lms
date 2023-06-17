<x-app-layout :class="['datepicker']">
    <section class="font-1 pt-5 hq-full" x-data="{ open: 'general-information', title: 'General Information', contactsEditUrl: '', backPage: '' }"
        x-effect="async () => {
            switch (open) {
                case 'general-information':
                    title = 'General Information'
                    break;
                case 'funding-settings':
                    title = 'Funding Settings';
                    let FundingUrl = '{{ routeCheck($route . 'funding',$id) }}';
                    let FundingResult = await doAjax(FundingUrl, method='get');
                    $('.fundingPage').html(FundingResult);
                    $('.ui.dropdown').dropdown();
                    $(`select[name='remittance_paid']`).trigger('change');
                    break;
                case 'notice-settings':
                    title = 'Notice Settings'
                    let noticeSave = '{{ routeCheck($route.'notice.save',$id) }}';
                    let noticeResult = await doAjax(noticeSave, method='get');
                    $('.noticePage').html(noticeResult);
                    $('.ui.dropdown').dropdown();
                    break;
                case 'contacts':
                    title = 'Contacts'
                    $('#general-agents-contacts').bootstrapTable('refresh')
                    break;
                case 'attachments':
                    title = 'Attachments'

                    break;
                case 'quotes':
                    title = 'Quotes'
                    break;
                case 'accounts':

                    title = 'Accounts'

                    break;
                case 'logs':
                   {{--  title = 'Logs'; --}}
                    $('#general-agents-logs').bootstrapTable('refresh')
                    break;
                case 'contactsEdit':
                    title = 'Contacts';
                    let result = await doAjax(contactsEditUrl, method='get');
                    $('.contactsEdit').html(result);
                    $('.ui.dropdown').dropdown();
                    let contactsEditmonth =  $('.contactsEdit .monthsNumber select').val()
                    daysList('.contactsEdit .daysList',contactsEditmonth);
                    faxMaskInput();  telephoneMaskInput();
                    break;
                default:
                    break;
            }

        }">
        <div class="container tableButtonInlineShow">
            <div class="row">
                <div class="col-md-12 page_table_heading">
                    <x-jet-section-title>
                        <x-slot name="title">
                           <span id="mainHedingText">{{ $data['name'] ?? '' }} - </span><span x-text="title"></span>
                        </x-slot>
                    </x-jet-section-title>
                </div>
                <div class="col-md-12 page_table_menu">
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="columns">
                                <div class="ui selection dropdown table-head-dropdown">
                                    <input type="hidden" x-bind:value=open /><i class="dropdown icon"></i>
                                    <div class="text" x-text="title">General Information</div>
                                    <div class="menu">
                                        <div class="item" @click="open = 'general-information'"
                                            x-show="open != 'general-information'">General Information</div>
                                        <div class="item" @click="open = 'funding-settings'"
                                            x-show="open != 'funding-settings'">Funding Settings</div>
                                        <div class="item" @click="open = 'notice-settings'"
                                            x-show="open != 'notice-settings'">Notice Settings</div>
                                        <div class="item" @click="open = 'contacts'" x-show="open != 'contacts'">
                                            Contacts</div>
                                        <div class="item" @click="open = 'attachments'"
                                            x-show="open != 'attachments'"> Attachments</div>
                                        <div class="item" @click="open = 'quotes'" x-show="open != 'quotes'">Quotes
                                        </div>
                                        <div class="item" @click="open = 'accounts'" x-show="open != 'accounts'">
                                            Accounts</div>
                                       {{--  <div class="item" @click="open = 'logs';" x-show="open != 'logs'">Logs</div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8" x-show="(open == 'general-information' || open == 'funding-settings' || open == 'notice-settings')">
                            <div class="row align-items-end">
                                <div class="col-md-12">
                                    <div class="columns d-flex justify-content-end">
                                         <button class="btn btn-default borderless" type="button" @click="open = 'logs'">
                                    @lang('text.logs')</button>
                                        <button class="btn btn-default backUrl" type="button">
                                            @lang('text.cancel')</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12" x-show="open == 'general-information'">
                    <form class="validationForm editForm" novalidate method="POST"
                        action="{{ Route::has($route . 'update') ? route($route . 'update', $id) : '' }}">
                        @csrf
                        @method('put')

                        <input type="hidden" name="logsArr">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">General
                                Agency Name</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="fw-600" name="name" required />

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label ingnorTitleCase">d/b/a</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="legal_name" />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label ">Entity Type</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('entity_type', entityType(), '', ['class' => 'w-100']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label ">TIN #</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="w-25 tin" name="tin" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="license_state" class="col-sm-3 col-form-label ">State Resident</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('license_state', stateDropDown(), '', [ 'class' => "ui dropdown input-sm w-100", ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="license_no" class="col-sm-3 col-form-label ">State Resident License #</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="license_no" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="licence_expiration_date" class="col-sm-3 col-form-label ">License Expiration Date</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="singleDatePicker" name="licence_expiration_date"
                                    placeholder="mm/dd/yyyy" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <x-jet-input type="email" class="email" name="email" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">Telephone</label>
                            <div class="col-sm-9">
                                <x-jet-input type="tel" name="telephone" class="telephone" required />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label ">Fax</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="fax" class="fax" />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label ">Website</label>
                            <div class="col-sm-9">
                                <x-jet-input type="url" name="website" class="url"
                                    placeholder="http://www.domain.com" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label ">Maximum Reinstate
                                Allowed</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="maximum_reinstate_allowed" class="onlyNumber w-25"
                                    data-maxlength="2" />
                            </div>
                        </div>

                        <div class="row">
                            <label for="payment_coupons_address"
                                class="col-sm-3 col-form-label requiredAsterisk">Corporate Office
                                Address</label>
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
                            <label for="mailing_address" class="col-sm-3 col-form-label ">Mailing Address
                            </label>
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
                        <div class="form-group row">
                            <label for="notes" class="col-sm-3 col-form-label "> Notes</label>
                            <div class="col-sm-9">
                                <textarea name="notes" id="notes" class="form-control" cols="30" rows="3"></textarea>
                            </div>
                        </div>

                        <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true"/>
                    </form>
                </div>

                <div class="col-md-12" x-show="open == 'contacts'">
                    @include('company.general-agents.pages.contacts.index')
                </div>
                <div class="col-md-12" x-show="open == 'quotes'">
                    @include('company.general-agents.pages.quotes.index')
                </div>
                <div class="col-md-12" x-show="open == 'attachments'">
                    @include('company.general-agents.pages.attachments.index')
                </div>
                <div class="col-md-12" x-show="open == 'accounts'">
                    @include('company.general-agents.pages.accounts.index')
                </div>
                <div class="col-md-12 noticePage" x-show="open == 'notice-settings'">

                </div>
                <div class="col-md-12" x-show="open == 'add-contact'">
                    @include('company.general-agents.pages.contacts.create')
                </div>
                <div class="col-md-12 fundingPage" x-show="open == 'funding-settings'">
                </div>
                <div class="col-md-12 contactsEdit" x-show="open == 'contactsEdit'">
                </div>
                <div class="col-md-12" x-show="open == 'logs'">
                    <x-bootstrap-table :data="[
                        'table' => 'logs',
                        'cookieid' => true,
                        'sortorder' => 'desc',
                        'sortname' => 'created_at',
                        'type' => 'serversides',
                        'ajaxUrl' => routeCheck('company.logs', ['type' => activePageName(), 'id' => $id]),
                    ]">
                        <thead>
                            <tr>
                                <th class="" data-sortable="true" data-field="created_at" data-width="170">
                                    Created
                                    Date
                                </th>

                                <th class="" data-sortable="true" data-field="username" data-width="200">
                                    User Name
                                </th>
                                <th class="" data-sortable="true" data-field="message">Description</th>
                            </tr>
                        </thead>
                    </x-bootstrap-table>
                </div>
            </div>
        </div>
    </section>
    @push('page_script')
        <script>
            var editArr = @json($data ?? []);
        </script>
    @endpush
</x-app-layout>
