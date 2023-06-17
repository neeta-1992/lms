<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '';

    /* protected function removeIndexPhpFromUrl(){

    if (request()->isMethod('get') && Str::contains(request()->getRequestUri(), '/public/')) {
    $url = str_replace('/public', '', request()->getRequestUri());

    if (strlen($url) > 0) {
    header("Location: $url", true, 301);
    exit;
    }
    }
    } */
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {

        //$this->removeIndexPhpFromUrl();
        Route::resourceVerbs(['create' => 'add']);

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web', 'user_type_change')
                ->group(base_path('routes/web.php'));

        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

       /*  RateLimiter::for('login', function (Request $request) {
            $username = $request->all();
            dd( $username);
            $key = 'login.' . $request->ip();
            $max = 5; // attempts
            $decay = 60; //seconds

            if (RateLimiter::tooManyAttempts($key, $max)) {
                $seconds = RateLimiter::availableIn($key);
                return redirect()->route('login')
                ->with('error', __('auth.throttle', ['seconds' => $seconds]));
            } else {
                RateLimiter::hit($key, $decay);
            }
        }); */
    }

}
