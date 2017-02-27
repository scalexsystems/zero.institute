<?php namespace Scalex\Zero\Criteria;

use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class OfDiscipline implements Criteria
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
            $model->where('discipline_id', $this->ids);
        } elseif (is_array($this->ids) and method_exists($model, 'whereIn')) {
            $model->whereIn('discipline_id', $this->ids);
        } elseif (is_array($this->ids)) {
            // TODO: Add whereIn support to algolia.
        }
    }
}
