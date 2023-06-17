<x-app-layout :class="['codemirror']">
    <x-jet-form-section :activePageName="$activePageName" :title="$title" :buttonGroup="['logs','other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index')]]]" class="validationForm editForm" novalidate action="{{ routeCheck($route . 'header-footer',['type'=>$type]) }}"  method="post">
        @slot('form')

            <input type="hidden" name="logsArr">

            <div class="form-group row">
                <label for="text" class="col-sm-3 col-form-label requiredAsterisk"> @lang("labels.header")</label>
                <div class="col-sm-9">
                    <textarea name="header" id="header" class="form-control headernoticeCodemirrorEditor " required cols="30"  rows="15"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="text" class="col-sm-3 col-form-label requiredAsterisk"> @lang("labels.footer")</label>
                 
                <div class="col-sm-9">
                    <textarea name="footer" id="footer" class="form-control footernoticeCodemirrorEditor " required cols="30"  rows="15"> </textarea>
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
            <x-button-group :cancel="routeCheck($route . 'index')" />


        @endslot
           @slot('logContent')
            <x-bootstrap-table :data="[
                'table'     => 'logs',
                'id'        => $activePageName.'-logs',
                'cookieid'  => true,
                'sortorder' => 'desc',
                'sortname'  => 'created_at',
                'type'      => 'serversides',
                'ajaxUrl' => routeCheck('admin.logs',['type' =>$activePageName]) ,
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
            let editArr = @json($editData ?? []);
        </script>
    @endpush
</x-app-layout>

