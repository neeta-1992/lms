    <x-table id="{{ $activePage ?? '' }}-notice-history">
        <thead>
        <tr>
            <th class="align-middle" data-sortable="true" data-field="created_at">@lang("labels.created_date")</th>
            <th class="align-middle" data-field="sent_printed">@lang('labels.date_sent_printed')</th>
            <th class="align-middle" data-field="notice">@lang('labels.notice')</th>
            <th class="align-middle" data-field="sent_to">@lang('labels.sent_to')</th>
            <th class="align-middle" data-field="action">@lang('labels.how_to_sent')</th>  
        </tr>
    </thead>
</x-table>