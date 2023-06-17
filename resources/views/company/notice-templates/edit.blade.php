<x-app-layout :class="['codemirror']">
    <x-jet-form-section :buttonGroup="['logs','other' => [['text' => 'Preview', 'class' => 'templatePreview'],['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index') ]]]" class="validationForm editForm" novalidate action="{{ routeCheck($route . 'update', $id) }}"  method="post">
        @slot('form')
        @method('put')
        <input type="hidden" name="id" value="{{ $id ?? '' }}">
            <input type="hidden" name="logsArr">
             <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label requiredAsterisk">Status</label>
                <div class="col-sm-9">
                   {!! form_dropdown('status',["1"=>'Enable',"0"=>'Disable'],'', ["class"=>"ui dropdown input-sm
                w-100","required"=>true]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk"> Name</label>
                <div class="col-sm-9">
                     <x-jet-input type="text" name="name" id="name" required/>
                </div>
            </div>
             <div class="form-group row">
                <label for="id" class="col-sm-3 col-form-label">Notice ID</label>
                <div class="col-sm-9">
                     <x-jet-input type="text" name="notice_id" id="id" :value="$data['id']" disabled/>
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label requiredAsterisk"> Description</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="description" id="description" required/>
                </div>
            </div>
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Send To</label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'send_to',
                        [
                            'Insured' => 'Insured',
                              'Agent' => 'Agent',
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
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Action</label>
                <div class="col-sm-9">
                    {!! form_dropdown('action', actionNoticeTemplates(), '', [
                        'class' => 'ui dropdown input-sm w-100',
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Send By</label>
                <div class="col-sm-9">
                    {!! form_dropdown('send_by', ['fax' => 'Fax', 'email' => 'Email', 'mail' => 'Mail'], '', [
                        'class' => 'input-sm w-100',
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Template Type</label>
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
                <label for="subject" class="col-sm-3 col-form-label requiredAsterisk">Subject</label>
                <div class="col-sm-9">
                     <x-jet-input type="text" name="subject" id="subject" required/>
                </div>
            </div>
            <div class="form-group row">
                <label for="text" class="col-sm-3 col-form-label requiredAsterisk"> Text</label>
                <div class="col-sm-9">
                    <textarea name="template_text" id="text" class="form-control noticeCodemirrorEditor templateEditor" required cols="30"
                        rows="3"></textarea>
                </div>
            </div>


            <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true"/>

           <div class="remodal remodal-lg" data-remodal-id="templatePreviewModel">
                <button class="remodal-close" data-remodal-action="close"></button>
                <iframe id="templatePreview" allowfullscreen="true" class="w-100 border-0 "  height="400">
                </iframe>
            </div>
        @endslot

        @slot('logContent')
            <x-bootstrap-table :data="[
                'table'     => 'logs',
                'cookieid'  => true,
                'sortorder' => 'desc',
                'sortname'  => 'created_at',
                'type'      => 'serversides',
                'ajaxUrl' => routeCheck('company.logs',['type' =>activePageName(),'id'=>$id]) ,
            ]">
                <thead>
                    <tr>
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">Created Date
                        </th>

                        <th class="" data-sortable="true" data-field="username" data-width="200">User Name
                        </th>
                        <th class="" data-sortable="true" data-field="message">Description</th>
                    </tr>
                </thead>
            </x-bootstrap-table>
        @endslot


    </x-jet-form-section>
    @push('page_script')

        <script>
            let editArr = @json($data ?? []);
        </script>
    @endpush
</x-app-layout>

