<?php

Route::group(array('before' => 'facebook-app.handleRequests|facebook-app.handleMainApp'), function () {
    $mainAppRoutes = function () {
        Route::any('/', function () {
            throw new \Euw\FacebookApp\Exceptions\GenericAppException("generic route for main app.");
//            return "generic route for main app.";
        });
    };

    Route::group(array('domain' => 'www.' . Config::get('app.domain')), $mainAppRoutes );
    Route::group(array('domain' => Config::get('app.domain')), $mainAppRoutes );
});