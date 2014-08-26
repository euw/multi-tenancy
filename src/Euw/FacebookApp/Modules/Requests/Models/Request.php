<?php namespace Euw\FacebookApp\Modules\Requests\Models;

use Carbon\Carbon;

class Request extends \Eloquent
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'requests';

    // Use fillable as a white list
    protected $fillable = array('request_id', 'tenant_id');

    public function tenant()
    {
        return $this->belongsTo('Euw\MultiTenancy\Modules\Tenants\Models\Tenant');
    }

}