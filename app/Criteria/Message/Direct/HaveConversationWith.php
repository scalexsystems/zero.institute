<?php namespace Scalex\Zero\Criteria\Message\Direct;

use Illuminate\Database\Query\JoinClause;
use Scalex\Zero\User;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class HaveConversationWith implements Criteria
{
    /**
     * @var \Scalex\Zero\User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Find users who has send a message to or received a message from the provided user.
     * And sort users according to time elapsed since last message.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param \Znck\Repositories\Contracts\Repository $repository
     *
     * @return void
     */
    public function apply($query, Repository $repository)
    {
        $query->join('messages', function (JoinClause $join) {
            $join->on(function (JoinClause $join) {
                $join->on('users.id', '=', 'messages.sender_id')
                     ->where('messages.receiver_type', $this->user->getMorphClass())
                     ->where('messages.receiver_id', $this->user->getKey());
            })->orOn(function (JoinClause $join) {
                $join->orOn('users.id', '=', 'messages.receiver_id')
                     ->where('messages.receiver_type', $this->user->getMorphClass())
                     ->where('messages.sender_id', $this->user->getKey());
            })->orderBy('messages.created_at', 'desc');
        });

        $query->groupBy('users.id');
    }
}
