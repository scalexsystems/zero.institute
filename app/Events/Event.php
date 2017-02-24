<?php namespace Scalex\Zero\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use ReflectionClass;
use ReflectionProperty;

abstract class Event implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function broadcastOn()
    {
        return [new PrivateChannel('noop')];
    }

    public function broadcastWith()
    {
        $payload = [];

        foreach ((new ReflectionClass($this))->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $payload[$property->getName()] = $this->formatProperty($property->getValue($this));
        }

        return $payload;
    }

    protected function formatProperty($value)
    {
        if ($value instanceof Model) {
            return $value->getKey();
        }

        if ($value instanceof Arrayable) {
            return $value->toArray();
        }

        return $value;
    }
}
