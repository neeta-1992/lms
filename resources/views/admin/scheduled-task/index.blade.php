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
                    'ajaxUrl' => routeCheck($route . 'index'),
                ]">
                    <thead>
                        <tr>
                            <th class="align-middle" data-sortable="false" data-width="170" data-field="created_at">Created Date</th>
                            <th class="align-middle" data-sortable="false" data-width="170" data-field="updated_at">Last Update Date</th>
                            <th class="align-middle" data-sortable="false" data-width="400" data-field="task_name">@lang("labels.task_name")</th>
                            <th class="align-middle" data-sortable="false" data-width="170" data-field="how_often">@lang("labels.how_often")</th>
                            <th class="align-middle" data-sortable="false" data-width="170" data-field="start_time">@lang("labels.start_time")</th>
                            <th class="align-middle" data-sortable="false" data-width="170" data-field="status">@lang("labels.status")</th>
                        </tr>
                    </thead>
                </x-bootstrap-table>
            </div>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
