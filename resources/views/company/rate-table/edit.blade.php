<x-app-layout>
    @push('common_style')
        <style>
            .addRateTable {
                table-layout: fixed;
            }

            .addRateTable tr th {
                padding: 0.75rem !important;
            }

            .addRateTable tr th,
            .addRateTable tr td {
                vertical-align: middle !important;
            }

            .addRateTable tr th:nth-child(1) {
                width: 40px;
            }

            .addRateTable tr th:nth-child(4) {
                width: 100px;
            }

            .addRateTableSetupfee {
                width: 410px;
            }

            .addRateTableSetupfee label {
                margin: 0px 0px 0px 0px !important;
            }

            .addRateTableSetupfee .zinput label::before {
                left: 9px !important;
            }

            .addRateTableSetupfee .zinput svg {
                left: 17px !important;
                top: 60% !important;
            }
        </style>
    @endpush
    <x-jet-form-section :buttonGroup="[
        'logs',
        'other' => [
            ['text' => 'Assign to Agents', 'url' => routeCheck($route . 'assignToAgents', $id)],
            ['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index')],
        ],
    ]" class="validationForm editForm" novalidate
        action="{{ routeCheck($route . 'update', $id) }}" method="post">
        @slot('form')
            @method('put')
            <input type="hidden" name="logsArr">
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.name') </label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control input-sm" id="name" placeholder="" required>
                </div>
            </div>

            <div class="form-group row">
                <label for="type" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.rate_table_type') </label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'type',
                        rateTableTypeDropDown(),
                        [],
                        [
                            'class' => 'ui fluid normal dropdown input-sm',
                            'required' => true,
                        ],
                    ) !!}


                </div>
            </div>
            <div class="form-group row">
                <label for="account_type" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.account_types') </label>
                <div class="col-sm-9">
                    {!! form_dropdown(
                        'account_type',
                        rateTableAccountType(),
                        [],
                        [
                            'class' => 'ui fluid normal dropdown input-sm',
                            'required' => true,
                        ],
                    ) !!}

                </div>
            </div>
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.state') </label>
                <div class="col-sm-9">
                    {!! form_dropdown('state', stateDropDown(['addKey' => ['All' => 'All States']]), '', [
                        'class' => 'ui dropdown w-100',
                        'required' => true,
                    ]) !!}


                </div>
            </div>
            <div class="form-group row">
                <label for="coverage_type" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.coverage_type') </label>
                <div class="col-sm-9">
                    {!! form_dropdown('coverage_type', coverageTypeDropDown(['addOption' => ['0' => 'All']]), '', [
                        'class' => 'ui dropdown input-sm w-100',
                        'required' => true,
                    ]) !!}


                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label ">@lang('labels.description')</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" cols="30" class="form-control" rows="3"
                        placeholder="{{ __('Rule of 78 (Fixed rate) This is company wide default rate') }}"></textarea>
                </div>
            </div>

            <div class="row ">

                <div class="col-md-12 page_table_menu">
                    <div class="row align-items-end">
                        <div class="col-md-12">
                            <div class="row align-items-end">
                                <div class="col-md-12">
                                    <div class="columns d-flex justify-content-end ">
                                        <button class="btn btn-default borderless deleteRowTableFee" type="button"
                                            name="Delete Range">Delete Range</button>
                                        <button class="btn btn-default borderless addRowTableFee" type="button"
                                            name="Add Range">Add Range</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="table-responsive">

                        <table class="table addRateTable" id="addRateTable">
                            <thead>
                                <tr>
                                    <th width="9">
                                        {{-- <x-jet-checkbox for="allFeeAmount" id="allFeeAmount"  class="allFeeAmount"
                                            value="" /> --}}
                                    </th>
                                    <th>@lang('labels.from') </th>
                                    <th>@lang('labels.to') </th>
                                    <th>@lang('labels.rate') </th>
                                    <th>@lang('labels.setup_fee') </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($data['rate_table_fee']))
                                    @foreach ($data['rate_table_fee'] as $key => $feeRow)
                                        <tr>

                                            <input type="hidden" name="rateTable[feeId][]"
                                                value="{{ encryptData($feeRow['id']) ?? '' }}" class="feeTableRowId">
                                            <td>
                                                <x-jet-checkbox for="fee_amount_row_{{ $loop->iteration }}"
                                                    id="fee_amount_row_{{ $loop->iteration }}"
                                                    class="fee_amount_row deleteCheckBoxFee" />
                                            </td>
                                            <td>
                                                <x-jet-input type="text" class="amount from_amount"
                                                    name="rateTable[from][]" id="name" required placeholder="$"
                                                    :value="$feeRow['from']" />
                                            </td>
                                            <td>
                                                <x-jet-input type="text" class="amount to_amount" name="rateTable[to][]"
                                                    id="name" required placeholder="$" :value="$feeRow['to']" />
                                            </td>
                                            <td>
                                                <x-jet-input type="text" class="percentageInput" name="rateTable[rate][]"
                                                    id="name" required placeholder="%" :value="$feeRow['rate']" />
                                            </td>
                                            <td class="addRateTableSetupfee">
                                                <div class="row align-items-center">
                                                    <div class="col-sm-7">
                                                        <label for="">@lang('labels.use_state_maximun')</label>
                                                        <x-jet-checkbox for="changesetup_{{ $loop->iteration }}"
                                                            class="changesetup setup_fees deleteCheckBoxFee"
                                                            :checked="$feeRow['is_state_maximun'] == 1 ? true : false" name="rateTable[setup_fee][]"
                                                            id="changesetup_{{ $loop->iteration }}" value="true" />
                                                    </div>
                                                    <div class="col-sm-1">
                                                        or
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <x-jet-input type="text" class="amount changesetup setup_fee"
                                                            name="rateTable[setup_fee_amount][]" id="changesetup"
                                                            placeholder="$" :value="$feeRow['setup_fee']" />
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>
                                            <x-jet-checkbox for="fee_amount_row_1" id="fee_amount_row_1"
                                                class="fee_amount_row deleteCheckBoxFee" value="" />
                                        </td>
                                        <td>
                                            <x-jet-input type="text" class="amount from_amount" name="rateTable[from][]"
                                                id="name" required placeholder="$" />
                                        </td>
                                        <td>
                                            <x-jet-input type="text" class="amount to_amount" name="rateTable[to][]"
                                                id="name" required placeholder="$" />
                                        </td>
                                        <td>
                                            <x-jet-input type="text" class="percentageInput" name="rateTable[rate][]"
                                                id="name" required placeholder="%" />
                                        </td>
                                        <td class="addRateTableSetupfee">
                                            <div class="row align-items-center">
                                                <div class="col-sm-7">
                                                    <label for="">@lang('labels.use_state_maximun')</label>
                                                    <x-jet-checkbox for="changesetup_1"
                                                        class="changesetup setup_fees deleteCheckBoxFee"
                                                        name="rateTable[setup_fee][]" id="changesetup_1"
                                                        value="true" />
                                                </div>
                                                <div class="col-sm-1">
                                                    or
                                                </div>
                                                <div class="col-sm-4">
                                                    <x-jet-input type="text" class="amount changesetup setup_fee"
                                                        name="rateTable[setup_fee_amount][]" id="changesetup"
                                                        placeholder="$" />
                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


            <x-button-group :cancel="routeCheck($route . 'index')" :isDelete="true" />

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

                        <th class="" data-sortable="true" data-field="username" data-width="200">@lang('labels.user_name')
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
