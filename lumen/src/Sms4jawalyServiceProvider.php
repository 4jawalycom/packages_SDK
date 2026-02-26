<?php

namespace Sms4jawaly\Lumen;

use Illuminate\Support\ServiceProvider;

class Sms4jawalyServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/sms4jawaly.php', 'sms4jawaly');

        $this->registerSmsGateway();
        $this->registerWhatsAppGateway();
    }

    public function boot()
    {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__ . '/../config/sms4jawaly.php' => config_path('sms4jawaly.php'),
            ], 'sms4jawaly-config');
        }
    }

    private function registerSmsGateway()
    {
        $this->app->singleton(Gateway::class, function ($app) {
            $config = $app['config']['sms4jawaly'] ?? [];

            // Backward-compat: fall back to config/services.php → sms4jawaly
            if (empty($config['api_key']) && !empty($app['config']['services.sms4jawaly'])) {
                $legacy = $app['config']['services.sms4jawaly'];
                $config['api_key'] = $legacy['api_key'] ?? $config['api_key'] ?? '';
                $config['api_secret'] = $legacy['api_secret'] ?? $config['api_secret'] ?? '';
            }

            return new Gateway(
                $config['api_key'] ?? '',
                $config['api_secret'] ?? '',
                [
                    'base_url' => $config['base_url'] ?? Gateway::API_BASE_URL,
                    'timeout'  => $config['timeout'] ?? 30,
                ]
            );
        });
    }

    private function registerWhatsAppGateway()
    {
        $this->app->singleton(WhatsAppGateway::class, function ($app) {
            $config = $app['config']['sms4jawaly.whatsapp'] ?? [];

            return new WhatsAppGateway(
                $config['app_key'] ?? '',
                $config['api_secret'] ?? '',
                $config['project_id'] ?? '',
                [
                    'base_url' => $config['base_url'] ?? WhatsAppGateway::API_BASE_URL,
                    'timeout'  => $config['timeout'] ?? 30,
                ]
            );
        });
    }
}
