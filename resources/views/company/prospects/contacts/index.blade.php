
<x-table id="{{ $activePage }}-contacts"  ajaxUrl="{{ routeCheck($route.'contact',$id) }}"  class="{{ $data['status'] == 8 ? 'disabledTable' : '' }}">
    <thead>
        <tr>
            <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">
              @lang('labels.created_date')
            </th>
            <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">
              @lang('labels.last_modified') </th>
            <th class="align-middle" data-sortable="true" data-width="660" data-field="name"> @lang('labels.name')
            </th>
        </tr>
    </thead>
</x-table>
