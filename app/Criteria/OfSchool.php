<?php namespace Scalex\Zero\Criteria;

use Scalex\Zero\Models\School;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class OfSchool implements Criteria
{
    protected $school;

    public function __construct(School $school) {
        $this->school = $school;
    }

    public function apply($builder, Repository $repository) {
        $builder->where('school_id', $this->school->getKey());
    }
}
