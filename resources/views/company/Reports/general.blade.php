<x-app-layout>
    <section class="font-1 pt-5 hq-full">
        <div class="container">
            <div class="row justify-content-center" x-data="{ open: 'Action' }">
                <div class="col-lg-12">
                    <h4>
                        <h4>{{ $pageTitle ?? dynamicPageTitle('page') ?? '' }}</h4>
                    </h4>
                  
                    
                    <div x-show="open == 'Action'">
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
                                        <th class="align-middle" data-sortable="false" data-width="170"
                                            data-field="created_at">General Ledger Name </th>
                                        <th class="align-middle" data-sortable="false" data-width="170"
                                            data-field="updated_at">Number</th>
                                        <th class="align-middle" data-sortable="false" data-width="660" data-field="name">Debit</th>
                                        <th class="align-middle" data-sortable="false" data-width="100" data-field="account_type">Credit</th>
                                       
                                        
                                    </tr>
                                </thead>
                            </x-bootstrap-table>
                        </div>
                    </div>
                    <div x-show="open == 'Logs'">
                    
                        <div class="table-responsive-sm">
                            <x-bootstrap-table :data="[
                                            'table'     =>'logs',
                                            'cookieid'  =>true,
                                            'sortorder' =>'desc',
                                            'sortname'  =>'created_at',
                                            'type'      =>'serversides',
                                            'currentUrl'=>'coverageType',
                                            'ajaxUrl'   => (Route::has('company.logs') ? route('company.logs',['type'=>'coverage-type']) : ''),
                                            'addUrl'    => (Route::has($route.'create') ? route($route.'create') : '')
                                            ]">
                    
                                <thead>
                                    <tr>
                                                       <th class="" data-sortable="true" data-field="created_at" data-width="170">Created Date</th>
                    
                    
                                        <th class="" data-sortable="true" data-field="username" data-width="200">User Name
                                        </th>
                                        <th class="" data-sortable="true" data-field="message">Description</th>
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
    
    
    