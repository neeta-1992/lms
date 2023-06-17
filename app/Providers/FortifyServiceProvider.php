<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Models\{
    User,PasswordReset,Company,UserSecuritySetting
};
use Hash,Str,Auth;
use Laravel\Fortify\Contracts\LoginResponse;
class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
        public function toResponse($request)
            {

                $prefix =   config('fortify.prefix'); ;
                return redirect($prefix.'/login');
            }
        });

        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
        public function toResponse($request)
        {
            $error = false;
            $userData = $request->user();
            $passwordExpiry = !empty($userData->password_expiry) ? $userData->password_expiry : '' ;
            $username       = !empty($userData->username) ? $userData->username : '' ;
            $status         = !empty($userData->status) ? (int)$userData->status : 0 ;
            $suspend        = !empty($userData->suspend) ? (int)$userData->suspend : 0 ;
            $userType       = !empty($userData->user_type) ? (int)$userData->user_type : 0 ;

            if($status  === 0){
                Auth::logout();
                return  redirect()->back()->with(['error' => "Youe account is deactive please contact administrator"])->withInput();
            }
            if($suspend === 1){
                Auth::logout();
                return  redirect()->back()->with(['error' => "Youe account is suspended please contact administrator"])->withInput();
            }
            if(!empty($passwordExpiry)){
                if($passwordExpiry <= date('Y-m-d')){
                    $verify = PasswordReset::getData(['username'=>$username]);
                    if ($verify->exists()) {
                        $verify->delete();
                    }
                    $token = Str::uuid().time().Str::random(20);
                    PasswordReset::create([
                        'username' => $userData?->username,
                        'token' => $token,
                        'user_type' => $userData?->user_type,
                        'created_at' => now()
                    ]);
                    Auth::logout();
                    session()->flash('status','Your password has expired please choose a new password');
                    return redirect()->route('reset.password.get', ['token' => $token]);
                }

            }
            $userData->login_date = date('Y-m-d');
            $userData->save();
            if(!empty($userType) && $userType == 1){
                return redirect('enetworks');
            }else{
                $prefix  = config('fortify.prefix');
                if(empty($prefix)){
                    $prefix = $userData?->company?->comp_domain_name ?? null;
                }
                return redirect($prefix);
            }
        }
    });
    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Fortify::authenticateUsing(function (Request $request) {
            $userType = config("fortify.prefix");
           /// $userType = $userType == "enetworks" ? 1 : 2;
            $user = User::whereEncrypted('username', $request->username)->first();
		//	dd( $user->toArray());
            if ($user &&  Hash::check($request->password, $user?->password)) {
                return $user;
            }
         });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $username = (string) $request->username;
            $prefix   = config("fortify.prefix");
            $userData = User::whereEncrypted('username', $username)->first();
            $userType = !empty($userData->user_type) ? (int)$userData->user_type : 0 ;
            $UserSecuritySetting = UserSecuritySetting::getData(['type'=>$userType])->first();
            $number_unsuccessful_in = $UserSecuritySetting?->number_unsuccessful_in ?? 5;
            $number_unsuccessful_minutes = $UserSecuritySetting?->number_unsuccessful_minutes ?? 60;
            $key = $username.$request->ip();
            $max = $number_unsuccessful_in; // attempts
            $decay = $number_unsuccessful_minutes; //seconds

            if (RateLimiter::tooManyAttempts($key, $max)) {
                $seconds = RateLimiter::availableIn($key);
                return redirect()->route('login')->with('error', __('auth.throttle', ['seconds' => $seconds]));
            } else {
                RateLimiter::hit($key, $decay);
            }

        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
