<?php namespace Scalex\Zero\Repositories;

use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Discipline;
use Znck\Repositories\Repository;

/**
 * @method Discipline find(string|int $id)
 * @method Discipline findBy(string $key, $value)
 * @method Discipline create(array $attr)
 * @method Discipline update(string|int|Discipline $id, array $attr, array $o = [])
 * @method Discipline delete(string|int|Discipline $id)
 * @method DisciplineRepository validate(array $attr, Discipline|null $model)
 */
class DisciplineRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Discipline::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:255',
        'short_name' => 'max:255',
        'school_id' => 'required|exists:schools,id',
    ];

    public function boot() {
        if (current_user()) {
            $this->pushCriteria(new OfSchool(current_user()->school));
        }
    }

    public function creating(Discipline $discipline, array $attributes) {
        $discipline->fill($attributes);
        $discipline->school()->associate(find($attributes, 'school_id'));

        return $discipline->save();
    }

    public function updating(Discipline $discipline, array  $attribute) {
        $discipline->fill($attribute);

        return $discipline->update();
    }
}
