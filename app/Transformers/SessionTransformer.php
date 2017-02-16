<?php namespace Scalex\Zero\Transformers;

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
            'name' => $session->name,
            'semester_id' => $session->semester_id,
        ];
    }
}
