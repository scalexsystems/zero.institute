<?php namespace Scalex\Zero\Repositories;

use Illuminate\Support\Arr;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Department;
use Scalex\Zero\Models\Teacher;
use Znck\Repositories\Repository;

/**
 * @method Department find(string|int $id)
 * @method Department findBy(string $key, $value)
 * @method Department create(array $attr)
 * @method Department update(string|int|Department $id, array $attr, array $o = [])
 * @method Department delete(string|int|Department $id)
 * @method DepartmentRepository validate(array $attr, Department|null $model)
 */
class DepartmentRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Department::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:255',
        'short_name' => 'nullable|max:255',
        'academic' => 'nullable|boolean',
        'head_id' => 'nullable|exists:teachers,id',
        'school_id' => 'required|exists:schools,id',
    ];

    public function boot()
    {
        if (current_user()) {
            $this->pushCriteria(new OfSchool(current_user()->school));
        }
    }

    public function creating(Department $department, array $attributes)
    {
        $department->fill($attributes);

        if (Arr::has($attributes, 'head_id')) {
            $department->head()->associate(find($attributes, 'head_id', Teacher::class));
        }

        $department->school()->associate(find($attributes, 'school_id'));

        return $department->save();
    }

    public function updating(Department $department, array $attributes)
    {
        $department->fill($attributes);

        if (Arr::has($attributes, 'head_id')) {
            $department->head()->associate(find($attributes, 'head_id', Teacher::class));
        }

        return $department->update();
    }
}
