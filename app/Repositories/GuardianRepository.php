<?php namespace Scalex\Zero\Repositories;

use Request;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Guardian;
use Scalex\Zero\Models\School;
use UnexpectedValueException;
use Znck\Repositories\Repository;

/**
 * @method Guardian find(string | int $id)
 * @method Guardian findBy(string $key, $value)
 * @method Guardian create(array $attr)
 * @method Guardian update(string | int | Guardian $id, array $attr, array $o = [])
 * @method Guardian delete(string | int | Guardian $id)
 * @method GuardianRepository validate(array $attr, Guardian | null $model)
 */
class GuardianRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Guardian::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'email' => 'nullable|email',
        'salary' => 'nullable|numeric',
    ];

    public function boot()
    {
        if ($user = Request::user()) {
            $this->pushCriteria(new OfSchool($user->school));
        }
    }

    public function creating()
    {
        throw new UnexpectedValueException('Use `createForSchool` method instead of `create`.');
    }

    public function createForSchool(School $school, array $attributes)
    {
        $guardian = new Guardian($attributes);

        $guardian->school()->associate($school);

        $this->onCreate($guardian->save());

        return $guardian;
    }
}
