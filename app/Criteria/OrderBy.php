<?php namespace Scalex\Zero\Criteria;

use Laravel\Scout\Builder;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class OrderBy implements Criteria
{
    public $columns;

    public function __construct($column, $order = 'asc')
    {
        $this->columns = is_array($column) ? $column : [[$column, $order]];
    }

    public function apply($model, Repository $repository)
    {
        if (!$model instanceof Builder) {
            foreach ($this->columns as $column) {
                call_user_func_array([$model, 'orderBy'], (array)$column);
            }
        }
    }
}
