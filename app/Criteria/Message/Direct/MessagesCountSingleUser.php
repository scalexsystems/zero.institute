<?php namespace Scalex\Zero\Criteria\Message\Direct;

use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class MessagesCountSingleUser implements Criteria
{
    public function apply($query, Repository $repository)
    {
        $query->addSelect(\DB::raw('users.*, count(messages.id) as messages_count, coalesce(MAX(messages.id), 0) as last_message_id'))
              ->leftJoin('messages as messages', 'messages.receiver_id', '=', 'users.id');

        $query->leftJoin('message_reads', 'messages.id', '=', 'message_reads.message_id')
              ->whereNull('message_reads.user_id')
              ->where(function ($query) {
                  $query->orWhere('messages.receiver_type', 'user')
                        ->orWhereNull('messages.receiver_id');
              });

        $query->groupBy('users.id')
              ->orderBy('last_message_id', 'desc')
              ->orderBy('name', 'asc');
    }
}
