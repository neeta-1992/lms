<x-app-layout :class="['datepicker']">
    @php
        $suspend = $data['suspend'] ?? 0;
        if($suspend == 1){
            $suspendButtonArr =['text' => __('labels.unsuspend'),'class'=> 'suspendStatus','dataId'=>$id];
            $pageTitle  = ['title' => $pageTitle,'badge'=>__('labels.suspended')];
        }else{
            $suspendButtonArr =['text' => __('labels.suspend'),'class'=> 'suspendStatus','dataId'=>$id];
             $pageTitle  = $pageTitle;
        }
    @endphp
    <x-jet-form-section :title="$pageTitle" :buttonGroup="['other' => [ $suspendButtonArr,['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index')]]]" class="validationForm editForm" novalidate
        action="{{ routeCheck($route . 'save-user', $id) }}" method="post" x-data="{ resetPassword: '' }" x-effect="async () => {
            switch (open) {
                case 'isForm':
                    title = '{{$userTypeText}} Information';

                default:
                    break;
            }
        }">
        @slot('menu_drop_dwon')
            <div class="columns">
                <div class="ui selection dropdown table-head-dropdown">
                    <input type="hidden" x-bind:value=open /><i class="dropdown icon"></i>
                    <div class="text" x-text="title">{{$userTypeText}} @lang('labels.information') </div>
                    <div class="menu">
                        <div class="item" @click="open = 'isForm'" x-show="open !== 'isForm'">@lang('labels.user_information')</div>
                        <div class="item" @click="open = 'user-settings'" x-show="open !== 'user-settings'">@lang('labels.settings')
                        </div>
                        <div class="item" @click="open = 'user-permissions'" x-show="open !== 'user-permissions'">@lang('labels.permissions') </div>
                        <div class="item" @click="open = 'user-reports'"
                            x-show="open !== 'user-reports';title == 'User Reports'">@lang('labels.reports') </div>
                        <div class="item" @click="open = 'logs';" x-show="open != 'logs'">@lang('labels.logs')</div>
                    </div>
                </div>
            </div>
        @endslot
        @slot('form')
            @method('put')
            <input type="hidden" name="logsArr">
            <input type="hidden" name="userId" value="{{ $id }}">
            @includeIf($view)
            <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true" />
        @endslot

        @slot('otherTab')
            <form class="validationForm groupPermissions singleForm" novalidate action="{{ routeCheck($route . 'group-permissions') }}" method="post" x-show="(open == 'user-settings' || open == 'user-permissions' || open == 'user-reports')">
                <input type="hidden" name="userId" value="{{ $id }}">
                @csrf

                <input type="hidden" name="logsArr">
                <div x-show="open == 'user-settings'">

                    <div class="mb-3">
                        <p class="fw-600">@lang('labels.default_values_used_when_creating_new_users')</p>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">@lang('labels.days_allowed_to_modify_due_date')</label>
                        <div class="col-sm-4">
                            <x-jet-input type="text" name="days_allowed_to_modify_due_date" class="digitLimit" value="{{ $userPermission['days_allowed_to_modify_due_date'] ?? '' }}"
                                data-limit="4" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">@lang('labels.days_allowed_to_suspend_accounts')</label>
                        <div class="col-sm-4">
                            <x-jet-input type="text" name="days_allowed_to_suspend_accounts" class="digitLimit"  value="{{ $userPermission['days_allowed_to_suspend_accounts'] ?? '' }}"
                                data-limit="4" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">@lang('labels.days_to_suspend_account_after_payment')</label>
                        <div class="col-sm-4">
                            <x-jet-input type="text" name="days_to_suspend_account_after_payment" class="digitLimit"  value="{{ $userPermission['days_to_suspend_account_after_payment'] ?? '' }}"
                                data-limit="4" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">@lang('labels.quote_activation_review_limit')</label>
                        <div class="col-sm-4">
                            <x-jet-input type="text" name="quote_activation_review_limit" class="amount"  value="{{ $userPermission['quote_activation_review_limit'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">@lang('labels.quote_activation_limit')</label>
                        <div class="col-sm-4">
                            <x-jet-input type="text" name="quote_activation_limit" class="amount"  value="{{ $userPermission['quote_activation_limit'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">@lang('labels.ap_quote_start_installment_threshold_days')</label>
                        <div class="col-sm-4">
                            <x-jet-input type="text" name="ap_quote_start_installment_threshold_days" class="digitLimit"
                                data-limit="4"  value="{{ $userPermission['ap_quote_start_installment_threshold_days'] ?? '' }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">@lang('labels.convenience_fee_override')</label>
                        <div class="col-sm-8">
                            <div class="zinput zradio zradio-sm  zinput-inline">
                                <input id="convenience_fee_override_enable" name="convenience_fee_override" type="radio"
                                    class="form-check-input" value="allow" {{ isset($userPermission['convenience_fee_override']) &&  $userPermission['convenience_fee_override'] == 'allow' ? 'checked' : '' }}>
                                <label for="convenience_fee_override_enable"
                                    class="form-check-label">@lang('labels.allow')</label>
                            </div>
                            <div class="zinput zradio  zradio-sm   zinput-inline">
                                <input id="convenience_fee_override_status_disable" name="convenience_fee_override"
                                    type="radio" class="form-check-input" value="prohibited"  {{ isset($userPermission['convenience_fee_override']) &&  $userPermission['convenience_fee_override'] == 'prohibited' ? 'checked' : '' }}>
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
                                <label for="comp_name" class="col-sm-3 col-form-label ">{{ $value['text'] ?? '' }}</label>
                                <div class="col-sm-9">
                                    @if (!empty($value['permissions']))

                                        @foreach ($value['permissions'] as $pkey => $permissions)
                                            @php
                                                $dbuserPermission = isset($userPermission['permission'][$value['key']]) ? $userPermission['permission'][$value['key']] : [];
                                            @endphp
                                            <x-jet-checkbox :isBlock="true" for="{{ $permissions['name'] }}"
                                                labelText="{{ $permissions['text'] }}"
                                                name="permission[{{ $value['key'] ?? '' }}][]" class="permissionCheckBox"
                                                id="{{ $permissions['name'] }}" value="{{ $permissions['name'] }}"
                                                data-key="{{ $value['key'] ?? '' }}" :checked="(in_array($permissions['name'],$dbuserPermission) ? true : false)" />
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
                                            @php
                                                $dbuserreport = isset($userPermission['report'][$value['key']]) ? $userPermission['report'][$value['key']] : [];
                                            @endphp
                                            <x-jet-checkbox :isBlock="true" for="{{ $permissions['name'] }}"
                                                labelText="{{ $permissions['text'] }}"
                                                name="report[{{ $value['key'] ?? '' }}][]" class="permissionCheckBox"
                                                id="{{ $permissions['name'] }}" value="{{ $permissions['name'] }}"
                                                data-key="{{ $value['key'] ?? '' }}" :checked="(in_array($permissions['name'], $dbuserreport) ? true : false)"/>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true" />
            </form>

        @endslot

        @slot('logContent')
            <x-table id="{{ $activePage }}-logs"
                ajaxUrl="{{ routeCheck('company.logs', ['type' => 'null', 'id' => 0, 'duId' => $id]) }}">

                <thead>
                    <tr>
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">@lang('labels.created_date')
                        </th>

                        <th class="" data-sortable="false" data-field="username" data-width="200">@lang('labels.user_name')
                        </th>
                        <th class="" data-sortable="true" data-field="message">@lang('labels.description')</th>
                    </tr>
                </thead>
                </x-bootstrap-table>
            @endslot
    </x-jet-form-section>
    @push('page_script')
        <script>
            let editArr = @json($data ?? []);
            let userPermission = @json($userPermission ?? []);
        </script>
    @endpush
</x-app-layout>
