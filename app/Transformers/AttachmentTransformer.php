<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Attachment;
use Znck\Transformers\Transformer;

class AttachmentTransformer extends Transformer
{
    public function show(Attachment $attachment)
    {
        return [
            'extension' => $attachment->extension,
            'title' => $attachment->title,
            'filename' => $attachment->filename,
            'mime' => $attachment->mime,
            'path' => attach_url($attachment),
            'size' => $attachment->size,
            'links' => $this->getLinks($attachment),
        ];
    }

    public function index(Attachment $attachment)
    {
        return $this->show($attachment);
    }

    protected function getLinks(Attachment $attachment): array
    {
        $links = ['original' => attach_url($attachment)];

        foreach (array_keys((array) $attachment->variations) as $variation) {
            $links[$variation] = attach_url($attachment, $variation);
        }

        return $links;
    }
}
