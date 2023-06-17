<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use DB;
use Illuminate\Http\Request;

class DBConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        try {

            $adminId = session()->get('adminCompanyId');
            $prefix = config('fortify.prefix');

            if(empty($prefix) && auth()->check() == true){
                $userData = auth()->user();
                $userType = $userData?->user_type ?? null;

                if(!empty($userData) && $userType !== 1){
                  /*   $companyName = $userData?->company?->comp_domain_name ?? null ;

                    Config::set(['fortify.prefix' => $companyName]);
                    return redirect()->route("company.dashboard"); */
                }else{
                    return redirect()->route("admin.dashboard");
                }
            }


            if ($prefix !== "enetworks") {
                if (empty($adminId)) {
                    Config::set(['database.is_connection' => 'company_mysql']);
                    Config::set(['database.default' => 'company_mysql']);
                }else{
                    Config::set(['database.is_connection' => 'company_mysql']);
                }
                $dbName = dbName($prefix);
                $defultDBName = config('database.connections.mysql.database');
                $userDatabase = "{$defultDBName}_$dbName";
                config(['database.connections.company_mysql.database' => $userDatabase]);
                DB::purge('company_mysql');
                DB::reconnect('company_mysql');
            }else{

            }


        }catch (\Illuminate\Database\QueryException $e){
        }catch (\Exception $e){
        }catch (\PDOException $e){
        }
        return $next($request);
    }
}
