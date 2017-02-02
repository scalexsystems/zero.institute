<?php namespace Scalex\Zero\Criteria\Attachment;

use Scalex\Zero\User;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class OwnedBy implements Criteria
{
    protected $user;

    /**
     * OwnedBy constructor.
     *
     * @param $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function apply($model, Repository $repository) {
        $model->where('owner_id', $this->user->getKey());
    }
}
