<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Attachment;
use Znck\Transformers\Transformer;


class AttachmentTransformer extends Transformer
{
    public function show(Attachment $attachment) {
        return $attachment->toArray();
    }
    public function index(Attachment $attachment) {
        return $attachment->toArray();
    }
}
