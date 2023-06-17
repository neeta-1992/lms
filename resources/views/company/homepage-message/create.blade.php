<x-app-layout :class="['codemirror','datepicker']">
    <x-jet-form-section :buttonGroup="['exit'=>['url'=>routeCheck($route . 'index')]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}"
        method="post">
        @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
                <div class="col-sm-3">
                    {!! form_dropdown('status', [1 => 'Enable', 0 => 'Disable'], '', [
                        'class' => "ui dropdown input-sm  w-25",
                        'required' => true,
                        'id' => 'status',
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.user_type')</label>
                <div class="col-sm-3">
                    {!! form_dropdown(
                        'user_type', userType(),'',['class' => "",'required' => true],
                    ) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="from_to_date" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.from_to')</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control input-sm daterangepickers" data-time-picker="true" required name="from_to_date" id="from_to_date"
                        placeholder="">
                </div>
            </div>
             <div class="form-group row">
                <label for="body" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.body")</label>
                <div class="col-sm-9">
                    <textarea name="body" id="body" required class="form-control homePageMesageCodemirrorEditor templateEditor" required
                        cols="30" rows="3"></textarea>
                </div>
            </div>



            <x-slot name="saveOrCancel"></x-slot>
        @endslot
    </x-jet-form-section>
</x-app-layout>
