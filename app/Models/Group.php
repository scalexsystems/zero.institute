<?php namespace Scalex\Zero\Models;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Contracts\Communication\ReceivesMessage;
use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\Others\GroupTrait;
use Scalex\Zero\Database\Relation\LastMessage;
use Scalex\Zero\User;

class Group extends BaseModel implements ReceivesMessage
{
    use SoftDeletes, GroupTrait;

    /**
     * Mass fillable fields.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'private'
    ];

    /**
     * Property types.
     *
     * @var array
     */
    protected $casts = [
        'private' => 'bool'
    ];

    /**
     * Extended schema.
     *
     * @var array
     */
    protected $extends = [
        'count_members'
    ];

    /**
     * Group owner. (@property \Scalex\Zero\User $owner)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * School of the group. (@property \Scalex\Zero\Models\School $school)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Group Profile Photo. (@property \Scalex\Zero\Models\Attachment $profilePhoto)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @deprecated in v0.4.0, use @method photo(). TODO: Remove in v0.5+.
     */
    public function profilePhoto()
    {
        return $this->photo();
    }

    /**
     * Group Profile Photo. (@property \Scalex\Zero\Models\Attachment $photo)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Attachment::class);
    }

    /**
     * Last message. (@property \Scalex\Zero\Models\Message $lastMessageAt)

*
*@return \Scalex\Zero\Database\Relation\LastMessage
     * @deprecated in v0.4.0, use @method lastMessage(). TODO: Remove in v0.5+.
     */
    public function lastMessageAt()
    {
        return $this->lastMessage();
    }

    /**
     * Last message. (@property \Scalex\Zero\Models\Message $lastMessage)

*
*@return \Scalex\Zero\Database\Relation\LastMessage
     */
    public function lastMessage()
    {
        return new LastMessage((new Message())->newQuery(), $this);
    }

    /**
     * List of group members. (@property \Scalex\Zero\User[] $members)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    /**
     * Echo channel name.
     *
     * @return string
     */
    public function getChannelName(): string
    {
        return $this->getMorphClass().'-'.$this->getKey();
    }

    /**
     * Echo channel.
     *
     * @return \Illuminate\Broadcasting\PresenceChannel
     */
    public function getChannel()
    {
        return new PresenceChannel($this->getChannelName());
    }
}
