<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\User;
use Znck\Transformers\Transformer;


class UserTransformer extends Transformer
{
    protected $availableIncludes = ['person'];

    public function show(User $user) {
        return [
            'name' => (string) $user->name,
            'photo' => attach_url($user->profilePhoto) ?? asset('img/placeholder-64.jpg'),
        ] + allow('read-email', $user, [
            'email' => $user->email,
        ], []) + allow('read-account', $user, [
            'registered' => !is_null($user->person),
            'verified' => is_null($user->verification_token),
            'type' => morph_model($user->person),
        ], []);
    }

    public function includePerson(User $user) {
        return $user->person
            ? $this->item($user->person, transformer($user->person))
            : $this->null();
    }
}
