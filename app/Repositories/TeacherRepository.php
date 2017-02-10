<?php namespace Scalex\Zero\Repositories;

use Ramsey\Uuid\Uuid;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\Geo\Address;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\User;
use Znck\Attach\Builder;
use Znck\Repositories\Repository;
use Illuminate\Http\UploadedFile;


/**
 * @method Teacher find(string|int $id)
 * @method Teacher findBy(string $key, $value)
 * @method Teacher create(array $attr)
 * @method Teacher update(string|int|Teacher $id, array $attr, array $o = [])
 * @method Teacher delete(string|int|Teacher $id)
 * @method TeacherRepository validate(array $attr, Teacher|null $model)
 */
class TeacherRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        // Basic Information
        'photo_id' => 'nullable|exists:attachments,id',
        'first_name' => 'required|max:255',
        'middle_name' => 'nullable|max:255',
        'last_name' => 'required|max:255',
        'date_of_birth' => 'required|date',
        'gender' => 'nullable|in:female,male,other',
        'blood_group' => 'nullable|in:A+,A-,AB+,AB-,B+,B-,O+,O-',
        'category' => 'nullable|in:gen,obc,sc,st,ot',
        'religion' => 'nullable|max:255',
        'language' => 'nullable|max:255',
        'nationality' => 'nullable|max:255',
        'passport' => 'nullable|max:255',
        'govt_id' => 'nullable|max:255',

        // Related to School
        'uid' => '',
        'date_of_joining' => 'nullable|date',
        'job_title' => 'nullable|max:255',
        'department_id' => 'required|exists:departments,id',
        'specialization' => 'nullable|max:255',
        'biometric_id' => 'nullable|max:255',

        // Qualification.
        'education' => 'nullable',

        // Past Working Experience.
        'experience' => 'nullable',

        // Address
        'address_id' => 'required|exists:addresses,id',

        // Bank Account Details
        'bank' => 'nullable|max:255',
        'beneficiary_name' => 'nullable|max:255',
        'bank_account_number' => 'nullable|max:255',
        'ifsc_code' => 'nullable|max:255',
        'income_tax_id' => 'nullable|max:255',

        // Medical Details
        'is_disabled' => 'nullable|boolean',
        'disability' => 'required_if:is_disabled,1|max:255',
        'disease' => 'nullable|max:255',
        'allergy' => 'nullable|max:255',
        'visible_marks' => 'nullable|max:255',
        'food_habit' => 'nullable|in:veg,non_veg',
        'medical_remarks' => 'nullable|max:65536',

        // Maintenance Information
        'archived' => 'nullable|boolean',
        'school_id' => 'required|exists:schools,id',
        'remarks' => 'nullable|max:65536',
    ];

    public function boot()
    {
        if (current_user()) {
            $this->pushCriteria(new OfSchool(current_user()->school));
        }
    }


    /**
     * @param array $rules
     * @param array $attributes
     * @param Teacher $teacher
     *
     * @return array
     */
    public function getUpdateRules(array $rules, array $attributes, $teacher)
    {
        $rules += array_dot(
            [
                'address' => repository(Address::class)->getRules($attributes, $teacher->address),
            ]);

        $rules['uid'] = 'required|unique:teachers,uid,' . $teacher->id . ',id,school_id,' . current_user()->school_id;

        return array_only($rules, array_keys($attributes));
    }

    public function getCreateRules(array $attributes)
    {
        $rules = $this->rules + array_dot(
                [
                    'address' => repository(Address::class)->getRules($attributes),
                ]);

        $rules['uid'] = 'required|unique:teachers,uid,NULL,id,school_id,' . current_user()->school_id;

        return $rules;
    }

    public function creating(Teacher $teacher, array $attributes)
    {
        $teacher->fill($attributes);

        $teacher->address()->associate(repository(Address::class)->create(array_get($attributes, 'address', [])));
        $teacher->department()->associate(find($attributes, 'department_id'));
        $teacher->school()->associate(find($attributes, 'school_id'));
        attach_attachment($teacher, 'profilePhoto', find($attributes, 'photo_id', Attachment::class));

        $teacher->bio = $this->getBio($teacher);

        $status = $teacher->save();

        if ($status and $teacher->address) {
            $teacher->address->addressee()->associate($teacher)->save();
        }

        return $status;
    }

    public function updating(Teacher $teacher, array $attributes)
    {
        $teacher->fill($attributes);

        if (array_has($attributes, 'department_id')) {
            $teacher->department()->associate(find($attributes, 'department_id'));
        }
        if (array_has($attributes, 'photo_id')) {
            attach_attachment($teacher, 'profilePhoto', find($attributes, 'photo_id', Attachment::class));
        }
        if (array_has($attributes, 'address') && !empty($attributes['address'])) {
            if (isset($teacher->address)) {
                repository(Address::class)
                    ->update($teacher->address, $attributes['address']);
            } else {
                $teacher->address()->associate(repository(Address::class)->create(array_get($attributes, 'address', [])));
            }
        }

        $teacher->bio = $this->getBio($teacher);

        return $teacher->update();
    }

    public function uploadPhoto(Teacher $teacher, UploadedFile $photo, User $user)
    {
        if (!$photo->isValid()) {
            throw new UploadException('Invalid photo.');
        }

        // Set path & slug.
        $attributes['path'] = $this->getPhotoUploadPath($teacher);
        $attributes['slug'] = $attributes['slug'] ?? Uuid::uuid4();

        // Prepare uploader.
        $uploader = Builder::makeFromFile($photo)->resize(360, 'preview', 360);;

        // Upload & get attachment.
        $attachment = $uploader->upload($attributes)->getAttachment();

        $attachment->owner()->associate($user);
        $attachment->related()->associate($teacher);

        $this->onCreate($attachment->save());

        // Associate photo to the teacher.
        $teacher->photo()->associate($attachment);

        $this->onUpdate($teacher->save());

        return $attachment;

    }

    protected function getPhotoUploadPath(Teacher $teacher)
    {
        return "schools/{$teacher->school_id}/teachers/photo/{$teacher->id}";
    }

    public function getBio()
    {
        return '';
    }

}
