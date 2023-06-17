<x-app-layout>
    <section class="font-1 pt-5 hq-full">
        <div class="container">
            <div class="row justify-content-center" x-data="{ open: 'request_activation' }">
                <div class="col-lg-12">
                    <h4>{{ $pageTitle ?? dynamicPageTitle('page') ?? '' }}</h4>
                    <div class="my-4"></div>
                    <div class="row mb-2 align-items-center ">
                        <div class="col-lg-6">
                            <div class="ui selection dropdown table-head-dropdown">
                                <input type="hidden" /><i class="dropdown icon"></i>
                                <div class="text">Request for Activation</div>
                                <div class="menu">
                                    <div class="item" @click="open = 'request_activation'">Request for Activation</div>
                                    <div class="item" @click="open = 'in_process_request'">In-Process Request</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div x-show="open == 'request_activation'">
                        <div class="table-responsive-sm">
                            <x-bootstrap-table :data="[
                           
                            'cookieid'  =>true,
                            'sortorder' =>'desc',
                            'sortname'  =>'created_at',
                            'type'      =>'serverside',
                            'currentUrl'=>'coverageType',
                            'ajaxUrl'   => (Route::has($route.'index') ? route($route.'index') : ''),
                            'addUrl'    => (Route::has($route.'create') ? route($route.'create') : '')
                            ]">
                                <thead>
                                    <tr>
                                        <th class="align-middle" data-sortable="false" data-width=""
                                            data-field="created_at">Created Date</th>
                                        <th class="align-middle" data-sortable="false" data-width=""
                                            data-field="updated_at">Last Update Date</th>
                                        <th class="align-middle" data-sortable="false" data-field="name">Created By</th>
                                        <th class="align-middle" data-sortable="false" data-field="account_type">Insured
                                            Name</th>
                                        <th class="align-middle" data-sortable="false" data-field="account_active">
                                            Agency Name</th>
                                            <th class="align-middle" data-sortable="false" data-field="account_active">
                                                Premium</th>
                                        <th class="align-middle" data-sortable="false" data-field="account_active">
                                            Down Payment</th>
                                        <th class="align-middle" data-sortable="false" data-field="account_active">
                                            Total</th>
                                       

                                    </tr>
                                </thead>
                            </x-bootstrap-table>
                        </div>
                    </div>
                    <div x-show="open == 'in_process_request'">

                        <div class="table-responsive-sm">
                            <x-bootstrap-table :data="[
                                                   
                                                    'cookieid'  =>true,
                                                    'sortorder' =>'desc',
                                                    'sortname'  =>'created_at',
                                                    'type'      =>'serverside',
                                                    'currentUrl'=>'coverageType',
                                                    'ajaxUrl'   => (Route::has($route.'index') ? route($route.'index') : ''),
                                                    'addUrl'    => (Route::has($route.'create') ? route($route.'create') : '')
                                                    ]">
                                <thead>
                                    <tr>
                                      <th class="align-middle" data-sortable="false" data-width="" data-field="created_at">Created Date</th>
                                    <th class="align-middle" data-sortable="false" data-width="" data-field="updated_at">Last Update Date</th>
                                    <th class="align-middle" data-sortable="false" data-field="name">Created By</th>
                                    <th class="align-middle" data-sortable="false" data-field="account_type">Insured
                                        Name</th>
                                    <th class="align-middle" data-sortable="false" data-field="account_active">
                                        Agency Name</th>
                                    <th class="align-middle" data-sortable="false" data-field="account_active">
                                        Premium</th>
                                    <th class="align-middle" data-sortable="false" data-field="account_active">
                                        Down Payment</th>
                                    <th class="align-middle" data-sortable="false" data-field="account_active">
                                        Total</th>

                                    </tr>
                                </thead>
                            </x-bootstrap-table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>