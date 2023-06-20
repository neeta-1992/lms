<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ $pageTitle ??  dynamicPageTitle('page') ?? '' }}
        </x-slot>
        @slot('content')
            <div class="table-responsive-sm">
                <x-table id="{{ $activePage ?? '' }}" :pagination="false">
                    <thead>
                        <tr>
                            <th class="align-middle" data-sortable="false" data-width="170">@lang('labels.notice_type')</th>
                            <th class="align-middle" data-sortable="false" data-width="170">@lang('labels.number_of_open_notices')</th>
                        </tr>
                    </thead>
                    <tbody>
                       @if(!empty($data))
                            @foreach($data as $key => $row)
                                @php
                                    $send_by = $row->send_by ?? '' ;
                                    $attachmentsCount = $row->attachments_count ?? 0;
                                    $count  = $row->count ?? 0 ;
                                    $count  = $send_by == 'mail' ? $count + $attachmentsCount : $count;
                                @endphp
                                <tr>
                                    <td> <a class="linkButton" href="{{ routeCheck($route.'show',$row->send_by) }}" data-turbolinks="false"> {{ ucfirst($row->send_by) }}</a> </td>
                                    <td>  {{ $count ?? 0 }} </td>
                                </tr>
                            @endforeach
                       @endif
                    </tbody>
                </x-table>
            </div>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
