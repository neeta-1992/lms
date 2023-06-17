<x-form action="{{ routeCheck($route.'alert.store',['accountId'=>$accountId]) }}" method="post" x-data="{ addTask: false }" x-effect="(()=>{
   if(addTask){
        $('.taskForm').find('.requiredAsterisk').parents('.form-group').find('input,select').attr('required','required')
   }else{
        $('.taskForm').find('.requiredAsterisk').parents('.form-group').find('input,select').removeAttr('required')
   }
})">
    @if(!empty($alertId))
    <x-jet-input type="hidden" name="id" value="{{ $alertId ?? '' }}" />
    @endif
    <div class="form-group row">
        <label for="alert_date" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.alert') @lang('labels.date')
        </label>
        <div class="col-sm-9">
            <x-jet-input type="text" name="alert_date" class="singleDatePicker" data-current-date="true" required />
        </div>
    </div>
    <div class="form-group row">
        <label for="category" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.category')</label>
        <div class="col-sm-9">
            <x-select :options="[
                'General' => 'General',
                'Accounting' => 'Accounting',
                'Risk' => 'Risk',
                'Underwriting' => 'Underwriting',
            ]" class="ui dropdown" name="category" required />
        </div>
    </div>
    <div class="form-group row">
        <label for="subject" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.alert') @lang('labels.subject')
        </label>
        <div class="col-sm-9">
            <x-jet-input type="text" name="alert_subject" class="" required />
        </div>
    </div>
    <div class="form-group row">
        <label for="text" class="col-sm-3 col-form-label ">@lang('labels.alert') @lang('labels.text')</label>
        <div class="col-sm-9">
            <textarea name="alert_text" id="text" cols="30" rows="5" class="form-control"></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="subject" class="col-sm-3 col-form-label">@lang('labels.add') @lang('labels.task')
        </label>
        <div class="col-sm-9">
            <x-jet-checkbox type="text" name="add_task" class="" id="addTask" for="addTask" x-on:change="addTask = $el.checked" />
        </div>
    </div>
    <div x-show="addTask" class="taskForm">
        <x-task-form />
    </div>
    <x-button-group :xclick="`open = 'account_alerts'`" />
</x-form>
