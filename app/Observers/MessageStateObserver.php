<?php namespace Scalex\Zero\Observers;

use Scalex\Zero\Events\Messages\MessageRead;
use Scalex\Zero\Models\Message\MessageState;

class MessageStateObserver
{
    public function created(MessageState $state) {
        event(new MessageRead($state));
    }
}
