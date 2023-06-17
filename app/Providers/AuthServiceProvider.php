<?php

namespace App\Providers;

 use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\{
    Company,User
};
use App\Encryption\Encrypter;
use DB,Config,Artisan,Str,Auth,Session;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('isAdmin', function($user) {
           return ($user->user_type == User::ADMIN && empty(session()->get('adminCompanyId')));
        });
        Gate::define('isAdminCompany', function($user) {
            return $user->user_type == User::ADMIN && !empty(session()->get('adminCompanyId'));
        });
        Gate::define('companyAdmin', function($user) {
            return ($user->user_type == User::COMPANYUSER && $user->role == 1);
        });
        Gate::define('company', function($user) {
            return ($user->user_type == User::COMPANYUSER);
        });
        Gate::define('companyUser', function($user) {
            return ($user->user_type == User::COMPANYUSER && $user->role == 2);
        });
        Gate::define('agentUser', function($user) {
            return ($user->user_type == User::AGENT);
        });
        Gate::define('insuredUser', function($user) {
            return ($user->user_type == User::INSURED);
        });
        Gate::define('saleorgUser', function($user) {
            return ($user->user_type == User::SALESORG);
        });

    }



}
