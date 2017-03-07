<?php namespace Scalex\Zero\Repositories;

use BadMethodCallException;
use Illuminate\Validation\Rule;
use Scalex\Zero\Models\FeeSession;
use Scalex\Zero\Models\School;
use Znck\Repositories\Repository;

/**
 * @method FeeSession find(int $id)
 * @method FeeSession findBy(string $key, $value)
 * @method FeeSession create(array $attr)
 * @method FeeSession update(int | FeeSession $id, array $attr, array $o = [])
 * @method FeeSession delete(int | FeeSession $id)
 */
class FeeSessionRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = FeeSession::class;

    public function getCreateRulesForSchool(School $school)
    {
        return [
            'name' => 'required|max:255',
            'started_at' => 'required|date',
            'ended_at' => 'required|date|after:started_at',
            'accepting' => 'nullable|boolean',
            'session_id' => [
                'bail',
                'required',
                Rule::exists('sessions', 'id')->where('school_id', $school->getkey()),
            ],
        ];
    }

    public function creating()
    {
        throw new BadMethodCallException('Use createWithSchool instead of create.');
    }

    public function createWithSchool(School $school, array $attributes)
    {
        $this->validateWith($attributes, $this->getCreateRulesForSchool($school));
        $session = new FeeSession($attributes);

        $session->school()->associate($school);
        $session->session()->associate($attributes['session_id']);

        $this->onCreate($session->save());

        return $session;
    }
}
