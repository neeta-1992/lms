<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ $pageTitle ?? '' }}
        </x-slot>
        @slot('content')
       
                <x-table id="{{ $activePage ?? '' }}-entered-payments-history" ajaxUrl="{{ routeCheck($route.'payments-history-list') }}">
                    <thead>
                        <tr>
                            <th class="align-middle"  data-width="170" data-field="processed_date">@lang('labels.processed_date')</th>
                            <th class="align-middle"  data-width="600" data-field="processed_by">@lang('labels.processed_by')</th>
                            <th class="align-middle"  data-width="170" data-field="total_transactions">@lang('labels.total_transactions')</th>
                            <th class="align-middle"  data-width="170" data-field="deposit_amount">@lang('labels.deposit_amount')</th>
                            <th class="align-middle"  data-width="" data-field="action">@lang('labels.action')</th>
                        </tr>
                    </thead>
                </x-table>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
