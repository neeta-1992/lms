<x-app-layout>
    <x-jet-action-section>
        <x-slot name="title">
            {{ dynamicPageTitle('page') ?? '' }}
        </x-slot>
        @slot('content')
            <x-table id="{{ $activePage }}" ajaxUrl="{{ routeCheck($route . 'index') }}" >
                <thead>
                    <tr>
                        <th class="align-middle" data-sortable="false" data-field="account_number">@lang('labels.account')
                        </th>
                        <th class="align-middle" data-sortable="true" data-field="insured">@lang('labels.insured') @lang('labels.name')</th>
                        <th class="align-middle" data-sortable="true" data-field="agency">@lang('labels.agency') @lang('labels.name')</th>
                        <th class="align-middle" data-sortable="false"  data-field="status">@lang('labels.status')</th>
                        <th class="align-middle" data-sortable="false"  data-field="balance_due">@lang('labels.balance_due')</th>
                        <th class="align-middle" data-sortable="false"  data-field="payment_amount">@lang('labels.installment_amount')</th>
                        <th class="align-middle" data-sortable="false"  data-field="next_due_date">@lang('labels.next_due_date')</th>
                        <th class="align-middle" data-sortable="false"  data-field="installment">@lang('labels.installment')</th>

                    </tr>
                </thead>
            </x-table>
        @endslot
    </x-jet-action-section>
    <!--/.section-->
</x-app-layout>
