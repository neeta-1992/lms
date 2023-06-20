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
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">@lang('labels.created_date')
                        </th>
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">@lang('labels.last_updated')
                        </th>
                        <th class="align-middle" data-sortable="true" data-width="" data-field="name">@lang('labels.rate_table_name')
                        </th>
                        <th class="align-middle" data-sortable="true" data-width="200" data-field="type">@lang('labels.rate_table_type')
                        </th>
                        <th class="align-middle" data-sortable="true" data-width="100" data-field="account_type">@lang('labels.account_type')
                        </th>
                        <th class="align-middle" data-sortable="true" data-width="100" data-field="state">
                            @lang('labels.state') </th>
                    </tr>
                </thead>

            </x-bootstrap-table>
        </div>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
