<x-app-layout>
    <section class="font-1 pt-5 hq-full">
        <div class="container">
            <div class="row justify-content-center" x-data="{ open: 'Action' }">
                <div class="col-lg-12">
                    <h4>
                        <h4>{{ $pageTitle ?? (dynamicPageTitle('page') ?? '') }}</h4>
                    </h4>


                    <div x-show="open == 'Action'">
                        <div class="table-responsive-sm">
                            <x-bootstrap-table :data="[
                                'cookieid' => true,
                                'sortorder' => 'desc',
                                'sortname' => 'created_at',
                                'type' => 'serverside',
                                'currentUrl' => 'coverageType',
                                'ajaxUrl' => Route::has($route . 'index') ? route($route . 'index') : '',
                                'addUrl' => Route::has($route . 'create') ? route($route . 'create') : '',
                            ]">
                                <thead>
                                    <tr>
                                        <th class="align-middle" data-sortable="false" data-width="170"
                                            data-field="created_at">@lang('labels.due_date') </th>
                                        <th class="align-middle" data-sortable="false" data-width="170"
                                            data-field="updated_at">@lang('labels.account')</th>
                                        <th class="align-middle" data-sortable="false" data-width="660"
                                            data-field="name"> @lang('labels.amount_due')</th>
                                        <th class="align-middle" data-sortable="false" data-width="100"
                                            data-field="account_type">@lang('labels.installment')</th>
                                        <th class="align-middle" data-sortable="false" data-width="100"
                                            data-field="account_type">@lang('labels.late_fee')</th>
                                        <th class="align-middle" data-sortable="false" data-width="100"
                                            data-field="account_type">@lang('labels.cancel_fee') </th>
                                        <th class="align-middle" data-sortable="false" data-width="100"
                                            data-field="account_type">@lang('labels.nsf_fee') </th>
                                        <th class="align-middle" data-sortable="false" data-width="100"
                                            data-field="account_type">@lang('labels.convenience_fee') </th>

                                    </tr>
                                </thead>
                            </x-bootstrap-table>
                        </div>
                    </div>
                    <div x-show="open == 'Logs'">

                        <div class="table-responsive-sm">
                            <x-bootstrap-table :data="[
                                'table' => 'logs',
                                'cookieid' => true,
                                'sortorder' => 'desc',
                                'sortname' => 'created_at',
                                'type' => 'serversides',
                                'currentUrl' => 'coverageType',
                                'ajaxUrl' => Route::has('company.logs')
                                    ? route('company.logs', ['type' => 'coverage-type'])
                                    : '',
                                'addUrl' => Route::has($route . 'create') ? route($route . 'create') : '',
                            ]">

                                <thead>
                                    <tr>
                                        <th class="" data-sortable="true" data-field="created_at"
                                            data-width="170">@lang('labels.created_date') </th>


                                        <th class="" data-sortable="true" data-field="username" data-width="200">
                                            @lang('labels.user_name')
                                        </th>
                                        <th class="" data-sortable="true" data-field="message">@lang('labels.description')
                                        </th>
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
