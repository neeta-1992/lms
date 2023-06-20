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
                    'ajaxUrl'   =>  Route::has($route.'index') ? route($route.'index') : '',
                ]">
                    <thead>
                        <tr>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">@lang("labels.created_date")</th>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">@lang("labels.last_update_date ")</th>
                            <th class="align-middle" data-sortable="true" data-width="" data-field="name">@lang("labels.name")</th>
                            <th class="align-middle" data-sortable="true" data-width="50" data-width="" data-field="notice_id">@lang('labels.id')</th>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="send_to">@lang("labels.send_to")</th>
                            <th class="align-middle" data-sortable="true" data-width="100" data-field="template_type">@lang('labels.type')</th>
                            <th class="align-middle" data-sortable="true" data-width="70" data-field="send_by">@lang("labels.send_by")</th>

                        </tr>
                    </thead>
                </x-bootstrap-table>
            </div>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
