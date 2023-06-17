<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ dynamicPageTitle('page') ?? '' }}
        </x-slot>
        @slot('content')
                <x-bootstrap-table :data="[
                    'cookieid'  => true,

                ]">
                    <thead>
                        <tr>
                            <th class="align-middle" data-sortable="true" data-width="200" data-field="name">@lang('labels.name')</th>
                        </tr>
                    </thead>
                    <tbody>
                         @php
                             $loginUserTypeArr = loginUserTypeArr();
                         @endphp
                         @foreach ($loginUserTypeArr as $key=> $user)
                             <tr>
                                  <td>

                                    <a data-turbolinks="false" href="{{ routeCheck($route."show",encryptUrl($key)) }}">{{ $user ?? '' }}</a>
                                  </td>
                             </tr>
                         @endforeach
                    </tbody>
                </x-bootstrap-table>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
