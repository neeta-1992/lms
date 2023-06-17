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
                'currentUrl' => 'financeCompany',
                'ajaxUrl' => Route::has($route . 'index') ? route($route . 'index') : '',
            ]">
                <thead>
                    <tr>
                        <th class="align-middle" data-sortable="true" data-width="200" data-field="created_at">Created Date</th>
                        <th class="align-middle" data-sortable="true" data-width="200" data-field="updated_at">Last Updated Date</th>
                        <th class="align-middle" data-sortable="true" data-width="400" data-field="name">Name</th>
                        <th class="align-middle" data-sortable="true" data-width="300" data-field="email">Email</th>
                      
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </x-bootstrap-table>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
