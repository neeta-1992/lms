<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ dynamicPageTitle('page') ?? '' }}
        </x-slot>
        @slot('content')


             <x-table id="{{ $activePage }}"  ajaxUrl="{{ routeCheck($route.'index') }}">
                <thead>
                    <tr>
                        <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">
                            @lang("labels.created_date")</th>
                        <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">
                            @lang("labels.last_update_date ")</th>
                        <th class="align-middle" data-sortable="true" data-width="" data-field="name">
                        @lang("labels.agency")  @lang("labels.name")</th>
                        <th class="align-middle" data-sortable="true" data-width="" data-field="contact_name">
                        @lang("labels.contact_name")</th>
                        <th class="align-middle" data-sortable="true" data-width="" data-field="email">
                        @lang("labels.email")</th>
                        <th class="align-middle" data-sortable="true" data-width="" data-field="telephone">
                        @lang("labels.telephone")</th>

                    </tr>
                </thead>
            </x-table>

        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
