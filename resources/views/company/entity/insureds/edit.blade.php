<x-app-layout :class="['datepicker']">
    <section class="font-1 pt-5 hq-full" x-data="{ open: 'general-information',attachmentsEditUrl:null, title: 'General Information', backPage: '', usersEditUrl: null }"
        x-effect="async () => {
            $('.otherSettings,.officeForm,.userForm,.noticePage,.fundingPage,.attachmentForm').html('')
            switch (open) {
                case 'general-information':
                    title = 'General Information'
                    break;
                case 'users':
                    title = 'Users'
                    $('#{{ $activePage ?? '' }}-users').bootstrapTable('refresh');
                    break;
                case 'userForm':
                    title = 'User'
                    const usersUrl =  usersEditUrl ?? '{{ routeCheck($route . 'users.create', $id) }}';
                    console.log(usersUrl)
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
                    let noticeSave = '{{ routeCheck($route . 'notice.save', $id) }}';
                    let noticeResult = await doAjax(noticeSave, method='get');
                    $('.noticePage').html(noticeResult);
                    $('.ui.dropdown').dropdown();
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
                                    <input  type="hidden" x-bind:value=open /><i class="dropdown icon"></i>
                                    <div class="text" x-text="title">General Information</div>
                                    <div class="menu">
                                        <div class="item" @click="open = 'general-information'"
                                            x-show="open != 'general-information'">General Information</div>

                                        <div class="item" @click="open = 'users'" x-show="open != 'users'">Users</div>
                                        <div class="item" @click="open = 'notices'" x-show="open != 'notices'">Notices
                                        </div>
                                        <div class="item" @click="open = 'attachments'"
                                            x-show="open != 'attachments'">Attachments</div>
                                        <div class="item" @click="open = 'quotes'" x-show="open != 'quotes'">Quotes
                                        </div>
                                        <div class="item" @click="open = 'accounts'" x-show="open != 'accounts'">
                                            Accounts</div>
                                        <div class="item" @click="open = 'logs'" x-show="open != 'logs'">
                                            Logs</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8" x-show="(open != 'users' && open != 'logs'  && open !== 'attachments')">
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
                            <label for="name" class="col-sm-3 col-form-label ">@lang('labels.insured') ID#</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" disabled value="{{ $data['username'] ?? '' }}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">
                                @lang('labels.agency')</label>
                            <div class="col-sm-9">
                                {!! form_dropdown('agency', $agency, '', ['class' => 'w-100', 'required' => true]) !!}
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
                          <div class="form-group row">
                            <label for="tin" class="col-sm-3 col-form-label ">@lang('labels.tin')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="w-25 tin" name="tin" />
                            </div>
                        </div>



                        <div class="row">
                              <label for="primary_address" class="col-sm-3 col-form-label"><span class="requiredAsterisk">@lang('labels.telephone')</span> / @lang("labels.fax") / @lang("labels.email")</label>
                            <div class="col-sm-9">
                                <div class="form-group row">

                                    <div class="col-md-4">
                                        <x-jet-input type="text" class="telephone" required name="telephone"
                                            placeholder="{{ __('labels.telephone') }}" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-jet-input type="text" class="fax"  name="fax"
                                            placeholder="{{ __('labels.fax') }}" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-jet-input type="email" class=""  name="email"
                                            placeholder="{{ __('labels.email') }}" />
                                    </div>
                                    <div class="col-md-12">
                                        <span style="font-size: .7rem;"> ** If an email address is provided, the
                                            system will send courtesy notices to the insured when the payment is
                                            late.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="legal_name"
                                class="col-sm-3 col-form-label ingnorTitleCase">@lang('labels.d_b_a')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="legal_name" />
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
                                            <x-jet-input type="text" required name="address" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <x-jet-input type="text" required name="city" placeholder="City" />
                                    </div>
                                    <div class="col-md-4">
                                        {!! form_dropdown('state', stateDropDown(), '', [
                                            'class' => "ui dropdown input-sm
                                                                w-100",
                                            'required' => true,
                                        ]) !!}
                                    </div>
                                    <div class="col-md-4">
                                        <x-jet-input type="text" required name="zip" class="zip_mask" />

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
                         <div class="form-group row align-items-center">
                        <label for="" class="col-sm-3 col-form-label requiredAsterisk">
                            @lang('labels.decline_reinstatement_text')</label>
                        <div class="col-sm-9">
                            <div class="zinput zradio zradio-sm  zinput-inline">
                                <input id="decline_reinstatement_enable" name="json[decline_reinstatement]" type="radio"
                                    required class="form-check-input" value="yes">
                                <label for="decline_reinstatement_enable" class="form-check-label">@lang("labels.yes")</label>
                            </div>
                            <div class="zinput zradio  zradio-sm   zinput-inline">
                                <input id="decline_reinstatement_disable" name="json[decline_reinstatement]" type="radio"
                                    required class="form-check-input" value="no">
                                <label for="decline_reinstatement_disable" class="form-check-label">@lang("labels.no")</label>
                            </div>
                        </div>
                    </div>

                        <div class="form-group row">
                            <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.years_in_business')</label>
                            <div class="col-sm-9">
                                  <x-jet-input type="text" name="json[years_business]" class="digitLimit w-25" data-limit="2" />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.naics_code')</label>
                            <div class="col-sm-9">
                                  <x-jet-input type="text" name="json[naics_code]" class=" w-25"  />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.duns')</label>
                            <div class="col-sm-9">
                                  <x-jet-input type="text" name="json[duns]" class=" w-25"  />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.dbconfidence_code')</label>
                            <div class="col-sm-9">
                                  <x-jet-input type="text" name="json[dbconfidence_code]" class=" w-25"  />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="copy_right_notice" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
                            <div class="col-sm-9">
                                  <textarea name="notes" id="notes" cols="30" class="form-control" rows="3"></textarea>
                            </div>
                        </div>
                        <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true" />
                    </form>
                </div>
                <div class="col-md-12" x-show="open == 'users'">
                    @includeIf($viwePath . '.users.index', [
                        'route' => $route . 'users.',
                        'agencyId' => $id,
                        'activePage' => $activePage,
                    ])
                </div>
                <div class="col-md-12 userForm" x-show="open == 'userForm'"> </div>

<div class="col-md-12 otherSettings" x-show="open == 'other-settings'">

                </div>

                <div class="col-md-12 attachmentForm" x-show="open == 'attachmentsForm'">

                </div>




                <div class="col-md-12" x-show="open == 'attachments'">
                    @includeIf($viwePath . 'attachments.index')
                </div>
                <div class="col-md-12" x-show="open == 'quotes'">
                    @includeIf($viwePath . 'quotes.index')
                </div>
                <div class="col-md-12" x-show="open == 'accounts'">
                    @includeIf($viwePath . 'accounts.index')
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
        </script>
    @endpush
</x-app-layout>
