<x-app-layout :class="['codemirror', 'datepicker']">
    <x-jet-form-section :title="$pageTitle" :activePageName="$activePage" :buttonGroup="['logs', 'other' => [['text' => __('labels.cancel'), 'url' => routeCheck('company.dashboard')]]]" class="validationForm editForm" novalidate
        action="{{ routeCheck($route . 'gl-create') }}" method="post">
        @slot('form')
            <div class="form-group row">
                <div class="col-sm-4 col-form-label">
                    <label> @lang('labels.for')</label>

                </div>
                <div class="col-sm-4 col-form-label">
                    <label> @lang('labels.default_bank_account')</label>
                </div>
                <div class="col-sm-4 col-form-label">
                    <label>@lang('labels.details')</label>
                </div>
            </div>

            <div class="">
                <div class="form-group row">
                    <div class="col-sm-4 col-form-label">
                        <label>@lang('labels.general_default')</label>
                    </div>
                    <div class="col-sm-4">
                        {!! form_dropdown('general_default', paymentdropdown(), '', [
                            'class' => 'ui dropdown input-sm w-100',
                            'required' => true,
                            'id' => '',
                        ]) !!}
                    </div>
                    <div class="col-sm-4">
                        <div class="fs--1">
                            <p class="mb-0 fs--1">The bank account specified here is used as the default for the following:
                            </p>
                            <ul>
                                <li>General Ledger Export to track any transaction where a bank account was not
                                    specified,</li>
                                <li>General Ledger Export to track any transaction where a bank account was not
                                    specified,</li>
                                <li>Refund at Account Close,</li>
                                <li>Refund at Flat Cancel, and</li>
                                <li>Manual Refund.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label>@lang('labels.deposit_default')</label>
                            </div>
                            <div class="col-sm-6">
                                {!! form_dropdown('deposit_default', paymentdropdown(), '', [
                                    'class' => 'ui dropdown input-sm w-100',
                                    'required' => true,
                                    'id' => '',
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label>@lang('labels.deposit_credit_card')</label>
                            </div>
                            <div class="col-sm-6">
                                {!! form_dropdown('deposit_credit_card', paymentdropdown(), '', [
                                    'class' => 'ui dropdown input-sm w-100',
                                    'required' => true,
                                    'id' => '',
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label>@lang('labels.deposit_echeck')</label>
                            </div>
                            <div class="col-sm-6">
                                {!! form_dropdown('deposit_echeck', paymentdropdown(), '', [
                                    'class' => 'ui dropdown input-sm w-100',
                                    'required' => true,
                                    'id' => '',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="fs--1">
                            <p class="mb-0 fs--1">The bank accounts specified here are used as the defaults on the following
                                screens:
                            </p>
                            <ul>
                                <li>Enter Payment,</li>
                                <li>Enter Instant Payment,</li>
                                <li>Enter Down Payment, and</li>
                                <li>Enter Return Premium.</li>

                            </ul>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label>@lang('labels.remittance_default')</label>
                            </div>
                            <div class="col-sm-6">
                                {!! form_dropdown('remittance_default', paymentdropdown(), '', [
                                    'class' => 'ui dropdown input-sm w-100',
                                    'required' => true,
                                    'id' => '',
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label>@lang('labels.remittance_check')</label>
                            </div>
                            <div class="col-sm-6">
                                {!! form_dropdown('remittance_check', paymentdropdown(), '', [
                                    'class' => 'ui dropdown input-sm w-100',
                                    'required' => true,
                                    'id' => '',
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label>@lang('labels.remittance_draft')</label>
                            </div>
                            <div class="col-sm-6">
                                {!! form_dropdown('remittance_draft', paymentdropdown(), '', [
                                    'class' => 'ui dropdown input-sm w-100',
                                    'required' => true,
                                    'id' => '',
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="fs--1">
                            <p class="mb-0 fs--1">The bank accounts specified here are used as the defaults for the
                                following:
                            </p>
                            <ul>
                                <li>Processing checks and</li>
                                <li>Printing drafts.</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <x-slot name="saveOrCancel"></x-slot>
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
