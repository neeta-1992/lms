<x-app-layout :class="['codemirror', 'datepicker']">
    <x-jet-form-section :buttonGroup="['logs', 'other' => [['text' => 'Preview', 'class' => 'templatePreview'],['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index') ]]]" class="validationForm editForm" novalidate
        action="{{ routeCheck($route . 'update', $id) }}" method="post">

        @slot('form')
            @method('put')
            <input type="hidden" name="logsArr">

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
                <div class="col-sm-3">
                    {!! form_dropdown('status', [1 => 'Enable', 0 => 'Disable'], '', [
                        'class' => 'ui dropdown input-sm  w-25',
                        'required' => true,
                        'id' => 'status',
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.user_type')</label>
                <div class="col-sm-3">
                    {!! form_dropdown('user_type', userType(), '', ['class' => '', 'required' => true]) !!}
                </div>
            </div>
            @php
                $from_to_date = changeDateFormat($data['from_date']) . ' - ' . changeDateFormat($data['to_date']);
                $data['from_to_date'] = $from_to_date;
            @endphp
            <div class="form-group row">
                <label for="from_to_date" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.from_to')</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control input-sm daterangepickers"  data-time-picker="true" required name="from_to_date"
                        id="from_to_date" placeholder="">
                </div>
            </div>
            <div class="form-group row">
                <label for="body" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.body')</label>
                <div class="col-sm-9">
                    <textarea name="body" id="body" required class="form-control homePageMesageCodemirrorEditor templateEditor"
                        required cols="30" rows="3"></textarea>
                </div>
            </div>

            <x-slot name="saveOrCancelDelete"></x-slot>
            <div class="remodal remodal-lg" data-remodal-id="templatePreviewModel">
                <button class="remodal-close" data-remodal-action="close"></button>
                <iframe id="templatePreview" allowfullscreen="true" class="w-100 border-0 " height="400"></iframe>
            </div>
        @endslot

        @slot('logContent')
            <x-bootstrap-table :data="[
                'table' => 'logs',
                'cookieid' => true,
                'sortorder' => 'desc',
                'sortname' => 'created_at',
                'type' => 'serversides',
                'ajaxUrl' => routeCheck('company.logs', ['type' => activePageName(), 'id' => $id]),
            ]">
                <thead>
                    <tr>
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">@lang('labels.created_date')
                        </th>

                        <th class="" data-sortable="true" data-field="username" data-width="200">@lang('labels.user_name')
                        </th>
                        <th class="" data-sortable="true" data-field="message">@lang('labels.description')</th>
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
