<?php

namespace App\Providers;

use App\Models\Settings;
use App\Macro\AppBoot;
use App\Mixins\AppMixins;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\Resource;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{

    protected $appConfig = array();
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Resource::withoutWrapping();

        $settings = Settings::get();
        $appConfig = array();
        foreach ($settings as $setting) {
            $appConfig[$setting->name] = $setting->value;
        }

        setlocale(LC_TIME, $appConfig['default_language'], $appConfig['default_language'].'.utf-8', $appConfig['default_language'].'.utf-8');

        \Carbon\Carbon::setLocale($appConfig['default_language']);
        /** Share settings with views */
        View::share([
            'settings' => $appConfig
        ]);

        Str::macro('generatePassword', function(){
            return Str::random(12);
        });

        AppBoot::mixin(new AppMixins());

        //$this->registerPolicies();

        if (! $this->app->routesAreCached()) {
           // Passport::routes();
        }
        Passport::routes();
    }

    /**
     * Project int method
     */


}
