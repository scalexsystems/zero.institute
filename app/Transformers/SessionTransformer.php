<?php namespace Scalex\Zero\Transformers;

use Auth;
use Scalex\Zero\Models\Session;
use Znck\Transformers\Transformer;


class SessionTransformer extends Transformer
{

    public function show(Session $session)
    {
        return $this->index($session);
    }

    public function index(Session $session)
    {
        return [
            'original_name' => $session->name,
            'name' => $session->semester->name.' '.$session->started_on->year,
            'semester_id' => $session->semester_id,
            'started_on' => iso_date($session->started_on),
            'ended_on' => iso_date($session->ended_on),
            'current' => $session->getKey() === (int)Auth::user()->school->session_id,
        ];
    }
}
