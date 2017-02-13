<?php namespace Scalex\Zero\Transformers;

use Gate;
use Request;
use Scalex\Zero\User;
use Znck\Transformers\Transformer;

class UserTransformer extends Transformer
{
    protected $availableIncludes = ['person'];

    public function index(User $user)
    {
        return [
            'name' => (string)$user->name,
            'photo' => attach_url($user->photo) ?? asset('img/placeholder.jpg'),
            'type' => morph_model($user->person),
            'bio' => $this->getBio($user),
            'unread_count' => $user->getAttribute('messages_count'),
            'last_message_id' => $user->getAttribute('last_message_id')
        ];
    }

    public function show(User $user)
    {
        return $this->showPartial($user) + $this->showEmail($user) + $this->me($user);
    }

    public function me(User $user)
    {
        if ($current = Request::user() and $user->getKey() === $current->getKey()) {
            return [
                'permissions' => $user->getPermissionNames()
            ];
        }

        return [];
    }

    public function includePerson(User $user)
    {
        if ($user->person) {
            return $this->item($user->person, transformer($user->person)->setIndexing(false));
        }

        return $this->null();
    }

    /**
     * Default bio string.
     *
     * @param \Scalex\Zero\User $user
     *
     * @return string
     */
    public function getBio(User $user)
    {
        return ''; // TODO: Implement user bio.
    }

    /**
     * User details.
     *
     * @param \Scalex\Zero\User $user
     *
     * @return array
     */
    protected function showPartial(User $user):array
    {
        return [
            'name' => (string)$user->name,
            'photo' => attach_url($user->photo) ?? asset('img/placeholder.jpg'),
            'type' => $user->person_type,
            'bio' => $this->getBio($user),
            'channel' => $user->getChannelName(),

            'unread_count' => $user->getAttribute('messages_count'),
            'last_message_id' => $user->getAttribute('last_message_id')
        ];
    }

    /**
     * Get user email
     *
     * @param \Scalex\Zero\User $user
     *
     * @return array
     */
    protected function showEmail(User $user)
    {
        if (Gate::allows('read-email', $user)) {
            return ['email' => $user->email];
        }

        return [];
    }
}
