<?php

Route::filter('multi-tenancy.auth', function () {
    $context = App::make('Euw\MultiTenancy\Contexts\Context');

    if (Auth::guest()) return Redirect::guest('login');

    $context->set(Auth::user());
});

Route::filter('multi-tenancy.selectTenant', function () {
    $server = explode('.', Request::server('HTTP_HOST'));

    if ( count($server) == 3 ) {
        $subdomain = $server[0];

        $tenant = Euw\MultiTenancy\Modules\Tenants\Models\Tenant::where('subdomain', '=', $subdomain)->first();

        if ($tenant) {
            $context = App::make('Euw\MultiTenancy\Contexts\Context');
            $context->set($tenant);
        } else {
            return Redirect::to(Request::secure() ? 'https://' : 'http://' . 'www.' . Config::get('app.domain'));
        }
    }

});