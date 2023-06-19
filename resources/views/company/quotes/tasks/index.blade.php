<div class="policyList ">
    <x-table id="{{ $activePage ?? '' }}-tasks{{  !empty($deleted) ? '-delete' : '' }}" queryParams="queryParams"  ajaxUrl="{{ routeCheck('company.task.index',['qId'=>$qId]) }}" data-custome-filter="{{ json_encode(taskStatus(null,true)) }}" data-custome-filter-checked="[3,4]">
        <thead>
            <tr>
                <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">@lang("labels.created_date")</th>
                <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">@lang("labels.last_update_date")</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="username">@lang("labels.username")</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="subject">@lang("labels.subject")</th>

                <th class="align-middle" data-sortable="true" data-width="" data-field="shedule">@lang("labels.schedule")</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="priority">@lang("labels.priority")</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="status">@lang("labels.status")</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="assign_task">@lang("labels.assign_task")</th>
            </tr>
        </thead>
    </x-table>
</div>