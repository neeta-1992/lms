<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use ESolution\DBEncryption\Console\Commands\EncryptModel;
use ESolution\DBEncryption\Console\Commands\DecryptModel;
class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

     /**
     * Bootstrap the application services.
     *
     * This method is called after all other service providers have
     * been registered, meaning you have access to all other services
     * that have been registered by the framework.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootValidators();


    }


    private function bootValidators(){
         Validator::extend('unique_encrypted', function ($attribute, $value, $parameters, $validator) {
            // Initialize
            $salt = substr(hash('sha256', config('encryption.encrypt_key')), 0, 16);


            //$withFilter = count($parameters) > 3 ? true : false;

            // Check using normal checker
            $connection = config('database.is_connection');

            $data = DB::connection($connection)->table($parameters[0])->whereRaw("CONVERT(AES_DECRYPT(FROM_BASE64(`{$parameters[1]}`), '{$salt}') USING utf8mb4) = '{$value}' ");
            if(!empty($parameters[2]) && !empty($parameters[3])){
                $ignoreId = isEncryptValue($parameters[3]) == true ? decryptUrl($parameters[3]) : $parameters[3];
                $prm = !empty($parameters[2]) && ($parameters[2] == 'id' || $parameters[2] == 'uuid') ? "!=" : '=' ;
                $data->where($parameters[2],$prm,$ignoreId);
            }
            if (!empty($parameters[4]) && !empty($parameters[5])) {
                $data->where($parameters[4], $parameters[5]);
            }

            if($data->first()){
                return false;
            }

            return true;
        });



        Validator::extend('exists_encrypted', function ($attribute, $value, $parameters, $validator) {

            // Initialize
             $salt = substr(hash('sha256', config('encryption.encrypt_key')), 0, 16);

            $withFilter = count($parameters) > 3 ? true : false;
            if(!$withFilter){
                $ignore_id = isset($parameters[2]) ? $parameters[2] : '';
            }else{
                $ignore_id = isset($parameters[4]) ? $parameters[4] : '';
            }

            // Check using normal checker
            $connection = config('database.is_connection');
            $data =
            DB::connection($connection)->table($parameters[0])->whereRaw("CONVERT(AES_DECRYPT(FROM_BASE64(`{$parameters[1]}`),
            '{$salt}') USING utf8mb4) = '{$value}' ");
            $data = $ignore_id != '' ? $data->where('id','!=',$ignore_id) : $data;

            if ($withFilter) {
                $data->where($parameters[2], $parameters[3]);
            }

            if ($data->first()) {
                return true;
            }

            return false;
        });
    }




}
