<x-app-layout>
    <x-jet-form-section :title="$pageTitle" :buttonGroup="['logs','other' => [['text' => __('labels.exit'), 'url' => routeCheck($route . 'index')]]]" class="validationForm" novalidate action="{{ routeCheck($route . 'store') }}" method="post">
        @slot('form')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 js-content">
                <div class="docs-table nothover Account_Status_Settings">
                    <table id="account_status_settings" data-toggle="table" data-icons-prefix="fa-thin" data-loading-template="loadingTemplate" data-show-header="false" data-buttons="buttons" data-buttons-class="default borderless" data-show-button-text="1" class="table table-bordered table-hover">
                      <thead>
							<tr class="d-none">
								<th data-field="title"></th>
							</tr>
						</thead>
                        <tbody>
                            <tr>
                                <td class="center text-dark bg-light font-weight-bold">Account Current</td>
                            </tr>
                            <tr>
                                <td class="">Accounts in this status are new (less than 24 hours), current, and
                                    overdue by less than the number of days to Intent to Cancel.</td>
                            </tr>
                            <tr>
                                <td class="center"><i class="fa-solid fa-arrow-down arrowicons fa-2x"></i></td>
                            </tr>
                            <tr>
                                <td class="center text-dark bg-light font-weight-bold"><a data-turbolinks="false" href="{{ routeCheck('company.account-status-settings.account-status-settings-tab', ['stateId' => $id, 'tab' => 'intent-to-cancel']) }}">Intent
                                        to Cancel</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="">Accounts in this status are overdue by a specified number of days,
                                    have a balance due from the insured that causes cancellation, and have had the
                                    Intent to Cancel notice sent.</td>
                            </tr>
                            <tr>
                                <td class="center"><i class="fa-solid fa-arrow-down arrowicons fa-2x"></i></td>
                            </tr>
                            <tr>
                                 <td class="center text-dark bg-light font-weight-bold"><a data-turbolinks="false" href="{{ routeCheck('company.account-status-settings.account-status-settings-tab', ['stateId' => $id, 'tab' => 'cancel']) }}">Cancel</a>
                                </td>

                            </tr>
                            <tr>
                                <td class="">Accounts in this status have had the Cancellation notice sent</td>
                            </tr>
                            <tr>
                                <td class="center"><i class="fa-solid fa-arrow-down arrowicons fa-2x"></i></td>
                            </tr>
                            <tr>
                                  <td class="center text-dark bg-light font-weight-bold"><a data-turbolinks="false" href="{{ routeCheck('company.account-status-settings.account-status-settings-tab', ['stateId' => $id, 'tab' => 'cancel-1']) }}">Cancel 1</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="">Accounts in this status have had return premiums applied to each
                                    policy and have had the Cancel 1 notice sent.
                                </td>
                            </tr>
                            <tr>
                                <td class="center "><i class="fa-solid fa-arrow-down arrowicons fa-2x"></i></td>
                            </tr>
                            <tr>
                                  <td class="center text-dark bg-light font-weight-bold"><a data-turbolinks="false" href="{{ routeCheck('company.account-status-settings.account-status-settings-tab', ['stateId' => $id, 'tab' => 'cancel-2']) }}">Cancel 2</a>
                                </td>

                            </tr>
                            <tr>
                                <td class="">Accounts in this status have had the Cancel 2 notice sent.</td>
                            </tr>
                            <tr>
                                <td class="center "><i class="fa-solid fa-arrow-down arrowicons fa-2x"></i></td>
                            </tr>
                            <tr>
                                  <td class="center text-dark bg-light font-weight-bold"><a data-turbolinks="false" href="{{ routeCheck('company.account-status-settings.account-status-settings-tab', ['stateId' => $id, 'tab' => 'collection']) }}">Collection</a>
                                </td>

                            </tr>
                            <tr>
                                <td class="">Accounts in this status have been sent to collection and the
                                    Collection notice has been sent.
                                </td>
                            </tr>
                            <tr>
                                <td class="center"><i class="fa-solid fa-arrow-down arrowicons fa-2x"></i></td>
                            </tr>
                            <tr>
                                 <td class="center text-dark bg-light font-weight-bold"><a data-turbolinks="false" href="{{ routeCheck('company.account-status-settings.account-status-settings-tab', ['stateId' => $id, 'tab' => 'closed']) }}">Closed</a>
                                </td>

                            </tr>
                            <tr>
                                <td class="">Accounts in this status are closed and have a zero balance.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
</x-app-layout>
