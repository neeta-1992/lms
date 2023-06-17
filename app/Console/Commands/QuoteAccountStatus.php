<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{
    QuoteAccountExposure,QuoteAccount,Company,User,AccountStatusSetting,Logs,TransactionHistory
};
use DBHelper,Config,Artisan,DB;
use Schema;
use App\Helpers\{
    DailyNotice
};
class QuoteAccountStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'account-status:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Quote Account Status Change';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userData = Company::getData(['type'=>'0'])->with('user')
                            ->whereHas('user',function($q){
                                 return $q->whereIn('status',[1,3]);
                            })->orderBy('id', "ASC")->get();

        if(empty($userData?->toArray())){
            return $this->error('User Data Not Found');
        }


        foreach($userData as $userRow){
            $compDomainName = $userRow?->comp_domain_name;
            $preDatabase    = config('database.connections.mysql.database');
            $comapnyUserName = !empty($compDomainName) ? dbName($compDomainName) : "";
            if(!empty($comapnyUserName)){
                $companyDBName = "{$preDatabase}_{$comapnyUserName}";
                if (databseCheck($companyDBName)) {
                    \Config::set('database.default', 'company_mysql');
                    \Config::set('database.connections.company_mysql.database', $companyDBName);
                    \DB::purge('company_mysql');
                    \DB::reconnect('company_mysql');


                    if (Schema::connection('company_mysql')->hasTable('users')) {
                         $this->quoteStatus();
                    }

                    \Config::set('database.default', 'mysql');
                    \Config::set('database.connections.mysql.database', $preDatabase);
                    \Config::set('database.connections.company_mysql.database', null);
                    DB::purge('mysql');
                    DB::reconnect('mysql');
                }
            }
        }



       // $data  = QuoteAccountExposure::getData();
        return Command::SUCCESS;
    }



    private function quoteStatus() {

      //  dd(date('Y-m-d', strtotime("+ 10 day")));
        $userData = DBHelper::userData(['type' => User::ADMIN])->first();
        $userId   = $userData?->id; 
        $qAE = QuoteAccountExposure::getData()->where('status',0)->with('account_data')->groupBy('account_id')->get();
        
        if(empty($qAE)){
            return $this->error('Data Empty');
        }
        $currentDate = date('Y-m-d');
        $canceldays = $cancellationFee =0;
        foreach($qAE as $key => $q){
            $paymentNumber = $q?->payment_number;
            $accountData = $q?->account_data;
            $accountId = $accountData?->id;
            $quoteTerm = $accountData?->quote_term;
            $numberOfPayment = $quoteTerm?->number_of_payment ?? 0;
            $accountType = $accountData?->account_type;
            $letFee      = $accountData?->latecharge ?? 0;
            $qFaLetFee   = floatval($q?->late_fee);
            $qFaCancelFee   = floatval($q?->cancel_fee);
           
           
            $letFee      = empty($letFee) ? floatval($letFee) : 0;
            $dueDate     = !empty($q?->payment_due_date) ? date('Y-m-d',strtotime($q?->payment_due_date)) : '';
            if(!empty($accountData)){
                $accountStatus = $accountData?->status ?? 0 ;
                $settingState  = $accountData?->quoteoriginationstate ?? 0 ;
                
                $accountStatusSetting = AccountStatusSetting::with('state_data')->whereHas('state_data',function($q)use($settingState) {
                    $q->whereEn('state',$settingState);
                })->first();
                if(!empty($accountStatusSetting)){

                    if($accountStatus == 1){

                        $account_days_overdue = $accountStatusSetting?->account_days_overdue ?? config('custom.account_status_setting.account_days_overdue');
                        $accountDueDate = !empty($account_days_overdue) ? date('Y-m-d',strtotime("+ {$account_days_overdue} days")) : '';

                       /*  if($accountDueDate <= $currentDate){ */
                            //Intent To Cancel Status Update Account
                            if($accountType  == 'commercial'){
                                $canceldays = $accountStatusSetting?->commercial_lines_days ?? config('custom.account_status_setting.commercial_lines_days');
                            }else if($accountType == 'personal'){
                                $canceldays = $accountStatusSetting?->personal_lines_days ?? config('custom.account_status_setting.personal_lines_days');
                            }

                            $cancelDate = !empty($canceldays) ? date('Y-m-d', strtotime("+".$canceldays." day",strtotime($currentDate))) : '';

                            $accountData->cancel_date = $cancelDate;
                            $accountData->status = 2;
                            $accountData->save();

                            $msg = 'Account intent to cancel by System';
                            !empty($msg) && Logs::saveLogs(['type'=>'accounts','user_id'=> $userId,'type_id'=>$accountData?->id ,'message'=>$msg]);

                            $transactionHistory = TransactionHistory::getData(['accountId'=>$accountId])->orderBy('created_at','desc')->first();
                            $balance   = floatval($transactionHistory?->balance ?? 0);
                            if(!empty($letFee) && empty($qFaLetFee)){

                                $q->late_fee = $letFee;
                                $q?->save();
                           
                                $totalBalance = ($balance + $letFee);
                                $transactionHistoryArr = [
                                    'payment_number'    => $paymentNumber,
                                    'account_id'        => $accountData->id,
                                    'description'       => 'Late Fee for Installment '.$paymentNumber.' of '.$numberOfPayment,
                                    'transaction_type'  => 'Late Fee',
                                    'balance'           => $totalBalance,
                                    'amount'            => $letFee,
                                    'debit'             => $letFee,
                                    'user_id'           => $userId ,
                                ];
                                TransactionHistory::insertOrUpdate($transactionHistoryArr);
                            }else{
                                $letFee = 0;
                            }

                            $accountbalance = (floatval($balance) + floatval($letFee));
                            $transactionHistoryArr = [
                                'payment_number'    => $paymentNumber,
                                'account_id'        => $accountData->id,
                                'transaction_type'   => 'Status',
                                'description'       => 'Intent to cancel',
                                'balance'           => $accountbalance,
                                'user_id'           => $userId,
                            ];
                            TransactionHistory::insertOrUpdate($transactionHistoryArr);
                            /* Daily Notice Created */
                            DailyNotice::accountStatusNoticesSend(['accountData' =>$accountData,'action' => 'intent_to_cancel','quoteTerm'=>$quoteTerm]);
                            $this->info($msg);
                        //}
                    }elseif($accountStatus == 2){
                        //Cancel
                        $accountCancelDate = $accountData->cancel_date;
                        $fewer_days_remaining = $accountStatusSetting?->fewer_days_remaining ?? config('custom.account_status_setting.fewer_days_remaining');
                        $accountDueDate = !empty($fewer_days_remaining) ? date('Y-m-d',strtotime("+ {$fewer_days_remaining} days",strtotime($accountCancelDate))) : '';

                    /*     if($accountDueDate <= $currentDate){ */
                            if($accountType  == 'commercial'){
                                $cancellationFee = $accountStatusSetting?->commercial_lines ?? config('custom.account_status_setting.commercial_lines');
                                $cancellationDay = $accountStatusSetting?->cancel_date_commercial_lines ?? config('custom.account_status_setting.cancel_date_commercial_lines');
                            }else if($accountType == 'personal'){
                                $cancellationFee = $accountStatusSetting?->personal_lines ?? config('custom.account_status_setting.personal_lines');
                                $cancellationDay = $accountStatusSetting?->cancel_date_personal_lines ?? config('custom.account_status_setting.cancel_date_personal_lines');
                            }

                          
                            /* Cancel Data */
                            $accountData->cancel_date = $currentDate;
                            $accountData->status = 3;
                            $accountData->save();


                            $msg = 'Account Canceled by System';
                            !empty($msg) && Logs::saveLogs(['type'=>'accounts','user_id'=>$userId,'type_id'=>$accountData?->id ,'message'=>$msg]);


                            $transactionHistory = TransactionHistory::getData(['accountId'=>$accountId])->orderBy('created_at','desc')->first();
                            $balance   = floatval($transactionHistory?->balance ?? 0);
                            if(!empty($letFee) && empty($qFaCancelFee)){

                                $q->cancel_fee = $cancellationFee;
                                $q?->save();
                                $totalBalance = ($balance + $cancellationFee);
                                $transactionHistoryArr = [
                                    'payment_number'    => $paymentNumber,
                                    'account_id'        => $accountData->id,
                                    
                                    'description'       => 'Cancel Fee for Installment '.$paymentNumber.' of '.$numberOfPayment,
                                    'transaction_type'  => 'Cancel Fee',
                                    'balance'           => $totalBalance,
                                    'amount'            => $cancellationFee,
                                    'debit'             => $cancellationFee,
                                    'user_id'           => $userId,
                                ];
                                TransactionHistory::insertOrUpdate($transactionHistoryArr);
                            }else{
                                $cancellationFee = 0;
                            }

                            $accountbalance = (floatval($balance) + floatval($cancellationFee));
                            $transactionHistoryArr = [
                                'payment_number'    => $paymentNumber,
                                'account_id'        => $accountData->id,
                               'transaction_type'   => 'Status',
                                'description'       => 'Canceled',
                                'balance'           => $accountbalance,
                                'user_id'           => $userId,
                            ];
                            TransactionHistory::insertOrUpdate($transactionHistoryArr);

                            /* Daily Notice Created */
                            DailyNotice::accountStatusNoticesSend(['accountData' =>$accountData,'action' => 'cancellation_notice','quoteTerm'=>$quoteTerm]);
                            $this->info($msg);
                      //  }

                    }elseif($accountStatus == 3){
                        $accountCancelDate = $accountData->cancel_date;
                        $cancellation_notice_days = $accountStatusSetting?->cancellation_notice_days ?? config('custom.cancellation_notice_days.fewer_days_remaining');
                        $accountDueDate = !empty($cancellation_notice_days) ? date('Y-m-d',strtotime("+ {$cancellation_notice_days} days",strtotime($accountCancelDate))) : '';

                        if($accountDueDate <= $currentDate){
                           

                        
                            /* Cancel Data */
                            $accountData->cancel_date = $currentDate;
                            $accountData->status = 4;
                            $accountData->save();

                          

                            $msg = 'Account Cancel 1 by System';
                            !empty($msg) && Logs::saveLogs(['type'=>'accounts','user_id'=>$userId,'type_id'=>$accountData?->id ,'message'=>$msg]);


                            $transactionHistory = TransactionHistory::getData(['accountId'=>$accountId])->orderBy('created_at','desc')->first();
                            $balance   = floatval($transactionHistory?->balance ?? 0);
                               
                            $transactionHistoryArr = [
                                'payment_number'    => $paymentNumber,
                                'account_id'        => $accountData->id,
                                'transaction_type'   => 'Status',
                                'description'       => 'Cancel 1',
                                'balance'           => $balance,
                                'user_id'           => $userId,
                            ];
                            TransactionHistory::insertOrUpdate($transactionHistoryArr);
                            
                            /* Daily Notice Created */
                            DailyNotice::accountStatusNoticesSend(['accountData' =>$accountData,'action' => 'cancel_letter_1','quoteTerm'=>$quoteTerm]);
                            $this->info($msg);
                        }
                    }elseif($accountStatus == 4){
                        $accountCancelDate = $accountData->cancel_date;
                        $sending_cancel_days = $accountStatusSetting?->sending_cancel_days ?? config('custom.cancellation_notice_days.sending_cancel_days');
                        $accountDueDate = !empty($sending_cancel_days) ? date('Y-m-d',strtotime("+ {$sending_cancel_days} days",strtotime($accountCancelDate))) : '';

                        if($accountDueDate <= $currentDate){
                           

                        
                            /* Cancel Data */
                            $accountData->cancel_date = $currentDate;
                            $accountData->status = 5;
                            $accountData->save();


                            $msg = 'Account Cancel 2 by System';
                            !empty($msg) && Logs::saveLogs(['type'=>'accounts','user_id'=>$userId,'type_id'=>$accountData?->id ,'message'=>$msg]);


                            $transactionHistory = TransactionHistory::getData(['accountId'=>$accountId])->orderBy('created_at','desc')->first();
                            $balance   = floatval($transactionHistory?->balance ?? 0);
                               
                            $transactionHistoryArr = [
                                'payment_number'    => $paymentNumber,
                                'account_id'        => $accountData->id,
                                'transaction_type'   => 'Status',
                                'description'       => 'Cancel 2',
                                'balance'           => $balance,
                                'user_id'           => $userId,
                              
                            ];
                            TransactionHistory::insertOrUpdate($transactionHistoryArr);
                            
                            /* Daily Notice Created */
                            DailyNotice::accountStatusNoticesSend(['accountData' =>$accountData,'action' => 'cancel_letter_2','quoteTerm'=>$quoteTerm]);
                            $this->info($msg);
                        }
                    }elseif($accountStatus == 5){
                        $accountCancelDate = $accountData->cancel_date;
                        $sending_cancel_days_collection = $accountStatusSetting?->sending_cancel_days_collection ?? config('custom.cancellation_notice_days.sending_cancel_days_collection');
                        $accountDueDate = !empty($sending_cancel_days_collection) ? date('Y-m-d',strtotime("+ {$sending_cancel_days_collection} days",strtotime($accountCancelDate))) : '';

                        if($accountDueDate <= $currentDate){
                           

                        
                            /* Cancel Data */
                            $accountData->cancel_date = $currentDate;
                            $accountData->status = 6;
                            $accountData->save();

                            $accountStatusText = "Collection";   
                            $msg = "Account {$accountStatusText} by System";
                            !empty($msg) && Logs::saveLogs(['type'=>'accounts','user_id'=>$userId,'type_id'=>$accountData?->id ,'message'=>$msg]);


                            $transactionHistory = TransactionHistory::getData(['accountId'=>$accountId])->orderBy('created_at','desc')->first();
                            $balance   = floatval($transactionHistory?->balance ?? 0);
                               
                            $transactionHistoryArr = [
                                'payment_number'    => $paymentNumber,
                                'account_id'        => $accountData->id,
                                'transaction_type'   => 'Status',
                                'description'       => $accountStatusText,
                                'balance'           => $balance,
                                'user_id'           => $userId,
                              
                            ];
                            TransactionHistory::insertOrUpdate($transactionHistoryArr);
                            
                            /* Daily Notice Created */
                            DailyNotice::accountStatusNoticesSend(['accountData' =>$accountData,'action' => 'collection','quoteTerm'=>$quoteTerm]);
                            $this->info($msg);
                        }
                    }elseif($accountStatus == 6){
                        $accountCancelDate = $accountData->cancel_date;
                        $most_recent_date_days = $accountStatusSetting?->most_recent_date_days ?? config('custom.cancellation_notice_days.most_recent_date_days');
                        $accountDueDate = !empty($most_recent_date_days) ? date('Y-m-d',strtotime("+ {$most_recent_date_days} days",strtotime($accountCancelDate))) : '';

                        if($accountDueDate <= $currentDate){
                           

                        
                            /* Cancel Data */
                            $accountData->cancel_date = $currentDate;
                            $accountData->status = 7;
                            $accountData->save();

                            $accountStatusText = "Closed";   
                            $msg = "Account {$accountStatusText} by System";
                            !empty($msg) && Logs::saveLogs(['type'=>'accounts','user_id'=>$userId,'type_id'=>$accountData?->id ,'message'=>$msg]);


                            $transactionHistory = TransactionHistory::getData(['accountId'=>$accountId])->orderBy('created_at','desc')->first();
                            $balance   = floatval($transactionHistory?->balance ?? 0);
                               
                            $transactionHistoryArr = [
                                'payment_number'    => $paymentNumber,
                                'account_id'        => $accountData->id,
                                'transaction_type'   => 'Status',
                                'description'       => $accountStatusText,
                                'balance'           => $balance,
                                'user_id'           => $userId,
                              
                            ];
                            TransactionHistory::insertOrUpdate($transactionHistoryArr);
                            
                            /* Daily Notice Created */
                            //DailyNotice::accountStatusNoticesSend(['accountData' =>$accountData,'action' => 'closed','quoteTerm'=>$quoteTerm]);
                            $this->info($msg);
                        }
                    }
                }
            }
        }

    }




}
