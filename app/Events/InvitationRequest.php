<?php namespace Scalex\Zero\Events;

class InvitationRequest extends Event
{
    public $name;

    public $email;

    /**
     * InvitationRequest constructor.
     *
     * @param $name
     * @param $email
     */
    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function broadcastOn()
    {
        return [];
    }
}
