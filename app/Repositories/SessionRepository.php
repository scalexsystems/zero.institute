<?php namespace Scalex\Zero\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Request;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Session;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Teacher;
use UnexpectedValueException;
use Znck\Repositories\Repository;

/**
 * @method Session find(string | int $id)
 * @method Session findBy(string $key, $value)
 * @method Session create(array $attr)
 * @method Session update(string | int | Session $id, array $attr, array $o = [])
 * @method Session delete(string | int | Session $id)
 * @method SessionRepository validate(array $attr, Session | null $model)
 */
class SessionRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Session::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:255',
        'started_on' => 'required|date',
        'ended_on' => 'required|date',
    ];

    /**
     * Get update rules.
     *
     * @param array $rules
     * @param array $attributes
     * @param \Scalex\Zero\Models\Session $session
     *
     * @return array
     */
    public function getUpdateRules(array $rules, array $attributes, $session)
    {
        return array_only(
            $rules + $this->getRulesForSchool($session->school),
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

        $session = new Session($attributes);

        $session->school()->associate($school);
        $session->semester()->associate($attributes['semester_id']);


        $this->onCreate($session->save());

        return $session;
    }

    public function creating(Session $session, array $attributes)
    {
        throw new UnexpectedValueException('Use `createForSchool` method instead of `create`.');
    }

    public function updating(Session $session, array $attributes)
    {
        $session->semester()->associate($attributes['semester_id'] ?? $session->semester_id);

        return $session->update($attributes);
    }

    protected function getRulesForSchool(School $school)
    {
        return $this->rules + [
                'semester_id' => [
                    'bail',
                    'required',
                    Rule::exists('semesters', 'id')->where('school_id', $school->getKey()),
                ],
            ];
    }
}
