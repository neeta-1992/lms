<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ dynamicPageTitle('page') ?? '' }}
        </x-slot>
        @slot('content')
            <div class="table-responsive-sm">
                <x-bootstrap-table :data="['cookieid'  => true,'sortorder' => 'asc','sortname'  => 'name', ]">
                    <thead>
                        <tr>
                           <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">@lang("labels.created_date")</th>
                            <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">@lang("labels.last_update_date ")</th>
                            <th class="align-middle" data-sortable="true" data-width="" data-field="state">@lang("labels.state") @lang("labels.name")</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if(!empty($data))
                            @foreach ($data as $row)
                               <tr>
                                   <td>{{ changeDateFormat($row['created_at']) }}</td>
                                   <td>{{ changeDateFormat($row['updated_at']) }}</td>
                                   <td> <a href="{{ routeCheck('company.account-status-settings.show',encryptUrl($row['id'])) }}" data-turbolinks="false">  {{ ($row['state']) }}</a></td>
                               </tr>

                            @endforeach
                        @endif
                    </tbody>



                </x-bootstrap-table>
            </div>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
