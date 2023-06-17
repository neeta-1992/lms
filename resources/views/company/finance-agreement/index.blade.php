<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ dynamicPageTitle('page') ?? '' }}
        </x-slot>
        @slot('content')

                <x-bootstrap-table :data="[
                    'cookieid' => true,
                    'sortorder' => 'desc',
                    'sortname' => 'created_at',
                    'type' => 'serverside',
                    'ajaxUrl' => routeCheck($route . 'index'),
                ]">
                    <thead>
                        <tr>
                            <th class="align-middle" data-sortable="false" data-width="170" data-field="created_at">Created Date
                            </th>
                            <th class="align-middle" data-sortable="false" data-width="170" data-field="updated_at">Last Update
                                Date</th>
                            <th class="align-middle" data-sortable="false" data-width="" data-field="name">Name</th>
                            <th class="" data-sortable="true" data-field="description">Description</th>

                        </tr>
                    </thead>
                </x-bootstrap-table>

        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
