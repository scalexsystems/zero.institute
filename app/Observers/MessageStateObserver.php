<?php namespace Scalex\Zero\Observers;

use Scalex\Zero\Events\Message\Read;
use Scalex\Zero\Models\MessageState;

class MessageStateObserver
{
    public function created(MessageState $state)
    {
        event(new Read($state));
    }
}
