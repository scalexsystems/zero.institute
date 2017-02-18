<?php namespace Scalex\Zero\Models;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\Models\Address;

class School extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'address_id',
        'website',
        'email',
        'phone',
        'fax',
        'university',
        'institute_type',
        'verified',
    ];

    protected $searchable = [
        'name',
        'slug',
        'verified',
    ];

    protected $extends = [
        'tokens',
        'email_domains',
    ];

    protected $casts = [
        'verified' => 'bool',
        'tokens' => 'array',
        'email_domains' => 'array',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function logo()
    {
        return $this->belongsTo(Attachment::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function getChannelName(): string
    {
        return $this->getMorphClass().'-'.$this->getKey();
    }

    public function getChannel()
    {
        return new PresenceChannel($this->getChannelName());
    }

    public function getPhotoUrl()
    {
        return attach_url($this->logo) ?? asset('img/placeholder.jpg');
    }
}
