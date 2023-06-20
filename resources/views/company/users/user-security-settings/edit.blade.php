<x-app-layout>
    <x-jet-form-section :buttonGroup="['logs','other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index') ]]]" class="validationForm editForm" novalidate action="{{ routeCheck($route . 'update', $id) }}"
        method="post">
        @slot('form')
            @method('put')
        <input type="hidden" name="logsArr">

             <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
                <div class="col-sm-3">
                   {!! form_dropdown('status',[1=>'Enable',0=>'Disable'],'', ["class"=>"","required"=>true]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="bank_name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.bank_name')  </label>
                <div class="col-sm-9">
                    <x-jet-input type="text" name="bank_name" required />
                </div>
            </div>
            <div class="form-group row">
                <label for="account_number" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.account_number') </label>
                <div class="col-sm-9">
                   <x-jet-input type="text" name="account_number" required />

                </div>
            </div>
            <div class="form-group row">
                <label for="gl_account" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.gl_account')</label>
               <div class="col-sm-9">
                   {!! form_dropdown('gl_account',glAccountDropDown(['onDB'=>true,'select'=>'number']),'', ["class"=>"","required"=>true]) !!}
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
                        <th class="" data-sortable="true" data-field="created_at" data-width="170">@lang('labels.created_date')
                        </th>

                        <th class="" data-sortable="true" data-field="username" data-width="200">
                          @lang('labels.user_name')
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
