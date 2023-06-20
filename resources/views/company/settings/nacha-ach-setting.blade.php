<x-app-layout>

        <x-jet-form-section :buttonGroup="['logs']" :activePageName="$activePage" class="validationForm editForm" :title="$pageTitle" novalidate
            action="{{ routeCheck($route) }}" method="post">
            @slot('form')
                <input type="hidden" name="logsArr">
            <div class="row ">
                <div class="col-sm-4"></div>
                <div class="col-sm-4"><p class="fw-600">@lang('labels.ach_deposits')</p></div>
                <div class="col-sm-4"><p class="fw-600">@lang('labels.ach_withdrawals')</p></div>
            </div>
            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label requiredAsterisk">@lang('labels.bank_name')</label>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="bank_name_deposits" required />
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="bank_name_withdrawals" required />
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label requiredAsterisk">@lang('labels.aba_routing_number')</label>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="routing_number_deposits" required class="digitLimit" data-limit="9"/>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="routing_number_withdrawals" required  class="digitLimit" data-limit="9"/>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label">@lang('labels.immediate_destination')</label>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="file_id_deposits" class="digitLimit" data-limit="10"/>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="file_id_withdrawals"  class="digitLimit" data-limit="10"/>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label">@lang('labels.company_identification')</label>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="company_id_deposits"  maxlength="10"/>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="company_id_withdrawals"  maxlength="10"/>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label requiredAsterisk">@lang('labels.origin_name')</label>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="origin_name_deposits" required />
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="origin_name_withdrawals" required />
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label">@lang('labels.company_entry_class_code')</label>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="company_entry_class_code_deposits"   maxlength="10"/>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="company_entry_class_code_withdrawals"  maxlength="10" />
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label">@lang('labels.company_discretionary_data')</label>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="company_discretionary_data_deposits"   maxlength="20"/>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="company_discretionary_data_withdrawals"   maxlength="20"/>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label requiredAsterisk">@lang('labels.company_name')</label>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="company_name_deposits" required maxlength="16"/>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="company_name_withdrawals" required maxlength="16"/>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label requiredAsterisk">@lang('labels.file_reference_code')</label>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="file_reference_code_deposits" required maxlength="8"/>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="file_reference_code_withdrawals" required maxlength="8"/>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label">@lang('labels.extra_file_header_line')</label>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="extra_file_header_line_deposits"  />
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="extra_file_header_line_withdrawals"  />
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label requiredAsterisk">@lang('labels.insured_payment_entry_class')</label>
                </div>
                <div class="col-sm-4">
                    {!! form_dropdown('insured_payment_entry_class_deposits', ['PPD' => 'PPD', 'CCD' => 'CCD'], '', [
                        'class' => 'w-100',
                        'required' => 1,
                    ]) !!}
                </div>
                <div class="col-sm-4">
                    {!! form_dropdown('insured_payment_entry_class_withdrawals', ['PPD' => 'PPD', 'CCD' => 'CCD'], '', [
                        'class' => 'w-100',
                        'required' => 1,
                    ]) !!}
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label requiredAsterisk">@lang('labels.remittance_entry_class')</label>
                </div>
                <div class="col-sm-4">
                    {!! form_dropdown('remittance_entry_class_deposits', ['PPD' => 'PPD', 'CCD' => 'CCD'], '', [
                        'class' => 'w-100',
                        'required' => 1,
                    ]) !!}
                </div>
                <div class="col-sm-4">
                    {!! form_dropdown('remittance_entry_class_deposits', ['PPD' => 'PPD', 'CCD' => 'CCD'], '', [
                        'class' => 'w-100',
                        'required' => 1,
                    ]) !!}
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label">@lang('labels.company_entry_description')</label>
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="company_entry_description_deposits" maxlength="10" />
                </div>
                <div class="col-sm-4">
                    <x-jet-input type="text" name="company_entry_description_withdrawals" maxlength="10" />
                </div>
            </div>

            <div class="row form-group">
                <div class="col-sm-4">
                    <label for="" class="col-form-label">@lang('labels.include_offset_entry')</label>
                </div>
                <div class="col-sm-4">
                    <x-jet-checkbox for="include_offset_entry_deposits"
                        name="include_offset_entry_deposits" id="include_offset_entry_deposits" value="offset_entry_deposits" />

                </div>
                <div class="col-sm-4">
                    <x-jet-checkbox for="include_offset_entry_withdrawals"
                        name="include_offset_entry_withdrawals" id="include_offset_entry_withdrawals" value="offset_entry_withdrawals" />
                </div>
            </div>



             <x-button-group cancel='{{ routeCheck("company.dashboard") }}'/>
            @endslot
            @slot('logContent')
            <x-bootstrap-table :data="[
                'table' => 'logs',
                'cookieid' => true,
                'id' => $activePage . '-logs',
                'sortorder' => 'desc',
                'sortname' => 'created_at',
                'type' => 'serversides',
                'ajaxUrl' => routeCheck('company.logs', ['type' => $activePage]),
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
