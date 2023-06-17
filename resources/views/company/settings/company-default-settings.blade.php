<x-app-layout>
    <x-jet-form-section :title="$pageTitle" :activePageName="$activePage" :buttonGroup="['logs', 'other' => [['text' => __('labels.cancel'), 'url' => routeCheck('company.settings.company-defaults')]]]" class="validationForm editForm" novalidate
        action="{{ routeCheck($route,[$id]) }}" method="post" x-data="{ FundingAddress : 'true' }">
        @slot('form')

            <input type="hidden" name="logsArr">
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.remittance_paid")</label>
                <div class="col-sm-3">

                    {!! form_dropdown(
                        'remittance_paid',
                        ['ACH per policy', 'ACH per statement', 'Check per policy', 'Check per statement'],
                        $data['remittance_paid'] ?? '',
                        ['class' => 'w-50 show_select_box', 'required' => true],
                        true,
                    ) !!}

                </div>
            </div>

            <div class="d-none remittance_paid_select_box">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.name_of_financial_institution")</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="financial_institution_name"  />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.bank_routing_number")</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="routing_number" class="onlyNumber"  />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.bank_account_number")</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="account_number" class="onlyNumber"/>
                    </div>
                </div>
            </div>
            <div class="form-group row ">
                <label for="" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.remittance_schedule")
                </label>
                <div class="col-sm-9">
                    <div class="zinput zradio zradio-sm pb-0">
                        <input id="Remittance_schedule_option_Days_After" name="remittance_schedule" type="radio" required
                            class="form-check-input" @checked(($data['remittance_schedule'] ?? '') == 'Days After Policy Inception') value="Days After Policy Inception">
                        <label for="Remittance_schedule_option_Days_After"
                            class="ingnorTitleCase form-check-label d-flex align-items-center">
                            <x-jet-input type="text" name="days_after_policy_inception_text"
                                style="width: 10% !important;" :value="$data['days_after_policy_inception_text'] ?? ''" />
                            <span class="pl-3">Days After Policy Inception</span>
                        </label>
                    </div>
                    <div class="zinput zradio  zradio-sm pb-0">
                        <input id="Remittance_schedule_option_Month" name="remittance_schedule" type="radio" required
                            class="form-check-input" @checked(($data['remittance_schedule'] ?? '') == '15 Days After the End of The Month of Policy Inception')
                            value="15 Days After the End of The Month of Policy Inception">
                        <label for="Remittance_schedule_option_Month"
                            class="ingnorTitleCase form-check-label d-flex align-items-center">
                            15 Days After the End of The Month of Policy Inception
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm pb-0">
                        <input id="Remittance_schedule_option_Policy" name="remittance_schedule" type="radio" required
                            class="form-check-input" @checked(($data['remittance_schedule'] ?? '') == 'Days After 1st Payment Due Date') value="Days After 1st Payment Due Date">
                        <label for="Remittance_schedule_option_Policy"
                            class="ingnorTitleCase form-check-label d-flex align-items-center">
                            <x-jet-input type="text" name="days_after_1st_payment_due_date_text"
                                style="width: 10% !important;" :value="$data['days_after_1st_payment_due_date_text'] ?? ''" />
                            <span class="pl-3">Days After 1st Payment Due Date</span>
                        </label>
                    </div>

                </div>
            </div>
             <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.compensation_paid_using")</label>
                <div class="col-sm-3">

                    {!! form_dropdown(
                        'compensation_pay_using',
                        ['ACH per policy', 'ACH per statement', 'Check per policy', 'Check per statement'],
                        $data['compensation_pay_using'] ?? '',
                        ['class' => 'w-50 show_select_box', 'required' => true],
                        true,
                    ) !!}

                </div>
            </div>
             <div class="d-none compensation_pay_using_select_box">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.name_of_financial_institution")</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="compensation_financial_institution_name" :value="$data['financial_institution_name'] ?? ''" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.bank_routing_number")</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="compensation_routing_number" class="onlyNumber" :value="$data['routing_number'] ?? ''" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.bank_account_number")</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="compensation_account_number" class="onlyNumber" :value="$data['account_number'] ?? ''" />
                    </div>
                </div>
            </div>
            <div class="form-group row ">
                <label for="" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.compensation_remittance_schedule")
                </label>
                <div class="col-sm-9">
                    <div class="zinput zradio zradio-sm pb-0">
                        <input id="compensation_Remittance_schedule_option_Days_After" name="compensation_remittance_schedule" type="radio" required
                            class="form-check-input" @checked(($data['compensation_remittance_schedule'] ?? '') == 'Days After Policy Inception') value="Days After Policy Inception">
                        <label for="compensation_Remittance_schedule_option_Days_After"
                            class="ingnorTitleCase form-check-label d-flex align-items-center">
                            <x-jet-input type="text" name="compensation_days_after_policy_inception_text"
                                style="width: 10% !important;" :value="$data['compensation_days_after_policy_inception_text'] ?? ''" />
                            <span class="pl-3">Days After Policy Inception</span>
                        </label>
                    </div>
                    <div class="zinput zradio  zradio-sm pb-0">
                        <input id="compensation_Remittance_schedule_option_Month" name="compensation_remittance_schedule" type="radio" required
                            class="form-check-input" @checked(($data['compensation_remittance_schedule'] ?? '') == '15 Days After the End of The Month of Policy Inception')
                            value="15 Days After the End of The Month of Policy Inception">
                        <label for="compensation_Remittance_schedule_option_Month"
                            class="ingnorTitleCase form-check-label d-flex align-items-center">
                            15 Days After the End of The Month of Policy Inception
                        </label>
                    </div>
                    <div class="zinput zradio zradio-sm pb-0">
                        <input id="compensation_Remittance_schedule_option_Policy" name="compensation_remittance_schedule" type="radio" required
                            class="form-check-input" @checked(($data['compensation_remittance_schedule'] ?? '') == 'Days After 1st Payment Due Date') value="Days After 1st Payment Due Date">
                        <label for="compensation_Remittance_schedule_option_Policy"
                            class="ingnorTitleCase form-check-label d-flex align-items-center">
                            <x-jet-input type="text" name="compensation_days_after_1st_payment_due_date_text"
                                style="width: 10% !important;" :value="$data['compensation_days_after_1st_payment_due_date_text'] ?? ''" />
                            <span class="pl-3">Days After 1st Payment Due Date</span>
                        </label>
                    </div>

                </div>
            </div>


            <div class="form-group row">
                <label for="license_state" class="col-sm-3 col-form-label ">@lang("labels.adjust_uneamed_compensation_close")</label>
                <div class="col-sm-9">
                    <x-jet-checkbox for="uneamed_compensation"
                        labelText='' class="" name="uneamed_compensation"
                        id="uneamed_compensation" value="uneamed_compensation_on_close" />
                </div>
            </div>
             <div class="form-group row">
                <label for="products_paid_using" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.setup_fee_add_products_paid_using")</label>
                <div class="col-sm-3">

                    {!! form_dropdown(
                        'products_paid_using',
                        ['ACH per policy', 'ACH per statement', 'Check per policy', 'Check per statement'],
                        $data['remittance_paid'] ?? '',
                        ['class' => 'w-50 show_select_box', 'required' => true],
                        true,
                    ) !!}

                </div>
            </div>
             <div class="d-none products_paid_using_select_box">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.name_of_financial_institution")</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="products_financial_institution_name" :value="$data['financial_institution_name'] ?? ''" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.bank_routing_number")</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="products_routing_number" class="onlyNumber" :value="$data['routing_number'] ?? ''" />
                    </div>
                </div>
                <div class="form-group row">
                    <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.bank_account_number")</label>
                    <div class="col-sm-9">
                        <x-jet-input type="text" name="products_account_number" class="onlyNumber" :value="$data['account_number'] ?? ''" />
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="license_state" class="col-sm-3 col-form-label ">Funding Address</label>
                <div class="col-sm-9">
                    <x-jet-checkbox for="funding_address_checkbox"
                        @change="FundingAddress = $event.target.checked ? true : '';" :checked="($data['funding_address_checkbox'] ?? 1) == 1 ? true : false"
                        labelText='Same as Mailing Address' class="changesetup setup_fees" name="funding_address_checkbox"
                        id="funding_address_checkbox" value="true" />
                </div>
            </div>
            <div class="row" x-show="FundingAddress == false">
                <label for="primary_address" class="col-sm-3 col-form-label "></label>
                <div class="col-sm-9">
                    <div class="form-group row">
                        <div class="col-md-12 mb-1">
                            <div class="form-group">
                                <x-jet-input type="text" name="funding_address"  />

                            </div>
                        </div>
                        <div class="col-md-12 mb-1">
                            <div class="form-group">
                                <x-jet-input type="text" name="funding_address_second" />

                            </div>
                        </div>
                        <div class="col-md-6">
                            <x-jet-input type="text" name="funding_city" placeholder="City" />
                        </div>
                        <div class="col-md-4">
                            {!! form_dropdown('funding_state', stateDropDown(), $data['funding_state'] ?? '', [
                                'class' => 'ui dropdown input-sm   w-100',

                            ]) !!}
                        </div>
                        <div class="col-md-2">
                            <x-jet-input type="text" name="funding_zip" placeholder="Zip" class="zip_mask"/>

                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label for="hold_all_payables" class="col-sm-3 col-form-label ">Hold All Payables</label>
                <div class="col-sm-9">
                     <x-jet-checkbox for="hold_all_payables"
                        labelText='' class="changesetup setup_fees" name="hold_all_payables"
                        id="hold_all_payables" value="true" />

                </div>
            </div>

              <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.default_refund_send_check_to")</label>
                <div class="col-sm-3">

                    {!! form_dropdown(
                        'refund_check_to',
                        ['Agent', 'Insured'],"",
                        ['class' => 'w-50', 'required' => true],
                        true,
                    ) !!}

                </div>
            </div>
              <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang("labels.default_refund_make_check_payable_to")</label>
                <div class="col-sm-3">

                    {!! form_dropdown(
                        'refund_check_payable',
                        ['Agent', 'Insured'],"",
                        ['class' => 'w-50', 'required' => true,'id'=>'refund_check_payable'],
                        true,
                    ) !!}

                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>GL Accounts</th>
                                    <th>Default Bank Account</th>
                                    <th>Details</th>

                                </tr>
                            </thead>
                            <tbody>



                                <tr>
                                    <td class="align-top" style="width: 255px; ">Deposit - Default:</td>
                                    <td class="align-top" style="width: 300px; ">
                                        <div class="form-group ">
                                            {!! form_dropdown('deposit_default', $bankData, $data['deposit_default'] ?? '', [
                                                'class' => 'w-100',
                                            ]) !!}</div>
                                    </td>
                                    <td class="align-top" rowspan="3">
                                        <div>The bank accounts specified here are used as the defaults on the following
                                            screens:</div>
                                        <ul>
                                            <li>Enter Payment,</li>
                                            <li>Enter Instant Payment,</li>
                                            <li>Enter Down Payment, and</li>
                                            <li>Enter Return Premium.</li>
                                        </ul>
                                    </td>

                                </tr>
                                <tr class="border-0">
                                    <td class="align-top" style="width: 255px; ">Deposit - Credit Card:</td>
                                    <td class="align-top" style="width: 300px; ">
                                        <div class="form-group ">
                                            {!! form_dropdown('deposit_credit_card', $bankData, $data['deposit_credit_card'] ?? '', [
                                                'class' => 'w-100',
                                            ]) !!}</div>
                                    </td>


                                </tr>

                                <tr class="border-0">
                                    <td class="align-top" style="width: 255px; ">Deposit - eCheck:</td>
                                    <td class="align-top" style="width: 300px; ">
                                        <div class="form-group ">
                                            {!! form_dropdown('deposit_eCheck', $bankData, $data['deposit_eCheck'] ?? '', [
                                                'class' => 'w-100',
                                            ]) !!}</div>
                                    </td>


                                </tr>




                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <x-button-group :cancel="routeCheck('company.settings.company-defaults')"/>
        @endslot

        @slot('logContent')
            <x-bootstrap-table :data="[
                'table' => 'logs',
                'cookieid' => true,
                'id' => $activePage . '-logs',
                'sortorder' => 'desc',
                'sortname' => 'created_at',
                'type' => 'serversides',
                'ajaxUrl' => routeCheck('company.logs', ['type' => $logActivePage]),
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
