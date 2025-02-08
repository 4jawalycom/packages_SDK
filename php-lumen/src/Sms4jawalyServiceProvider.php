<?php

namespace Sms4jawaly\Lumen;

use Illuminate\Support\ServiceProvider;

class Sms4jawalyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Gateway::class, function ($app) {
            $config = $app['config']['services.sms4jawaly'];
            return new Gateway(
                $config['api_key'],
                $config['api_secret']
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
