    <x-table id="{{ $activePage ?? '' }}-account-alerts" ajaxUrl="{{ routeCheck($route.'alert.index',$data->id) }}">
        <thead>
        <tr>
            <th class="align-middle" data-sortable="true" data-field="created_at">@lang("labels.created_date")</th>
            <th class="align-middle" data-sortable="true" data-field="created_by">@lang('labels.created_by')</th>
            <th class="align-middle" data-sortable="true" data-field="alert_subject">@lang('labels.subject')</th>
            <th class="align-middle" data-sortable="true" data-field="category">@lang('labels.category')</th>
            <th class="align-middle" data-sortable="true" data-field="task">@lang('labels.task')</th>
        </tr>
    </thead>
</x-table>


