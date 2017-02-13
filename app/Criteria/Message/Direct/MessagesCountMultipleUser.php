<?php namespace Scalex\Zero\Criteria\Message\Direct;

use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class MessagesCountMultipleUser implements Criteria
{
    public function apply($query, Repository $repository)
    {
        $query->addSelect(\DB::raw('users.*, count(messages.id) as messages_count, coalesce(MAX(messages.id), 0) as last_message_id'));

        $query->leftJoin('message_reads', 'messages.id', '=', 'message_reads.message_id')
              ->whereNull('message_reads.user_id');

        $query->groupBy('users.id')
              ->orderBy('last_message_id', 'desc')
              ->orderBy('name', 'asc');
    }
}
