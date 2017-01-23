<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Message;
use Scalex\Zero\User;
use Znck\Transformers\Transformer;

class MessageTransformer extends Transformer
{
    protected $availableIncludes = ['sender', 'receiver', 'attachments'];

    protected $defaultIncludes = ['sender', 'attachments'];

    protected $timestamps = false;

    public function index(Message $message)
    {
        $readAt = $this->getReadAt($message);

        return [
            'type' => $message->type,
            'content' => $message->content,
            'private' => !is_null($message->intended_for),
            'unread' => is_null($this->getReadAt($message)),
            'read_at' => iso_date($readAt),
            'received_at' => iso_date($message->created_at),
        ];
    }

    public function show(Message $message)
    {
        return $this->index($message);
    }

    public function includeSender(Message $message)
    {
        return $this->item($message->sender);
    }

    public function includeReceiver(Message $message)
    {
        return $this->item($message->receiver);
    }

    public function includeAttachments(Message $message)
    {
        return $this->collection($message->attachments);
    }

    protected function getReadAt(Message $message)
    {
        if (
            !app()->runningInConsole()
            and (int)$message->sender->getKey() === (int)current_user()->getKey()
        ) {
            return $message->created_at;
        }

        if ($message->receiver instanceof User) {
            return $message->read_at;
        }

        return $message->userReadAt;
    }
}
