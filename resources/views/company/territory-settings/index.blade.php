<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ dynamicPageTitle('page') ?? '' }}
        </x-slot>
        @slot('content')
            <div class="table-responsive-sm">
                <x-bootstrap-table :data="[
                    'cookieid'  => true,
                    'sortorder' => 'desc',
                    'sortname'  => 'created_at',
                    'type'      => 'serverside',
                    'ajaxUrl'   => routeCheck($route.'index'),
                ]">
                    <thead>
                        <tr>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">@lang("labels.created_date")</th>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">@lang("labels.last_update_date ")</th>
                            <th class="align-middle" data-sortable="true" data-width="400" data-field="name">@lang("labels.name")</th>
                            <th class="align-middle" data-sortable="true" data-width="" data-field="status">@lang("labels.status")</th>
                            </tr>
                    </thead>
                </x-bootstrap-table>
            </div>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
