    <x-table id="{{ $activePage ?? '' }}-payment-schedule-table" :pagination="false">
        <thead>
        <tr>
            <th class="align-middle" data-field="payment_number">@lang("labels.payment")</th>
            <th class="align-middle" data-width="100" data-field="payment_due_date">@lang('labels.payment_due_date')</th>
            <th class="align-middle" data-width="100" data-field="amount_financed">@lang('labels.amount_financed')</th>
            <th class="align-middle" data-width="100" data-field="monthly_payment">@lang('labels.monthly') @lang('payment')</th>
            <th class="align-middle" data-field="interest">@lang('labels.interest')</th>
            <th class="align-middle" data-field="principal">@lang('labels.principal')</th>
            <th class="align-middle" data-width="100" data-field="principal_balance">@lang("labels.principal_balance")</th>
            <th class="align-middle" data-width="100" data-field="payoff_balance">@lang("labels.payoff_balance")</th>
            <th class="align-middle" data-width="100" data-field="interest_refund">@lang("labels.unearned_interest")</th>
            <th class="align-middle" data-field="status">@lang("labels.status")</th>
        </tr>
    </thead>
</x-table>
