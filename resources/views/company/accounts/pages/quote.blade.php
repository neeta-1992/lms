<x-table id="{{ $activePage ?? '' }}-quote-list" >
    <thead>
        <tr>
            <th class="align-middle">@lang('labels.last_update_date')</th>
            <th class="align-middle" data-width="780">@lang('labels.quote') #</th>

        </tr>
    </thead>
    <tbody>
        @if(!empty($data->quote_data))
            @foreach($data->quote_data as $key => $row)
                 <tr>
                    <td>{{ changeDateFormat($row->updated_at) }}</td>
                    <td><a class="linkButton" href="{{ routeCheck('company.quotes.edit', $row->id) }}" data-turbolinks="false">{{ $row->qid ?? '' }}.{{  $row->version ?? '' }}</a></td>
                 </tr>
            @endforeach
        @endif
    </tbody>
</x-table>
