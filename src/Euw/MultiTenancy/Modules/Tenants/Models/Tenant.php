<?php namespace Euw\MultiTenancy\Modules\Tenants\Models;

class Tenant extends \Eloquent
{

    /**
     * Guarded properties
     * @var array
     */
    protected $guarded = array('id');

}