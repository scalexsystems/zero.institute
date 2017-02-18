<?php namespace Scalex\Zero\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Request;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Department;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Teacher;
use UnexpectedValueException;
use Znck\Repositories\Repository;

/**
 * @method Department find(string | int $id)
 * @method Department findBy(string $key, $value)
 * @method Department create(array $attr)
 * @method Department update(string | int | Department $id, array $attr, array $o = [])
 * @method Department delete(string | int | Department $id)
 * @method DepartmentRepository validate(array $attr, Department | null $model)
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
        'short_name' => 'required|max:255',
        'academic' => 'required|boolean',
    ];

    /**
     * Get update rules.
     *
     * @param array $rules
     * @param array $attributes
     * @param \Scalex\Zero\Models\Department $department
     *
     * @return array
     */
    public function getUpdateRules(array $rules, array $attributes, $department)
    {
        return array_only(
            $rules + $this->getRulesForSchool($department->school),
            array_keys($attributes)
        );
    }


    public function boot()
    {
        if ($user = Request::user()) {
            $this->pushCriteria(new OfSchool($user->school));
        }
    }

    public function createForSchool(School $school, array $attributes)
    {
        $this->validateWith($attributes, $this->getRulesForSchool($school));

        $department = new Department($attributes);

        $department->school()->associate($school);
        $department->head()->associate($attributes['head_id'] ?? $department->head_id);


        $this->onCreate($department->save());

        return $department;
    }

    public function creating(Department $department, array $attributes)
    {
        throw new UnexpectedValueException('Use `createForSchool` method instead of `create`.');
    }

    public function updating(Department $department, array $attributes)
    {
        $department->head()->associate($attributes['head_id'] ?? $department->head_id);

        return $department->update($attributes);
    }

    protected function getRulesForSchool(School $school)
    {
        return $this->rules + [
                'head_id' => [
                    'bail',
                    'nullable',
                    Rule::exists('teachers', 'id')->where('school_id', $school->getKey()),
                ],
            ];
    }
}
