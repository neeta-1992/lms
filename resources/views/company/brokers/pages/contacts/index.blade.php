
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
                    Created Date
                </th>
                <th class="align-middle" data-sortable="false" data-width="170" data-field="updated_at">
                    Last
                    Modified </th>
                <th class="align-middle" data-sortable="false" data-width="660" data-field="name"> Name
                </th>
            </tr>
        </thead>
    </x-bootstrap-table>