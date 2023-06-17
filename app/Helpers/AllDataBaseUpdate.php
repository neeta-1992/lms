<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Route;
use Config;
use App\Models\{
    User,Company,RateTable,CoverageType,StateSettings,QuoteSetting
};
use DB;
class AllDataBaseUpdate{

    public static function allDataSave($model,$type,$data,$id){
        $companyData = Company::with('user')->whereHas('user',function($q){
          $q->whereIn('status',[1,3]);
        })->get();
        /* dd($companyData); */
        $preDatabase = config('database.connections.mysql.database');
        foreach($companyData as $companyRow){
            $compDomainName  = $companyRow?->comp_domain_name;
            $comapnyUserName =  !empty($compDomainName) ? strtolower(trim(str_replace("-","_",$compDomainName))) : "";
            $companyDBName   =  "{$preDatabase}_{$comapnyUserName}";

            \Config::set('database.connections.company_mysql.database',$companyDBName);
            DB::purge('company_mysql');
            DB::reconnect('company_mysql');

            self::saveData($model,$type,$data,$id);
            /* switch ($type) {
                case 'rateTable':
                    self::rateTableSaveData($data,$id);
                    break;
                case 'coverageType':
                    self::coverageTypeSaveData($data,$id);
                    break;
                case 'stateSetting':
                    self::stateSettingSaveData($data,$id);
                    break;
                default:
                    # code...
                    break;
            } */


        }
    }


    /*
     *  RateTable Table Data save Company DataBase RateTable
     */
    private static function saveData($model,$type,$data,$id){
        $data['onDB'] = "company_mysql";
        $data['parent_id'] = $data['id'];
        $data['parentId'] = $id;
        unset($data['save_option']);
        /* dd( $data); */
        $model::insertOrUpdate($data);
    }


    public static function quoteSetting(){
        $data = QuoteSetting::getData()->first();
        return $data;
    }
}
