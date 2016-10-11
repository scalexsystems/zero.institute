<?php namespace Scalex\Zero\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Scalex\Zero\Contracts\Person;
use Scalex\Zero\Database\ExtendibleModel;
use Scalex\Zero\Models\Geo\Address;

class Guardian extends ExtendibleModel implements Person
{
    use SoftDeletes;

    protected $fillable = [
        // Basic Information.
        'first_name',
        'middle_name',
        'last_name',
        'date_of_birth',
        'gender',
        'blood_group',
        'category',
        'religion',
        'language',
        'passport',
        'govt_id',
        // Personal Information.
        'income',
        'phone',

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

    protected $searchable = ['name'];

    protected $dates = ['date_of_birth'];

    protected $appends = ['name'];

    public function getNameAttribute() {
        return str_replace(
            '  ', ' ',
            $this->attributes['first_name'].' '.
            $this->attributes['middle_name'].' '.
            $this->attributes['last_name']
        );
    }

    /**
     * School.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school() {
        return $this->belongsTo(School::class);
    }

    /**
     * Home address.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address() {
        return $this->belongsTo(Address::class);
    }

    /**
     * Profile photo of the student.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profilePhoto() {
        return $this->belongsTo(Attachment::class, 'photo_id');
    }
}
