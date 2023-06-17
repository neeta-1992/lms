<x-app-layout>
    <x-jet-action-section x-data="quotsIndex">
        <x-slot name="title">
            {{ $pageTitle ?? ''  }}
        </x-slot>

        @slot('uiDropDwon')
       
            @if($pageType == 'index')
                <div class="ui selection dropdown table-head-dropdown maindropdown">
                    <input type="hidden" x-bind:value=tab /><i class="dropdown icon"></i>
                    <div class="text" x-text="title">@lang('labels.open_quote')</div>
                    <div class="menu">
                        <div class="item" @click="tab = 'open_quote';title = '{{ __('labels.open_quote') }}';initTable()" x-show="tab != 'open_quote'">@lang('labels.open_quote')</div>
                        <div class="item" @click="tab = 'draft_quote';title = '{{ __('labels.draft_quote') }}';initTable()" x-show="tab != 'draft_quote'">@lang('labels.draft_quote')</div>
                        <div class="item" @click="tab = 'delete_quote';title = '{{ __('labels.delete_quote') }}';initTable()" x-show="tab != 'delete_quote'">@lang('labels.delete_quote')</div>
                    </div>
                </div>
                @endslot
                @slot('content')
                <div class="table-responsive-sm">
                    <x-table id="{{ $activePage ?? '' }}" :noToggle="true">
                        <thead>
                            <tr>
                                <th class="align-middle" data-sortable="true" data-field="quoteid">@lang('labels.quote') {{ '#' }} </th>
                                <th class="align-middle" data-sortable="true" data-field="created_at">@lang('labels.created_date')</th>
                                <th class="align-middle" data-sortable="true" data-field="updated_at">@lang('labels.last_modified')</th>
                                <th class="align-middle" data-sortable="true" data-field="insured">@lang('labels.insured') @lang('labels.name')</th>
                                <th class="align-middle" data-sortable="true" data-field="agency">@lang('labels.agency') @lang('labels.name')</th>
                                <th class="align-middle" data-sortable="true" data-field="premium">@lang('labels.premium') </th>
                            </tr>
                        </thead>
                    </x-table>
                </div>
            @else
                <div class="ui selection dropdown table-head-dropdown maindropdown">
                    <input type="hidden" x-bind:value=tab /><i class="dropdown icon"></i>
                    <div class="text" x-text="title">@lang('labels.request_for_activation')</div>
                    <div class="menu">
                        <div class="item" @click="tab = 'request_for_activation';title = '{{ __('labels.request_for_activation') }}';initTable()" x-show="tab != 'request_for_activation'">@lang('labels.request_for_activation')</div>
                        <div class="item" @click="tab = 'in_process_request';title = '{{ __('labels.in_process_request') }}';initTable()" x-show="tab != 'in_process_request'">@lang('labels.in_process_request')</div>
         
                    </div>
                </div>
                @endslot
                @slot('content')
                <div class="table-responsive-sm">
                    <x-table id="{{ $activePage ?? '' }}" :noToggle="true">
                        <thead>
                            <tr>
                                <th class="align-middle" data-sortable="true" data-field="quoteid">@lang('labels.quote') {{ '#' }} </th>
                                <th class="align-middle" data-sortable="true" data-field="created_at">@lang('labels.created_date')</th>
                                <th class="align-middle" data-sortable="true" data-field="updated_at">@lang('labels.last_modified')</th>
                                <th class="align-middle" data-sortable="true" data-field="assign_to">@lang('labels.assign') @lang('labels.to')</th>
                                <th class="align-middle" data-sortable="true" data-field="insured">@lang('labels.insured') @lang('labels.name')</th>
                                <th class="align-middle" data-sortable="true" data-field="agency">@lang('labels.agency') @lang('labels.name')</th>
                                <th class="align-middle" data-sortable="true" data-field="premium">@lang('labels.premium') </th>
                                <th class="align-middle" data-sortable="false" data-field="down_payment">  Down Payment</th>
                                <th class="align-middle" data-sortable="false" data-field="total">  Total</th>
                             </tr>
                        </thead>
                    </x-table>
                </div>
            @endif
        @endslot
         

    </x-jet-action-section>
    <!--/.section-->

    @push('page_script_code')
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("quotsIndex", () => ({
                tab: '{{ $pageType == "index" ? "open_quote" : "request_for_activation" }}'
                , title:  '{{ $pageType == "index" ? __("labels.open_quote") : __("labels.request_for_activation") }}'
                , init() {
                    this.initTable()
                }
                , initTable() {
                    $('#{{ $activePage ?? '' }}').bootstrapTable('destroy').bootstrapTable({
                        url: "{{ routeCheck($route . 'index') }}?tab=" + this.tab
                    });
                }
                

            }));
        });

    </script>
    @endpush
</x-app-layout>
