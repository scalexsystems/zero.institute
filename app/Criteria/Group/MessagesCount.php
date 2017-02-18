<?php namespace Scalex\Zero\Criteria\Group;

use Illuminate\Database\Query\JoinClause;
use Scalex\Zero\User;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class MessagesCount implements Criteria
{

    protected $id;

    /**
     * MessagesCount constructor.
     *
     * @param $id
     */
    public function __construct(User $user)
    {
        $this->id = $user->getKey();
    }

    public function apply($query, Repository $repository)
    {
        $query->addSelect(\DB::raw('groups.*, count(messages.id) - count(message_reads.id) as messages_count, coalesce(MAX(messages.id), 0) as last_message_id'))
              ->leftJoin('messages', function (JoinClause $join) {
                  $join->on('messages.receiver_id', '=', 'groups.id')
                       ->where(function ($query) {
                           $query->orWhere('messages.receiver_type', 'group')
                                 ->orWhereNull('messages.receiver_id');
                       });
              }
              );

        $query->leftJoin('message_reads', function (JoinClause $join) {
            $join->on('messages.id', '=', 'message_reads.message_id')->where('message_reads.user_id', $this->id);
        });

        $query->groupBy('groups.id')
              ->orderBy('last_message_id', 'desc')
              ->orderBy('name', 'asc');
    }
}
