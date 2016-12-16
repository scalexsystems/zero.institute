<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Attachment;
use Znck\Transformers\Transformer;


class AttachmentTransformer extends Transformer
{
    public function show(Attachment $attachment) {
        return [
            'extension' => $attachment->extension,
            'filename' => $attachment->filename,
            'mime' => $attachment->mime,
            'path' => attach_url($attachment),
            'size' => $attachment->size,

        ];
    }
    public function index(Attachment $attachment) {
        return $this->show($attachment);
    }
}
