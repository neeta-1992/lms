<x-app-layout :class="[]">
    <x-jet-form-section :title="$pageTitle" :activePageName="$activePage" :buttonGroup="['logs', 'other' => [['text' => __('labels.cancel'), 'url' => routeCheck($route . 'payment-method-permissions')]]]" class="validationForm editForm" novalidate action="{{ routeCheck($route . 'payment-method-permissions-settings',$id) }}" method="post">
        @slot('form')
        <input type="hidden" name="logsArr">
        <div class="form-group row">
            <div class="col-sm-4 col-form-label">
                <label>@lang('labels.payment_method')</label>
            </div>
            <div class="col-sm-4 col-form-label">
                <label> @lang('labels.permissions')</label>
            </div>
            <div class="col-sm-4 col-form-label">
                <label>@lang('labels.description')</label>
            </div>
        </div>

        <div class="">
            <div class="form-group row">
                <div class="col-sm-4 col-form-label">
                    <label>@lang('labels.check')</label>
                </div>
                <div class="col-sm-4">
                    {!! form_dropdown('check', paymentdropdown(), '', [
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
                            <label>@lang('labels.money_order')</label>
                        </div>
                        <div class="col-sm-6">
                            {!! form_dropdown('money_order', paymentdropdown(), '', [
                            'class' => 'ui dropdown input-sm w-100',
                            'required' => true,
                            'id' => '',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>@lang('labels.cashiers_check')</label>
                        </div>
                        <div class="col-sm-6">
                            {!! form_dropdown('cashiers_check', paymentdropdown(), '', [
                            'class' => 'ui dropdown input-sm w-100',
                            'required' => true,
                            'id' => '',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>@lang('labels.cash')</label>
                        </div>
                        <div class="col-sm-6">
                            {!! form_dropdown('cash', paymentdropdown(), '', [
                            'class' => 'ui dropdown input-sm w-100',
                            'required' => true,
                            'id' => '',
                            ]) !!}
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>@lang('labels.statement_payable')</label>
                        </div>
                        <div class="col-sm-6">
                            {!! form_dropdown('statement_payable', paymentdropdown(), '', [
                            'class' => 'ui dropdown input-sm w-100',
                            'required' => true,
                            'id' => '',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>@lang('labels.electronic_check')</label>
                        </div>
                        <div class="col-sm-6">
                            {!! form_dropdown('electronic_check', paymentdropdown(), '', [
                            'class' => 'ui dropdown input-sm w-100',
                            'required' => true,
                            'id' => '',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>@lang('labels.ach')</label>
                        </div>
                        <div class="col-sm-6">
                            {!! form_dropdown('ach', paymentdropdown(), '', [
                            'class' => 'ui dropdown input-sm w-100',
                            'required' => true,
                            'id' => '',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label>@lang('labels.credit_card')</label>
                        </div>
                        <div class="col-sm-6">
                            {!! form_dropdown('credit_card', paymentdropdown(), '', [
                            'class' => 'ui dropdown input-sm w-100',
                            'required' => true,
                            'id' => '',
                            ]) !!}
                        </div>
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
        let editArr = @json($data ? ? []);

    </script>
    @endpush
</x-app-layout>
