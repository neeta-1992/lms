<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\GlAccount;
use App\Models\Logs;
use App\Models\Payment;
use App\Models\PaymentsHistory;
use App\Models\QuoteAccount;
use App\Models\Setting;
use App\Models\TransactionHistory;use Error;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    private $viwePath = "company.Payments.";
    public $pageTitle = "Verify Entered Payments";
    public $activePage = "verify-entered-payments";
    public $route = "company.payment.";
    public function __construct(Payment $model)
    {
        $this->model = $model;
    }
    public function enterpayments()
    {
        return view($this->viwePath . "enter", ['route' => $this->route]);
    }

    public function verifypayments()
    {
        $userArr = [];
        $this->pageTitle = "Verify Entered Payments";

        return view($this->viwePath . "verify", ['route' => $this->route, 'pageTitle' => $this->pageTitle, 'activePage' => $this->activePage, 'userArr' => $userArr]);
    }

    public function paymenthistory()
    {
        $this->pageTitle = 'Entered Payments History';
        return view($this->viwePath . "history", ['route' => $this->route, 'pageTitle' => $this->pageTitle, 'activePage' => $this->activePage]);
    }

    public function achpayment()
    {

        $this->pageTitle = 'ACH Payment History';
        return view($this->viwePath . "achpayment", ['route' => $this->route, 'pageTitle' => $this->pageTitle, 'activePage' => $this->activePage]);

    }

    public function findPayment(Request $request)
    {

        $status = $request->post('status');
        $users = $request->post('users');
        $installment = $request->post('installment');
        $payoff = $request->post('payoff');
        $type = $request->post('type');

        $isSearch = false;
        if ($status == 'all') {
            $isSearch = true;
        }

        if (!empty($users) && $users != 'null') {
            $isSearch = true;
        }
        if (!empty($type)) {
            $isSearch = true;
        }

        if ($isSearch) {
            $paymentData = $this->model::getData(['status' => 0, 'users' => $users, 'payoff_status' => 0]);
            if (!empty($installment) && $type == 'process') {
                $paymentData = $paymentData->whereIn('id', $installment);
            }
            $paymentData = $paymentData->latest()->get();
/* dd($paymentData); */
            $payoffpaymentsdatas = $this->model::getData(['status' => 0, 'users' => $users, 'payoff_status' => 1]);
            if (!empty($payoff) && $type == 'process') {
                $payoffpaymentsdatas = $payoffpaymentsdatas->whereIn('id', $payoff);
            }
            $payoffpaymentsdatas = $payoffpaymentsdatas->latest()->get();
            return view($this->viwePath . "find-payment", ['route' => $this->route, 'paymentData' => $paymentData, 'payoffpaymentsdatas' => $payoffpaymentsdatas, 'activePage' => $this->activePage, 'type' => $type]);
        }
    }

    public function commitProcessEntered(Request $request)
    {

        try {

            $userData = $request->user();
            $username = $userData?->name;
            $status = $request->post('status');
            $users = $request->post('users');
            $installmentArr = $request->post('installment');
            $payoffArr = $request->post('payoff');
            $type = $request->post('type');
            $payoffArr = !empty($payoffArr) ? $payoffArr : [];
            $installmentArr = !empty($installmentArr) ? $installmentArr : [];
            $paymentArr = $paymentIds = $achPaymentArr = $achPaymentIdArr = [];
            $totlaAmount  = $totalOtherFee = $otherfee = $totalInterest = $totalSetupFee = 
            $totalStopPayment = $totalConvientFee = $setupFee = $totalLateFee = $totalNsfFee = $totalCancelFee = $interest = $principal = $installment = $totalPrincipal = $totalInterest = 0;
            $achTotlaAmount= $achtotalOtherFee  = $achTotalInterest = $achTotalSetupFee = $achTotalStopPayment = $achTotalConvientFee = $achTotalLateFee = $achTotalNsfFee = $achTotalCancelFee = $achTotalPrincipal = $achTotalInterest = 0;
            if (!empty($installmentArr) || !empty($payoffArr) && $type == 'commit') {
                $allId = $installmentArr + $payoffArr;
                /*  dd($allId); */
                $paymentData = $this->model::getData(['status' => 0]);
                if (!empty($allId)) {
                    $paymentData = $paymentData->whereIn('id', $allId);
                }
                $paymentData = $paymentData->get();
              
                $totalDeposits = 0;
                $view = $paymentsHistoryData = $achpaymentsHistoryId = $paymentHistoryId = null ;
                if (!empty($paymentData)) {
                    foreach ($paymentData as $key => $value) {
                        $paymentId = $value?->id ?? 0;
                        $paymentNumber = $value?->payment_number ?? 0;
                        $accountId = $value?->account_id ?? 0;
                        $paymentMethod = $value?->payment_method ?? 0;
                        $installmentPay = toFloat($value?->installment_pay ?? 0);
                        $lateFee = toFloat($value?->late_fee ?? 0);
                        $cancelFee = toFloat($value?->cancel_fee ?? 0);
                        $nsfFee = toFloat($value?->nsf_fee ?? 0);
                        $convientFee = toFloat($value?->convient_fee ?? 0);
                        $amount = toFloat($value?->amount ?? 0);
                        $totalDue = toFloat($value?->total_due ?? 0);
                        $stopPayment = toFloat($value?->stop_payment ?? 0);
                        $installmentJson = !empty($value?->installment_json) ? json_decode($value?->installment_json, true) : '';

                        if (!empty($installmentJson)) {
                            $installment = array_column($installmentJson, 'installment');
                            $installment = !empty($installment) ? array_sum($installment) : 0;
                            $principal = array_column($installmentJson, 'principal');
                            $principal = !empty($interest) ? array_sum($principal) : 0;
                            $interest = array_column($installmentJson, 'interest');
                            $interest = !empty($interest) ? array_sum($interest) : 0;
                        }
                        $principalAmount = $installmentPay - $interest;
                        $otherfee  = $convientFee + $stopPayment;

                        $totlaAmount += $amount;
                        $totalPrincipal += $principalAmount;
                        $totalInterest += $interest;
                        $totalConvientFee += $convientFee;
                        $totalLateFee += $lateFee;
                        $totalNsfFee += $nsfFee;
                        $totalCancelFee += $cancelFee;
                        $totalStopPayment += $stopPayment;
                        $totalOtherFee += $otherfee;
                        

                        $paymentIds[] = $paymentId;
                        $paymentArr[$paymentId] = [
                            'payment_number' => $paymentNumber,
                            'total' => $amount,
                            'principal' => $principalAmount,
                            'late_fee' => $lateFee,
                            'nsf_fee' => $nsfFee,
                            'cancel_fee' => $cancelFee,
                            'convient_fee' => $convientFee,
                            'stop_payment' => $stopPayment,
                            'interest' => $interest,
                            'payment_method' => $paymentMethod,
                            'otherfee' => $otherfee,
                        ];
                        $totalDeposits++;

                        if (strtolower($paymentMethod) == 'ach' || strtolower($paymentMethod) == 'echeck') {

                            $achPaymentIdArr[] = $paymentId;

                            $achTotlaAmount += $amount;
                            $achTotalPrincipal += $principalAmount;
                            $achTotalInterest += $interest;
                            $achTotalConvientFee += $convientFee;
                            $achTotalLateFee += $lateFee;
                            $achTotalNsfFee += $nsfFee;
                            $achTotalCancelFee += $cancelFee;
                            $achTotalStopPayment += $stopPayment;
                            $achtotalOtherFee += $otherfee;

                            $achPaymentArr[$paymentId] = [
                                'payment_number' => $paymentNumber,
                                'total' => $amount,
                                'principal' => $principalAmount,
                                'late_fee' => $lateFee,
                                'nsf_fee' => $nsfFee,
                                'cancel_fee' => $cancelFee,
                                'convient_fee' => $convientFee,
                                'stop_payment' => $stopPayment,
                                'interest' => $interest,
                                'payment_method' => $paymentMethod,
                                'otherfee' => $otherfee,
                            ];
                        }

                        /* account payment status change  */
                        if (!empty($accountId)) {
                            $quoteAccountData = QuoteAccount::getData(['id' => $accountId])->first();
                            $status = $quoteAccountData?->status ?? 0;

                            $transactionHistory = TransactionHistory::getData(['accountId' => $accountId])->orderBy('iid', 'desc')->first();
                            $balance = !empty($transactionHistory?->balance) ? toFloat($transactionHistory?->balance) : 0;

                            if (empty($balance)) {
                                $accountStatusArr = accountStatus(7);
                                $status = 7;
                            } else {
                                $status = 1;
                                $accountStatusArr = accountStatus(1);
                            }

                            $quoteAccountData->status = $status;
                            $quoteAccountData->payment_status = 0;
                            $quoteAccountData->save();

                            $accountStatus = !empty($accountStatusArr['text']) ? $accountStatusArr['text'] : '';
                            $accountText = $accountStatus . ' by ' . $username;
                            Logs::saveLogs(['type' => 'accounts', 'user_id' => $userData?->id, 'type_id' => $accountId, 'message' => $accountText]);

                            $input['payment_id'] = $value->id;
                            $input['account_id'] = $accountId;
                            $input['transaction_type'] = 'Status';
                            $input['description'] = $accountStatus;
                            $input['balance'] = $balance;
                            TransactionHistory::insertOrUpdate($input);
                        }

                    }

                    if (!empty($achPaymentIdArr)) {
                        $achPaymentId = implode(',', $achPaymentIdArr);
                        $achTotalArr = [
                            'total' => $achTotlaAmount,
                            'principal' => $achTotalPrincipal,
                            'interest' => $achTotalInterest,
                            'setup_fee' => $achTotalSetupFee,
                            'late_fee' => $achTotalLateFee,
                            'nsf_fee' => $achTotalNsfFee,
                            'cancel_fee' => $achTotalCancelFee,
                            'convient_fee' => $achTotalConvientFee,
                            'stop_payment' => $achTotalStopPayment,
                            'otherfee' => $achtotalOtherFee,
                        ];

                        $achPaymentInsertArr = [
                            'payment_ids' => $achPaymentId,
                            'total_deposits' => count($achPaymentIdArr),
                            'deposit_amount' => $achTotlaAmount,
                            'totals' => json_encode($achTotalArr),
                            'payments' => json_encode($achPaymentArr),
                            'type ' => 2,
                        ];
                        $achpaymentsHistoryData =  PaymentsHistory::insertOrUpdate($achPaymentInsertArr);
                        $achpaymentsHistoryId = $achpaymentsHistoryData?->id;

                    }

                    if (!empty($paymentIds)) {
                        $paymentId = implode(',', $paymentIds);
                        $totalArr = [
                            'total' => $totlaAmount,
                            'principal' => $totalPrincipal,
                            'interest' => $totalInterest,
                            'setup_fee' => $totalSetupFee,
                            'late_fee' => $totalLateFee,
                            'nsf_fee' => $totalNsfFee,
                            'cancel_fee' => $totalCancelFee,
                            'convient_fee' => $totalConvientFee,
                            'stop_payment' => $totalStopPayment,
                            'otherfee' => $totalOtherFee,
                        ];

                        $paymentInsertArr = [
                            'payment_ids' => $paymentId,
                            'total_deposits' => $totalDeposits,
                            'deposit_amount' => $totlaAmount,
                            'totals' => json_encode($totalArr),
                            'payments' => json_encode($paymentArr),
                        ];

                        $paymentsHistoryData = PaymentsHistory::insertOrUpdate($paymentInsertArr);
                        $paymentHistoryId = $paymentsHistoryData?->id;
                        /* Status Update In Payment Data */
                        $this->model::getData()->whereIn('id', $paymentIds)->update(['status' => 1]);
                    }

                    Logs::saveLogs(['type' => $this->activePage, 'user_id' => $userData?->id, 'type_id' => $paymentsHistoryData?->id, 'message' => 'Payments is in processed']);
                    $view = view($this->viwePath . "find-payment", ['route' => $this->route, 'paymentData' => $paymentData, 'activePage' => $this->activePage, 'type' => $type])->render();

                }
            }
            if (!empty($view)) {
                return response()->json(['status' => true, 'view' => $view,'achId' => $achpaymentsHistoryId,'paymentId' => $paymentHistoryId ], 200);
            } else {
                throw new Error("Data Empty");
            }

        } catch (\Throwable $th) {
            /*   dd($th); */
            return response()->json(['status' => false, 'msg' => 'Something went wrong please try again'], 200);
        }
    }

    /*
    @Ajax Get Data List
     */
    public function paymentsHistoryList(Request $request)
    {

        $columnName = !empty($request['sort']) ? $request['sort'] : '';
        $columnSortOrder = !empty($request['order']) ? $request['order'] : '';
        $offset = !empty($request['offset']) ? $request['offset'] : 0;
        $limit = !empty($request['limit']) ? $request['limit'] : 25;
        $searchValue = !empty($request['search']) ? $request['search'] : '';
        $type = !empty($request['type']) ? $request['type'] : '';

        $sqlData = PaymentsHistory::getData();
        if (!empty($type) && $type == 'ach') {
            $sqlData = $sqlData->where('type', 2);
        }
        $totalstateDatas = $sqlData->count();
        $dataArr = [];
        $date = $sqlData->skip($offset)->take($limit)->orderBy($columnName, $columnSortOrder)->get();

        if (!empty($date)) {
            foreach ($date as $row) {

                if ($type != 'ach') { 
                $icon = '<a data-turbolinks="false" class="cursor-pointer text-warning" title="IIF File" href="' . routeCheck($this->route . 'download-iif-file', ['type' => 'history', 'id' => $row?->id]) . '"><i class="iconcolororange fa-solid fa-file-arrow-down"></i></a>';
                    $icon .= '<a  data-turbolinks="false" class="ml-2 cursor-pointer   text-warning" title="CSV File"  href="' . routeCheck($this->route . 'download-csv-file', ['type' => 'history', 'id' => $row?->id]) . '"><i class="iconcolororange fa-solid fa-file-csv"></i></a>';
                   // $icon .= '<a data-turbolinks="false"  class=" ml-2 cursor-pointer  text-warning" title="Nacha File"  href="' . routeCheck($this->route . 'download-nacha-file', ['type' => 'history', 'id' => $row?->id]) . '"><i class="iconcolororange fa-solid fa-file-arrow-down"></i></a>';
              } else { 
                    $icon = '<a data-turbolinks="false"  class="cursor-pointer  text-warning" title="Nacha File"  href="' . routeCheck($this->route . 'download-nacha-file', ['type' => 'history', 'id' => $row?->id]) . '"><i class="iconcolororange fa-solid fa-file-arrow-down"></i></a>';
                } 

                $dataArr[] = [
                    "processed_date" => changeDateFormat($row?->created_at),
                    "processed_by" => $row?->user?->name,
                    "total_transactions" => $row?->total_deposits ?? 0,
                    "deposit_amount" => dollerFA($row?->deposit_amount ?? 0),
                    "action" => $icon,
                ];

            }
        }
        $response = array("total" => $totalstateDatas, "totalNotFiltered" => $totalstateDatas, "rows" => $dataArr);
        return json_encode($response);
    }

    /* download-iif-file */
    public function downloadIifFile(Request $request)
    {
        try {

            $type = $request->type;
            $id = $request->id;
            $paymentIds = $request->paymentIds;

            
            $data = PaymentsHistory::getData()->where('id', $id)->first();
            //    dd( $data);
            if (!empty($data)) {

                $totalArr = !empty($data?->totals) ? json_decode($data?->totals, true) : [];
                $paymentArr = !empty($data?->payments) ? json_decode($data?->payments, true) : [];
                $today_date = changeDateFormat($data?->created_at ?? '', true);

                $IFFdatas[] = array('!ACCNT', 'NAME', 'ACCNTTYPE', 'DESC', 'ACCNUM', 'EXTRA');
                $IFFdatas[] = array('ACCNT', 'Checking', 'BANK');
                $IFFdatas[] = array('ACCNT', 'Income', 'INC');
                $IFFdatas[] = array('!TRNS', 'TRNSID', 'TRNSTYPE', 'DATE', 'ACCNT', 'NAME', 'CLASS', 'AMOUNT', 'DOCNUM', 'CLEAR');
                $IFFdatas[] = array('!SPL', 'SPLID', 'TRNSTYPE', 'DATE', 'ACCNT', 'NAME', 'CLASS', 'AMOUNT', 'DOCNUM', 'CLEAR');
                $IFFdatas[] = array('!ENDTRNS');

                if (!empty($totalArr)) {
                    $total = !empty($totalArr['total']) ? toRound($totalArr['total']) : '';
                    $principal = !empty($totalArr['principal']) ? toRound($totalArr['principal']) : '';
                    $interest = !empty($totalArr['interest']) ? toRound($totalArr['interest']) : '';
                    $setup_fee = !empty($totalArr['setup_fee']) ? toRound($totalArr['setup_fee']) : '';
                    $late_fee = !empty($totalArr['late_fee']) ? toRound($totalArr['late_fee']) : '';
                    $nsf_fee = !empty($totalArr['nsf_fee']) ? toRound($totalArr['nsf_fee']) : '';
                    $cancel_fee = !empty($totalArr['cancel_fee']) ? toRound($totalArr['cancel_fee']) : '';
                    $otherfee = !empty($totalArr['otherfee']) ? toRound($totalArr['otherfee']) : '';

                    if (!empty($total)) {
                        $glAccountNum = GlAccount::getData(['name' => 'Bank Account', 'status' => 1])->first()?->number ?? '';
                        $IFFdatas[] = array('TRNS', '', 'DEPOSIT', $today_date, $glAccountNum, '', '', $total, '', 'N');
                    }

                    if (!empty($principal)) {
                        $glAccountNum = GlAccount::getData(['name' => 'Accounts Receivable', 'status' => 1])->first()?->number ?? '';
                        $IFFdatas[] = array('SPL', '', 'DEPOSIT', $today_date, $glAccountNum, '', '', '-' . $principal, '', 'N');
                    }

                    if (!empty($interest)) {
                        $glAccountNum = GlAccount::getData(['name' => 'Earned Interest', 'status' => 1])->first()?->number ?? '';
                        $IFFdatas[] = array('SPL', '', 'DEPOSIT', $today_date, $glAccountNum, '', '', '-' . $interest, '', 'N');
                    }

                    if (!empty($setup_fee)) {
                        $glAccountNum = GlAccount::getData(['name' => 'Setup Fee Income', 'status' => 1])->first()?->number ?? '';
                        $IFFdatas[] = array('SPL', '', 'DEPOSIT', $today_date, $glAccountNum, '', '', '-' . $setup_fee, '', 'N');
                    }

                    if (!empty($late_fee)) {
                        $glAccountNum = GlAccount::getData(['name' => 'Late Fee Income', 'status' => 1])->first()?->number ?? '';
                        $IFFdatas[] = array('SPL', '', 'DEPOSIT', $today_date, $glAccountNum, '', '', '-' . $late_fee, '', 'N');
                    }
                    if (!empty($nsf_fee)) {
                        $glAccountNum = GlAccount::getData(['name' => 'NSF Fee Income', 'status' => 1])->first()?->number ?? '';
                        $IFFdatas[] = array('SPL', '', 'DEPOSIT', $today_date, $glAccountNum, '', '', '-' . $nsf_fee, '', 'N');
                    }
                    if (!empty($cancel_fee)) {
                        $glAccountNum = GlAccount::getData(['name' => 'Cancellation Fee Income', 'status' => 1])->first()?->number ?? '';
                        $IFFdatas[] = array('SPL', '', 'DEPOSIT', $today_date, $glAccountNum, '', '', '-' . $cancel_fee, '', 'N');
                    }
                    if (!empty($otherfee)) {
                        $glAccountNum = GlAccount::getData(['name' => 'Other Fee Income', 'status' => 1])->first()?->number ?? '';
                        $IFFdatas[] = array('SPL', '', 'DEPOSIT', $today_date, $glAccountNum, '', '', '-' . $otherfee, '', 'N');
                    }
                    $IFFdatas[] = array('ENDTRNS');
                }

                $downloadname = date('Y-m-d') . '.iif';
                $headers = array(
                    "Content-type" => "text/csv",
                    "Content-Disposition" => "attachment; filename=$downloadname",
                    "Pragma" => "no-cache",
                    "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                    "Expires" => "0",
                );

                $callback = function () use ($IFFdatas) {
                    $file = fopen('php://output', 'w');
                    foreach ($IFFdatas as $ro) {
                        fputcsv($file, $ro, "\t", '"');
                    }
                    fclose($file);

                };

                return response()->stream($callback, 200, $headers);
            }else{
                throw new Error("Data Empty"); 
            }

            //code...
        } catch (\Throwable $th) {
            return redirect()->back();
        }
    }

    /* download-csv-file */
    public function downloadCsvFile(Request $request)
    {

        try {

            $type = $request->type;
            $id = $request->id;

            $data = PaymentsHistory::getData()->where('id', $id)->get();
            if (empty($data)) {
                throw new Error("Data Empty");
            }
            $IFFdatas[] = array('Date Entered', 'Entered By', 'Date Processed', 'Processed By', 'Account #', 'Agent', ' Insured', '  Amount', 'Princ.', ' Int.', 'Setup Fee', 'Late Charge', 'NSF', 'Cancel Fee', 'Other Fee', ' Down Payment', ' AccountsPayable');
            $currentpayment_method = '';
            $n = $p = $totalss = $otherfee = $setup_fee = $principalss = $interestss = $setup_feess = $late_feess = $nsf_feess = $cancel_feess = $otherfeess = $downpaymentss = $AccountsPayabless = 0;
            foreach ($data as $key => $history) {
                $p++;
                $paymentUser = $history?->user;
                $paymentIds = !empty($history?->payment_ids) ? explode(',', $history?->payment_ids) : [];
                $paymentsArr = !empty($history?->payments) ? json_decode($history?->payments, true) : '';

                $paymentData = Payment::getData()->whereIn('id', $paymentIds)->get();
                if (!empty($paymentData)) {
                    foreach ($paymentData as $key => $payment) {
                        $paymentId = $payment?->id;
                        $accountData = $payment?->account_data;
                        $agentUser = $payment?->account_data?->agent_user;
                        $insuredUser = $payment?->account_data?->insured_user;
                        $Entered = $payment?->user?->name;

                        extract($paymentsArr[$paymentId]);

                        $AccountsPayable = $downpayment = 0;
                        $downpayment = !empty($downpayment) ? $downpayment : 0;
                        $downpayments = !empty($downpayment) ? dollerFA($downpayment) : '$0.00';

                        $AccountsPayable = !empty($AccountsPayable) ? $AccountsPayable : 0;
                        $AccountsPayables = !empty($AccountsPayable) ? dollerFA($AccountsPayable) : '$0.00';

                        if ($currentpayment_method != $payment_method && $p != 1) {
                            $totalss = dollerFA($totalss ?? 0);
                            $principalss = dollerFA($principalss ?? 0);
                            $interestss = dollerFA($interestss ?? 0);
                            $setup_feess = dollerFA($setup_feess ?? 0);
                            $late_feess = dollerFA($late_feess ?? 0);
                            $nsf_feess = dollerFA($nsf_feess ?? 0);
                            $cancel_feess = dollerFA($cancel_feess ?? 0);
                            $otherfeess = dollerFA($otherfeess ?? 0);
                            $downpaymentss = dollerFA($downpaymentss ?? 0);
                            $AccountsPayabless = dollerFA($AccountsPayabless ?? 0);

                            $IFFdatas[] = array('', '', '', '', '', '', 'Total ' . $currentpayment_method . ' ' . $n, $totalss, $principalss, $interestss, $setup_feess, $late_feess, $nsf_feess, $cancel_feess, $otherfeess, $downpaymentss, $AccountsPayabless);
                            $n = $totalss = $principalss = $interestss = $setup_feess = $late_feess = $nsf_feess = $cancel_feess = $otherfeess = $downpaymentss = $AccountsPayabless = 0;
                            $IFFdatas[] = array();
                            $IFFdatas[] = array();
                        }

                        $currentpayment_method = $payment_method;
                        $totalss += $total;
                        $principalss += $principal;
                        $interestss += $interest;
                        $setup_feess += $setup_fee;
                        $late_feess += $late_fee;
                        $nsf_feess += $nsf_fee;
                        $cancel_feess += $cancel_fee;
                        $otherfeess += $otherfee;
                        $downpaymentss += $downpayment;
                        $AccountsPayabless += $AccountsPayable;

                        $IFFdatas[] = array(
                            $payment?->created_at,
                            $Entered,
                            $payment?->created_at,
                            $paymentUser?->name,
                            $accountData?->account_number,
                            $agentUser?->name,
                            $insuredUser?->name,
                            dollerFA($total ?? 0),
                            dollerFA($principal ?? 0),
                            dollerFA($interest ?? 0),
                            dollerFA($setup_fee ?? 0),
                            dollerFA($late_fee ?? 0),
                            dollerFA($nsf_fee ?? 0),
                            dollerFA($cancel_fee ?? 0),
                            dollerFA($downpayments ?? 0),
                            dollerFA($AccountsPayables ?? 0),
                        );
                        $n++;
                    }

                }
            }
/* dd($IFFdatas); */
            $downloadname = time() . '_csv_payment.csv';
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$downloadname",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0",
            );

            $callback = function () use ($IFFdatas) {
                $file = fopen('php://output', 'w');
                foreach ($IFFdatas as $ro) {
                    fputcsv($file, $ro);
                }
                fclose($file);

            };

            return response()->stream($callback, 200, $headers);

        } catch (\Throwable $th) {
            throw $th;

            return redirect()->back();
        }
    }

    /*  */
    public function downloadNachaFile(Request $request)
    {

        try {

            $type = $request->type;
            $id = $request->id;

            $data = PaymentsHistory::getData(['type' => 2])->where('id', $id)->first();
            $paymentIds = $data?->payment_ids;
            if (empty($data)) {
                throw new Error("Data Empty");
            }

            $achSetting = Setting::getData(['type' => 'nacha-ach-setting'])->first();
            $achSetting = !empty($achSetting?->json) ? json_decode($achSetting?->json) : null;

            if (!empty($achSetting)) {
                $routing_number_deposits = $achSetting?->routing_number_deposits ?? '';
                $routing_number_deposits = strlen($routing_number_deposits) < 9 ? str_pad($routing_number_deposits, 9, ' ') : $routing_number_deposits;

                $company_id_deposits = $achSetting?->company_id_deposits ?? '';
                $company_id_deposits = strlen($company_id_deposits) < 10 ? str_pad($company_id_deposits, 10, ' ') : $company_id_deposits;

                $file_id_deposits = $achSetting?->file_id_deposits ?? '';
                $file_id_deposits = strlen($file_id_deposits) < 10 ? str_pad($file_id_deposits, 10, ' ') : $file_id_deposits;

                $bank_name_deposits = $achSetting?->bank_name_deposits ?? '';
                $bank_name_deposits = strlen($bank_name_deposits) < 23 ? str_pad($bank_name_deposits, 23, ' ') : $bank_name_deposits;

                $origin_name_deposits = $achSetting?->origin_name_deposits ?? '';
                $origin_name_deposits = strlen($origin_name_deposits) < 23 ? str_pad($origin_name_deposits, 23, ' ') : $origin_name_deposits;

                $file_reference_code_deposits = $achSetting?->file_reference_code_deposits ?? '';
                $file_reference_code_deposits = strlen($file_reference_code_deposits) < 8 ? str_pad($file_reference_code_deposits, 8, ' ') : $file_reference_code_deposits;

                $company_name_deposits = $achSetting?->company_name_deposits ?? '';
                $company_name_deposits = strlen($company_name_deposits) < 16 ? str_pad($company_name_deposits, 16, ' ') : $company_name_deposits;

                $company_discretionary_data_deposits = $achSetting?->company_discretionary_data_deposits ?? '';
                $company_discretionary_data_deposits = strlen($company_discretionary_data_deposits) < 20 ? str_pad($company_discretionary_data_deposits, 20, ' ') : $company_discretionary_data_deposits;

                $insured_payment_entry_class_deposits = $achSetting?->insured_payment_entry_class_deposits ?? '';
                $insured_payment_entry_class_deposits = strlen($insured_payment_entry_class_deposits) < 3 ? str_pad($insured_payment_entry_class_deposits, 3, ' ') : $insured_payment_entry_class_deposits;

                $company_entry_description = $achSetting?->company_entry_description_deposits ?? '';
                $company_entry_description = strlen($company_entry_description) < 10 ? str_pad($company_entry_description, 10, ' ') : $company_entry_description_deposits;

                $blank = '';
                if ((strlen($blank)) < 3) {
                    $blank = str_pad($blank, 3, ' ');
                }

                $dfi_identification = !empty($routing_number_deposits) ? substr($routing_number_deposits, 0, 8) : '';
                if ((strlen($dfi_identification)) < 8) {
                    $dfi_identification = str_pad($dfi_identification, 8, ' ');
                }

                $batch_number = '0000001';
                if ((strlen($batch_number)) < 7) {
                    $batch_number = str_pad($batch_number, 7, ' ');
                }

                $blank16 = '';
                if ((strlen($blank16)) < 16) {
                    $blank16 = str_pad($blank16, 16, ' ');
                }
                $blank15 = '';
                if ((strlen($blank15)) < 15) {
                    $blank15 = str_pad($blank15, 15, ' ');
                }
                $blank3 = '';
                if ((strlen($blank3)) < 3) {
                    $blank3 = str_pad($blank3, 3, ' ');
                }
                $blank2 = '';
                if ((strlen($blank2)) < 2) {
                    $blank2 = str_pad($blank2, 2, ' ');
                }

                $foreign_exchange_indicator = '';
                if ((strlen($foreign_exchange_indicator)) < 2) {
                    $foreign_exchange_indicator = str_pad($foreign_exchange_indicator, 2, ' ');
                }
                $foreign_exchange_reference_indicator = '';
                if ((strlen($foreign_exchange_reference_indicator)) < 1) {
                    $foreign_exchange_reference_indicator = str_pad($foreign_exchange_reference_indicator, 1, ' ');
                }
                $iso_destination_country_code = '';
                if ((strlen($iso_destination_country_code)) < 2) {
                    $iso_destination_country_code = str_pad($iso_destination_country_code, 2, ' ');
                }
                $orignator_destination = '';
                if ((strlen($orignator_destination)) < 10) {
                    $orignator_destination = str_pad($orignator_destination, 10, ' ');
                }
                $standard_enter_class_code = '';
                if ((strlen($standard_enter_class_code)) < 3) {
                    $standard_enter_class_code = str_pad($standard_enter_class_code, 3, ' ');
                }
                $company_entry_description_code = '';
                if ((strlen($company_entry_description_code)) < 10) {
                    $company_entry_description_code = str_pad($company_entry_description_code, 10, ' ');
                }
                $iso_currency_code = '';
                if ((strlen($iso_currency_code)) < 3) {
                    $iso_currency_code = str_pad($iso_currency_code, 3, ' ');
                }
                $getway = '';
                if ((strlen($getway)) < 8) {
                    $getway = str_pad($getway, 8, ' ');
                }

                $currentdate = date('ymd');
                $currenttime = date('hm');
                $IFFdatas[] = array('101 ' . $routing_number_deposits . '' . $file_id_deposits . '' . $currentdate . '' . $currenttime . 'A094101' . $bank_name_deposits . '' . $origin_name_deposits . '' . $file_reference_code_deposits);
                $IFFdatas[] = array('5225' . '' . $company_name_deposits . '' . $company_discretionary_data_deposits . '' . $company_id_deposits . '' . $insured_payment_entry_class_deposits . '' . $company_entry_description . '' . $currentdate . '' . $currentdate . '' . $blank . '1' . $dfi_identification . '' . $batch_number);

                /* Payment Data */
                $patmentData = Payment::getData()->where('id', $paymentIds)->get();

                $totalroutingnumber = $totalamount = $p = 0;
                $trace_number = $batch_number;
                if (!empty($patmentData)) {
                    foreach ($patmentData as $key => $payment) {
                        # code...
                        $p++;
                        $accountData = $payment?->account_data;
                        $payment_method_account_type = $accountData?->payment_method_account_type ?? '';

                        $tranction_code = '27';
                        if ((strlen($tranction_code)) < 2) {
                            $tranction_code = str_pad($tranction_code, 2, ' ');
                        }

                        $rdfi_rounting_number = !empty($payment?->routing_number) ? substr($payment?->routing_number, 0, 8) : '';
                        $totalroutingnumber = !empty($rdfi_rounting_number) ? ($totalroutingnumber + (int) $rdfi_rounting_number) : $totalroutingnumber;
                        if ((strlen($rdfi_rounting_number)) < 8) {
                            $rdfi_rounting_number = str_pad($rdfi_rounting_number, 8, ' ');
                        }

                        $check_digit = !empty($payment?->routing_number) ? substr($payment?->routing_number, -1) : '';
                        if ((strlen($check_digit)) < 1) {
                            $check_digit = str_pad($check_digit, 1, ' ');
                        }

                        $dfi_account_number = !empty($payment?->account_number) ? substr($payment?->account_number, 0, 17) : '';
                        if ((strlen($dfi_account_number)) < 17) {
                            $dfi_account_number = str_pad($dfi_account_number, 17, ' ');
                        }

                        $indiviual_name = !empty($payment?->account_holder_name) ? substr($payment?->account_holder_name, 0, 22) : '';
                        if ((strlen($indiviual_name)) < 22) {
                            $indiviual_name = str_pad($indiviual_name, 22, ' ');
                        }

                        if ($p != '1') {
                            $trace_number++;
                        }

                        if ((strlen($trace_number)) < 7) {
                            $trace_number = str_pad($trace_number, 7, '0', STR_PAD_LEFT);
                        }

                        $amount = toFloat($payment?->amount ?? 0);
                        $totalamount += $amount;
                        $replaceamount = str_ireplace('.','',$amount);
                        if ((strlen($amount)) < 10) {
                            $amount = str_pad($amount, 10, "0", STR_PAD_LEFT);
                        }

                        $quote_account_number = !empty($accountData?->account_number) ? str_ireplace('.', '', $accountData?->account_number) : '';
                        $check_serial_number = $quote_account_number;
                        if ((strlen($check_serial_number)) < 15) {
                            $check_serial_number = str_pad($check_serial_number, 15, '0', STR_PAD_LEFT);
                        }

                        $IFFdatas[] = array('6' . '' . $tranction_code . '' . $rdfi_rounting_number . '' . $check_digit . '' . $dfi_account_number . '' . $replaceamount . '' . $check_serial_number . '' . $indiviual_name . '' . $blank2 . '0' . $dfi_identification . '' . $trace_number);
                      
                    }
                }

                $addenda_records = $p;
                if ((strlen($addenda_records)) < 6) {
                    $addenda_records = str_pad($addenda_records, 6, "0", STR_PAD_LEFT);
                } else if ((strlen($addenda_records)) > 6) {
                    $addenda_records = substr($addenda_records, 6);
                }

                $EntryHash = $totalroutingnumber;
                if ((strlen($EntryHash)) < 10) {
                    $EntryHash = str_pad($EntryHash, 10, "0", STR_PAD_LEFT);
                } else if ((strlen($EntryHash)) > 10) {
                    $EntryHash = substr($EntryHash, 10);
                }

                $zero12 = '';
                if ((strlen($zero12)) < 12) {
                    $zero12 = str_pad($zero12, 12, '0');
                }

                $totalamount = !empty($totalamount) ? toFloat($totalamount) : 0;
                if ((strlen($totalamount)) < 12) {
                    $totalamount = str_pad($totalamount, 12, "0", STR_PAD_LEFT);
                }

                $blank19 = '';
                if ((strlen($blank19)) < 19) {
                    $blank19 = str_pad($blank19, 19, ' ');
                }
                $blank6 = '';
                if ((strlen($blank6)) < 6) {
                    $blank6 = str_pad($blank6, 6, ' ');
                }

                $IFFdatas[] = array('8225' . '' . $addenda_records . '' . $EntryHash . '' . $totalamount . '' . $zero12 . '' . $company_id_deposits . '' . $blank19 . '' . $blank6 . '' . $dfi_identification . '' . $batch_number);

                $blank39 = '';
                if ((strlen($blank39)) < 39) {
                    $blank39 = str_pad($blank39, 39, ' ');
                }
                $addendarecords = $p;
                if ((strlen($addendarecords)) < 8) {
                    $addendarecords = str_pad($addendarecords, 8, "0", STR_PAD_LEFT);
                } else if ((strlen($addendarecords)) > 8) {
                    $addendarecords = substr($addendarecords, 8);
                }
                $IFFdatas[] = array('9000001' . '000001' . $addendarecords . '' . $EntryHash . '' . $totalamount . '' . $zero12 . '' . $blank39);

                $totalcount = count($IFFdatas);
                $getdigitnumber = tanValueGat($totalcount);
                $ninedigitrow = $getdigitnumber - $totalcount;
                $nine94 = '';
                if ((strlen($nine94)) < 94) {
                    $nine94 = str_pad($nine94, 94, '9');
                }
                if (($totalcount != $getdigitnumber) && !empty($ninedigitrow)) {
                    for ($i = 1; $i <= $ninedigitrow; $i++) {
                        $IFFdatas[] = array($nine94);
                    }
                } else if ($totalcount == $getdigitnumber) {
                    for ($i = 1; $i <= 10; $i++) {
                        $IFFdatas[] = array($nine94);
                    }
                }
            }


            $fileName = date('Y-m-d').'.text';
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0",
            );

            $callback = function () use ($IFFdatas) {
                $file = fopen('php://output', 'w');
                foreach ($IFFdatas as $ro =>$ff) {
                        fwrite($file,$ff[0]. "\r\n"); 
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);


        } catch (\Throwable $th) {
            throw $th;

            return redirect()->back();
        }

    }

}
