<?php namespace Scalex\Zero\Criteria\Message;

use Scalex\Zero\Contracts\Communication\ReceivesMessage;
use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class MessageSentTo implements Criteria
{
    protected $receiver;

    public function __construct(ReceivesMessage $receiver)
    {
        $this->receiver = $receiver;
    }

    public function apply($query, Repository $repository)
    {
        $query->where('receiver_id', $this->receiver->getKey())
              ->where('receiver_type', $this->receiver->getMorphClass());
    }
}
