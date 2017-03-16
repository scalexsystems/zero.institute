<?php

namespace Scalex\Zero\Events\FeeSession;

use Scalex\Zero\Events\Event;
use Scalex\Zero\Models\FeeSession;

class Created extends Event
{
    public $fee_session;

    /**
     * Created constructor.
     *
     * @param $fee_session
     */
    public function __construct(FeeSession $fee_session)
    {
        $this->fee_session = $fee_session;
    }

    public function broadcastOn()
    {
        return [$this->fee_session->school->getChannel()];
    }
}
