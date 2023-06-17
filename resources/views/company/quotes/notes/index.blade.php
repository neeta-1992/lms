<div class="policyList">
    <x-table id="{{ $activePage ?? '' }}-notes{{  (!empty($quoteData->status) && $quoteData->status ==6) ? '-delete' : '' }}" ajaxUrl="{{ routeCheck($route.'viewList',['qId'=>$qId,'vId'=>$vId]) }}">
        <thead>
            <tr>
                <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">@lang("labels.created_date")</th>
                <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">@lang("labels.last_update_date")</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="username">@lang("labels.username")</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="subject">@lang("labels.subject")</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="description">@lang("labels.description")</th>
            </tr>
        </thead>
       <tbody>

       </tbody>
    </x-table>
</div>
