<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ dynamicPageTitle('page') ?? '' }}
        </x-slot>
        @slot('content')
            <div class="table-responsive-sm">
                <x-bootstrap-table :data="[
                    'cookieid' => true,
                    'sortorder' => 'asc',
                    'sortname' => 'name',
                    'type' => 'serverside',
                    'currentUrl' => 'coverageType',
                    'ajaxUrl' => Route::has($route . 'index') ? route($route . 'index') : '',
                   
                ]">
                    <thead>
                        <tr>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">Created Date
                            </th>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">Last Update
                                Date</th>
                            <th class="align-middle" data-sortable="true" data-width="660" data-field="name">Coverage Name
                            </th>
                            <th class="align-middle" data-sortable="true" data-width="100" data-field="account_type">
                                Account Type</th>
                            <th class="align-middle" data-sortable="true" data-width="100" data-field="account_active">
                                Active</th>
                        </tr>
                    </thead>
                </x-bootstrap-table>
            </div>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
