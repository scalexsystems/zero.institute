<?php

namespace Scalex\Zero\Repositories\Course;

use Scalex\Zero\Models\Course\Session;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Teacher;
use Znck\Repositories\Repository;

/**
 * @method Session find(string|int $id)
 * @method Session findBy(string $key, $value)
 * @method Session create(array $attr)
 * @method Session update(string|int|Session $id, array $attr, array $o = [])
 * @method Session delete(string|int|Session $id)
 * @method SessionRepository validate(array $attr, Session|null $model)
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
        'name' => 'nullable|max:255',
        'started_on' => 'required|date',
        'ended_on' => 'required|date',
        'course_id' => 'required|exists:courses,id',
        'instructor_id' => 'required|exists:teachers,id',
    ];

    public function creating(Session $session, array $attributes)
    {
        $session->fill($attributes);
        $session->course()->associate(find($attributes, 'course_id'));
        $session->instructor()->associate($instructor = find($attributes, 'instructor_id', Teacher::class));

        $group = new Group([
            'name' => $session->course->name,
            'description' => 'Course discussion group',
            'private' => true,
        ]);
        $group->owner()->associate($instructor->user);
        $group->photo_id = $session->course->photo_id;
        $group->type = 'course';
        $group->save();

        $session->group()->associate($group);

        $status = $session->save();

        if (!$status) {
            $group->delete();
        } else {
            $group->addMembers((array) $group->owner->getKey());
        }

        return $status;
    }

    public function updating(Session $session, array $attributes)
    {
        $session->fill($attributes);

        if (array_has($attributes, 'instructor_id')) {
            $instructor = find($attributes, 'instructor_id', Teacher::class);

            $group = $session->group;
            $old = $group->owner->getKey();
            $session->instructor()->associate($instructor);
            $session->save();

            $group->owner()->associate($session->instructor->user);
            $group->save();

            $group->addMembers((array)$session->instructor->user->getKey());
            $group->removeMembers((array)$old);
        }

        return $session->update();
    }

    public function enroll(Session $session, array $students)
    {
        $enrolled = \DB::table('course_session_student')
            ->select('student_id')->whereSessionId($session->getKey())
            ->whereIn('student_id', (array) $students)->get()
            ->pluck('student_id')->toArray();

        $newEnrollments = array_values(array_diff($students, $enrolled));

        $session->students()->attach($newEnrollments);

        $session->group->addMembers($newEnrollments);
    }
}
