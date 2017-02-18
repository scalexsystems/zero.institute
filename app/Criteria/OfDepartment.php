<?php namespace Scalex\Zero\Criteria;

use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class OfDepartment implements Criteria
{
    /**
     * @var
     */
    protected $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function apply($model, Repository $repository)
    {
        if (is_numeric($this->ids)) {
            $model->where('department_id', $this->ids);
        } elseif (is_array($this->ids)) {
            $model->whereIn('department_id', $this->ids);
        }
    }
}
