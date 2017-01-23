<?php namespace Scalex\Zero\Criteria;

use Laravel\Scout\Builder as Scout;
use Scalex\Zero\Models\School;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class OfSchool implements Criteria
{
    protected $school;

    public function __construct(School $school)
    {
        $this->school = $school;
    }

    public function apply($query, Repository $repository)
    {
        if ($query instanceof Scout) {
            $query->where('school_id', $this->school->getKey());
        } else {
            $query->where(function ($query) {
                /** @var \Illuminate\Database\Query\Builder $query */

                $query->orWhere('school_id', $this->school->getKey())
                      ->orWhereNull('school_id');
            });
        }
    }
}
