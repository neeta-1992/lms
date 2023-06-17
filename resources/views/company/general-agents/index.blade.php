<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ dynamicPageTitle('page') ?? '' }}
        </x-slot>
        @slot('content')
            <div class="table-responsive-sm">
                <x-bootstrap-table :data="[
                    'cookieid' => true,
                    'sortorder' => 'desc',
                    'sortname' => 'created_at',
                    'type' => 'serverside',
                    'ajaxUrl' => routeCheck($route . 'index') ,
                ]">
                    <thead>
                        <tr>
                            <th class="align-middle" data-sortable="false" data-width="170" data-field="created_at">Created Date
                            </th>
                            <th class="align-middle" data-sortable="false" data-width="170" data-field="updated_at">Last
                                Modified </th>
                            <th class="align-middle" data-sortable="false" data-width="660" data-field="name">General Agent
                                Name</th>
                            <th class="align-middle" data-sortable="false" data-width="100" data-field="account_type">d/b/a
                            </th>

                        </tr>
                    </thead>
                </x-bootstrap-table>
            </div>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
