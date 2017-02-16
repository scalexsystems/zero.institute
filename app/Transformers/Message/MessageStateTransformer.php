<?php namespace Scalex\Zero\Transformers\Message;

use Scalex\Zero\Models\Message\MessageState;
use Znck\Transformers\Transformer;


class MessageStateTransformer extends Transformer
{
    public function show(MessageState $model)
    {
        return $model->toArray();
    }

    public function index(MessageState $model)
    {
        return $model->toArray();
    }
}
