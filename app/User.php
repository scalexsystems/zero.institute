<?php namespace Scalex\Zero;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\BaseModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Scalex\Zero\Models\School;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    BelongsToSchool
{
    use Authenticatable, Authorizable, CanResetPassword;

    use HasApiTokens, Notifiable;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    public function school() {
        return $this->belongsTo(School::class);
    }

    public function profilePhoto() {
        return $this->belongsTo(Attachment::class, 'photo_id');
    }

    public function person() {
        return $this->morphTo();
    }
}
