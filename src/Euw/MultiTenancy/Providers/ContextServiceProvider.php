<?php namespace Euw\MultiTenancy\Providers;

use Illuminate\Support\ServiceProvider;

class ContextServiceProvider extends ServiceProvider
{

    /**
     * Register
     */
    public function register()
    {
        $this->app['context'] = $this->app->share(function ($app) {
            return new \Euw\MultiTenancy\Contexts\TenantContext;
        });

        $this->app->bind('Euw\MultiTenancy\Contexts\Context', function ($app) {
            return $app['context'];
        });
    }

}