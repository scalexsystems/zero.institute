<?php namespace Scalex\Zero\Criteria\Group;

use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class MessagesCount implements Criteria
{

    public function apply($query, Repository $repository)
    {
        $query->addSelect(\DB::raw('groups.*, count(*) as messages_count'))
            ->leftJoin('messages', 'messages.receiver_id', '=', 'groups.id')
            ->leftJoin('message_reads', 'messages.id', '=', 'message_reads.message_id')
            ->whereNull('message_reads.user_id')
            ->where(function ($query) {
                $query->orWhere('messages.receiver_type', 'group')
                    ->orWhereNull('messages.receiver_id');
            })
            ->groupBy('groups.id');
    }
}
