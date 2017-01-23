<?php namespace Scalex\Zero\Criteria;

use Scalex\Zero\User;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class MessageIntendedFor implements Criteria
{
    /**
     * @var \Scalex\Zero\User
     */
    protected $user;

    public function __construct(User $user = null)
    {
        $this->user = $user;
    }

    public function apply($query, Repository $repository)
    {
        if (!is_null($this->user)) {
            $query->where(function ($query) {
                /** @var \Illuminate\Database\Query\Builder $query */
                $query->orWhere('intended_for', $this->user->getKey())
                      ->orWhereNull('intended_for');
            });
        } else {
            $query->whereNull('intended_for');
        }
    }
}
