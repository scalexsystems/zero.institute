<?php namespace Scalex\Zero\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Contracts\Database\BelongsToSchool;
use Scalex\Zero\Contracts\Person;
use Scalex\Zero\Database\BaseModel;
use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\Models\Address;
use Scalex\Zero\ModelTraits\FoodHabitTrait;
use Scalex\Zero\User;

class Student extends BaseModel implements Person, BelongsToSchool
{
    use SoftDeletes, FoodHabitTrait;

    protected $fillable = [
        // Basic Information.
        'first_name',
        'last_name',
        'middle_name',
        'date_of_birth',
        'gender',
        'blood_group',
        'category',
        'religion',
        'language',
        'passport',
        'govt_id',

        // Related to School.
        'uid',
        'date_of_admission',
        'boarding_type',
        'biometric_id',

        // Medical Information.
        'is_disabled',
        'disability',
        'disease',
        'allergy',
        'visible_marks',
        'food_habit',
        'medical_remarks',

        // Maintenance Information.
        'remarks',
    ];

    protected $searchable = [
        'name',
        'first_name',
        'middle_name',
        'last_name',
        'uid',
        'department_id',
        'discipline_id',
        'school_id',
    ];

    protected $casts = [
        'is_disabled' => 'boolean',
        'archived' => 'boolean',
    ];

    protected $extends = ['bio'];

    protected $dates = ['date_of_birth', 'date_of_admission'];

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
     * School of the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Student is registered to the academic department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Student is registered to the discipline.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
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
     * Student's father.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function father()
    {
        return $this->belongsTo(Guardian::class);
    }

    /**
     * Student's mother.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mother()
    {
        return $this->belongsTo(Guardian::class);
    }

    /**
     * Profile photo of the student.
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
        return $this->belongsToMany(CourseSession::class, 'course_session_student', 'student_id', 'session_id')->withTimestamps();
    }

    public function getRouteKeyName()
    {
        return 'uid';
    }

    public function setDateOfAdmissionAttribute($value)
    {
        $this->attributes['date_of_admission'] = Carbon::parse($value);
    }

    public function setDateOfBirthAttribute($value)
    {
        $this->attributes['date_of_birth'] = Carbon::parse($value);
    }

    public function getPhotoUrl()
    {
        return attach_url($this->photo) ?? asset('img/placeholder.jpg');
    }

    public function getYearAttribute()
    {
        if ($this->date_of_admission instanceof Carbon) {
            return $this->date_of_admission->year;
        }
    }
}
