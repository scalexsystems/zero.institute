<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\FeeSession;
use Znck\Transformers\Transformer;

class FeeSessionTransformer extends Transformer
{
    public function show(FeeSession $session)
    {
        return $this->index($session);
    }

    public function index(FeeSession $session)
    {
        return [
            'name' => (string)$session->name,
            'started_at' => iso_date($session->started_at),
            'ended_at' => iso_date($session->ended_at),
            'session_id' => (int)$session->session_id,
            'accepting' => (bool)$session->accepting,
        ];
    }
}
