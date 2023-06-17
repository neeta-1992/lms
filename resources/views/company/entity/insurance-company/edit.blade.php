<x-app-layout :class="['datepicker']">
    <section class="font-1 pt-5 hq-full" x-data="{ open: 'general-information',attachmentsEditUrl:null, title: 'General Information', contactsEditUrl: '', backPage: '', domiciliary: '{{ $data['mailing_address_radio'] ?? '' }}' }"
        x-effect="async () => {
             $('.otherSettings,.officeForm,.userForm,.noticePage,.fundingPage,.attachmentForm').html('')
            switch (open) {
                case 'general-information':
                    title = 'General Information';
                    break;
                case 'funding-settings':
                    title = 'Funding Settings';
                    let FundingUrl = '{{ routeCheck($route . 'funding', $id) }}';
                    let FundingResult = await doAjax(FundingUrl, method='get');
                    $('.fundingPage').html(FundingResult);
                    $('.ui.dropdown').dropdown();
                    $(`select[name='remittance_paid']`).trigger('change');
                    break;
                case 'notice-settings':
                    title = 'Notice Settings';
                    let noticeSave = '{{ routeCheck($route . 'notice.save', $id) }}';
                    let noticeResult = await doAjax(noticeSave, method='get');
                    $('.noticePage').html(noticeResult);
                    $('.ui.dropdown').dropdown();
                    break;
                case 'contacts':
                    title = 'Contacts'
                    $('#{{ $activePage ?? '' }}-contacts').bootstrapTable('refresh')
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
                case 'logs':
                    $('#{{ $activePage ?? '' }}-logs').bootstrapTable('refresh')
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
                            <span id="mainHedingText">{{ $data['name'] ?? '' }} {{-- - </span><span x-text="title"></span> --}}
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
                                        <div class="item" @click="open = 'attachments'"
                                            x-show="open != 'attachments'"> Attachments</div>
                                        <div class="item" @click="open = 'quotes'" x-show="open != 'quotes'">Quotes
                                        </div>
                                        <div class="item" @click="open = 'accounts'" x-show="open != 'accounts'">
                                            Accounts</div>
                                        <div class="item" @click="open = 'logs';" x-show="open != 'logs'">Logs</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8" x-show="(open !== 'logs' && open !== 'attachments' && open !== 'quotes')">
                            <div class="row align-items-end">
                                <div class="col-md-12">
                                    <div class="columns d-flex justify-content-end">
                                        {{--    <button class="btn btn-default borderless" type="button" @click="open = 'logs'">
                                            @lang('labels.logs')</button> --}}
                                        <button class="btn btn-default" type="button">
                                            <a href="{{ routeCheck($route . 'index') }}">@lang('labels.cancel')</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12" x-show="open == 'general-information'">

                    <form class="validationForm editForm" novalidate method="POST" action="{{ routeCheck($route . 'update', $id) }}">
                        @csrf
                        @method('put')
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label ">@lang('labels.insurance_company') ID#</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="username" disabled />
                            </div>
                        </div>
                        <input type="hidden" name="logsArr">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">Name</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="name" required />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tax_id" class="col-sm-3 col-form-label ingnorTitleCase">FEIN #</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="taxId" name="tax_id" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telephone" class="col-sm-3 col-form-label requiredAsterisk">
                                Telephone</label>
                            <div class="col-sm-9">
                                <x-jet-input type="tel" class="telephone" name="telephone" required
                                    placeholder="(000) 000-000" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="fax" class="col-sm-3 col-form-label ">
                                Fax</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="fax" name="fax" />
                            </div>
                        </div>
                        <div class="row">
                            <label for="address" class="col-sm-3 col-form-label requiredAsterisk">Mailing
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
                                            'class' => 'ui dropdown input-sm w-100',
                                            'required' => true,
                                            'id' => 'primary_address_state','placeholder'=>'Select State'
                                        ]) !!}


                                    </div>
                                    <div class="col-md-2">
                                        <x-jet-input type="text" class="zip_mask" name="zip" required placeholder="Zip"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<div class="form-group row align-items-center">
                            <label for="mailing_address_yes"
                                class="col-sm-3 col-form-label requiredAsterisk">Additional
                                Address
                                Information?</label>
                            <div class="col-sm-9">
                                <div class="zinput zradio zradio-sm  zinput-inline  p-0">
                                    <input id="mailing_address_yes" @change="domiciliary = 'yes'"
                                        name="mailing_address_radio" type="radio" required class="form-check-input"
                                        value="yes">
                                    <label for="mailing_address_yes" class="form-check-label">Yes</label>
                                </div>
                                <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                    <input id="mailing_address_no" @change="domiciliary = 'no'"
                                        name="mailing_address_radio" type="radio" required class="form-check-input"
                                        value="no">
                                    <label for="mailing_address_no" class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>-->
                        <div class="row">
                            <label for="mailing_address" class="col-sm-3 col-form-label ">Domiciliary
                                Address</label>
                            <div class="col-sm-9 ">
                                <div class="form-group row">
                                    <div class="col-md-12 mb-1">
                                        <div class="form-group">
                                            <x-jet-input type="text" name="mailing_address" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <x-jet-input type="text" name="mailing_city" placeholder="City"  />
                                    </div>
                                    <div class="col-md-4">
                                        {!! form_dropdown('mailing_state', stateDropDown(), '', [
                                            'class' => 'ui dropdown input-sm w-100',
                                            'id' => 'mailing_state','placeholder'=>'Select State'
                                        ]) !!}


                                    </div>
                                    <div class="col-md-2">
                                        <x-jet-input type="text" class="zip_mask" name="mailing_zip" placeholder="Zip"  />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="current_aggregate_outstandings" class="col-sm-3 col-form-label">Current
                                Aggregate Outstandings</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" disabled class="amount"
                                    name="current_aggregate_outstandings" placeholder="$" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="limit_of_aggregate_outstandings" class="col-sm-3 col-form-label">Limit
                                Of
                                Aggregate Outstandings</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="amount" name="aggregate_limit"
                                    placeholder="$" />
                            </div>
                        </div>



                        {{-- <div class="form-group row">
                    <label for="website" class="col-sm-3 col-form-label ">Website</label>
                    <div class="col-sm-9">
                        <x-jet-input type="url" class="w-50" name="website" placeholder="http://www.domain.com" />

                    </div>
                </div> --}}


                        {{-- <div class="mb-3">
                    <p class="fw-600">A.M. Best</p>
                </div> --}}

                        <div class="form-group row">
                            <label for="AM_best_rating" class="col-sm-3 col-form-label ">@lang('labels.a_m_best_rating')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="" name="json[rating]" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="NAIC_number" class="col-sm-3 col-form-label ">@lang('labels.naic_number')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="" name="json[naic_number]" />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="AM_best_financial_size"
                                class="col-sm-3 col-form-label ">@lang('labels.a_m_best_financial_size')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="" name="json[financial_size]" />
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="AM_best_rating_date"
                                class="col-sm-3 col-form-label ">@lang('labels.a_m_best_rating_date')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="singleDatePicker" name="json[rating_date]" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="AM_best_number" class="col-sm-3 col-form-label ">@lang('labels.a_m_best_number')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="am_best_number" name="json[number]" />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="AM_best_group_number"
                                class="col-sm-3 col-form-label ">@lang('labels.a_m_best_group_number')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="" name="json[group_number]" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="AM_best_group_name" class="col-sm-3 col-form-label ">@lang('labels.a_m_best_group_name')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="" name="json[group_name]" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="aggregation_code" class="col-sm-3 col-form-label ">@lang('labels.aggregation_code')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" class="" name="json[aggregation_code]" />

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="AM_best_url" class="col-sm-3 col-form-label ">@lang('labels.a_m_best_url')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="url" name="json[url]" class="am_best_url"
                                    readonly="readonly" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="notes" class="col-sm-3 col-form-label">@lang('labels.notes')</label>
                            <div class="col-sm-9">
                                <textarea name="notes" id="notes" cols="30" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true" />
                    </form>
                </div>



                <div class="col-md-12" x-show="open == 'quotes'">
                    @include($viwePath . 'pages.quotes.index')
                </div>


                <div class="col-md-12" x-show="open == 'attachments'">
                    @include($viwePath . 'pages.attachments.index')
                </div>


                <div class="col-md-12" x-show="open == 'accounts'">
                    @include($viwePath . 'pages.accounts.index')
                </div>


                <div class="col-md-12 noticePage" x-show="open == 'notice-settings'">

                </div>


                <div class="col-md-12" x-show="open == 'add-contact'">
                    @include($viwePath . 'pages.contacts.create')
                </div>

                <div class="col-md-12 fundingPage" x-show="open == 'funding-settings'">


                </div>


                <div class="col-md-12 contactsEdit" x-show="open == 'contactsEdit'">

                </div>
                   <div class="col-md-12 attachmentForm" x-show="open == 'attachmentsForm'">

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

                                <th class="" data-sortable="true" data-field="username" data-width="200">User
                                    Name
                                </th>
                                <th class="" data-sortable="true" data-field="message">Description</th>
                            </tr>
                        </thead>
                    </x-bootstrap-table>

                </div>
            </div>
        </div>
    </section>
    @php
        $data = $data?->makeHidden(['id']) ?? [];
    @endphp
    @push('page_script')
        <script>
            const AB_BEST_WEBSITE_URL = "{{ env('AB_BEST_WEBSITE_URL') ?? '' }}";
            var editArr = @json($data);
        </script>
    @endpush
</x-app-layout>
