<?php namespace Scalex\Zero\Transformers;

use Illuminate\Support\Str;
use Scalex\Zero\Models\Intent;
use Znck\Transformers\Transformer;

class IntentTransformer extends Transformer
{
    protected $availableIncludes = ['user'];

    public function index(Intent $intent)
    {
        $service = app(IntentService::class);
        $method = 'transform'.Str::studly($intent->tag).'Intent';

        return call_user_func([$service, $method], $intent);
    }

    public function show(Intent $intent)
    {
        return [
            'tag' => (string)$intent->tag,
            'body' => (string)$intent->body,
            'locked' => $intent->locked,
            'status' => $this->getStatus($intent),
        ];
    }

    public function getStatus(Intent $intent): string
    {
        if ($intent->status) {
            return $intent->status;
        }

        if ($intent->closed) {
            return 'closed';
        }

        if ($intent->locked) {
            return 'pending review';
        }

        return 'open';
    }

    public function includeUser(Intent $intent)
    {
        return $this->item($intent->user);
    }
}
