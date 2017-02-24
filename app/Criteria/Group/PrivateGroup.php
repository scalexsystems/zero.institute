<?php namespace Scalex\Zero\Criteria\Group;

use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class PrivateGroup implements Criteria
{
    protected $value;

    /**
     * PrivateGroup constructor.
     *
     * @param $value
     */
    public function __construct(bool $value = true)
    {
        $this->value = $value;
    }

    public function apply($query, Repository $repository)
    {
        $query->where('private', (int)$this->value);
    }
}
