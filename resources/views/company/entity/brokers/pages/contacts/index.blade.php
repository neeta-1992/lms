
    <x-bootstrap-table :data="[
        'table' => 'contacts_table',
        'id'    => $activePage.'-contacts',
        'cookieid' => true,
        'sortorder' => 'desc',
        'sortname' => 'created_at',
        'type' => 'serversides',
        'ajaxUrl' => routeCheck($route.'contact',$id),
    ]">
        <thead>
            <tr>
                <th class="align-middle" data-sortable="false" data-width="170" data-field="created_at">
                    @lang('labels.created_date')
                </th>
                <th class="align-middle" data-sortable="false" data-width="170" data-field="updated_at">
                   @lang('labels.last_modified') </th>
                <th class="align-middle" data-sortable="false" data-width="660" data-field="name"> @lang('labels.name')
                </th>
            </tr>
        </thead>
    </x-bootstrap-table>
