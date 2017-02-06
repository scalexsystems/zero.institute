<?php namespace Scalex\Zero;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Scalex\Zero\Contracts\Communication\ReceivesMessage;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Role;
use Scalex\Zero\Models\School;
use Znck\Trust\Contracts\Permissible as PermissibleContract;
use Znck\Trust\Traits\Permissible;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    BelongsToSchool,
    PermissibleContract,
    ReceivesMessage
{
    use Authenticatable, Authorizable, CanResetPassword;

    use HasApiTokens, Notifiable, Permissible;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'verification_token'];

    protected $extends = ['other_email', 'other_verification_token', 'approved'];

    protected $searchable = ['name', 'email', 'school_id'];

    protected $casts = [
        'approved' => 'bool',
    ];

    protected $observables = [
        'permissionsAdded', 'permissionsRemoved'
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * User photo. (@property \Scalex\Zero\Models\Attachment $photo)
     *
     * @deprecated in v0.4.0. TODO: Remove in v0.5+.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profilePhoto()
    {
        return $this->photo();
    }

    /**
     * User photo. (@property \Scalex\Zero\Models\Attachment $photo)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Attachment::class, 'photo_id');
    }

    public function person()
    {
        return $this->morphTo();
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }

    public function getChannelName(): string
    {
        return $this->getMorphClass().'-'.$this->getKey();
    }

    public function getChannel()
    {
        return new PrivateChannel($this->getChannelName());
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps()->withPivot('school_id');
    }
}
