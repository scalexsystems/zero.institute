<?php namespace Scalex\Zero\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

abstract class Event implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
}
