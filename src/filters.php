<?php

Route::filter('auth.tenant', function () {
    $context = App::make('Euw\MultiTenancy\Contexts\Context');

    if (Auth::guest()) return Redirect::guest('login');

    $context->set(Auth::user());
});

Route::filter('selectTenant', function () {
    $server = explode('.', Request::server('HTTP_HOST'));

    if ( count($server) == 3 ) {
        $subdomain = $server[0];

        $tenant = Euw\MultiTenancy\Modules\Tenants\Models\Tenant::where('subdomain', '=', $subdomain)->first();

        if ($tenant) {
            $context = App::make('Euw\MultiTenancy\Contexts\Context');
            $context->set($tenant);
        }
    }

});