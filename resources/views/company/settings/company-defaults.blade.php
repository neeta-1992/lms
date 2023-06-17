<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ $pageTitle  ?? dynamicPageTitle('page') }}
        </x-slot>
        @slot('content')
            <div class="table-responsive-sm">
                <x-bootstrap-table :data="[
                    'cookieid' => true,
                    'sortorder' => 'asc',
                    'sortname' => 'name',


                ]">
                    <thead>
                        <tr>

                            <th class="align-middle" data-sortable="true" data-width="" data-field="name">@lang("labels.name")
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                         @isset($data)
                              @foreach ($data as $key => $value)
                                   <tr>
                                      <td>
                                         <a data-turbolinks="false" href="{{ routeCheck("company.settings.company-default-settings",['id'=>encryptUrl($key)]) }}">{{ $value ?? '' }}</a>
                                      </td>
                                   </tr>
                              @endforeach
                         @endisset
                    </tbody>

                </x-bootstrap-table>
            </div>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
