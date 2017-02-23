<?php namespace Scalex\Zero\Repositories;

use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\Uuid;
use Scalex\Zero\Models\Address;
use Scalex\Zero\Models\School;
use Scalex\Zero\User;
use Znck\Attach\Builder;
use Znck\Repositories\Repository;

/**
 * @method School find(string $id, array $col = [])
 * @method School findBy(string $key, $value)
 * @method School create(array $attr)
 * @method School update(string | School $id, array $attr, array $o = [])
 * @method School delete(string | School $id)
 * @method SchoolRepository validate(array $attr, School $model = null)
 */
class SchoolRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = School::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:255',
        'slug' => 'required|min:4|max:255|alphadash|reserved|unique:schools',
        'address_id' => 'required|exists:addresses,id',
        'email' => 'required|email',
        'phone' => 'required|phone',
        'fax' => 'nullable|phone',
        'university' => 'required|max:255',
        'institute_type' => 'required|max:255',
        'logo_id' => 'nullable|exists:attachments,id',
        'verified' => 'nullable|boolean',
    ];

    public function updating(School $school, array $attributes)
    {
        return $school->update($attributes);
    }

    public function updateAddress(School $school, array $attributes)
    {
        $repository = repository(Address::class);

        if ($school->address) {
            $repository->update($school->address, $attributes);
        } else {
            $address = $repository->create($attributes);

            $school->address()->associate($address);

            $this->onUpdate($school->save());
        }

        return $school;
    }

    public function uploadPhoto(School $school, UploadedFile $photo, User $user)
    {
        if (!$photo->isValid()) {
            throw new UploadException('Invalid photo.');
        }

        // Set path & slug.
        $attributes['path'] = $this->getPhotoUploadPath($school);
        $attributes['slug'] = $attributes['slug'] ?? Uuid::uuid4();

        // Prepare uploader.
        $uploader = Builder::makeFromFile($photo)->resize(360, 'preview', 360);
        ;

        // Upload & get attachment.
        $attachment = $uploader->upload($attributes);

        $attachment->owner()->associate($user);
        $attachment->related()->associate($school);

        $this->onCreate($attachment->save());

        // Associate photo to the student.
        $school->logo()->associate($attachment);

        $this->onUpdate($school->save());

        return $attachment;
    }


    protected function getPhotoUploadPath(School $school)
    {
        return "schools/{$school->id}/logo";
    }
}
