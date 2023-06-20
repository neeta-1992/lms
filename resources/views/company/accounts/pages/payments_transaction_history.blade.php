
<x-table id="{{ $activePage ?? '' }}-payment-transaction-history" >
        <thead>
        <tr>
            <th class="align-middle" data-field="transaction_date">@lang("labels.transaction_date")</th>
            <th class="align-middle" data-field="user">@lang('labels.user')</th>
            <th class="align-middle" data-field="transaction">@lang('labels.transaction')</th>
            <th class="align-middle" data-field="debit">@lang('labels.debit')</th>
            <th class="align-middle" data-field="credit">@lang('labels.credit')</th>
            <th class="align-middle" data-field="balance">@lang('labels.balance')</th>
            <th class="align-middle" data-field="description">@lang("labels.description")</th>
        </tr>
    </thead>
</x-table>
