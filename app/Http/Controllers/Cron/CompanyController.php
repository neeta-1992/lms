<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    User,Company,CompanyEmailSetting,CompanyFaxSetting,RateTable
};
use DB,Config,Artisan,Schema;
class CompanyController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $companyUserData = User::whereUserType(2)->whereStatus(0)->orderBy('id',"ASC")->first();
		if(empty($companyUserData)){
            return dd('already create database and user data');
        }

        $companyData     = $companyUserData?->company;
        $companyFaxSettings = $companyData?->companyFaxSettings?->toArray();
        $companyEmailSettings  = $companyData?->companyEmailSettings?->toArray();
        $compDomainName  = $companyData?->comp_domain_name;
        $companyUserData = $companyUserData?->toArray();

        $adminUserData  =  User::whereUserType(1)->whereStatus(1)->first()?->makeHidden(['id','password','created_at','updated_at','name'])?->toArray();
        $rateTable  = RateTable::get()?->makeHidden(['created_at','updated_at'])?->toArray();

        $userId = $companyUserData['id'];
        $preDatabase = config('database.connections.mysql.database');

        if(!empty($companyUserData)){
            //Company Create DataBase On Company
            $comapnyUserName =  $compDomainName;
            $comapnyUserName =  !empty($comapnyUserName) ? strtolower(trim(str_replace("-","_",$comapnyUserName))) : "";

            $companyDBName   =  "{$preDatabase}_{$comapnyUserName}";
            //DB::statement("CREATE DATABASE IF NOT EXISTS {$companyDBName}");



            \Config::set('database.default','company_mysql');
            \Config::set('database.connections.company_mysql.database',$companyDBName);
            DB::purge('company_mysql');
            DB::reconnect('company_mysql');
            Artisan::call('migrate');
            Artisan::call('db:seed');

            if(Schema::connection('company_mysql')->hasTable('users')){
                if(!empty($companyData) ){

                /*
                    * Company All Data Save In Company DataBase
                */
                $ids = $this->saveDataCompany($companyData,$companyEmailSettings,$companyEmailSettings,$companyUserData,$adminUserData);

                /*
                * Defult Rate Table Data Save in Company Database
                */
                $this->saveRateTableData($rateTable,$ids);

                }
            }
            \Config::set('database.default','mysql');
            \Config::set('database.connections.mysql.database',$preDatabase);
            \Config::set('database.connections.company_mysql.database',null);
            DB::purge('mysql');
            DB::reconnect('mysql');

            User::whereId($companyUserData['id'])->update(['status'=>1]);
            return dd('create database and user data');
        }
    }


    private function saveDataCompany($adminCompanyData,$companyEmailSettingData,$companyFaxSetting,$companyUserData,$adminUserData){
        $adminId = 0;
        $companyAdminData = $adminCompanyData?->makeHidden(['id','deleted_at','created_at','updated_at'])->toArray();
        $companyAdminData['status'] =1;
        $comData = Company::saveCompany($companyAdminData); // Company Data Data Save
        $comId   = $comData->id;

        /*
         *  @Company Email Setting Save In Company DataBase
         */
        if(!empty($companyEmailSettingData) && !empty($comId)){
            foreach($companyEmailSettingData as $comAdminEmailSetting){
                $comAdminEmailSetting['company_id'] = $comId;

                CompanyEmailSetting::saveData($comAdminEmailSetting);
            }
        }

        /*
         *  @Company Fax Setting Save In Company DataBase
         */

        if(!empty($companyFaxSetting)){
            $companyFaxSetting['company_id'] = $comId;
            CompanyFaxSetting::saveData($companyFaxSetting);
        }

        /*
         *  Company Database Create User Table In Company Table And Admin Data
         */


        if(!empty($companyUserData) && !empty($comId)){

            /*
            * admin Data Save In company database For company table
            */
            $adminUserData['password'] = "null";
            $adminData = User::create($adminUserData);
            $adminId   = $adminData?->id;

            $companyUserData['company_id'] = $comId;
            $companyUserData['status'] =1;
            $companyUserData['passwordHash'] =1;
            $companyUserData['logId'] =$adminId;
            $userData=  User::saveCompany($companyUserData);
        }
        return (object)['companyId'=>$comId,'adminId'=>$adminId,'companyUserId'=>$userData?->id];
    }

    private function saveRateTableData($rateTable,$ids){

        if(empty($rateTable)){
            return false;
        }

        foreach($rateTable as $rateTableRow){
            $rateTableRow['user_id']    =  $ids?->adminId ?? 0;
            $rateTableRow['parent_id']  =  $rateTableRow['id'];
            $rateTableRow['logId']      =  $ids?->adminId ?? 0;
            unset($rateTableRow['id']);
            RateTable::insertOrUpdate($rateTableRow);
        }

    }
}
