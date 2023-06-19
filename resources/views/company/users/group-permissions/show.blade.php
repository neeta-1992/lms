<x-app-layout :class="['datepicker']">
    <section class="font-1 pt-5 hq-full" x-data="{ open: 'isForm', form: false, title: 'Default Values' }"
        x-effect="async () => {
            switch (open) {
                case 'isForm':
                    title = 'Default Values';
                    form  = true;
                    break;
                case 'user-permissions':
                    title = 'User Permissions';
                    form  = true;
                    break;
                case 'user-reports':
                    title = 'User Reports';
                    form  = true;
                    break;
                case 'logs':
                     form  = false;
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
                            <span id="mainHedingText">{{ $pageTitle }}
                        </x-slot>
                    </x-jet-section-title>
                </div>
                <div class="col-md-12 page_table_menu">
                    <div class="row ">
                        <div class="col-md-4">
                            <div class="columns">
                                <div class="ui selection dropdown table-head-dropdown">
                                    <input type="hidden" x-bind:value=open /><i class="dropdown icon"></i>
                                    <div class="text" x-text="title">Default Values</div>
                                    <div class="menu">
                                        <div class="item" @click="open = 'isForm'" x-show="open !== 'isForm'">Default
                                            Values</div>
                                        <div class="item" @click="open = 'user-permissions'"
                                            x-show="open !== 'user-permissions'"> User Permissions</div>
                                        <div class="item" @click="open = 'user-reports'"
                                            x-show="open !== 'user-reports';title == 'User Reports'">User Reports</div>
                                        <div class="item" @click="open = 'logs';" x-show="open != 'logs'">Logs</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8" x-show="(open != 'offices' && open != 'users' && open != 'logs')">
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


                <div class="col-md-12" x-show="form == true">
                    <form class="validationForm groupPermissions reloadForm titleArrForm " novalidate method="POST"
                        action="{{ routeCheck($route . 'store') }}">
                        @csrf

                        <input type="hidden" name="logsArr">
                        <input type="hidden" name="userType" value="{{ $id ?? '' }}">
                        <div class="col-md-12" x-show="open == 'isForm'">
                            <div class="mb-3">
                                <p class="fw-600">Default values used when creating new users</p>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">@lang('labels.days_allowed_to_modify_due_date')</label>
                                <div class="col-sm-4">
                                    <x-jet-input type="text" name="days_allowed_to_modify_due_date"
                                        class="digitLimit" data-limit="4" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">@lang('labels.days_allowed_to_suspend_accounts')</label>
                                <div class="col-sm-4">
                                    <x-jet-input type="text" name="days_allowed_to_suspend_accounts"
                                        class="digitLimit" data-limit="4" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">@lang('labels.days_to_suspend_account_after_payment')</label>
                                <div class="col-sm-4">
                                    <x-jet-input type="text" name="days_to_suspend_account_after_payment"
                                        class="digitLimit" data-limit="4" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">@lang('labels.quote_activation_review_limit')</label>
                                <div class="col-sm-4">
                                    <x-jet-input type="text" name="quote_activation_review_limit" class="amount" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">@lang('labels.quote_activation_limit')</label>
                                <div class="col-sm-4">
                                    <x-jet-input type="text" name="quote_activation_limit" class="amount" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">@lang('labels.ap_quote_start_installment_threshold_days')</label>
                                <div class="col-sm-4">
                                    <x-jet-input type="text" name="ap_quote_start_installment_threshold_days"
                                        class="digitLimit" data-limit="4" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">@lang('labels.convenience_fee_override')</label>
                                <div class="col-sm-8">
                                    <div class="zinput zradio zradio-sm  zinput-inline">
                                        <input id="convenience_fee_override_enable" name="convenience_fee_override"
                                            type="radio" class="form-check-input" value="allow">
                                        <label for="convenience_fee_override_enable"
                                            class="form-check-label">@lang('labels.allow')</label>
                                    </div>
                                    <div class="zinput zradio  zradio-sm   zinput-inline">
                                        <input id="convenience_fee_override_status_disable"
                                            name="convenience_fee_override" type="radio" class="form-check-input"
                                            value="prohibited">
                                        <label for="convenience_fee_override_status_disable"
                                            class="form-check-label">@lang('labels.prohibited')</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" x-show="open == 'user-permissions'">
                            @if (!empty($permissions))
                                @foreach ($permissions as $key => $value)
                                    <div class="form-group row">
                                        <label for="comp_name"
                                            class="col-sm-4 col-form-label ">{{ $value['text'] ?? '' }}</label>
                                        <div class="col-sm-8">
                                            @if (!empty($value['permissions']))
                                                @foreach ($value['permissions'] as $pkey => $permissions)
                                                    @php
                                                        $block = isset($permissions['block']) ? $permissions['block'] : true;
                                                        $chackValue = !empty($permissions['value']) ? $permissions['value'] : $permissions['name'] ;
                                                        $chackId = !empty($permissions['value']) ? $permissions['value'].'-'.$permissions['name'] : $permissions['name'] ;
                                                    @endphp
                                                    <x-jet-checkbox :isBlock="$block" for="{{ $chackId ?? '' }}"
                                                        labelText="{{ $permissions['text'] }}" 
                                                        name="permission[{{ $value['key'] ?? '' }}][]"
                                                        class="permissionCheckBox {{ isset($permissions['class']) ? $permissions['class'] : '' }}"
                                                        id="{{ $chackId ?? '' }}"
                                                        value="{{ $chackValue }}"  data-key="{{ $value['key'] ?? '' }}"/>
                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                            @endif

                        </div>
                        <div class="col-md-12" x-show="open == 'user-reports'">
                            @if (!empty($reports))
                                @foreach ($reports as $key => $value)
                                    <div class="form-group row">
                                        <label for="comp_name"
                                            class="col-sm-3 col-form-label ">{{ $value['text'] ?? '' }}</label>
                                        <div class="col-sm-9">
                                            @if (!empty($value['permissions']))
                                                @foreach ($value['permissions'] as $pkey => $permissions)
                                                    <x-jet-checkbox :isBlock="true" for="{{ $permissions['name'] }}"
                                                        labelText="{{ $permissions['text'] }}"
                                                        name="report[{{ $value['key'] ?? '' }}][]"
                                                          class="permissionCheckBox"
                                                        id="{{ $permissions['name'] }}"
                                                        value="{{ $permissions['name'] }}" data-key="{{ $value['key'] ?? '' }}" />
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div class="form-group row">
                            <label for="state" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                                <div class="row form-group align-top-radio">

                                    <div class="col-sm-12">
                                        <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                            <input id="yes" class="form-check-input" name="save_option" checked
                                                type="radio" value="save_defaults_only">
                                            <label for="yes" class="form-check-label">Save Defaults Only:
                                                EXISTING USERS
                                                ARE NOT AFFECTED</label>
                                        </div>
                                        <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                            <input id="no" class="form-check-input" name="save_option"
                                                type="radio" value="save_and_reset">
                                            <label for="no" class="form-check-label">Save & Reset Existing User
                                                Permissions: Save the default values and permissions and apply the
                                                default
                                                values and permissions to all existing users belonging to this user ALL
                                                EXISTING
                                                PERMISSIONS AND SPECIFIED VALUES FOR USERS IN THIS USER GROUP WILL BE
                                                REPLACED.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <x-button-group :cancel="routeCheck($route . 'index')" />
                    </form>
                </div>

                <div class="col-md-12" x-show="open == 'logs'">
                    <x-table id="{{ $activePage }}-logs"
                        ajaxUrl="{{ routeCheck('company.logs', ['type' => $activePage, 'id' => $id]) }}">
                        <thead>
                            <tr>
                                <th class="" data-sortable="true" data-field="created_at" data-width="170">Created Date</th>
                                <th class="" data-sortable="true" data-field="username" data-width="200">User Name</th>
                                <th class="" data-sortable="true" data-field="message">Description</th>
                            </tr>
                        </thead>
                    </x-table>
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
