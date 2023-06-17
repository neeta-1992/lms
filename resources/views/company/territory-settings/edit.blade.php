<x-app-layout>
    <x-jet-form-section :buttonGroup="['logs','other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index') ]]]" class="validationForm editForm" novalidate action="{{ routeCheck($route . 'update', $id) }}"
        method="post">
        @slot('form')
            @method('put')
        <input type="hidden" name="logsArr">
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.territory_name")</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="name" id="name" required
                        placeholder="">
                </div>
            </div>

            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.assigned_states")</label>
                <div class="col-sm-9">
                    {!! form_dropdown('state[]', stateDropDown(['keyType'=>"id"]), '', ["class"=>"ui fluid normal dropdown input-sm",
                    'multiple'=>true]) !!}
                </div>
            </div>


           <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true"/>
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
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">Created Date
                        </th>

                        <th class="" data-sortable="true" data-field="username" data-width="200">
                            User Name
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
