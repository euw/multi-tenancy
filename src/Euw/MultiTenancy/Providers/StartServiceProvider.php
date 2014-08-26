<?php namespace Euw\MultiTenancy\Providers;

use Illuminate\Support\ServiceProvider;

class StartServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->register('Euw\MultiTenancy\Providers\ContextServiceProvider');
//        $this->app->register('Euw\MultiTenancy\Modules\Articles\Providers\ModuleProvider');
    }

}