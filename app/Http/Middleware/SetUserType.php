<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Encryption\Encrypter;
use DB,Config,Artisan,Str,Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
class SetUserType
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
        $prefix  =  config('fortify.prefix');

        if(!empty($prefix)){
            switch ($prefix) {
                case 'livewire':
                    config(['fortify.prefix' =>null ]);
                    break;
                case 'cron':
                    break;
                case 'enetworks':
                    $appUrl = env('APP_URL')."/enetworks";
                  //  setEnv('APP_LIVE_URL',$appUrl);
                    session()->put('adminCompanyId',null);
                    Config::set(['database.default'=>'mysql']);
                    Config::set(['fortify.home'=>$prefix]);
                    break;
                default:
                    Config::set(['fortify.home'=>$prefix]);
                    $appUrl = env('APP_URL')."/".$prefix;
                   /*  $appLiveUrl = env('APP_LIVE_URL');
                    if($appUrl !== $appLiveUrl){
                        setEnv('APP_LIVE_URL',$appUrl);
                    } */
                    $companyData = Company::whereEncrypted('comp_domain_name',$prefix)->firstOrFail();
                    $usTimeZone  = $companyData?->us_time_zone ?? config("app.timezone");
                    Config::set(['app.timezone'=>$usTimeZone]);
                    $companyId    = $request->session()->get('adminCompanyId');
                    $request->merge(['company_data' =>$companyData]);


                break;
            }
        }else{
           abort(404);
        }
        return $next($request);
    }





}
