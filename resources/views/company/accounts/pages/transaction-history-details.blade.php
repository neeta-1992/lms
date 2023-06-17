@php
    $payInterest = $principals = 0;
    $payment_number = $data?->payment_number ?? 0;
    $new_payment_number = $data?->new_payment_number ?? 0;
    $paymnetNumber = !empty($new_payment_number) ? $new_payment_number : $payment_number;

    if(!empty($new_payment_number)){
        $paymnetnumber = $or = '';
        for($i=$payment_number;$i <= $new_payment_number;$i++){
                $paymnetnumber .= $or.''.$i;
                $or = ', ';
        }
    }

    $paymentData = $data?->payment_data;
    $installmentJson = !empty($paymentData->installment_json) ? json_decode($paymentData->installment_json,true) : '' ;
    if(!empty($installmentJson)){
        $payInterestArr = array_column($installmentJson,'interest');
        $principalsArr  = array_column($installmentJson,'principal');
        $principals     = !empty($principalsArr) ? array_sum($principalsArr) : 0;
        $payInterest     = !empty($payInterestArr) ? array_sum($payInterestArr) : 0;
    }
@endphp

<table class="table modaltableview">
		   <tbody>
			<tr>
				<td width="25%">Payment Number</td>
				<td width="25%">{{  $paymnetNumber ?? 0 }}</td>
				<td width="25%">Installment </td>
				<td width="25%">{{ dollerFA($data?->installment_pay ?? 0) }}</td>
			</tr>
			<tr>
				<td>Payment Method</td>
				<td>{{ $data?->payment_method }}</td>
				<td>Principal </td>
				<td>{{ dollerFA($principals ?? 0) }}</td>
			</tr>
			<tr>
				<td>Reference</td>
				<td>{{ ($data?->reference ?? 0) }}</td>
				<td>Interest </td>
				<td>{{ dollerFA($payInterest ?? 0) }}</td>
			</tr>
			<tr>
				<td>Received From</td>
				<td>{{ ($data?->received_from ?? '') }}</td>
				<td>Convenience Fee</td>
				<td>{{ dollerFA($data?->convient_fee ?? 0) }}</td>
			</tr>
			
			<tr>
				
					<td></td>
					<td></td>
				
				<td>Late Fee</td>
				<td>{{ dollerFA($data?->late_fee ?? 0) }}</td>
			</tr>
			<tr>
				<td>Notes</td>
				<td>{{ ($data?->notes ?? '') }}</td>
				<td>Cancel Fee</td>
				<td>{{ dollerFA($data?->cancel_fee ?? 0) }}</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>NSF Fee</td>
				<td>{{ dollerFA($data?->nsf_fee ?? 0) }}</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>Stop Payment</td>
				<td>{{ dollerFA($data?->stop_payment ?? 0) }}</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td>Amount</td>
				<td>{{ dollerFA($data?->amount ?? 0) }}</td>
			</tr>
			</tbody>
			</table>