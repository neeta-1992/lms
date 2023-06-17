<x-app-layout :class="['datepicker']">
    <section class="font-1 pt-5 hq-full" x-data="{ open: 'general-information',disablesF:false,editContactsForm : false, title: 'General Information', officeEditUrl: null, backPage: '', contactsEditUrl : null }"
        x-effect="async () => {
            $('.otherSettings,.officeForm,.contactsForm,.noticePage,.fundingPage').html('');

            switch (open) {

                case 'general-information':
                    title = 'General Information'
                    break;
                case 'offices':
                    title = 'Office'
                    $('#{{ $activePage ?? '' }}-offices').bootstrapTable('refresh');
                    break;
                case 'contacts':
                    title = 'Contacts'
                    $('#{{ $activePage ?? '' }}-contacts').bootstrapTable('refresh')
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
                    disablesF = '{{ $data['status'] == 8 ? true : false }}';
                    if(disablesF){
                        disablesForm('.officeForm');
                    }
                    break;
                  case 'contactsForm':
                    title = 'Contacts';
                    editContactsForm = isEmptyChack(contactsEditUrl) ? false : true ;
                    let  contactUrl  =   contactsEditUrl ?? '{{ routeCheck($route . 'contact.create', $id) }}';
                    let result = await doAjax(contactUrl, method='get');
                    $('.contactsForm').html(result);
                    $('.ui.dropdown').dropdown();
                    let contactsEditmonth =  $('.contactsForm .monthsNumber select').val()
                    daysList('.contactsForm .daysList',contactsEditmonth);
                    faxMaskInput();  telephoneMaskInput();
                     disablesF = '{{ $data['status'] == 8 ? true : false }}';
                    if(disablesF){
                        disablesForm('.contactsForm');
                    }
                    break;

                case 'logs':
                    $('#{{ $activePage ?? '' }}-logs').bootstrapTable('refresh')
                    break;
                default:
                    break;
            }

        }"  >

        <div class="container tableButtonInlineShow">
            <div class="row">
                <div class="col-md-12 page_table_heading">
                    <x-jet-section-title>
                        <x-slot name="title">
                            {{ $data['agency'] ?? '' }}
                        </x-slot>
                        <x-slot name="badge">
                           {{ prospectsStatuArr($data['status'] ?? 1)  }}
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
                                            x-show="open != 'general-information'">
                                            General Information</div>
                                        <div class="item" @click="open = 'contacts'" x-show="open != 'contacts'">
                                            Contacts</div>
                                        <div class="item" @click="open = 'offices'" x-show="open != 'offices'">Offices
                                        </div>
                                        <div class="item" @click="open = 'logs';" x-show="open != 'logs'">Logs
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8" x-show="(open != 'contacts' && open != 'offices' && open != 'logs')">
                            <div class="row align-items-end">
                                <div class="col-md-12">
                                    <div class="columns d-flex justify-content-end">
                                        <button class="btn btn-default " type="button">
                                            <a href="{{ routeCheck($route . 'index') }}" data-turbolinks="false">
                                                @lang('labels.cancel')</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12" x-show="open == 'general-information'">
                    <form class="validationForm editForm singleForm {{ $data['status'] == 8 ? 'disablesForm' : '' }}" novalidate method="POST"
                        action="{{ Route::has($route . 'update') ? route($route . 'update', $id) : '' }}">
                        @csrf
                        @method('put')
                        <input type="hidden" name="logsArr">
                        <div class="row form-group">
                            <label for="agencyList"
                                class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.agency')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="agency" required  />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="legal_name"
                                class="col-sm-3 col-form-label ingnorTitleCase">@lang('labels.d_b_a')</label>
                            <div class="col-sm-9">
                                <x-jet-input type="text" name="legal_name"  />

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="legal_name"
                                class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
                            <div class="col-sm-9">
                                <x-select :options="prospectsStatuArr()" name="status" class="ui dropdown prospects_status {{ $data['status'] == 8 ? 'disabled'  : ''}}" required
                                    placeholder="Select Status" data-prospect="{{ $id ?? '' }}"/>
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
                                <x-jet-input type="url" name="website" class="url"
                                    placeholder="http://www.domain.com" />
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
                                            'class' => 'ui dropdown input-sm w-100',
                                            'required' => true,
                                            'placeholder' => 'Select State',
                                        ]) !!}
                                    </div>
                                    <div class="col-md-2">
                                        <x-jet-input type="text" name="zip" class="zip_mask" required
                                            placeholder="Zip" />

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
                        <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true" />
                    </form>
                </div>
                <div class="col-md-12" style="position: relative" x-show="(open == 'contacts')">
                    @include($viwePath . 'contacts.index', [
                        'data' => $data,
                    ])
                </div>
                <div class="col-md-12 contactsForm" x-show="open == 'contactsForm'">

                </div>

                <div class="col-md-12" x-show="open == 'offices'" style="position: relative">
                    @include($viwePath . '.offices.index', [
                        'route' => $route . 'office.',
                        'agencyId' => $id,
                        'activePage' => $activePage,
                        'data' => $data,
                    ])
                </div>
                <div class="col-md-12 officeForm" x-show="open == 'officeForm'"> </div>
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

            $(document).on("change",'.prospects_status select', async function () {
                if($(this).parents('.ui.dropdown').hasClass('disabled')){
                    return false;
                }
                 let id = $(this).data('prospect');
                 let val = $(this).val();
                 if(val == 8){
                     const ajaxResponse = await  doAjax("{{ routeCheck($route.'checkProspectAgencyUsersvalue') }}",'post',{id:id});
                     if(ajaxResponse){
                          textAlertModel(true,ajaxResponse);
                     }
                   }

            });


             $(document).on('change','.office_select_prospects select', async function () {
                    let value = $(this).val();


                    let userId = $(this).parents('form').find('input[name="userId"]').val();
                    let opthtml = "";
                    const URL = BASE_URL + 'common/prospect-office-wish-role';
                    const result = await doAjax(URL, 'post', {
                        office: value,
                        userId: userId
                    });
                    if(result.status == true){
                        const role  = result?.role;
                        $.each(role, function (indexInArray, valueOfElement) {
                            opthtml += `<option value='${indexInArray}'>${valueOfElement}</option>`;
                        });
                    }
                    $('.role_select .text').html(null)
                    $('.role_select select').val(null)
                    $('.role_select select').html(opthtml);
                    let role_selectvalue = $('.role_select select').attr('data-selected');
                    $(".role_select").dropdown("set selected", role_selectvalue);

                });
        </script>
    @endpush
</x-app-layout>
