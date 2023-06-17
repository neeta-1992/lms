<x-app-layout :class="['datepicker','codemirror']">
    <section class="font-1 pt-5 hq-full"
        x-data="{ open: 'general-information', title: 'General Information',attachmentsEditUrl:null, officeEditUrl: null, backPage: '',usersEditUrl:null }"
        x-effect="async () => {
            $('.otherSettings,.officeForm,.userForm,.noticePage,.fundingPage,.attachmentForm').html('')
            switch (open) {

                case 'general-information':
                    title = 'General Information'
                    break;
                case 'offices':
                    title = 'Office'
                    $('#{{ $activePage ?? '' }}-offices').bootstrapTable('refresh');
                    break;
                case 'users':
                    title = 'Users'
                    $('#{{ $activePage ?? '' }}-users').bootstrapTable('refresh');
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
                    $('#{{ $activePage ?? '' }}-attachments').bootstrapTable('refresh');
                    break;
                case 'attachmentsForm':
                    let attachmentsUrl =  attachmentsEditUrl ?? '{{ routeCheck('company.attachments.create') }}';
                    let attachmentResult = await doAjax(attachmentsUrl, method='get',{id:'{{ $id }}',type:'{{ $activePage ?? '' }}'});
                    $('.attachmentForm').html(attachmentResult);
                    /* $('.ui.dropdown').dropdown(); */
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
                                    <div class="text" x-text="title">General Information</div>
                                    <div class="menu">
                                        <div class="item" @click="open = 'general-information'"
                                            x-show="open != 'general-information'">General Information</div>
                                        <div class="item" @click="open = 'offices'" x-show="open != 'offices'">Offices
                                        </div>

                                        <div class="item" @click="open = 'users'" x-show="open != 'users'">Users</div>
                                        <div class="item" @click="open = 'compensation-table'" x-show="open != 'compensation-table'">Compensation Table</div>

                                        <div class="item" @click="open = 'funding'" x-show="open != 'funding'">Funding
                                        </div>
                                        <div class="item" @click="open = 'notices'" x-show="open != 'notices'">Notices
                                        </div>
                                         <div class="item" @click="open = 'attachments'"
                                            x-show="open != 'attachments'">Attachments</div>

                                        <div class="item" @click="open = 'quotes'" x-show="open != 'quotes'">Quotes
                                        </div>
                                        <div class="item" @click="open = 'accounts'" x-show="open != 'accounts'">
                                            Accounts</div>

                                        <div class="item" @click="open = 'logs'" x-show="open != 'logs'">Logs</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                          <div class="col-md-8" x-show="(open != 'users' && open != 'logs' && open != 'offices' && open != 'attachments')">
                            <div class="row align-items-end">
                                <div class="col-md-12">
                                    <div class="columns d-flex justify-content-end">
                                        <button class="btn btn-default " type="button">
                                           <a  href="{{ routeCheck($route.'index') }}" data-turbolinks="false"> @lang('labels.cancel')</a></button>
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
                                class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.name')</label>
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
                                class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.entity_type')</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('entity_type', entityType(), '', ['class' => 'w-100','required'=>true]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tin" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.tin')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="w-25 tin" name="tin" required/>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.email')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="email" name="email" class="email " required/>
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
                            <label for="mailing_address" class="col-sm-3 col-form-label ">Mailing Address </label>
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
                            <label for="e_signature" class="col-sm-3 col-form-label ">@lang("labels.e_signature")</label>
                            <div class="col-sm-9">
                                <textarea name="e_signature" id="e_signature" class="form-control templateEditor codemirrorEditorEsignature"  cols="30"
                                    rows="3"></textarea>
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
                <div class="col-md-12 otherSettings" x-show="open == 'other-settings'">

                </div>

                <div class="col-md-12" x-show="open == 'compensation-table'">
                    <form class="validationForm editForm" novalidate method="POST"
                        action="{{ Route::has($route . 'update') ? route($route . 'update', $id) : '' }}">
                        @csrf
                        @method('put')
                        <input type="hidden" name="logsArr">

                        <div class="form-group row">
                            <label for="license_no"
                                class="col-sm-3 col-form-label ">@lang('labels.sales_executive_eompensation_table')</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('compensation_table', compensationTableDropDown(), '', [
                                'class' => "ui dropdown input-sm w-100",
                                ]) !!}
                            </div>
                        </div>
                        <x-button-group :cancel="routeCheck($route . 'index')" />
                    </form>

                </div>
                   <div class="col-md-12 attachmentForm" x-show="open == 'attachmentsForm'">

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
