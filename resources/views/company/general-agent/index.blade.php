<x-app-layout>
<section class="font-1 pt-5 hq-full">
    <div class="container">
        <div class="row justify-content-center" x-data="{ open: 'Action' }">
            <div class="col-lg-12">
               <h4>{{ dynamicPageTitle('page') ?? '' }}</h4>
                <div class="my-4"></div>
                <div class="row mb-2 align-items-center ">
                    <div class="col-lg-6">
                        <div class="ui selection dropdown table-head-dropdown">
                            <input type="hidden" /><i class="dropdown icon"></i>
                            <div class="text">{{ dynamicPageTitle('page') ?? '' }}</div>
                            <div class="menu">
                                <div class="item" @click="open = 'Action'">{{ dynamicPageTitle('page') ?? '' }}</div>
                                <div class="item" @click="open = 'Logs'">Logs</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div x-show="open == 'Action'">
                   
                        
                        <x-bootstrap-table  :data="[
                            
                            'cookieid'  =>true,
                            'sortorder' =>'desc',
                            'sortname'  =>'created_at',
                            'type'      =>'serverside',
                          
                            'ajaxUrl' => (Route::has($route.'index') ? route($route.'index') : ''),
                            'addUrl'    => (Route::has($route.'create') ? route($route.'create') : '')
                            ]">
                            <thead>
                                <tr>
                                    <th class="align-middle" data-sortable="true" data-width="400"
                                        data-field="name">Name</th>
                                    <th class="align-middle" data-sortable="true" data-width="300"
                                        data-field="email">Email</th>
                                    <th class="align-middle" data-sortable="true" data-width="200"
                                        data-field="telephone">Telephone</th>
                                    {{-- <th class="align-middle" data-sortable="true" data-width="100" data-field="status">
                                        Status</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                             
                            </tbody>
                        
                        </x-bootstrap-table>
                  
                </div>
             
                <div x-show="open == 'Logs'">

                    <div class="table-responsive-sm">
                        <x-bootstrap-table :data="[
                            'table'     =>'logs',
                            'cookieid'  =>true,
                            'sortorder' =>'desc',
                            'sortname'  =>'created_at',
                            'type'      =>'serversides',
                            
                            'ajaxUrl' => (Route::has('company.logs') ? route('company.logs',['type'=>'finance-company']) : ''),
                           'addUrl' => (Route::has($route.'create') ? route($route.'create') : '')
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
<!--/.section-->
</x-app-layout>