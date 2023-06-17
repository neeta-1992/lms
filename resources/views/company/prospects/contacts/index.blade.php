
<x-table id="{{ $activePage }}-contacts"  ajaxUrl="{{ routeCheck($route.'contact',$id) }}"  class="{{ $data['status'] == 8 ? 'disabledTable' : '' }}">
    <thead>
        <tr>
            <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">
                Created Date
            </th>
            <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">
                Last
                Modified </th>
            <th class="align-middle" data-sortable="true" data-width="660" data-field="name"> Name
            </th>
        </tr>
    </thead>
</x-table>
