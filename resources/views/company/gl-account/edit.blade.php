<x-app-layout>
    <x-jet-form-section :buttonGroup="['logs','other' => [['text' => __('text.cancel'), 'url' => routeCheck($route . 'index') ]]]" class="validationForm editForm" novalidate
        action="{{ routeCheck($route . 'update', $id) }}" method="post">

        @slot('form')
            @method('put')
            <input type="hidden" name="logsArr">
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">GL Account
                    Name</label>
                <div class="col-sm-9">
                    <x-jet-input type="text" class="" name="name" required disabled/>

                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-sm-3 col-form-label requiredAsterisk">Status</label>
                <div class="col-sm-9">
                   {!! form_dropdown('status',[1=>'Enable',0=>'Disable'],'', ["class"=>"ui dropdown input-sm w-100","required"=>true]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="number" class="col-sm-3 col-form-label requiredAsterisk">GL Account #</label>
                <div class="col-sm-9">
                     <x-jet-input type="text"  name="number" required/>
                </div>
            </div>
            <div class="form-group row">
                <label for="notes" class="col-sm-3 col-form-label "> Notes</label>
                <div class="col-sm-9">
                    <textarea name="notes" id="notes" class="form-control"  cols="30"
                        rows="3"></textarea>
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
