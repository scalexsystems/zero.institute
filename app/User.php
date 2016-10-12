<?php namespace Scalex\Zero;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Scalex\Zero\Contracts\Communication\ReceivesMessage;
use Scalex\Zero\Contracts\Communication\SendsMessage;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\School;
use Znck\Trust\Contracts\Permissible as PermissibleContract;
use Znck\Trust\Traits\Permissible;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    BelongsToSchool,
    PermissibleContract,
    ReceivesMessage,
    SendsMessage
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

    protected $extends = ['other_email', 'other_verification_token'];

    public function school() {
        return $this->belongsTo(School::class);
    }

    public function profilePhoto() {
        return $this->belongsTo(Attachment::class, 'photo_id');
    }

    public function person() {
        return $this->morphTo();
    }

    public function groups() {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }
}
