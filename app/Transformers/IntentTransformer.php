<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Intent;
use Znck\Transformers\Transformer;

class IntentTransformer extends Transformer
{
    protected $availableIncludes = ['user'];

    public function index(Intent $intent) {
        return [
            'type' => $intent->body['type'] ?? '',
            'uid' => $intent->body['uid'] ?? '',
            'department_id' => $intent->body['department_id'] ?? '',
            'discipline_id' => $intent->body['discipline_id'] ?? '',
            'date_of_admission' => $intent->body['date_of_admission'] ?? '',
            'email' => $intent->user->email,
            'name' => $intent->body['first_name'].' '.$intent->body['last_name'],
        ];
    }

    public function show(Intent $intent) {
        return [
            'tag' => (string)$intent->tag,
            'body' => (string)$intent->body,
            'locked' => (boolean)$intent->locked,
            'rejected' => (boolean)$intent->retry,
        ];
    }

    public function includeUser(Intent $intent) {
        return $this->item($intent->user, transformer($intent->user));
    }
}
