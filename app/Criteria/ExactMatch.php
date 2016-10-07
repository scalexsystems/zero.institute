<?php namespace Scalex\Zero\Criteria;

use Ramsey\Uuid\Uuid;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class ExactMatch implements Criteria
{
    protected $id;

    /**
     * ExactMatch constructor.
     *
     * @param string|int $id
     */
    public function __construct($id) {
        $this->id = $id;
    }


    public function apply($model, Repository $repository) {
        $id = $this->id;

        if (is_numeric($id) and $id > 0) {
            $model->where($repository->getModel()->getKeyName(), intval($id));
        }
    }
}
