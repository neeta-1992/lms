<x-app-layout>
    <x-jet-form-section :activePageName="$activePageName" :title="$title" :buttonGroup="['logs','other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index')]]]" class="validationForm editForm" novalidate action="{{ routeCheck($route . 'css') }}"  method="post">
        @slot('form')

            <input type="hidden" name="logsArr">

            <div class="form-group row">
                <label for="text" class="col-sm-3 col-form-label requiredAsterisk"> @lang("labels.css")</label>
                <div class="col-sm-9">
                    <textarea name="css" id="text" class="form-control css" required cols="30"  rows="15"> {{ $data->value ?? '' }}</textarea>
                </div>
            </div>


            <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true"/>


        @endslot
           @slot('logContent')
            <x-bootstrap-table :data="[
                'table'     => 'logs',
                'id'        => $activePageName.'-logs',
                'cookieid'  => true,
                'sortorder' => 'desc',
                'sortname'  => 'created_at',
                'type'      => 'serversides',
                'ajaxUrl' => routeCheck('company.logs',['type' =>$activePageName]) ,
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

