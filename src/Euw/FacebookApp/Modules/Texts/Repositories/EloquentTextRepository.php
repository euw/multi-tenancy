<?php namespace Euw\FacebookApp\Modules\Texts\Repositories;

use Euw\MultiTenancy\Contexts\Context;
use Illuminate\Database\Eloquent\Model;
use Euw\MultiTenancy\Modules\Tenants\Repositories\TenantRepository;

class EloquentTextRepository extends TenantRepository implements TextRepository
{

    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Context
     */
    protected $context;

    /**
     * Construct
     *
     * @param Euw\MultiTenancy\Contexts\Context $context
     * @param Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model, Context $context)
    {
        $this->model = $model;
        $this->context = $context;
    }

    /**
     * Return all projects
     *
     * @param array $with
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all(array $with = array())
    {
        return $this->allThroughColumn($with);
    }

    /**
     * Return a single project
     *
     * @param array $with
     * @return Illuminate\Database\Eloquent\Model
     */
    public function find($id, array $with = array())
    {
        return $this->findThroughColumn($id, $with);
    }

    /**
     * Get Results by Page
     *
     * @param int $page
     * @param int $limit
     * @param array $with
     * @return StdClass Object with $items and $totalItems for pagination
     */
    public function getByPage($page = 1, $limit = 10, $with = array())
    {
        return $this->getByPageThroughColumn($page, $limit, $with);
    }

    /**
     * Search for a single result by key and value
     *
     * @param string $key
     * @param mixed $value
     * @param array $with
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getFirstBy($key, $value, array $with = array())
    {
        return $this->getFirstByThroughColumn($key, $value, $with);
    }

    /**
     * Search for many results by key and value
     *
     * @param string $key
     * @param mixed $value
     * @param array $with
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function getManyBy($key, $value, array $with = array())
    {
        return $this->getManyByThroughColumn($key, $value, $with);
    }

}