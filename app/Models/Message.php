<?php namespace Scalex\Zero\Models;

use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\Others\MessageReadAt;
use Scalex\Zero\User;

class Message extends BaseModel
{
    protected $fillable = ['type', 'content', 'intended_for'];

    protected $dates = ['read_at'];

    public function sender()
    {
        return $this->belongsTo(User::class);
    }

    public function receiver()
    {
        return $this->morphTo();
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'related');
    }

    public function userReadAt()
    {
        return new MessageReadAt($this->newQuery(), current_user());
    }
}
