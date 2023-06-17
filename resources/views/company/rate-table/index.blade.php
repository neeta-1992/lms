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
                    'ajaxUrl' => Route::has($route . 'index') ? route($route . 'index') : '',
                ]">
                    <thead>
                        <tr>
                            <th class="" data-sortable="true" data-field="created_at" data-width="170">Created Date
                            </th>
                            <th class="" data-sortable="true" data-field="created_at" data-width="170">Last Updated
                            </th>
                            <th class="align-middle" data-sortable="true" data-width="" data-field="name">Rate Table Name
                            </th>
                            <th class="align-middle" data-sortable="true" data-width="200" data-field="type">Rate Table Type
                            </th>
                            <th class="align-middle" data-sortable="true" data-width="100" data-field="account_type">Account
                                Type</th>
                            <th class="align-middle" data-sortable="true" data-width="100" data-field="state">
                                State</th>
                        </tr>
                    </thead>

                </x-bootstrap-table>
            </div>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
