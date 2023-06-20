@php
$currentStatus = !empty($data['current_status']) ? $data['current_status'] : 0;
@endphp
<div class="col-md-12 page_table_menu quotes_in_mail_box_">
    <div class="row ">

        <div class="col-md-12">
            <div class="row align-items-end">
                <div class="col-md-12">
                    <div class="columns d-flex justify-content-end">
                        @if ($currentStatus !== 1)
                        <button class="btn btn-default closeTask" type="button"
                            x-show="(open != 'append' && open != 'logs')" data-id="{{ $id }}">
                            @lang('labels.close')</button>
                        <button class="btn btn-default" type="button" x-on:click="editTask('{{ $id }}')" >
                            @lang('labels.append')</button>
                        @else
                        <button class="btn btn-default reopenTask" type="button" data-id="{{ $id }}">
                            @lang('labels.reopen')</button>
                        @endif



                        <button class="btn btn-default " type="button" x-on:click="open = 'tasks'">@lang('labels.cancel')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



    <table class="table">

        <tbody>
            <tr>
                <td>@lang('labels.status')</td>
                <td> {{ taskStatus($data['current_status'] ?? 'null', true) }}</td>
            </tr>
            <tr>
                <td>@lang('labels.priority')</td>
                <td> {{ $data['priority'] ?? '' }}</td>
            </tr>
            <tr>
                <td>@lang('labels.schedule')</td>
                <td> {{ changeDateFormat($data['shedule']) ?? '' }}</td>
            </tr>
            <tr>
                <td>@lang('labels.created_by')</td>
                <td> {{ $data->created_by->name ?? '' }}</td>
            </tr>
            <tr>
                <td>@lang('labels.assigned')</td>
                <td> {{ $data->assigned->name ?? '' }}</td>
            </tr>
            <tr>
                <td>@lang('labels.subject')</td>
                <td> {{ $data->subject ?? '' }}</td>
            </tr>
            <tr>
                <td>@lang('labels.notes')</td>
                <td> {{ $data->notes ?? '' }}</td>
            </tr>

        </tbody>
    </table>









    <x-table id="{{ $activePage }}-tasks-append-list"
        ajaxUrl="{{ routeCheck('company.task.index', ['parentId' => $id]) }}">
        <thead>
            <tr>
                <th class="align-middle" data-sortable="true" data-width="170" data-field="created_at">
                    @lang('labels.created_date')</th>
                <th class="align-middle" data-sortable="true" data-width="170" data-field="updated_at">
                    @lang('labels.last_update_date')</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="username">
                    @lang('labels.username')</th>
                <th class="align-middle" data-sortable="true" data-width="" data-field="subject">
                    @lang('labels.subject')
                </th>

                <th class="align-middle" data-sortable="" data-width="" data-field="shedule">
                    @lang('labels.schedule')
                </th>
                <th class="align-middle" data-sortable="" data-width="" data-field="priority">
                    @lang('labels.priority')
                </th>
                <th class="align-middle" data-sortable="" data-width="" data-field="status">
                    @lang('labels.status')
                </th>
                <th class="align-middle" data-sortable="" data-width="" data-field="assign_task">
                    @lang('labels.assign_task')
                </th>

            </tr>
        </thead>
    </x-table>





    <div class="remodal" id="closeTaskModel" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
        <button data-remodal-action="close" class="remodal-close"></button>
        <h5>@lang('labels.close_task')  </h5>
        <form action="{{ routeCheck('company.task.cloes-task',['qId' => $qId]) }}" class="reloadForm">
            <div class="form-group text-left ">
                <x-jet-input type="hidden" name="id" value="{{ $id }}" />
                <label for="notes" class=" col-form-label requiredAsterisk">@lang('labels.notes')</label>
                <div class="">
                    <textarea name="notes" id="notes" required cols="30" rows="5" class="form-control"></textarea>
                </div>
            </div>

            <button class="btn btn-sm btn-primary saveData">Submit</button>
            <button data-remodal-action="cancel" class="btn btn-default btn-sm">Cancel</button>

        </form>
    </div>
    <div class="remodal" id="reopenTaskModel" data-remodal-options="hashTracking: false, closeOnOutsideClick: false">
        <button data-remodal-action="close" class="remodal-close"></button>
        <h5>@lang('labels.reopen_task')  </h5>
        <form action="{{ routeCheck('company.task.reopen-task',['qId' => $qId]) }}" class="reloadForm">
            <div class="form-group text-left ">
                <x-jet-input type="hidden" name="id" value="{{ $id }}" />
                <label for="description" class=" col-form-label requiredAsterisk">@lang('labels.description')</label>
                <div class="">
                    <textarea name="description" id="description" required cols="30" rows="5"
                        class="form-control"></textarea>
                </div>
            </div>

            <button class="btn btn-sm btn-primary saveData">Submit</button>
            <button data-remodal-action="cancel" class="btn btn-default btn-sm">Cancel</button>

        </form>
    </div>


