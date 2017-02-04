<?php namespace Scalex\Zero\Repositories;

use Illuminate\Http\UploadedFile;
use Ramsey\Uuid\Uuid;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\User;
use Znck\Attach\Builder;
use Znck\Repositories\Repository;

/**
 * @method User find($id, $columns = ['*'])
 * @method User findBy(string $key, $value)
 * @method User create(array $attr)
 * @method User update(string|User $id, array $attr, array $o = [])
 * @method User delete(string|User $id)
 */
class UserRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'nullable|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|max:60',
        'photo_id' => 'nullable|exists:documents,id',
        'school_id' => 'required|exists:schools,id',
    ];

    /**
     * TODO: Try to remove this function.
     *
     * @param \Scalex\Zero\User $user
     * @param array $attributes
     *
     * @deprecated
     *
     * @return bool
     */
    public function creating(User $user, array $attributes)
    {
        $user->fill(array_only($attributes, ['name', 'email']));
        $user->verification_token = str_random(32);

        if ($password = array_get($attributes, 'password')) {
            $user->password = bcrypt($password);
        }

        if ($photo = find($attributes, 'photo_id', Attachment::class)) {
            attach_attachment($user, 'photo', $photo);
        }

        if ($school = find($attributes, 'school_id')) {
            $user->school()->associate($school);
        }

        if ($person = find($attributes, 'person')) {
            $user->person()->associate($person);
        }

        return $user->save();
    }


    /**
     * TODO: Try to remove this function.
     *
     * @param \Scalex\Zero\User $user
     * @param array $attributes
     * @param array $options
     *
     * @deprecated
     *
     * @return bool
     */
    public function updating(User $user, array $attributes, array $options = [])
    {
        if (array_has($attributes, 'email')) {
            $user->other_email = $attributes['email'];
            $user->other_verification_token = str_random(32);

            unset($attributes['email']);
        }

        $user->fill(array_only($attributes, ['name']));

        if ($password = array_get($attributes, 'password')) {
            $user->password = bcrypt($password);
        }

        if ($photo = array_get($attributes, 'photo_id')) {
            $user->photo()->associate($photo);
        }

        if ($person = array_get($attributes, 'person')) {
            $user->person()->associate($person);
        }

        return $user->save($options);
    }

    /**
     * Upload message attachment for the user.
     *
     * @param \Scalex\Zero\User $user
     * @param \Illuminate\Http\UploadedFile $file
     * @param array $attributes
     *
     * @return \Scalex\Zero\Models\Attachment
     */
    public function uploadMessageAttachment(User $user, UploadedFile $file, array $attributes = []): Attachment
    {
        return $this->upload($user, $file, $attributes, 'messages');
    }

    /**
     * Prepare upload path for user.
     *
     * @param \Scalex\Zero\User $user
     * @param string $directory
     *
     * @return string
     */
    protected function getUploadPath(User $user, string $directory): string
    {
        return "schools/{$user->school_id}/users/{$user->id}/${directory}";
    }

    /**
     * Upload file for user.
     *
     * @param \Scalex\Zero\User $user
     * @param \Illuminate\Http\UploadedFile $file
     * @param array $attributes
     * @param string $directory
     *
     * @return \Scalex\Zero\Models\Attachment
     */
    public function upload(User $user, UploadedFile $file, array $attributes = [], string $directory = 'attachments'): Attachment
    {
        $this->validateWith(compact('file'), ['file' => 'required|file']);

        $attributes['path'] = $this->getUploadPath($user, $directory);
        $attributes['slug'] = $attributes['slug'] ?? Uuid::uuid4();

        $uploader = Builder::makeFromFile($file);

        if (preg_match('^image\/.*', $file->getMimeType())) {
            $uploader->resize(4096)->resize(450, 'preview');
        }

        $attachment = $uploader->upload($attributes)->getAttachment();

        $attachment->owner()->associate($user);
        $attachment->related()->associate($user);

        $this->onCreate($attachment->save());

        return $attachment;
    }
}
