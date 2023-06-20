<x-app-layout :class="['datepicker']">
    <x-jet-form-section :buttonGroup="['logs', 'other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index')]]]" class="validationForm editForm" novalidate
        action="{{ routeCheck($route . 'update', $id) }}" method="post">
        @slot('form')
            @method('put')
            <input type="hidden" name="logsArr">

            <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label requiredAsterisk"> @lang("labels.name")</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control input-sm" name="name" id="name" required
                                    placeholder="">
                            </div>
                        </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.status")</label>
                <div class="col-sm-4">
                    {!! form_dropdown('status',[1=>'Enable',0=>'Disable'],'', ["class"=>"disabled
                    w-100","required"=>true]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label ">@lang("labels.description")</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" class="form-control"  cols="30" rows="3"></textarea>
                </div>
            </div>

                 <x-slot name="saveOrCancelDelete"></x-slot>



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
