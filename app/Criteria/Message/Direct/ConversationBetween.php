<?php namespace Scalex\Zero\Criteria\Message\Direct;

use Scalex\Zero\User;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class ConversationBetween implements Criteria
{
    /**
     * @var \Scalex\Zero\User
     */
    private $one;
    /**
     * @var \Scalex\Zero\User
     */
    private $other;

    public function __construct(User $one, User $other)
    {
        $this->one = $one;
        $this->other = $other;
    }

    public function apply($query, Repository $repository)
    {
        $query->where(function ($query) {
            $query->where(function ($query) {
                $query->where('receiver_id', $this->one->getKey())
                      ->where('receiver_type', $this->one->getMorphClass())
                      ->where('sender_id', $this->other->getKey());
            })->orWhere(function ($query) {
                $query->where('receiver_id', $this->other->getKey())
                      ->where('receiver_type', $this->other->getMorphClass())
                      ->where('sender_id', $this->one->getKey());
            });
        });
    }
}
