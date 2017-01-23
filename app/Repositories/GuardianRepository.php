<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Guardian;
use Znck\Repositories\Repository;

/**
 * @method Guardian find(string|int $id)
 * @method Guardian findBy(string $key, $value)
 * @method Guardian create(array $attr)
 * @method Guardian update(string|int|Guardian $id, array $attr, array $o = [])
 * @method Guardian delete(string|int|Guardian $id)
 * @method GuardianRepository validate(array $attr, Guardian|null $model)
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
    protected $rules = [];

    public function boot()
    {
        if (current_user()) {
            $this->pushCriteria(new OfSchool(current_user()->school));
        }
    }
}
