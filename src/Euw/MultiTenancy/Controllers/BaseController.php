<?php namespace Euw\MultiTenancy\Controllers;

use App;
use Controller;
use View;

class BaseController extends Controller {

    public function __construct() {
        $context = App::make('Euw\MultiTenancy\Contexts\Context');
        $tenant = $context->getOrThrowException();
        View::share('pageId', $tenant->fb_page_id);
    }

}
