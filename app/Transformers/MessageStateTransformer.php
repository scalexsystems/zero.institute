<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\MessageState;
use Znck\Transformers\Transformer;


class MessageStateTransformer extends Transformer
{
    public function show(MessageState $model)
    {
        return $model->toArray();
    }

    public function index(\Scalex\Zero\Models\MessageState $model)
    {
        return $model->toArray();
    }
}
