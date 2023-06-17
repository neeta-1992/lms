<x-table id="{{ $activePage ?? '' }}-quotes"  ajaxUrl="{{ routeCheck('company.quotes.index',['general_agent' => ($id ?? 'null') ]) }}">
    <thead>
        <tr>
            <th class="align-middle" data-sortable="true" data-field="quoteid">@lang('labels.quote') {{ '#' }} </th>
            <th class="align-middle" data-sortable="true" data-field="created_at">@lang('labels.created_date')</th>
            <th class="align-middle" data-sortable="true" data-field="updated_at">@lang('labels.last_modified')</th>
            <th class="align-middle" data-sortable="true" data-field="insured">@lang('labels.insured') @lang('labels.name')</th>
            <th class="align-middle" data-sortable="true" data-field="account_type">@lang('labels.account_type') </th>
            <th class="align-middle" data-sortable="true" data-field="quote_type">@lang('labels.quote_type') </th>
            <th class="align-middle" data-sortable="true" data-field="premium">@lang('labels.pure_premium') </th>
            <th class="align-middle" data-sortable="true" data-field="total">@lang('labels.total') </th>
        </tr>
    </thead>
</x-table>
