<x-app-layout :class="['dateDropdown', 'datepicker', 'inMail', 'quill', 'emoji']">
    <section class="font-1 pt-5 hq-full" x-data="accountDetails" x-effect="accountDetailsEffect">
        <div class="container tableButtonInlineShow">
            <div class="row">
                <div class="col-md-12 page_table_heading">
                    <x-jet-section-title>
                        <x-slot name="title">
                            {{ __('labels.account') }} {{ '#' }} {{ $data?->account_number ?? '' }}
                            {{ !empty($data?->insur_data->name) ? ' - ' . ucfirst($data?->insur_data->name) : '' }}
                        </x-slot>
                    </x-jet-section-title>
                </div>
                <div class="col-md-12 ">
                    @if (!empty($todayAlert?->toArray()))
                        @foreach ($todayAlert as $key => $value)
                            <div class="alert alert-info alertMessage lodeHtmlData" role="alert"
                                x-show="!getCookie('{{ $value->id ?? '' }}')">
                                <button class="close" type="button" data-dismiss="alert" aria-label="Close"
                                    x-on:click="setCookie('{{ $value->id ?? '' }}',true,1)">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>{!! $value->alert_subject ?? '' !!}</strong>
                                {!! $value->alert_text ?? '' !!}
                            </div>
                        @endforeach
                    @endif
                </div>

                <div class="col-md-12 page_table_menu">
                    <div class="row ">
                        <div class="col-md-4">
                            {{-- Menu Dropdown --}}
                            <div class="columns">

                                <div class="ui selection dropdown table-head-dropdown maindropdown accountmaindropdown"
                                    style="">
                                    <input type="hidden" x-bind:value=open /><i class="dropdown icon"></i>
                                    <div class="text" x-text='title ?? "{{ __('labels.account_information') }}"'>
                                        @lang('labels.account_information')</div>
                                    <div class="menu" style="">
                                        <div class="item  pl-2 pr-2" x-on:click='open = "account_information";'>
                                            @lang('labels.account_information')</div>
                                        <div class="item pl-2 pr-2" x-on:click='open = "payment_schedule_history"'
                                            x-show='open != "payment_schedule_history"'>@lang('labels.payment_schedule_history')</div>
                                        <div class="item" x-on:click='open = "payments_transaction_history"'
                                            x-show='open != "payments_transaction_history"'> @lang('labels.payments_transaction_history')</div>
                                        <div class="item" x-on:click='open = "policies_endorsments"'
                                            x-show='open != "policies_endorsments"'>@lang('labels.policies_endorsments')</div>
                                        <div class="item" x-on:click='open = "enter_payment"'
                                            x-show='open != "enter_payment"'>@lang('labels.enter_payment')</div>
                                        <div class="item" x-on:click='open = "notice_history"'
                                            x-show='open != "notice_history"'>@lang('labels.notice_history')</div>
                                        <div class="item" x-on:click='open = "account_alerts"'
                                            x-show='open != "account_alerts"'>@lang('labels.account_alerts')</div>
                                        <div class="item" x-on:click='open = "manual_status_changes"'
                                            x-show='open != "manual_status_changes"'>@lang('labels.manual_status_changes')</div>
                                        <div class="item" x-on:click='open = "enter_return_premium_commission"'
                                            x-show='open != "enter_return_premium_commission"'> @lang('labels.enter_return_premium_commission')</div>
                                        <div class="item" x-on:click='open = "assess_manual_fee"'
                                            x-show='open != "assess_manual_fee"'>@lang('labels.assess_manual_fee')</div>
                                        <div class="item" x-on:click='open = "add_new_policy"'
                                            x-show='open != "add_new_policy"'>@lang('labels.add_new_policy')</div>
                                        <div class="item" x-on:click='open = "add_endorsements"'
                                            x-show='open != "add_endorsements"'>@lang('labels.add_endorsements')</div>
                                        <div class="item" x-on:click='open = "state_settings"'
                                            x-show='open != "state_settings"'>@lang('labels.state_settings')</div>
                                        <div class="item" x-on:click='open = "notes"' x-show='open != "notes"'>
                                            @lang('labels.notes')</div>
                                        <div class="item" x-on:click='open = "quotes"' x-show='open != "quotes"'>
                                            @lang('labels.quotes')</div>
                                        <div class="item" x-on:click='open = "attachments"' x-show='open != "quotes"'>
                                            @lang('labels.attachments')</div>
                                        <div class="item" x-on:click='open = "e_signature"'
                                            x-show='open != "e_signature"'>@lang('labels.e_signature_')</div>
                                        <div class="item" x-on:click='open = "logs"' x-show='open != "logs"'>
                                            @lang('labels.logs')</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="row align-items-end">
                                <div class="col-md-12">
                                    <div class="columns d-flex justify-content-end">
                                        <div class="lodeHtmlData"
                                            x-bind:class="(open == 'attachments') ? 'd-flex' : 'd-none'">
                                            <button class="btn btn-default borderless collapse_all"
                                                type="button">@lang('labels.collapse_all')</button>
                                            <button class="btn btn-default borderless expand_all"
                                                type="button">@lang('labels.expand_all')</button>
                                            <button class="btn btn-default borderless" type="button"
                                                x-on:click="uploadAttachment()">@lang('labels.upload_attachment')</button>

                                        </div>
                                        <div class="lodeHtmlData" x-bind:class="(back) ? 'd-flex' : 'd-none'">
                                            <button class="btn btn-default"
                                                x-on:click="open = back">@lang('labels.exit')</a></button>
                                        </div>
                                        {{-- <div class="lodeHtmlData"
                                            x-bind:class="(isEmptyChack(back)) ? 'd-flex' : 'd-none'">
                                            <button class="btn btn-default"
                                                x-on:click="open == 'attachments'">@lang('labels.exit')</button>
                                        </div>  --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tabs  --}}

                {{-- Account Information  --}}
                <div class="col-md-12" x-show="open == 'account_information'">
                    @includeIf($viwePath . 'pages.account_information')
                </div>

                {{-- payment schedule history  --}}
                <div class="col-md-12" x-show="open == 'payment_schedule_history'">
                    @includeIf($viwePath . 'pages.payment_schedule_history')
                </div>

                {{-- payments transaction history  --}}
                <div class="col-md-12" x-show="open == 'payments_transaction_history'">
                    @includeIf($viwePath . 'pages.payments_transaction_history')
                </div>

                {{-- Notice History  --}}
                <div class="col-md-12" x-show="open == 'notice_history'">
                    @includeIf($viwePath . 'pages.notice_history')
                </div>

                {{-- account  alerts --}}
                <div class="col-md-12" x-show="open == 'account_alerts'">
                    @includeIf($viwePath . 'pages.account_alert.index')
                </div>
                {{-- manual_status_changes --}}
                <div class="col-md-12" x-show="open == 'manual_status_changes'">
                    @includeIf($viwePath . 'pages.manual_status_changes')
                </div>
                {{-- manual_status_changes --}}
                <div class="col-md-12" x-show="open == 'enter_return_premium_commission'">
                    @includeIf($viwePath . 'pages.enter_return_premium_commission')
                </div>
                {{-- manual_status_changes --}}
                <div class="col-md-12" x-show="open == 'assess_manual_fee'">
                    @includeIf($viwePath . 'pages.assess_manual_fee')
                </div>
                {{-- state_settings --}}
                <div class="col-md-12" x-show="open == 'state_settings'">
                    @includeIf($viwePath . 'pages.state_settings')
                </div>
                {{-- notes --}}
                <div class="col-md-12" x-show="open == 'notes'">
                    @includeIf($viwePath . 'pages.notes.index')
                </div>
                {{-- index --}}
                <div class="col-md-12" x-show="open == 'e_signature'">
                    @include($viwePath . 'pages.e_signature.index')
                </div>

                {{-- quotes --}}
                <div class="col-md-12" x-show="open == 'quotes'">
                    @include($viwePath . 'pages.quote')
                </div>

                <div class="col-md-12 enterPayment" x-show="open == 'enter_payment'"></div>




                {{-- attachments --}}
                <div class="col-md-12 attachments" x-show="open == 'attachments' || open == 'attachment_add'"> </div>
                <div class="col-md-12 htmlData" x-show="open == 'htmlData'"> </div>
                <div class="col-md-12" x-show="open == 'logs'">
                    <x-table id="{{ $activePage }}-logs" :noToggle="true">
                        <thead>
                            <tr>
                                <th class="" data-sortable="true" data-field="created_at" data-width="170">
                                    @lang('labels.created_date')</th>
                                <th class="" data-sortable="true" data-field="username" data-width="200">
                                    @lang('labels.username')</th>
                                <th class="" data-sortable="true" data-field="message">@lang('labels.description')</th>
                            </tr>
                        </thead>
                    </x-table>
                </div>
            </div>


            {{-- Models  --}}

            @includeIf('company.accounts.model')
    </section>
    @push('page_script')
        @php
            $titleArr = [
                'account_information' => __('labels.account_information'),
                'payment_schedule_history' => __('labels.payment_schedule_history'),
                'payments_transaction_history' => __('labels.payments_transaction_history'),
                'policies_endorsments' => __('labels.policies_endorsments'),
                'notice_history' => __('labels.notice_history'),
                'account_alerts' => __('labels.account_alerts'),
                'manual_status_changes' => __('labels.manual_status_changes'),
                'enter_return_premium_commission' => __('labels.enter_return_premium_commission'),
                'assess_manual_fee' => __('labels.assess_manual_fee'),
                'add_new_policy' => __('labels.add_new_policy'),
                'add_endorsements' => __('labels.add_endorsements'),
                'state_settings' => __('labels.state_settings'),
                'notes' => __('labels.notes'),
                'attachments' => __('labels.attachments'),
                'e_signature' => __('labels.e_signature_'),
                'logs' => __('labels.logs'),
            ];
        @endphp
        <script>
            const editId = "{{ $data->id }}";
            const activePage = "{{ $activePage }}";
            const dropDownTitle = @json($titleArr);
        </script>
    @endpush
</x-app-layout>
