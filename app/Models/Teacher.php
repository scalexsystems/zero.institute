<?php namespace Scalex\Zero\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Contracts\Person;
use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\Models\Geo\Address;
use Scalex\Zero\Models\Course\Session;
use Scalex\Zero\User;

class Teacher extends BaseModel implements BelongsToSchool, Person
{
    use SoftDeletes;

    protected $fillable = [
        // Basic Information
        'photo_id',
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'blood_group',
        'category',
        'religion',
        'language',
        'nationality',
        'passport',
        'govt_id',

        // Related to School
        'uid',
        'date_of_joining',
        'job_title',
        'department_id',
        'specialization',
        'biometric_id',

        // Qualification
        'education',

        // Past Working Experience
        'experience',

        // Bank Account Details
        'bank',
        'beneficiary_name',
        'bank_account_number',
        'ifsc_code',
        'income_tax_id',

        // Medical Details
        'is_disabled',
        'disability',
        'disease',
        'allergy',
        'visible_marks',
        'food_habit',
        'medical_remarks',

        // Maintenance Information
        'remarks',
    ];

    protected $casts = [
        'is_disabled' => 'boolean',
        'archived' => 'boolean',
        // Qualification Details
        'education' => 'json',
        // Past Working Experience
        'experience' => 'json',
    ];

    protected $searchable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'uid',
        'department_id',
        'school_id',
    ];

    protected $extends = ['bio'];

    protected $dates = ['date_of_birth', 'date_of_joining'];

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        return str_replace(
            '  ', ' ',
            $this->attributes['first_name'].' '.
            $this->attributes['middle_name'].' '.
            $this->attributes['last_name']
        );
    }



    /**
     * School of the employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Employee is employed at the department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Home address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Profile photo of the teacher.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photo()
    {
        return $this->belongsTo(Attachment::class, 'photo_id');
    }

    /**
     * Associated user account.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function user()
    {
        return $this->morphOne(User::class, 'person');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'instructor_id');
    }

    public function getRouteKeyName()
    {
        return 'uid';
    }

    public function getPhotoUrl()
    {
        return attach_url($this->photo) ?? asset('img/placeholder.jpg');
    }

    public function setDateOfJoiningAttribute($value)
    {
        $this->attributes['date_of_joining'] = Carbon::parse($value);
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = Carbon::parse($value);
    }
}
