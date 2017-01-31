<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\User;
use Scalex\Zero\Action;
use Znck\Transformers\Transformer;

class UserTransformer extends Transformer
{
    protected $availableIncludes = ['person'];

    public function index(User $user)
    {
        return [
            'name' => (string) $user->name,
            'photo' => attach_url($user->profilePhoto) ?? asset('img/placeholder-64.jpg'),
            'type' => morph_model($user->person),
            'bio' => $this->getBio($user),
            'department' => $user->person->department->short_name ?? '',
            'active_at' => ($user->relationLoaded('lastMessageAt') and $user->lastMessageAt) ? iso_date($user->lastMessageAt->created_at) : null,
        ];
    }

    public function show(User $user)
    {
        return
            [
                'name' => (string) $user->name,
                'photo' => attach_url($user->profilePhoto) ?? asset('img/placeholder-64.jpg'),
                'type' => morph_model($user->person),
                'bio' => $this->getBio($user),
                'channel' => $user->getChannelName(),
            ] + allow('read-email', $user, [
                'email' => $user->email,
            ], []) + allow('read-account', $user, [
                'registered' => !is_null($user->person),
                'verified' => is_null($user->verification_token),
                'approved' => (bool) $user->approved,
                'permissions' => [
                    'courses' => trust($user)->to(Action::UPDATE_COURSE),
                    'people' => trust($user)->is('admin'),
                    'settings' => trust($user)->to(Action::UPDATE_SCHOOL),
                ],
            ], []);
    }

    public function includePerson(User $user)
    {
        return $user->person ? $this->item($user->person) : $this->null();
    }

    public function getBio(User $user)
    {
        return $user->person ? $user->person->bio : '';
    }
}
