<?php namespace Scalex\Zero\Criteria;

use Scalex\Zero\User;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class MessageSentBy implements Criteria
{
    protected $sender;

    public function __construct(User $sender) {
        $this->sender = $sender;
    }

    public function apply($query, Repository $repository) {
        $query->where('sender_id', $this->sender->getKey());
    }
}
