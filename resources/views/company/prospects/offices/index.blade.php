<x-table id="{{ $activePage  }}-offices" ajaxUrl="{{ routeCheck($route.'index', ['agencyId' => $id]) }}" class="{{ $data['status'] == 8 ? 'disabledTable' : '' }}">
    <thead>
        <tr>
            <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">
                @lang('labels.created_date')</th>
            <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">
                @lang('labels.last_update_date ')</th>
            <th class="align-middle" data-sortable="true" data-width="" data-field="name">
                @lang('labels.office') @lang('labels.name')</th>
        </tr>
    </thead>
</x-table>
