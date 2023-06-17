<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ dynamicPageTitle('page') ?? '' }}
        </x-slot>
        @slot('content')
            <div class="table-responsive-sm">
                <x-bootstrap-table :data="[
                    'cookieid'  => true,
                    'sortorder' => 'asc',
                    'sortname'  => 'name',
                    'type'      => 'serverside',
                    'ajaxUrl'   => routeCheck($route.'index'),
                ]">
                    <thead>
                        <tr>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">Created Date</th>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">Last Update Date</th>
                            <th class="align-middle" data-sortable="true" data-width="200" data-field="number">GL Number</th>
                            <th class="align-middle" data-sortable="true" data-width=""    data-field="name">GL Name</th>
                        </tr>
                    </thead>
                </x-bootstrap-table>
            </div>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
