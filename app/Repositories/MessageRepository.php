<?php namespace Scalex\Zero\Repositories;

use Carbon\Carbon;
use DB;
use Illuminate\Database\Eloquent\Collection;
use Scalex\Zero\Contracts\Communication\ReceivesMessage;
use Scalex\Zero\Criteria\Attachment\OwnedBy;
use Scalex\Zero\Events\Messages\MessageRead;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\Group;
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
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Create message between users.
     *
     * @param \Scalex\Zero\User $receiver
     * @param array $attributes
     * @param \Scalex\Zero\User $sender
     *
     * @return \Scalex\Zero\Models\Message
     */
    public function createWithUser(User $receiver, array $attributes, User $sender) {
        return $this->createWithSenderAndReceiver($receiver, $attributes, $sender);
    }

    /**
     * Create message in group.
     *
     * @param \Scalex\Zero\Models\Group $receiver
     * @param array $attributes
     * @param \Scalex\Zero\User $sender
     *
     * @return \Scalex\Zero\Models\Message
     */
    public function createWithGroup(Group $receiver, array $attributes, User $sender) {
        return $this->createWithSenderAndReceiver($receiver, $attributes, $sender);
    }

    /**
     * Mark one message as read.
     *
     * @param \Scalex\Zero\Models\Message $message
     * @param \Scalex\Zero\User $user
     *
     * @return \Scalex\Zero\Models\Message
     */
    public function read(Message $message, User $user) {
        if (!$message->isReadBy($user)) {
            $this->onUpdate(false !== $message->read($user));
        }

        return $message;
    }

    /**
     * Mark all messages as read.
     *
     * @param \Illuminate\Database\Eloquent\Collection $messages
     * @param \Scalex\Zero\User $user
     */
    public function readAll(Collection $messages, User $user) {
        $old = DB::table('message_reads')
                 ->where('user_id', $user->getKey())
                 ->whereIn('message_id', $messages->modelKeys())
                 ->get('id')->pluck('id');


        $timestamp = Carbon::now();

        $entries = $messages->keyBy('id')->except($old)
                            ->map(function (Message $message) use ($user, $timestamp) {
                                return [
                                    'message_id' => $message->getKey(),
                                    'user_id' => $user->getKey(),
                                    'read_at' => $timestamp,
                                ];
                            });

        $this->onUpdate(DB::table('message_reads')->insert($entries));

        event(new MessageRead($messages));
    }

    /**
     * Create message with provided sender & receiver.
     *
     * @param \Scalex\Zero\User|\Scalex\Zero\Models\Group $receiver
     * @param array $attributes
     * @param \Scalex\Zero\User $sender
     *
     * @return \Scalex\Zero\Models\Message
     */
    protected function createWithSenderAndReceiver(ReceivesMessage $receiver, array $attributes, User $sender) {
        $this->validateWith($attributes, [
            'content' => 'required_without:attachments',
        ]);

        $message = new Message($attributes);

        $message->type = 'default';
        $message->sender()->associate($sender);
        $message->receiver()->associate($receiver);

        $this->onCreate($message->save());

        if (!isset($attributes['attachments'])) {
            return $message;
        }

        $attachments = repository(Attachment::class)
            ->pushCriteria(new OwnedBy($sender))
            ->findMany($attributes['attachments']);

        $message->attachments()->saveMany($attachments);

        return $message;
    }
}
