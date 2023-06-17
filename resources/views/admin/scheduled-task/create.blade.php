<x-app-layout :class="['datepicker']">
<x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]"
         class="validationForm" novalidate action="{{ routeCheck($route.'store') }}" method="post">
       @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.task_name")</label>
                <div class="col-sm-4">
                    {!! form_dropdown('task_name', taskName(['nameArr'=>$nameArr]), '', ["class"=>"ui dropdown input-sm w-100","required"=>null]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.start_time")</label>
                <div class="col-sm-4">
                    {!! form_dropdown('start_time', timePicker(), '', ["class"=>"w-100 time","required"=>true]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.us_time_zone")</label>
                <div class="col-sm-4">
                    {!! form_dropdown('us_time_zone', timeZoneDropDown(), '', ["class"=>"ui dropdown input-sm
                    w-100","required"=>null]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.how_often")</label>
                <div class="col-sm-4">
                    {!! form_dropdown('how_often', howOften(), '', ["class"=>"ui dropdown input-sm
                    w-100","required"=>null]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.start_date")</label>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="start_date" id="start_date" class="singleDatePicker" required />
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label">@lang("labels.end_date") </label>
                <div class="col-sm-4">
                    <x-jet-input type="text"  name="end_date" id="end_date"  class="singleDatePicker"/>
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.status")</label>
                <div class="col-sm-4">
                    {!! form_dropdown('status',[1=>'Enable',2=>'Disable'],'', ["class"=>"ui dropdown input-sm
                    w-100","required"=>true]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label ">@lang("labels.description")</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" class="form-control"  cols="30" rows="3"></textarea>
                </div>
            </div>


            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">
                    <div class="row form-group align-top-radio">

                        <div class="col-sm-12">
                            <div class="zinput zradio zradio-sm  zinput-inline p-0 mb-2">
                                <input id="yes" class="form-check-input" name="save_option" checked type="radio"
                                    value="save_defaults_only">
                                <label for="yes" class="form-check-label">Save defaults only: EXISTING FINANCE
                                    COMPANIES ARE
                                    NOT AFFECTED</label>
                            </div>
                            <div class="zinput zradio  zradio-sm   zinput-inline  p-0">
                                <input id="no" class="form-check-input" name="save_option" type="radio"
                                    value="save_and_reset">
                                <label for="no" class="form-check-label">Save and Reset existing FINANCE COMPANIES:
                                    Save the
                                    default coverage types values and apply the default coverage types
                                    values to all existing FINANCE COMPANIES for the coverage types. ALL EXISTING COVERAGE
                                    TYPES AND SPECIFIED VALUES FOR
                                    FINANCE COMPANIES WILL BE REPLACED.</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

              <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true"/>
        @endslot
    </x-jet-form-section>
</x-app-layout>
