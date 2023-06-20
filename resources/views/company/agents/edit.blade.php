<x-app-layout :class="['datepicker']">
    <section class="font-1 pt-5 hq-full"
        x-data="{ open: 'general-information', title: 'General Information', officeEditUrl: null, backPage: '',usersEditUrl:null }"
        x-effect="async () => {
            $('.otherSettings,.officeForm,.userForm,.noticePage,.fundingPage').html('')
            switch (open) {

                case 'general-information':
                    title = 'General Information'
                    break;
                case 'offices':
                    title = 'Office'
                    $('#agents-offices').bootstrapTable('refresh');
                    break;
                case 'users':
                    title = 'Users'
                    $('#agents-users').bootstrapTable('refresh');
                    break;
                case 'other-settings':
                    title = 'Other Setting';
                    const otherSettingsUrl =  '{{ routeCheck($route . 'other-settings', $id) }}';
                    let otherSettingsResult = await doAjax(otherSettingsUrl, method='get');
                    $('.otherSettings').html(otherSettingsResult);
                    $('.ui.dropdown').dropdown();
                    telephoneMaskInput();
                    faxMaskInput();
                    zipMask();
                    digitLimit();
                    amount();
                    break;
                case 'officeForm':
                    title = 'Office'
                    const officeFormUrl =  officeEditUrl ?? '{{ routeCheck($route . 'office.create', $id) }}';
                    let officeFormResult = await doAjax(officeFormUrl, method='get');
                    $('.officeForm').html(officeFormResult);
                    $('.ui.dropdown').dropdown();
                    telephoneMaskInput();
                    faxMaskInput();
                    zipMask();
                    break;
                case 'userForm':
                    title = 'User'
                    const usersUrl =  usersEditUrl ?? '{{ routeCheck($route . 'users.create', $id) }}';
                    let usersUrlResult = await doAjax(usersUrl, method='get');
                    $('.userForm').html(usersUrlResult);
                    $('.ui.dropdown').dropdown();
                    telephoneMaskInput();
                    faxMaskInput();
                    zipMask();
                    daysList();
                    singleDatePicker();
                    percentageInput();
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
                 case 'notices':
                    title = 'Notice'
                    let noticeSave = '{{ routeCheck($route.'notice.save',$id) }}';
                    let noticeResult = await doAjax(noticeSave, method='get');
                    $('.noticePage').html(noticeResult);
                    $('.ui.dropdown').dropdown();
                    break;
                case 'funding':
                    title = 'Funding';
                    let FundingUrl = '{{ routeCheck($route . 'funding',$id) }}';
                    let FundingResult = await doAjax(FundingUrl, method='get');
                    $('.fundingPage').html(FundingResult);
                    $('.ui.dropdown').dropdown();
                    $('.show_select_box select').trigger('change');
                    break;
                case 'logs':
                    $('#{{ $activePage ?? '' }}-logs').bootstrapTable('refresh')
                    break;
                default:
                    break;
            }

        }">
        <div class="container tableButtonInlineShow">
            <div class="row">
                <div class="col-md-12 page_table_heading">
                    <x-jet-section-title>
                        <x-slot name="title" >
                            <span id="mainHedingText" >{{ $data['name'] ?? '' }} - </span><span x-text="title"></span>
                        </x-slot>
                    </x-jet-section-title>
                </div>
                <div class="col-md-12 page_table_menu">
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="columns">
                                <div class="ui selection dropdown table-head-dropdown">
                                    <input type="hidden" x-bind:value=open /><i class="dropdown icon"></i>
                                    <div class="text" x-text="title">@lang('labels.general_information')</div>
                                    <div class="menu">
                                        <div class="item" @click="open = 'general-information'"
                                            x-show="open != 'general-information'">@lang('labels.general_information')</div>
                                        <div class="item" @click="open = 'offices'" x-show="open != 'offices'">@lang('labels.offices')
                                        </div>

                                        <div class="item" @click="open = 'users'" x-show="open != 'users'">@lang('labels.users')</div>
                                        <div class="item" @click="open = 'rate-table'" x-show="open != 'rate-table'">
                                           @lang('labels.rate_tables_compensation')</div>

                                        <div class="item" @click="open = 'funding'" x-show="open != 'funding'">@lang('labels.funding')
                                        </div>
                                        <div class="item" @click="open = 'notices'" x-show="open != 'notices'">@lang('labels.notices')
                                        </div>
                                        <div class="item" @click="open = 'other-settings'"
                                            x-show="open != 'other-settings'">@lang('labels.other_settings')</div>
                                        <div class="item" @click="open = 'attachments'" x-show="open != 'attachments'">
                                            @lang('labels.attachments')</div>
                                        <div class="item" @click="open = 'quotes'" x-show="open != 'quotes'">@lang('labels.quotes')
                                        </div>
                                        <div class="item" @click="open = 'accounts'" x-show="open != 'accounts'">
                                            @lang('labels.accounts')</div>


                                        {{-- <div class="item" @click="open = 'logs';" x-show="open != 'logs'">Logs
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8"
                            x-show="(open == 'general-information' || open == 'funding-settings' || open == 'notice-settings')">
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
                            <label for="name" class="col-sm-3 col-form-label ">@lang('labels.agency_id')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" disabled value="{{ $data['username'] ?? '' }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name"
                                class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.agency_name')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="fw-600" name="name" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="legal_name"
                                class="col-sm-3 col-form-label ingnorTitleCase">@lang('labels.d_b_a')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="legal_name" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="entity_type"
                                class="col-sm-3 col-form-label ">@lang('labels.entity_type')</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('entity_type', entityType(), '', ['class' => 'w-100']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tin" class="col-sm-3 col-form-label ">@lang('labels.tin')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="w-25 tin" name="tin" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="personal_maximum_finance_amount"
                                class="col-sm-3 col-form-label ">@lang('labels.personal_maximum_finance_amount')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="amount" name="personal_maximum_finance_amount"
                                    placeholder="$" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="commercial_maximum_finance_amount"
                                class="col-sm-3 col-form-label ">@lang('labels.commercial_maximum_finance_amount')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="amount" name="commercial_maximum_finance_amount"
                                    placeholder="$" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="resident_license_state"
                                class="col-sm-3 col-form-label ">@lang('labels.state_resident')</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('license_state', stateDropDown(['keyType'=>'id']), ($data['profile']['state_resident'] ?? 0), [
                                  'class' => "ui dropdown input-sm w-100",
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="license_no"
                                class="col-sm-3 col-form-label ">@lang('labels.state_resident_license')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="license_no"  value="{{ ($data['profile']['license_no'] ?? 0) }}"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="licence_expiration_date"
                                class="col-sm-3 col-form-label ">@lang('labels.license_expiration_date')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="licence_expiration_date" class="singleDatePicker"
                                    placeholder="mm/dd/yyyy" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label ">@lang('labels.email')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="email" name="email" class="email " />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telephone"
                                class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.telephone')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="tel" name="telephone" class="telephone" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fax" class="col-sm-3 col-form-label ">@lang('labels.fax')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="fax" class="fax " />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label ">@lang('labels.website')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="url" name="website" class="url"
                                    placeholder="http://www.domain.com" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="maximum_reinstate_allowed"
                                class="col-sm-3 col-form-label ">@lang('labels.maximum_reinstate_allowed')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="w-25 " name="maximum_reinstate_allowed" />
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
                                        <x-jet-input type="text" name="mailing_zip" class="zip_mask" />

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="notes" class="col-sm-3 col-form-label">@lang('labels.upload_agency_ec_insurance')</label>
                            <div class="col-sm-6">
                                <x-input-file label="{{ __('labels.upload_copy_ec_insurance_coi') }}" name="upload_agency_ec_insurance" data-file="agent" accept=".docs,.pdf"/>
                            </div>
                            @if(!empty($data['upload_agency_ec_insurance_url']))
                            <div class="col-md-3 text-left" >
                                <a href="javascript:void(0)" onClick="fileIframeModel('{{ $data['upload_agency_ec_insurance_url'] }}')">View File</a>
                            </div>
                            @endif
                        </div>
                        <div class="form-group row">
                            <label for="notes" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
                            <div class="col-sm-9">
                                <textarea name="notes" id="notes" cols="30" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <x-slot name="saveOrCancel"></x-slot>
                        <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true" />
                    </form>
                </div>
                <div class="col-md-12" x-show="open == 'users'">
                    @include($viwePath . '.users.index', [
                    'route' => $route . 'users.',
                    'agencyId' => $id,
                    'activePage' => $activePage,
                    ])
                </div>
                <div class="col-md-12 userForm" x-show="open == 'userForm'"> </div>
                <div class="col-md-12" x-show="open == 'offices'">
                    @include($viwePath . '.offices.index', [
                    'route' => $route . 'office.',
                    'agencyId' => $id,
                    'activePage' => $activePage,
                    ])
                </div>
                <div class="col-md-12 officeForm" x-show="open == 'officeForm'"> </div>
                <div class="col-md-12 otherSettings" x-show="open == 'other-settings'">

                </div>

                <div class="col-md-12" x-show="open == 'rate-table'">
                    <form class="validationForm editForm" novalidate method="POST"
                        action="{{ Route::has($route . 'update') ? route($route . 'update', $id) : '' }}">
                        @csrf
                        @method('put')
                        <input type="hidden" name="logsArr">
                        <div class="form-group row">
                            <label for="rate_table" class="col-sm-3 col-form-label ">@lang('labels.rate_table')</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('rate_table[]', rateTableDropDown(), '', [
                                'class' => "w-100",'multiple'=>'multiple'
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="license_no"
                                class="col-sm-3 col-form-label ">@lang('labels.agent_compensation_table')</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('compensation_table', compensationTableDropDown(), '', [
                                'class' => "ui dropdown input-sm w-100",
                                ]) !!}
                            </div>
                        </div>
                        <x-button-group :cancel="routeCheck($route . 'index')" />
                    </form>

                </div>
                <div class="col-md-12" x-show="open == 'attachments'">
                    @include($viwePath . 'attachments.index')
                </div>
                <div class="col-md-12" x-show="open == 'quotes'">
                    @include($viwePath . 'quotes.index')
                </div>
                <div class="col-md-12" x-show="open == 'accounts'">
                    @include($viwePath . 'accounts.index')
                </div>
                <div class="col-md-12 noticePage" x-show="open == 'notices'"></div>
                <div class="col-md-12 fundingPage" x-show="open == 'funding'"></div>
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
                                   @lang('labels.created_date')

                                </th>

                                <th class="" data-sortable="true" data-field="username" data-width="200">
                                    @lang('labels.user_name')
                                </th>
                                <th class="" data-sortable="true" data-field="message">@lang('labels.description')</th>
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

        $(document).on('change','.office_select select', async function () {
            let value = $(this).val();
            let opthtml = "";
            const URL = '{{ routeCheck($route."officeWishRole") }}';
            const result  = await doAjax(URL,'post',{office:value});
            if(result.status == true){
                const role  = result?.role;
                $.each(role, function (indexInArray, valueOfElement) {
                    opthtml += `<option value='${indexInArray}'>${valueOfElement}</option>`;
                });
            }
            $('.role_select select').html(opthtml)
        });
    </script>
    @endpush
</x-app-layout>
