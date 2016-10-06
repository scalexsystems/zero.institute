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
        if ($repository->getModel()->getIncrementing()) {
            $id = intval($this->id);

            if (is_int($id) and $id > 0) {
                $model->where($repository->getModel()->getKeyName(), $id);
            }
        } else {
            $id = (string)$this->id;

            if (Uuid::isValid($id)) {
                $model->where($repository->getModel()->getKeyName(), $id);
            }
        }
    }
}
