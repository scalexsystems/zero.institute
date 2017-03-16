<?php

namespace Scalex\Zero\Events\FeeSession;

use Scalex\Zero\Events\Event;
use Scalex\Zero\Models\FeeSession;

class Updated extends Event
{
    public $feeSession;

    /**
     * Created constructor.
     *
     * @param $fee_session
     */
    public function __construct(FeeSession $fee_session)
    {
        $this->feeSession = $fee_session;
    }

    public function broadcastOn()
    {
        return [$this->feeSession->school->getChannel()];
    }
}
