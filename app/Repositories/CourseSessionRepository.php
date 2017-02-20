<?php

namespace Scalex\Zero\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\User;
use Znck\Repositories\Exceptions\StoreResourceException;
use Znck\Repositories\Repository;

/**
 * @method \Scalex\Zero\Models\CourseSession find(int $id)
 * @method CourseSession findBy(string $key, $value)
 * @method \Scalex\Zero\Models\CourseSession create(array $attr)
 * @method \Scalex\Zero\Models\CourseSession update(int | \Scalex\Zero\Models\CourseSession $id, array $attr, array $o = [])
 * @method \Scalex\Zero\Models\CourseSession delete(int | \Scalex\Zero\Models\CourseSession $id)
 * @method CourseSessionRepository validate(array $attr, \Scalex\Zero\Models\CourseSession | null $model)
 */
class CourseSessionRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = \Scalex\Zero\Models\CourseSession::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'nullable|max:255',
        'started_on' => 'required|date',
        'ended_on' => 'required|date',
    ];

    /**
     * Get update rules.
     *
     * @param array $rules
     * @param array $attributes
     * @param \Scalex\Zero\Models\CourseSession $session
     *
     * @return array
     */
    public function getUpdateRules(array $rules, array $attributes, $session)
    {
        return array_only(
            $rules + $this->getRulesForSchool($session->course->school),
            array_keys($attributes)
        );
    }

    public function createForCourse(Course $course, array $attributes)
    {
        $this->validateWith($attributes, $this->getRulesForSchool($course->school));

        $instructor = Teacher::find($attributes['instructor_id']);

        if ($instructor->user) {
            throw new StoreResourceException('Instructor does not have an account on Zero.');
        }

        $session = new \Scalex\Zero\Models\CourseSession($attributes);

//        $session->name = TODO: Create a default session name.

        $session->course()->associate($course);
        $session->instructor()->associate($instructor);
        $session->group()->associate($this->createGroupForSession($course, $instructor->user));

        $this->onCreate($session->save());

        return $session;
    }

    public function updating(\Scalex\Zero\Models\CourseSession $session, array $attributes)
    {
        if (isset($attributes['private'])) {
            unset($attributes['private']);
        }

        $session->instructor()->associate($attributes['instructor_id'] ?? $session->instructor_id);

        return $session->update($attributes);
    }

    public function enroll(\Scalex\Zero\Models\CourseSession $session, Collection $students)
    {
        $duplicates = $session->students()->wherePivotIn('student_id', $students->modelKeys())->get()->keyBy('id');

        $students = $students->filter(function (Student $student) use ($duplicates) {
            return !$duplicates->has($student->getKey());
        });

        $session->students()->attach($students);

        $users = $students->load('user')->map(function (Student $student) {
            return $student->user;
        })->pluck('id');

        $session->group->addMembers($users);

        return $students;
    }

    public function expel(\Scalex\Zero\Models\CourseSession $session, Collection $students)
    {
        $session->students()->detach($students);

        $users = $students->load('user')->map(function (Student $student) {
            return $student->user;
        })->pluck('id');

        $session->group->removeMembers($users);

        return $students;
    }

    protected function getRulesForSchool(School $school)
    {
        return [
            'instructor_id' => [
                'bail',
                'required',
                Rule::exists('teachers', 'id')->where('school_id', $school->getKey()),
            ],
        ];
    }

    /**
     * @param \Scalex\Zero\Models\Course $course
     * @param $instructor
     *
     * @return \Scalex\Zero\Models\Group
     */
    protected function createGroupForSession(Course $course, User $owner): Group
    {
        $group = new Group();

        $group->name = $course->name;
        $group->description = $course->description;
        $group->type = morph_model(Course::class);
        $group->private = true;
        $group->owner()->associate($owner);
        $group->school()->associate($course->school);

        $this->onCreate($group->save());

        return $group;
    }
}
