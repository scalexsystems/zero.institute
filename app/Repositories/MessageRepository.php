<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Models\Message;
use Scalex\Zero\User;
use Znck\Repositories\Repository;

/**
 * @method Message find(string|int $id)
 * @method Message findBy(string $key, $value)
 * @method Message create(array $attr)
 * @method Message update(string|int|Message $id, array $attr, array $o = [])
 * @method Message delete(string|int|Message $id)
 * @method MessageRepository validate(array $attr, Message|null $model)
 */
class MessageRepository extends Repository
{
    use \Znck\Repositories\Traits\RepositoryHelper;

    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'sender_id' => 'required|exists:users,id',
        'receiver' => 'required',
        'intended_for' => 'nullable|exists:users,id',
    ];

    public function creating(Message $message, array $attributes) {
        $message->fill($attributes);

        $message->sender()->associate($attributes['sender_id']);
        $message->receiver()->associate($attributes['receiver']);

        return $message->save();
    }
}
