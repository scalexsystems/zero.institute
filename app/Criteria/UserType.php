<?php namespace Scalex\Zero\Criteria;

use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class UserType implements Criteria
{
    protected $types;

    /**
     * UserType constructor.
     *
     * @param $types
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    public function apply($query, Repository $repository)
    {
        if (count($this->types) > 0) {
            $query->whereIn('person_type', $this->types);
        }
    }
}
