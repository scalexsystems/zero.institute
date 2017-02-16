<?php

namespace Scalex\Zero\Models;

use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\User;

class MessageState extends BaseModel
{
    /**
     * Override table name.
     *
     * @var string
     */
    protected $table = 'message_reads';

    /**
     * Disable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Format dates.
     *
     * @var array
     */
    protected $dates = [
        'read_at'
    ];

    /**
     * State of message. (@property \Scalex\Zero\Models\Message $message)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Message state for user. (@property \Scalex\Zero\User $user)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
