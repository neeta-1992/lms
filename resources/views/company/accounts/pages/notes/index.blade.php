<x-table id="{{ $activePage ?? '' }}-notes" :noToggle="true" ajaxUrl="{{ routeCheck($route.'notes-list',$data->id) }}" data-toggle="table">
    <thead>
        <tr>
            <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">@lang('labels.created_date')</th>
            <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">@lang('labels.last_update_date')</th>
            <th class="align-middle" data-sortable="true" data-width="" data-field="username">@lang('labels.username')</th>
            <th class="align-middle" data-sortable="true" data-width="" data-field="subject">@lang('labels.subject')</th>
            <th class="align-middle" data-sortable="true" data-width="" data-field="description">@lang('labels.description')</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</x-table>
