<x-app-layout>
    <section class="font-1 pt-5 hq-full" x-data="{ open: 'default-values', title: 'Default Values', contactsEditUrl: '', backPage: '' }" x-effect="async () => {
            switch (open) {
                case 'default-values':

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
                            {{ $pageTitle ?? '' }}
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
                                        <div class="item" @click="open = 'default-values'" x-show="open !== 'default-values'">Default Values</div>
                                        <div class="item" @click="open = 'user-permissions'" x-show="open !== 'user-permissions'">User Permissions</div>
                                        <div class="item" @click="open = 'user-reports'" x-show="open !== 'user-reports'">User Reports</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
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


                <div class="col-md-12" x-show="open == 'default-values'">
                    <form class="validationForm editForm" novalidate method="POST">
                        @csrf
                        <input type="hidden" name="logsArr">
                        <div class="mb-3">
                            <p class="fw-600">Default values used when creating new users</p>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">@lang('labels.days_allowed_to_modify_due_date')</label>
                            <div class="col-sm-4">
                                <x-jet-input type="text" name="days_allowed_to_modify_due_date" class="digitLimit" data-limit="4" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">@lang('labels.days_allowed_to_suspend_accounts')</label>
                            <div class="col-sm-4">
                                <x-jet-input type="text" name="days_allowed_to_suspend_accounts" class="digitLimit" data-limit="4" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">@lang('labels.days_to_suspend_account_after_payment')</label>
                            <div class="col-sm-4">
                                <x-jet-input type="text" name="days_to_suspend_account_after_payment" class="digitLimit" data-limit="4" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">@lang('labels.quote_activation_review_limit')</label>
                            <div class="col-sm-4">
                                <x-jet-input type="text" name="quote_activation_review_limit" class="digitLimit" data-limit="4" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">@lang('labels.quote_activation_limit')</label>
                            <div class="col-sm-4">
                                <x-jet-input type="text" name="quote_activation_limit" class="digitLimit" data-limit="4" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">@lang('labels.ap_quote_start_installment_threshold_days')</label>
                            <div class="col-sm-4">
                                <x-jet-input type="text" name="ap_quote_start_installment_threshold_days" class="digitLimit" data-limit="4" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">@lang('labels.convenience_fee_override')</label>
                            <div class="col-sm-8">
                                <div class="zinput zradio zradio-sm  zinput-inline">
                                    <input id="convenience_fee_override_enable" name="convenience_fee_override" type="radio" class="form-check-input" value="1">
                                    <label for="convenience_fee_override_enable" class="form-check-label">@lang('labels.allow')</label>
                                </div>
                                <div class="zinput zradio  zradio-sm   zinput-inline">
                                    <input id="convenience_fee_override_status_disable" name="convenience_fee_override" type="radio" class="form-check-input" value="0">
                                    <label for="convenience_fee_override_status_disable" class="form-check-label">@lang('labels.prohibited')</label>
                                </div>
                            </div>
                        </div>
                        <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true" />
                    </form>
                </div>


                <div class="col-md-12" x-show="open == 'user-permissions'">
                    @if(!empty($permissions))
                        @foreach($permissions as $key => $value)
                            <div class="form-group row">
                                <label for="comp_name" class="col-sm-4 col-form-label ">{{ $value['text'] ?? '' }}</label>
                                 <div class="col-sm-8">
                                    @if(!empty($value['permissions']))
                                          @foreach ($value['permissions'] as $pkey => $permissions)
                                                <x-jet-checkbox :isBlock="true"  for="{{ $permissions['name'] }}" labelText="{{ $permissions['text'] }}" name="{{ $value['key'] ?? '' }}[]" id="{{ $permissions['name'] }}" value="{{ $permissions['name'] }}" />
                                          @endforeach
                                    @endif

                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <div class="col-md-12" x-show="open == 'user-reports'">
                    @if(!empty($reports))
                        @foreach($reports as $key => $value)
                            <div class="form-group row">
                                <label for="comp_name" class="col-sm-4 col-form-label ">{{ $value['text'] ?? '' }}</label>
                                 <div class="col-sm-8">
                                    @if(!empty($value['permissions']))
                                          @foreach ($value['permissions'] as $pkey => $permissions)
                                                <x-jet-checkbox :isBlock="true" for="{{ $permissions['name'] }}" labelText="{{ $permissions['text'] }}" name="{{ $value['key'] ?? '' }}[]" id="{{ $permissions['name'] }}" value="{{ $permissions['name'] }}" />
                                          @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
        </div>
    </section>

</x-app-layout>
