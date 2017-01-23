<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Models\Attachment;
use Scalex\Zero\User;
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

    public function creating(User $user, array $attributes) {
        $user->fill(array_only($attributes, ['name', 'email']));
        $user->verification_token = str_random(32);

        if ($password = array_get($attributes, 'password')) {
            $user->password = bcrypt($password);
        }

        if ($photo = find($attributes, 'photo_id', Attachment::class)) {
            attach_attachment($user, 'profilePhoto', $photo);
        }

        if ($school = find($attributes, 'school_id')) {
            $user->school()->associate($school);
        }

        if ($person = find($attributes, 'person')) {
            $user->person()->associate($person);
        }

        return $user->save();
    }

    public function updating(User $user, array $attributes, array $options = []) {
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
            $user->profilePhoto()->associate($photo);
        }

        if ($person = array_get($attributes, 'person')) {
            $user->person()->associate($person);
        }

        return $user->save($options);
    }
}
