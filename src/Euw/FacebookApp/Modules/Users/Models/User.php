<?php namespace Euw\FacebookApp\Modules\Users\Models;

use Carbon\Carbon;

class User extends \Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    protected $softDelete = false;

    // Use fillable as a white list
//    protected $fillable = array('title', 'slug', 'content', 'active', 'frontpage', 'image', 'meta_description', 'type', 'keywords', 'publish_date', 'user_id', 'tenant_id');
    protected $fillable = array('tenant_id');



}