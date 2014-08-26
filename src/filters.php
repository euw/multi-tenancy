<?php

use Euw\FacebookApp\Exceptions\UserHasDeniedAuthenticationException;
use Euw\FacebookApp\Exceptions\UserHasNotLikedPageException;

App::before(function ($request) {
    header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
});

function getLatestRequestId()
{
    $latestRequest = null;

    $requestIds = Request::get("request_ids");
    if (!empty($requestIds)) {
        // request_ids is a comma separated string with the latest request id at the end.
        // we need to grab that last request id!
        $requests = explode(',', $requestIds);
        $latestRequest = end($requests);
    }

    return $latestRequest;
}

function getLatestRequest()
{
    $latestRequestId = getLatestRequestId();
    $request = Euw\FacebookApp\Modules\Requests\Models\Request::whereRequestId($latestRequestId)->first();
    return $request;
}

function getSubdomainForRequest($request)
{
    $subdomain = $request->tenant->subdomain;
    return $subdomain;
}

Route::filter('facebook-app.handleRequests', function ()
{
    $request = getLatestRequest();

    if ( $request ) {
        $subdomain = getSubdomainForRequest($request);

        // Todo: use // instead of specifying protocol when we support wildcard subdomains

        $url = 'http://' . $subdomain . '.' . Config::get('app.domain'); // . Request::server('SCRIPT_NAME');
        return Redirect::to($url);
    }
});

Route::filter('facebook-app.handleMainApp', function () {

    $facebook = App::make('Facebook');

    $signedRequest = $facebook->getSignedRequest();

    if (!is_null($signedRequest) && isset($signedRequest['page'])) {

        if (isset($signedRequest['page'])) {
            $pageId = $signedRequest['page']['id'];

            $tenant = Euw\MultiTenancy\Modules\Tenants\Models\Tenant::where('fb_page_id', '=', $pageId)->firstOrFail();

            if ( $tenant ) {
                $subdomain = $tenant->subdomain;
                // Todo: use // instead of specifying protocol when we support wildcard subdomains
                $url = 'http://' . $subdomain . '.' . Config::get('app.domain');// . Request::server('SCRIPT_NAME');
                return Redirect::to($url);
            }
        }
    }
});

function userIsFanOfPage($fbPageId)
{
    $facebook = App::make('Facebook');
    $fql_query = 'SELECT page_id FROM page_fan WHERE uid=me() AND page_id=' . $fbPageId;
    $fql_result = $facebook->api(array(
        'method' => 'fql.query',
        'query'  => $fql_query
    ));

    return (count($fql_result) > 0);
}

Route::filter('facebook-app.like', function() {
    $facebook = App::make('Facebook');
    $signedRequest = $facebook->getSignedRequest();

    if ( is_null($signedRequest) ) {

        $context = App::make('Euw\MultiTenancy\Contexts\Context');
        $tenant = $context->getOrThrowException();

        $user = $facebook->getUser();

        if ( $user ) {
            if ( userIsFanOfPage($tenant->fb_page_id) ) {
//                dd("fan");
            } else {
                throw new UserHasNotLikedPageException('not fan');
            }
        } else {
//            dd("not authed yet");
        }

    } else {
        if (isset($signedRequest['page']) && !$signedRequest['page']['liked']) {

            throw new UserHasNotLikedPageException('not fan in page tab');
        }
    }


});


Route::filter('facebook-app.auth', function () {
    $facebook = App::make('Facebook');
    $user = $facebook->getUser();

    $params = array(
        'scope' => Config::get('facebook-app::scope')
    );

    if ($user) {
        try {
            // Proceed knowing you have a logged in user who's authenticated.
            // use $user id instead of /me here, because /me requires an active access token, which often fails
            $userProfile = $facebook->api('/' . $user);

        } catch (FacebookApiException $e) {
            error_log($e);
            $user = null;
        }
    } else {
        if (Request::get('error_reason') == 'user_denied') {
            throw new UserHasDeniedAuthenticationException;
        } else {
            $loginUrl = $facebook->getLoginUrl($params);
            return '<script>top.location.href="' . $loginUrl . '"</script>';
        }
    }
});