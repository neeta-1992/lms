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
                            <th class="align-middle" data-sortable="false" data-width="170" data-field="created_at">@lang('labels.created_date')
                            </th>
                            <th class="align-middle" data-sortable="false" data-width="170" data-field="updated_at">
                                @lang('labels.last_update_date')</th>
                            <th class="align-middle" data-sortable="false" data-width="" data-field="name">@lang('labels.name')</th>
                            <th class="" data-sortable="true" data-field="description">@lang('labels.description')</th>

                        </tr>
                    </thead>
                </x-bootstrap-table>

        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
