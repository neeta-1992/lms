<?php

namespace App\Console\Commands;

use Config;
use DB;
use Illuminate\Console\Command;
use Schema;
use App\Models\{
    QuoteAccountExposure,QuoteAccount,Company,User,PendingPayment,
    AccountStatusSetting,Logs,TransactionHistory,Payment as PaymentModel
};
use DBHelper;
class Payment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account:pay';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Account Payment For Ach And Credit card';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $userData = Company::getData(['type' => '0'])->with('user')
            ->whereHas('user', function ($q) {
                return $q->whereIn('status', [1, 3]);
            })->orderBy('id', "ASC")->get();

        if (empty($userData?->toArray())) {
            return $this->error('User Data Not Found');
        }

        foreach ($userData as $userRow) {
            $compDomainName = $userRow?->comp_domain_name;
            $preDatabase = config('database.connections.mysql.database');
            $comapnyUserName = !empty($compDomainName) ? dbName($compDomainName) : "";
            if (!empty($comapnyUserName)) {
                $companyDBName = "{$preDatabase}_{$comapnyUserName}";
                if (databseCheck($companyDBName)) {
                    \Config::set('database.default', 'company_mysql');
                    \Config::set('database.connections.company_mysql.database', $companyDBName);
                    \DB::purge('company_mysql');
                    \DB::reconnect('company_mysql');

                    if (Schema::connection('company_mysql')->hasTable('users')) {
                        $this->accountPayment();
                    }

                    \Config::set('database.default', 'mysql');
                    \Config::set('database.connections.mysql.database', $preDatabase);
                    \Config::set('database.connections.company_mysql.database', null);
                    DB::purge('mysql');
                    DB::reconnect('mysql');
                }
            }
        }

        return Command::SUCCESS;
    }




    private function accountPayment() {

        $payment = QuoteAccount::getData()
                    ->where('payment_status',0)
                    ->where('suspend_status',0)
                    ->whereIn('status',[1,2,3])
                    ->where(function($q){
                        $q->whereRaw('payment_method = "ach"')->orWhereRaw('payment_method = "credit_card"');
                    })->get();
        
        $request = request();
       
        if(!empty($payment)){
            foreach ($payment as $key => $data) {
                # code...
                $quoteData              = $data?->q_data; //Quote Data
                $quoteTerm              = $data?->quote_term; //Quote Trem Data
                $numberOfpayment        = $quoteTerm?->number_of_payment ?? 0;
                $accountType            = $quoteData?->account_type;
                $nextPayment            = $data?->next_payment; // Next Payment Data
                $paymentMethod          = $data?->payment_method; // Next Payment Data
                $convenienceFee         = 0;
    
                if(!empty($nextPayment) ){

                    $pendingPayment = PendingPayment::getData(['accountId'=>$data->id])
                                        ->selectRaw('payment_number,SUM(due_installment) as amount,SUM(due_late_fee) as lateFee,SUM(due_cancel_fee) as cancelFee,SUM(due_nsf_fee) as nsfFee,SUM(due_convient_fee) as convientFee')
                                        ->orderBy('created_at','desc')->first();

                    $pendingAmount      = !empty($pendingPayment?->amount) ? floatval($pendingPayment?->amount) : 0 ;
                    $pendingLateFee     = !empty($pendingPayment?->lateFee) ? floatval($pendingPayment?->lateFee) : 0 ;
                    $pendingcancelFee   = !empty($pendingPayment?->cancelFee) ? floatval($pendingPayment?->cancelFee) : 0 ;
                    $pendingNsfFee      = !empty($pendingPayment?->nsfFee) ? floatval($pendingPayment?->nsfFee) : 0 ;
                    $pendingConvientFee = !empty($pendingPayment?->convientFee) ? floatval($pendingPayment?->convientFee) : 0 ;

                    
                    $monthly_payment    = floatval($nextPayment->monthly_payment ?? 0) + $pendingAmount;
                    $late_fee           = floatval($nextPayment->late_fee ?? 0) + $pendingLateFee;
                    $cancel_fee         = floatval($nextPayment->cancel_fee ?? 0) + $pendingcancelFee;
                    $nsf_fee            = floatval($nextPayment->nsf_fee ?? 0) + $pendingNsfFee;
                    $totalAmount        = $monthly_payment + $late_fee + $cancel_fee + $nsf_fee ;

                    $stateSettings  = !empty($data?->state_settings) ? json_decode($data?->state_settings, true) : '';
                    $percentageFeeCreditCard = !empty($stateSettings['state_setting']['percentage_fee_credit_card']) ? toRound($stateSettings['state_setting']['percentage_fee_credit_card']) : 0;
                    $feeCreditCard  = !empty($stateSettings['state_setting']['fee_credit_card']) ? formatAmount($stateSettings['state_setting']['fee_credit_card']) : 0;
                    $percentageCommFeeCreditCard = !empty($stateSettings['state_setting']['percentage_comm_fee_credit_card']) ? toRound($stateSettings['state_setting']['percentage_comm_fee_credit_card']) : 0;
                    $commFeeCreditCard = !empty($stateSettings['state_setting']['comm_fee_credit_card']) ? formatAmount($stateSettings['state_setting']['comm_fee_credit_card']) : 0;

                    if(!empty($paymentMethod) && $paymentMethod == 'credit_card'){
                        if (!empty($accountType) && $accountType == 'commercial') {
                            $convenienceFee = $totalAmount * $percentageCommFeeCreditCard / 100 + $feeCreditCard;
                        } elseif (!empty($accountType) && $accountType == 'personal') {
                            $convenienceFee = $totalAmount * $percentageFeeCreditCard / 100 + $feeCreditCard;
                        }
                        $request['convenience_fee']             =  $convenienceFee;
                    }
                    

                    $adminData                              =  User::getData(['type' => User::ADMIN])->first();
                    $request['activePage']                  = 'accounts';
                    $request['userData']                    =  $adminData;
                    $request['account_id']                  =  $data->id;
                    $request['payment_number']              =  $nextPayment->payment_number;
                    $request['payment_type']                =  'installment';
                    $request['payment_method']              =  $data->payment_method;
                    $request['due_payment']                 =  $totalAmount;
                    $request['amount_apply_installment']    =  $totalAmount;
                    $request['received_from']               =  'insured';
                    $request['payType']                     =  'cron';
                   
                    PaymentModel::savePayment($data,$numberOfpayment,$accountType,$nextPayment,$request);
                }
                

            }
            $this->info('Success');
        }

    }
}
