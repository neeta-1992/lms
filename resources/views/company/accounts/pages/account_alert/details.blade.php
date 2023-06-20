
<div class="col-md-12 page_table_menu quotes_in_mail_box_">
    <div class="row ">

        <div class="col-md-12">
            <div class="row align-items-end">
                <div class="col-md-12">
                    <div class="columns d-flex justify-content-end">
                        <button class="btn btn-default" type="button" x-on:click="accountAlertInsertOrUpdate('{{ $id }}')">
                            @lang('labels.append')</button>
                        <button class="btn btn-default " type="button"
                            x-on:click="open = 'account_alerts'">@lang('labels.cancel')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<table class="table">

    <tbody>
        <tr>
            <td>@lang('labels.created_date')</td>
            <td> {{ changeDateFormat($data['created_at'] ?? 'null', true) }}</td>
        </tr>
        <tr>
            <td>@lang('labels.last_update_date')</td>
            <td> {{ $data['updated_at'] ?? '' }}</td>
        </tr>
        <tr>
            <td>@lang('labels.created_by')</td>
            <td> {{ $data->user?->name ?? '' }}</td>
        </tr>
        <tr>
            <td>@lang('labels.alert') @lang('labels.date')</td>
            <td> {{ changeDateFormat($data->alert_date) ?? '' }}</td>
        </tr>
        <tr>
            <td>@lang('labels.alert') @lang('labels.subject')</td>
            <td> {{ $data->alert_subject ?? '' }}</td>
        </tr>
        <tr>
            <td>@lang('labels.alert') @lang('labels.text')</td>
            <td> {{ $data->alert_text ?? '' }}</td>
        </tr>
        <tr>
            <td>@lang('labels.task')</td>
            <td> {{ !empty($data->task) ? 'Yes' : 'No' }}</td>
        </tr>

    </tbody>
</table>

<div class="col-md-12 page_table_menu">
    <div class="row ">
        <div class="col-md-12 p-0">
            <div class="row align-items-start">
                <div class="col-md-12">
                    <div class="columns d-flex justify-content-start">
                        <h5>@lang('labels.alert_history')</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <x-table id="{{ $activePage ?? '' }}-account-alerts-history"
            ajaxUrl="{{ routeCheck($route . 'alert.index',['accountId' => $data->account_id,'parentId'=>$data->parent_id ?? $data->id]) }}">
            <thead>
                <tr>
                    <th class="align-middle" data-sortable="true" data-field="created_at">@lang('labels.created_date')</th>
                    <th class="align-middle" data-sortable="true" data-field="created_by">@lang('labels.created_by')</th>
                    <th class="align-middle" data-sortable="true" data-field="alert_subject">@lang('labels.subject')</th>
                    <th class="align-middle" data-sortable="true" data-field="category">@lang('labels.category')</th>
                    <th class="align-middle" data-sortable="true" data-field="task">@lang('labels.task')</th>
                </tr>
            </thead>
        </x-table>
    </div>
</div>
