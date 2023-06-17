<x-form action="{{ routeCheck($route.'update',['qId'=>$qId,'vId'=>$vId,'id'=>$id]) }}" method="post" x-data="{istask:false}"  x-effect="async () => {
    if(istask){
       $('.taskBox').find('.requiredAsterisk').parent('.row').find('input,select').attr('required','required');
    }else{
        $('.taskBox').find('.requiredAsterisk').parent('.row').find('input,select').removeAttr('required');
    }
  }">
  @method('put')
    <div class="form-group row">
        <label for="bank_name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.subject')</label>
        <div class="col-sm-9">
            <x-jet-input type="text" name="subject" required  value="{{ $data->subject ?? '' }}"/>
        </div>
    </div>
    <div class="form-group row">
        <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.type')</label>
        <div class="col-sm-3">
            <x-select :options="['Private' => 'Private', 'Public' => 'Public']" name="type" required class="ui dropdown"
                placeholder="Select {{ __('labels.type') }}" selected="{{ $data->type ?? '' }}" />
        </div>
    </div>
    <div class="form-group row">
        <label for="bank_name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.description')</label>
        <div class="col-sm-9">
            <textarea name="description" id="description" cols="30" rows="5" class="form-control" required>{{ $data->description ?? '' }}</textarea>
        </div>
    </div>
    <div class="form-group row ">
        <label for="notes" class="col-sm-3 col-form-label">@lang('labels.upload_file')</label>
        <div class="col-sm-9 ">
            <x-input-file label="{{ __('labels.upload_file') }}" name="files[]" data-file="notes"
                accept=".jpeg,.png,.gif,.pdf" multiple data-multiple-caption="{count} files selected" />
        </div>
    </div>
    <div class="form-group row ">
        <label for="notes" class="col-sm-3 col-form-label">@lang('labels.add') @lang('labels.task')</label>
        <div class="col-sm-9 ">
            <x-jet-checkbox name="is_task" id="is_task" x-on:change="istask= $el.checked"  />
        </div>
    </div>

    <div class="taskBox" x-show="istask == true">
        <div class="form-group row">
            <label for="bank_name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.subject')</label>
            <div class="col-sm-9">
                <x-jet-input type="text" name="task[subject]" value="{{ $data->subject ?? '' }}"  />
            </div>
        </div>
        <div class="form-group row">
            <label for="bank_name" class="col-sm-3 col-form-label ">@lang('labels.notes')</label>
            <div class="col-sm-9">
                <textarea name="task[notes]" id="notes" cols="30" rows="5" class="form-control"></textarea>
            </div>
        </div>
        <div class="form-group row">
            <label for="schedule" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.schedule')</label>
            <div class="col-md-6">
                <x-jet-input type="hidden" name="task[shedule]" class="dataDropDown"  data-required="true" data-min-date="true"/>
            </div>
            <div class="col-md-1">
                <x-link class="dataDropDownClear">Clear</x-link>
            </div>
        </div>


        <div class="form-group row">
            <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.priority')</label>
            <div class="col-sm-3">
                <x-select :options="['High' => 'High', 'Medium' => 'Medium', 'Low' => 'Low']" name="task[priority]"   class="ui dropdown"
                    placeholder="Select {{ __('labels.priority') }}" />
            </div>
        </div>
        <div class="form-group row">
            <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
            <div class="col-sm-3">
                <x-select :options="taskStatus()" name="task[status]" class="ui dropdown"
                    placeholder="Select {{ __('labels.status') }}"  />
            </div>
        </div>
        <div class="form-group row ">
            <label for="notes" class="col-sm-3 col-form-label">@lang('labels.upload_file')</label>
            <div class="col-sm-9 ">
                <x-input-file label="{{ __('labels.upload_file') }}" name="task[files][]" data-file="task"
                    accept=".jpeg,.png,.gif,.pdf" multiple data-multiple-caption="{count} files selected" />
            </div>
        </div>

        <div class="form-group row">
            <label for="gl_account" class="col-sm-3 col-form-label ">@lang('labels.assign_task')</label>
            <div class="col-sm-3">
                <x-select :options="$userData ?? []" name="assign_task" class="ui dropdown" placeholder="Select"  />
            </div>
        </div>
    </div>
    <x-button-group xclick="detailsNotes('{{ $id }}')"/>
</x-form>
