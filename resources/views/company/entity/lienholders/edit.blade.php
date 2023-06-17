<x-app-layout :class="['datepicker']">
    <section class="font-1 pt-5 hq-full" x-data="{ open: 'general-information',attachmentsEditUrl:null, title: 'General Information', contactsEditUrl: '', backPage: '', domiciliary: '{{ $data['mailing_address_radio'] ?? '' }}' }"
        x-effect="async () => {
            $('.contactsForm,.noticePage').html(null);
            switch (open) {
                case 'general-information':
                    title = 'General Information';
                    break;
                case 'contacts':
                    title = 'Contacts'
                    $('#{{ $activePage ?? '' }}-contacts').bootstrapTable('refresh')
                    break;
                case 'attachments':
                    title = 'Attachments'
                    break;
                case 'accounts':
                    title = 'Accounts'
                    break;
                case 'logs':
                    $('#{{ $activePage ?? '' }}-logs').bootstrapTable('refresh')
                    break;
                case 'notices':
                    title = 'Notice'
                    let noticeSave = '{{ routeCheck($route.'notice.save',$id) }}';
                    let noticeResult = await doAjax(noticeSave, method='get');
                    $('.noticePage').html(noticeResult);
                    $('.ui.dropdown').dropdown();
                    break;
                case 'contactsForm':
                    title = 'Contacts';
                    let  contactUrl  =   contactsEditUrl ?? '{{ routeCheck($route.'contact.create',$id) }}';
                    let result = await doAjax(contactUrl, method='get');
                    $('.contactsForm').html(result);
                    $('.ui.dropdown').dropdown();
                    let contactsEditmonth =  $('.contactsForm .monthsNumber select').val()
                    daysList('.contactsForm .daysList',contactsEditmonth);
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
                                        <div class="item" @click="open = 'general-information'" x-show="open != 'general-information'">General Information</div>
                                        <div class="item" @click="open = 'contacts'" x-show="open != 'contacts'">Contacts</div>
                                         <div class="item" @click="open = 'notices'" x-show="open != 'notices'">Notices</div>
                                        <div class="item" @click="open = 'attachments'" x-show="open != 'attachments'"> Attachments</div>
                                        <div class="item" @click="open = 'accounts'" x-show="open != 'accounts'">Accounts</div>
                                        <div class="item" @click="open = 'logs'" x-show="open != 'logs'">Logs</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      <div class="col-md-8" x-show="(open != 'contacts' && open != 'logs')">
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
                            <label for="name" class="col-sm-3 col-form-label ">@lang('labels.lienholder') ID#</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" disabled value="{{ $data['username'] ?? '' }}" />
                            </div>
                        </div>
                       <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.name')</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="fw-600" name="name" required />

                </div>
            </div>

            <div class="form-group row">
                <label for="legal_name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.tax_id")</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="tax_id" class="taxId w-25" required/>

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
                                'required' => true,'placeholder'=> 'Select State'
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="zip" class="zip_mask" required  placeholder="Zip"  />

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
                                'class' => 'ui dropdown input-sm w-100', 'placeholder'=> 'Select State'
                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="mailing_zip" class="zip_mask" placeholder="Zip"  />

                        </div>
                    </div>
                </div>
            </div>
                  <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true"/>
                    </form>
                </div>



                <div class="col-md-12" x-show="open == 'attachments'">
                    @include($viwePath.'pages.attachments.index')
                </div>


                <div class="col-md-12" x-show="open == 'accounts'">
                    @include($viwePath.'pages.accounts.index')
                </div>
                <div class="col-md-12" x-show="open == 'contacts'">
                    @include($viwePath.'pages.contacts.index')
                </div>
                <div class="col-md-12" x-show="open == 'add-contact'">

                </div>
                <div class="col-md-12 noticePage" x-show="open == 'notices'">

                </div>
                <div class="col-md-12 contactsForm" x-show="open == 'contactsForm'">

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
    @push('page_script')
        <script>
            var editArr = @json($data ?? []);
        </script>
    @endpush
</x-app-layout>
