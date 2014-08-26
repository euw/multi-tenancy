<?php namespace Euw\FacebookApp;

use Illuminate\Support\ServiceProvider;
use App;
use Config;
use View;
use Facebook;

class FacebookAppServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        App::singleton('Facebook', function () {
            $config = array(
                'appId'              => Config::get('facebook-app::appId'),
                'secret'             => Config::get('facebook-app::appSecret'),
                'fileUpload'         => false, // optional
                'allowSignedRequest' => true, // optional, but should be set to false for non-canvas apps
            );

            return new Facebook($config);
        });

        View::composer('facebook-app::layouts.master', function ($view) {
            $view->with('appId', Config::get('facebook-app::appId'));
            $view->with('pageId', '');
            $view->with('channelUrl', Config::get('facebook-app::channelUrl'));
        });

        $this->app->register('Euw\FacebookApp\Modules\Providers\ModuleProvider');
	}

    public function boot()
    {
        $this->package('euw/facebook-app');

        include __DIR__ . '/../../filters.php';
        include __DIR__ . '/../../routes.php';
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
