<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Semester;
use Znck\Repositories\Repository;

/**
 * @method Semester find(string|int $id)
 * @method Semester findBy(string $key, $value)
 * @method Semester create(array $attr)
 * @method Semester update(string|int|Semester $id, array $attr, array $o = [])
 * @method Semester delete(string|int|Semester $id)
 * @method SemesterRepository validate(array $attr, Semester|null $model)
 */
class SemesterRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Semester::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:255',
        'school_id' => 'required|exists:schools,id',
    ];

    public function boot()
    {
        if (current_user()) {
            $this->pushCriteria(new OfSchool(current_user()->school));
        }
    }

    public function creating(Semester $semester, array $attributes)
    {
        $semester->fill($attributes);
        $semester->school()->associate(find($attributes, 'school_id'));

        return $semester->save();
    }

    public function updating(Semester $semester, array  $attribute)
    {
        $semester->fill($attribute);

        return $semester->update();
    }
}
