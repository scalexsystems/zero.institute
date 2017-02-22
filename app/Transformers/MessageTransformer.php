<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Message;
use Znck\Transformers\Transformer;

class MessageTransformer extends Transformer
{
    protected $availableIncludes = ['sender', 'receiver', 'attachments'];

    protected $defaultIncludes = ['sender', 'attachments'];

    protected $timestamps = false;

    /**
     * Bulk transform.
     *
     * @param \Scalex\Zero\Models\Message $message
     *
     * @return array
     */
    public function show(Message $message)
    {
        $readAt = $this->getReadAt($message);

        return [
            'type' => $message->type,
            'content' => $message->content,
            'private' => !is_null($message->intended_for),
            'unread' => is_null($readAt),
            'read_at' => iso_date($readAt),
            'received_at' => iso_date($message->created_at),
            'receiver_type' => (string)$message->receiver_type,
            'receiver_id' => (int)$message->receiver_id,
        ];
    }

    /**
     * Single transform.
     *
     * @param \Scalex\Zero\Models\Message $message
     *
     * @return array
     */
    public function index(Message $message)
    {
        return $this->show($message);
    }

    /**
     * Transform sender.
     *
     * @param \Scalex\Zero\Models\Message $message
     *
     * @return mixed
     */
    public function includeSender(Message $message)
    {
        return $this->item($message->sender);
    }

    /**
     * Transform receiver.
     *
     * @param \Scalex\Zero\Models\Message $message
     *
     * @return mixed
     */
    public function includeReceiver(Message $message)
    {
        return $this->item($message->receiver);
    }

    /**
     * Transform attachments.
     *
     * @param \Scalex\Zero\Models\Message $message
     *
     * @return mixed
     */
    public function includeAttachments(Message $message)
    {
        return $this->collection($message->attachments);
    }

    /**
     * Get message read timestamp.
     *
     * @param \Scalex\Zero\Models\Message $message
     *
     * @return \Carbon\Carbon|mixed|null
     */
    protected function getReadAt(Message $message)
    {
        if ($message->relationLoaded('state')) {
            $state = $message->state;

            return $state ? $state->read_at : null;
        }

        return null;
    }
}
