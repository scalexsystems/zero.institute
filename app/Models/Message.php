<?php namespace Scalex\Zero\Models;

use Carbon\Carbon;
use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\Database\Relation\MessageReadAt;
use Scalex\Zero\Models\MessageState;
use Scalex\Zero\User;

class Message extends BaseModel
{
    /**
     * Mass fillable fields.
     *
     * @var array
     */
    protected $fillable = ['content'];

    /**
     * Format dates.
     *
     * @var array
     */
    protected $dates = ['read_at'];

    /**
     * Cached result for user read calls.
     *
     * @var array
     */
    protected $userReadCache = [];


    protected $perPage = 25;

    /**
     * Message sender. (@property \Scalex\Zero\User $sender)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Message receiver. (@property \Scalex\Zero\Models\Group|\Scalex\Zero\User $receiver)
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function receiver()
    {
        return $this->morphTo();
    }

    /**
     * Intended receiver of a group message. (@property \Scalex\Zero\User $intended)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function intended()
    {
        return $this->belongsTo(User::class, 'intended_for');
    }

    /**
     * Message attachments. (@property \Scalex\Zero\Models\Attachment $attachments)
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'related');
    }

    /**
     * Messages read states for all relevant users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function states()
    {
        return $this->hasMany(MessageState::class);
    }

    /**
     * Mark message as read.
     *
     * @param \Scalex\Zero\User $user
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function read(User $user)
    {
        $state = new MessageState();

        $state->user()->associate($user);
        $state->read_at = Carbon::now();

        return $this->states()->save($state);
    }

    /**
     * Is message read by user?
     *
     * @param \Scalex\Zero\User $user
     *
     * @return bool
     */
    public function isReadBy(User $user)
    {
        if (isset($this->userReadCache[$user->getKey()])) {
            return $this->userReadCache[$user->getKey()];
        }

        return $this->userReadCache[$user->getKey()] = $this->states()
            ->getQuery()->where('user_id', $user->getKey())->exists();
    }

    /**
     * Get message read state for the user.

*
*@param \Scalex\Zero\User $user


*
*@return \Scalex\Zero\Models\MessageState|mixed|null
     */
    public function readAt(User $user)
    {
        return $this->states()->getQuery()->where('user_id', $user->getKey())->first();
    }
}
