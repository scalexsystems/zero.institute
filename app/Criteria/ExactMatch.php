<?php namespace Scalex\Zero\Criteria;

use Ramsey\Uuid\Uuid;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class ExactMatch implements Criteria
{
    protected $id;
    /**
     * @var null
     */
    private $key;

    /**
     * ExactMatch constructor.
     *
     * @param string|int $id
     */
    public function __construct($id, $key = null) {
        $this->id = $id;
        $this->key = $key;
    }


    public function apply($model, Repository $repository) {
        $id = $this->id;

        if (is_numeric($id) and $id > 0) {
            $model->where($this->key ?? $repository->getModel()->getKeyName(), intval($id));
        }
    }
}
