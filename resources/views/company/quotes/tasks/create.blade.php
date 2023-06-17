<x-form action="{{ routeCheck($route.'tasks-create',['qId'=>$qId,'vId'=>$vId]) }}" method="post">

    <div class="form-group row">
        <label for="bank_name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.subject')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" name="subject" required />
        </div>
    </div>
    <div class="form-group row">
        <label for="bank_name" class="col-sm-3 col-form-label ">@lang('labels.notes')</label>
        <div class="col-sm-9">
            <textarea name="notes" id="notes" cols="30" rows="5" class="form-control"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="schedule" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.schedule')</label>
        <div class="col-md-6">
            <x-jet-input type="hidden" name="shedule" class="dataDropDown" data-required="true" data-min-date="true"/>
        </div>
        <div class="col-md-1">
            <x-link class="dataDropDownClear">Clear</x-link>
        </div>
    </div>

    </div>
    <div class="form-group row">
        <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.priority')</label>
        <div class="col-sm-3">
            <x-select :options="['High' => 'High', 'Medium' => 'Medium', 'Low' => 'Low']" name="priority" required class="ui dropdown"
                placeholder="Select {{ __('labels.priority') }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
        <div class="col-sm-3">
            <x-select :options="taskStatus()" name="status" class="ui dropdown"
                placeholder="Select {{ __('labels.status') }}" required />
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
            <x-select :options="$userData ?? []" name="assign_task" class="ui dropdown" placeholder="Select"  />
        </div>
    </div>
    <x-button-group :xclick="`open = 'tasks'`"/>
</x-form>
