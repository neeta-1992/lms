
<x-table :noToggle="true">
    <thead class="d-none">
        <tr>
           <td colspan="10"></td>
        </tr>
    </thead>
    <tbody>
        @if (!empty($quotePolicy))
            @foreach ($quotePolicy as $key => $row)
                @php
                    $purePremium = !empty($row['pure_premium']) ? $row['pure_premium'] : 0;
                    $policyFee = !empty($row['policy_fee']) ? $row['policy_fee'] : 0;
                    $brokerFee = !empty($row['broker_fee']) ? $row['broker_fee'] : 0;
                    $inspectionFee = !empty($row['inspection_fee']) ? $row['inspection_fee'] : 0;
                    $down_payment = !empty($row['down_payment']) ? $row['down_payment'] : 0;
                    $taxesAndStampFees = !empty($row['taxes_and_stamp_fees']) ? $row['taxes_and_stamp_fees'] : 0;
                    $total = $purePremium + $policyFee + $brokerFee + $inspectionFee + $taxesAndStampFees;
                @endphp
                <tr>
                    <td colspan="7"> <div  x-on:click="policyDetails('{{ $row->id }}')"><b>{{ $loop->iteration }} @lang('labels.policy') # {{ $row->policy_number ?? '' }}</b></div>
                    </td>
                </tr>
                <tr>
                    <td>Date Activated</td>
                    <td>Coverage Type</td>
                    <td>Inception Date</td>
                    <td colspan="2">Insurance Company</td>
                    <td colspan="2">General Agent</td>
                    <td >Premium</td>
                    <td>Balance</td>
                </tr>
                <tr>
                    <td>{{ !empty($row->created_at) ? changeDateFormat($row->created_at) : '' }}</td>
                    <td>{{ $row->coverage_type_data?->name ?? '' }}</td>
                    <td>{{ !empty($row->inception_date) ? changeDateFormat($row->inception_date) : '' }}</td>
                    <td colspan="2">{{ $row->insurance_company_data?->name ?? '' }}</td>
                    <td colspan="2">{{ $row->general_agent_data?->name ?? '' }}</td>
                    <td>{{ dollerFA($row->pure_premium) ?? '' }}</td>
                    <td>{{ dollerFA($total) ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="7"><b>Payable/Payments</b></td>
                </tr>
                <tr>
                <tr>
                    <td><b>Due Date</b></td>
                    <td><b>Process Date</b></td>
                    <td><b>Processed By</b></td>
                    <td><b>Type</b></td>
                    <td><b>Payee</b></td>
                    <td><b>Amount</b></td>
                    <td><b>Method</b></td>
                    <td><b>Check/Ref #</b></td>
                    <td><b>Date Paid</b></td>

                </tr>
                <tr>
                    <td>{{ !empty($row?->payable?->due_date) ? changeDateFormat($row?->payable?->due_date) : '' }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $row?->payable?->type ?? '' }}</td>
                    <td>{{ $row?->payable?->paymee?->name ?? '' }}</td>
                    <td>{{ dollerFA($row?->payable?->totalamount) ?? '' }}</td>
                    <td>Check per Policy</td>
                    <td></td>
                </tr>
            @endforeach
        @endif
    </tbody>

</x-table>
