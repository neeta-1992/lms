@php
$currentStatus = !empty($data['current_status']) ? $data['current_status'] : 0;
@endphp
<div class="col-md-12 page_table_menu quotes_in_mail_box_">
    <div class="row ">
        <div class="col-md-12">
            <div class="row align-items-end">
                <div class="col-md-12">
                    <div class="columns d-flex justify-content-end">
                        <button class="btn btn-default " type="button"> <a href="javascript:void(0)" data-turbolinks="false"  x-on:click="detailsTask('{{ $data['id'] ?? '' }}')">@lang('labels.cancel')</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




    <form action="{{ routeCheck('company.task.update', $id) }}" method="post" class="validationForm"
        novalidate>
        @csrf
        @method('put')
        <x-jet-input type="hidden" value="{{ $qId ?? '' }}" name="qId"/>
        <x-jet-input type="hidden" value="{{ $vId ?? '' }}" name="vId"/>
        <div class="form-group row">
            <label for="bank_name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.subject')</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="subject" required value="{{ $data->subject ?? ''  }}" />
            </div>
        </div>
        <div class="form-group row">
            <label for="bank_name" class="col-sm-3 col-form-label ">@lang('labels.notes')</label>
            <div class="col-sm-9">
                <textarea name="notes" id="notes" cols="30" rows="5" class="form-control">{{ $data->notes ?? ''  }}</textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="schedule" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.schedule')</label>
            <div class="col-md-6">
                <x-jet-input type="hidden" name="shedule" class="dataDropDown" data-required="true" data-min-date="true"
                    data-value='{{ date(' Y-m-d') }}' value="{{ $data->shedule ?? ''  }}" />
            </div>
            <div class="col-md-1">
                <x-link class="dataDropDownClear">Clear</x-link>
            </div>
        </div>
        <div class="form-group row">
            <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.priority')</label>
            <div class="col-sm-3">
                <x-select :options="['High' => 'High', 'Medium' => 'Medium', 'Low' => 'Low']" name="priority" required
                    class="ui dropdown" placeholder="Select {{ __('labels.priority') }}" selected="{{ $data->priority ?? ''  }}" />
            </div>
        </div>
        <div class="form-group row">
            <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
            <div class="col-sm-3">
                <x-select :options="taskStatus()" name="status" class="ui dropdown"
                    placeholder="Select {{ __('labels.status') }}" required selected="{{ $data['current_status'] }}" />
            </div>
        </div>
        <div class="form-group row ">
            <label for="notes" class="col-sm-3 col-form-label">@lang('labels.upload_file')</label>
            <div class="col-sm-9 ">
                <x-input-file label="{{ __('labels.upload_file') }}" name="files[]" data-file="task"
                    accept=".jpeg,.png,.gif,.pdf" multiple data-multiple-caption="{count} files selected" />
            </div>
        </div>
        <div class="form-group row">
            <label for="gl_account" class="col-sm-3 col-form-label ">@lang('labels.assign_task')</label>
            <div class="col-sm-3">
                <x-select :options="$userData ?? []" name="assign_task" class="ui dropdown" placeholder="Select" selected="{{ $data->assign_task ?? ''  }}" />
            </div>
        </div>
        <x-button-group :cancel="routeCheck($route . 'index')" xclick="open = 'tasks'" />
    </form>





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
        <h5>Close Task</h5>
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
        <h5>Reopen Task</h5>
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

