<?php

namespace App\Console\Commands;

use App\Mail\CompanyDataBase as CompanyDataBaseMail;


use App\Models\{
    User,RateTable,CompanyFaxSetting,CompanyEmailSetting,Company,ScheduledTask,
    StateSettings,StateSettingsTwo,FinanceAgreement,Entity,NoticeTemplate,GlAccount,CancellationReasons
};
use Artisan;
use Config;
use DB;
use Illuminate\Console\Command;
use Mail;
use Schema;

class CompanyInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'company:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Install';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         Mail::raw('Cron running Successfully', function ($message) {
            $message->to('neetaagrawal19@gmail.com')->subject("Cron test");
        });

        $companyUserData = User::whereUserType(2)->whereIn("status",[0,2])->orderBy('id', "ASC")->first();

        if (empty($companyUserData)) {
            return $this->error('Already create database and user data');
        }
        $companyData = $companyUserData?->company;
        $companyFaxSettings = $companyData?->companyFaxSettings?->toArray();

        $companyEmailSettings = $companyData?->companyEmailSettings?->toArray();
        $compDomainName = $companyData?->comp_domain_name;
        $companyUserData = $companyUserData?->toArray();
        $adminUserData = User::whereUserType(1)->whereStatus(1)->first()?->makeHidden(['id', 'password', 'created_at', 'updated_at', 'name'])?->toArray();
        $rateTable = RateTable::get()?->makeHidden(['created_at', 'updated_at'])?->toArray();
        $StateSettings = StateSettings::with("StateSetting")->get()?->makeHidden(['created_at', 'updated_at'])?->toArray();
        $FinanceAgreement = FinanceAgreement::get()?->makeHidden(['created_at', 'updated_at'])?->toArray();
        $NoticeTemplate = NoticeTemplate::get()?->makeHidden(['created_at', 'updated_at'])?->toArray();
        $Entity = Entity::get()?->makeHidden(['created_at', 'updated_at'])?->toArray();
        $GlAccount = GlAccount::get()?->makeHidden(['created_at', 'updated_at'])?->toArray();
        $GlAccount = GlAccount::get()?->makeHidden(['created_at', 'updated_at'])?->toArray();
        $ScheduledTask = ScheduledTask::get()?->makeHidden(['created_at', 'updated_at'])?->toArray();
        $CancellationReasons = CancellationReasons::get()?->makeHidden(['created_at', 'updated_at'])?->toArray();
        $userId = $companyUserData['id'];

        $preDatabase = config('database.connections.mysql.database');

        if (!empty($companyUserData)) {
            //Company Create DataBase On Company
            $comapnyUserName = $compDomainName;
            $comapnyUserName = !empty($comapnyUserName) ? strtolower(trim(str_replace("-", "_", $comapnyUserName))) : "";

            $companyDBName = "{$preDatabase}_{$comapnyUserName}";
            //DB::statement("CREATE DATABASE IF NOT EXISTS {$companyDBName}");

            $isConn = true;
            if (!databseCheck($companyDBName)) {
                $isConn = false;
                try {

                    Mail::to(env('ADMIN_MAIL'))->send(new CompanyDataBaseMail(['name' => $companyDBName]));
                    $updateData = User::whereUserType(2)->whereId($userId)->update(['status' => 2]);

                    return $this->info($companyDBName . ' DATABASE SEND MAIL FOR ADMIN');
                } catch (\Throwable$th) {
                    $isConn = false;
                    die($th->getMessage());
                }
            }

            \Config::set('database.default', 'company_mysql');
            \Config::set('database.connections.company_mysql.database', $companyDBName);

            if (!$isConn) {
                return $this->error($companyDBName . ' DATABASE NOT EXISTS');
            }
            DB::purge('company_mysql');
            DB::reconnect('company_mysql');
            Artisan::call('migrate');
            Artisan::call('db:seed');

            if (Schema::connection('company_mysql')->hasTable('users')) {
                if (!empty($companyData)) {
                    /*
                     * Company All Data Save In Company DataBase
                     */
                    $ids = $this->saveDataCompany($companyData, $companyEmailSettings, $companyFaxSettings, $companyUserData, $adminUserData);

                    /*
                     * Defult Rate Table Data Save in Company Database
                     */
                    $this->saveStateSettings($StateSettings, $ids);
                    /*
                     * Defult FinanceAgreement Data Save in Company Database
                     */
                    $this->saveFinanceAgreement($FinanceAgreement, $ids);
                    /*
                     * Defult NoticeTemplate Data Save in Company Database
                     */
                    $this->saveNoticeTemplate($NoticeTemplate, $ids);
                    /*
                     * Defult Entity Data Save in Company Database
                     */
                    $this->saveInsuranceCompanies($Entity, $ids);
                    /*
                     * Defult GlAccount Data Save in Company Database
                     */
                    $this->saveGlAccount($GlAccount, $ids);
                    /*
                     * Defult saveScheduledTask Data Save in Company Database
                     */
                    $this->saveScheduledTask($ScheduledTask, $ids);
                    /*
                     * Defult saveScheduledTask Data Save in Company Database
                     */
                    $this->cancellationReasons($CancellationReasons, $ids);

                }
            }
            \Config::set('database.default', 'mysql');
            \Config::set('database.connections.mysql.database', $preDatabase);
            \Config::set('database.connections.company_mysql.database', null);
            DB::purge('mysql');
            DB::reconnect('mysql');

            User::whereId($companyUserData['id'])->update(['status' => 1]);
            $this->description = "{$companyDBName} DataBase Create Succussfully";
            return $this->info($this->description);
        }

    }

    private function saveDataCompany($adminCompanyData, $companyEmailSettingData, $companyFaxSetting, $companyUserData, $adminUserData)
    {
        $adminId = 0;
        $companyAdminData = $adminCompanyData?->makeHidden(['id', 'deleted_at', 'created_at', 'updated_at'])->toArray();
        $companyAdminData['status'] = 1;
        $comData = Company::saveCompany($companyAdminData); // Company Data Data Save
        $comId = $comData->id;

        /*
         *  @Company Email Setting Save In Company DataBase
         */
        if (!empty($companyEmailSettingData) && !empty($comId)) {
            foreach ($companyEmailSettingData as $comAdminEmailSetting) {
                $comAdminEmailSetting['company_id'] = $comId;

                CompanyEmailSetting::saveData($comAdminEmailSetting);
            }
        }

        /*
         *  @Company Fax Setting Save In Company DataBase
         */

        if (!empty($companyFaxSetting)) {
            $companyFaxSetting['company_id'] = $comId;

            CompanyFaxSetting::saveData($companyFaxSetting);
        }

        /*
         *  Company Database Create User Table In Company Table And Admin Data
         */

        if (!empty($companyUserData) && !empty($comId)) {
            /*
             * admin Data Save In company database For company table
             */
            $adminUserData['password'] = "null";
            $adminData = User::create($adminUserData);
            $adminId = $adminData?->id;

            $companyUserData['company_id'] = $comId;
            $companyUserData['status'] = 1;
            $companyUserData['passwordHash'] = 1;
            $companyUserData['logId'] = $adminId;
            $userData = User::saveCompany($companyUserData);
        }
        return (object) ['companyId' => $comId, 'adminId' => $adminId, 'companyUserId' => $userData?->id];
    }



    private function saveStateSettings($data, $ids) {

        if (empty($data)) {
            return false;
        }
        foreach ($data as $row) {
            $state_setting = $row['state_setting'];
            unset($row['state_setting']);
            $response = array_merge($state_setting,$row);
            $response['user_id'] = $ids?->adminId ?? 0;
            $response['parent_id'] = $row['id'];
            $response['logId'] = $ids?->adminId ?? 0;
            unset($response['id']);
            StateSettings::insertOrUpdate($response);
        }
    }

    private function saveFinanceAgreement($data, $ids){
        if (empty($data)) {
            return false;
        }
        foreach ($data as $row) {
            $row['user_id'] = $ids?->adminId ?? 0;
            $row['parent_id'] = $row['id'];
            $row['logId'] = $ids?->adminId ?? 0;
            unset($row['id']);
            FinanceAgreement::insertOrUpdate($row);
        }
    }
    private function saveNoticeTemplate($data, $ids){
        if (empty($data)) {
            return false;
        }
        foreach ($data as $row) {
            $row['user_id'] = $ids?->adminId ?? 0;
            $row['parent_id'] = $row['id'];
            $row['logId'] = $ids?->adminId ?? 0;
            unset($row['id']);
            NoticeTemplate::insertOrUpdate($row);
        }
    }


    private function saveInsuranceCompanies($data, $ids){
        if (empty($data)) {
            return false;
        }
        foreach ($data as $row) {
            $row['user_id'] = $ids?->adminId ?? 0;
            $row['parent_id'] = $row['id'];
             $row['activePage'] = "insurance-company";
            $row['logId'] = $ids?->adminId ?? 0;
            unset($row['id']);
            Entity::insertOrUpdate($row);
        }
    }

    private function saveGlAccount($data, $ids){
        if (empty($data)) {
            return false;
        }
        foreach ($data as $row) {
            $row['user_id'] = $ids?->adminId ?? 0;
            $row['parent_id'] = $row['id'];
            $row['logId'] = $ids?->adminId ?? 0;
            unset($row['id']);
            GlAccount::insertOrUpdate($row);
        }
    }


      private function saveScheduledTask($data, $ids){
        if (empty($data)) {
            return false;
        }
        foreach ($data as $row) {
            $row['user_id'] = $ids?->adminId ?? 0;
            $row['parent_id'] = $row['id'];
            $row['activePage'] = "scheduled-task";
            $row['logId'] = $ids?->adminId ?? 0;
            unset($row['id']);
            ScheduledTask::insertOrUpdate($row);
        }
    }






    private function saveRateTableData($rateTable, $ids)
    {
        if (empty($rateTable)) {
            return false;
        }
        foreach ($rateTable as $rateTableRow) {
            $rateTableRow['user_id'] = $ids?->adminId ?? 0;
            $rateTableRow['parent_id'] = $rateTableRow['id'];
            $rateTableRow['logId'] = $ids?->adminId ?? 0;
            unset($rateTableRow['id']);
            RateTable::insertOrUpdate($rateTableRow);
        }
    }


    private function cancellationReasons($cancellationReasons, $ids)
    {
        if (empty($cancellationReasons)) {
            return false;
        }
        foreach ($cancellationReasons as $row) {
            $row['user_id'] = $ids?->adminId ?? 0;
            $row['parent_id'] = $row['id'];
            $row['logId'] = $ids?->adminId ?? 0;
            unset($row['id']);
            CancellationReasons::insertOrUpdate($row);
        }
    }
}
