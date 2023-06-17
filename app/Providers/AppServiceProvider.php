<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use DB,Config,Artisan,Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $prefix =  request()->segment(1);
        if (!$this->app->runningInConsole()) {
                switch ($prefix) {
                    case 'livewire':
                        config(['fortify.prefix' =>'livewire' ]);
                        break;
                    case 'cron':
                        config(['fortify.prefix' =>'cron' ]);
                        break;
                    case 'enetworks':
                        config(['fortify.prefix' =>'enetworks' ]);
                        break;
                    default:

                        config(['fortify.prefix' =>$prefix]);
                        break;
            }
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){

        Blade::directive('money', function ($amount) {
            return "<?php echo '$' . number_format($amount, 2); ?>";
        });

    }



}
