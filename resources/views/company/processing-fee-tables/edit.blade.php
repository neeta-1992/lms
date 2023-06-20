<x-app-layout>

    <x-jet-form-section :buttonGroup="['logs', 'other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'index')]]]" class="validationForm editForm " novalidate
        action="{{ routeCheck($route . 'update', $id) }}" method="post">
        @slot('form')
            @method('put')
            <input type="hidden" name="logsArr">
            <div class="form-group row">
                <label for="state" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.status')</label>
                <div class="col-sm-9">
                    {!! form_dropdown('status', ['1' => 'Enable', '0' => 'Disable'], 0, ['class' => 'w-100 ', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="name" class="col-sm-3 col-form-label requiredAsterisk">@lang('labels.processing_fee_table_name')</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="name" id="name" required
                        placeholder="">
                </div>
            </div>

            <div class="form-group row">
                <label for="description" class="col-sm-3 col-form-label">@lang('labels.description')</label>
                <div class="col-sm-9">
                    <textarea name="description" id="description" cols="30" class="form-control" rows="3"></textarea>
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

                        <table class="table addOtherFeeTable" id="addOtherFeeTable">
                            <thead>
                                <tr>
                                    <th width="9">

                                    </th>
                                    <th>@lang('labels.from')</th>
                                    <th>@lang('labels.to')</th>

                                    <th>@lang('labels.fee') @lang('labels.amount')</th>


                                </tr>
                            </thead>
                            <tbody>

                                @if (!empty($data['processing_table_fee']))
                                    @foreach ($data['processing_table_fee'] as $key => $feeRow)

                                        <tr>
                                            <input type="hidden" class="feeTableRowId"  value="{{ encryptData($feeRow['id']) }}"
                                            name="feeTable[id][]" />
                                            <td>
                                                <x-jet-checkbox for="fee_amount_row_{{ $key }}"
                                                    id="fee_amount_row_{{ $key }}"
                                                    class="fee_amount_row deleteCheckBoxFee" value="" />
                                            </td>
                                            <td>
                                                <x-jet-input type="text" required class="amount from_amount"
                                                    :value="$feeRow['from']" name="feeTable[from][]" placeholder="$" />
                                            </td>
                                            <td>
                                                <x-jet-input type="text" required class="amount to_amount"
                                                    :value="$feeRow['to']" name="feeTable[to][]" placeholder="$" />
                                            </td>

                                            <td>
                                                <x-jet-input type="text" required class="amount" :value="$feeRow['fee']"
                                                    name="feeTable[fee][]" placeholder="$" />
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
                                            <x-jet-input type="text" required class="amount from_amount"
                                                name="feeTable[from][]" placeholder="$" />
                                        </td>
                                        <td>
                                            <x-jet-input type="text" required class="amount to_amount"
                                                name="feeTable[to][]" placeholder="$" />
                                        </td>

                                        <td>
                                            <x-jet-input type="text" required class="amount" name="feeTable[fee][]"
                                                placeholder="$" />
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

                        <th class="" data-sortable="true" data-field="username" data-width="200">
                           @lang('labels.user_name')
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
