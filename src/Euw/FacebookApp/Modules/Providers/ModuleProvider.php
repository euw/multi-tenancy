<?php namespace Euw\FacebookApp\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use Euw\FacebookApp\Modules\Texts\Models\Text;
use Euw\FacebookApp\Modules\Texts\Repositories\EloquentTextRepository;
use Euw\FacebookApp\Modules\Users\Models\User;
use Euw\FacebookApp\Modules\Users\Repositories\EloquentUserRepository;

class ModuleProvider extends ServiceProvider
{

    /**
     * Register
     */
    public function register()
    {
        $this->registerTextRepository();
        $this->registerUserRepository();
    }

    /**
     * Register Text Repository
     */
    public function registerTextRepository()
    {
        $this->app->bind('Euw\FacebookApp\Modules\Texts\Repositories\TextRepository', function ($app) {
            return new EloquentTextRepository(new Text, $app['context']);
        });
    }

    public function registerUserRepository()
    {
        $this->app->bind('Euw\FacebookApp\Modules\Users\Repositories\UserRepository', function ($app) {
            return new EloquentUserRepository(new User, $app['context']);
        });
    }


}