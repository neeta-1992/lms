<x-app-layout :class="['codemirror']">

<x-jet-form-section :buttonGroup="['other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]"
         class="validationForm" novalidate action="{{ routeCheck($route.'store') }}" method="post">
       @slot('form')
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.name")</label>
                <div class="col-sm-9">
                     <x-jet-input type="text" name="name" id="name" required/>
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.description")</label>
                <div class="col-sm-9">
                     <x-jet-input type="text" name="description" id="description" required/>

                </div>
            </div>
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.send_to")</label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'send_to',
                        [
                            'Insured' => 'Insured',
                            'General_agent' => 'General Agent',
                            'Broker' => 'Broker',
                            'Insurance_company' => 'Insurance Company',
                            'Lienholder' => 'Lienholder',
                            'Sales_organizations' => 'Sales Organizations',
                            'Any' => 'Any',
                        ],
                        '',
                        ['class' => 'input-sm w-100', 'required' => true],
                    ) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.action")</label>
                <div class="col-sm-9">
                    {!! form_dropdown('action', actionNoticeTemplates(), '', [
                        'class' => 'ui dropdown input-sm w-100',
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.send_by")</label>
                <div class="col-sm-9">
                    {!! form_dropdown('send_by', ['fax' => 'Fax', 'email' => 'Email', 'mail' => 'Mail'], '', [
                        'class' => 'input-sm w-100',
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.template_type")</label>
                <div class="col-sm-9">
                    {!! form_dropdown('template_type', noticeTemplateType(), '', [
                        'class' => 'ui dropdown input-sm w-100',
                        'required' => true,
                    ]) !!}
                </div>
            </div>
          {{--   <div class="row cronBox d-none">
                <label for="subject" class="col-sm-3 col-form-label requiredAsterisk">Schedule</label>
                <div class="col-sm-9">
                    <div class="form-group row">
                        <div class="col-md-9 mb-1">
                            @php
                                $weekDropDown = weekDropDown();
                            @endphp
                            @if (!empty($weekDropDown))
                                @foreach ($weekDropDown as $key => $weekValue)
                                  <x-jet-checkbox for="schedule_days_{{ $key ?? '' }}" :labelText="$weekValue" name="schedule_days[]"  id="schedule_days_{{ $key ?? '' }}" value="{{ $key ?? '' }}" />
                                @endforeach
                            @endif

                        </div>
                        <div class="col-md-3">
                            <x-jet-input type="text" class="timePicker" name="schedule_time " id="schedule_time"  placeholder="Schedule Time"/>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="form-group row d-none">
                <label for="subject" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.subject")</label>
                <div class="col-sm-9">
                     <x-jet-input type="text" name="subject" id="subject" required/>
                </div>
            </div>
            <div class="form-group row">
                <label for="text" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.text")</label>
                <div class="col-sm-9">
                    <textarea name="template_text" id="text" class="form-control noticeCodemirrorEditor" required cols="30"
                        rows="3"></textarea>
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
             <x-button-group :cancel="routeCheck($route . 'index')"/>
        @endslot
    </x-jet-form-section>
</x-app-layout>
