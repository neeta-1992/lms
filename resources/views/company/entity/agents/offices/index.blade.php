<x-bootstrap-table :data="[
    'id' => $activePage . '-offices',
    'cookieid' => true,
    'sortorder' => 'desc',
    'sortname' => 'created_at',
    'type' => 'serversides',

    'ajaxUrl' => routeCheck($route.'index', ['agencyId' => $id]),
]">

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
</x-bootstrap-table>
