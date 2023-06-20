<x-app-layout :class="['codemirror']">
    <x-jet-form-section :buttonGroup="['logs', 'other' => [['text' => 'Preview', 'class' => 'templatePreview'],['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index') ]]]" class="validationForm editForm" novalidate
        action="{{ routeCheck($route . 'update', $id) }}" method="post">

        @slot('form')
            @method('put')
            <input type="hidden" name="logsArr">

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk"> @lang('labels.name')</label>
                <div class="col-sm-9">
                     <x-jet-input type="text" class="fw-600" name="name" id="name" required />
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('status', [1 => 'Enable', 0 => 'Disable'], '', [
                        'class' => 'ui dropdown input-sm w-100',
                        'required' => true,
                    ]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label requiredAsterisk"> @lang('labels.description')</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" class="form-control" required cols="30" rows="3"></textarea>

                </div>
            </div>
            <div class="form-group row">
                <label for="template" class="col-sm-3 col-form-label requiredAsterisk"> @lang('labels.text')</label>
                <div class="col-sm-9">
                    <textarea name="template" id="template" class="form-control financeAgreementCodemirrorEditor templateEditor" required
                        cols="30" rows="3"></textarea>

                </div>
            </div>




            <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true"/>
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
