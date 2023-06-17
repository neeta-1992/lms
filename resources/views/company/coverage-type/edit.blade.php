<x-app-layout>
    <x-jet-form-section :buttonGroup="['logs','other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index') ]]]" class="validationForm editForm" novalidate action="{{ routeCheck($route . 'update', $id) }}"
        method="post">
        @slot('form')
            @method('put')
        <input type="hidden" name="logsArr">
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label requiredAsterisk">Coverage name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control input-sm  fw-600" name="name" id="name" required placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Account type</label>
            <div class="col-sm-9">
                <?=  form_dropdown('account_type', ['all'=>'All','commercial'=>'Commercial','personal'=>'Personal'], '', ["class"=>"w-100","required"=>true]); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Active</label>
            <div class="col-sm-9">
                <?=  form_dropdown('account_active',['yes'=>'Yes','no'=>'No'],'', ["class"=>"ui dropdown input-sm w-100","required"=>true]); ?>
            </div>
        </div>
        <div class="form-group row">
            <label for="state" class="col-sm-3 col-form-label requiredAsterisk">Cancel Term in Days</label>
            <div class="col-sm-9">
                <?=  form_dropdown('cancel_terms',['10'=>'10 Days','20'=>'20 Days','30'=>'30 Days','45'=>'45 Days'],'10', ["class"=>"ui dropdown input-sm w-100","required"=>true]); ?>
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
