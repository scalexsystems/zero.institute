<?php

namespace Scalex\Zero\Repositories;

use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Request;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\User;
use Znck\Repositories\Repository;

/**
 * @method Course find(string | int $id)
 * @method Course findBy(string $key, $value)
 * @method Course create(array $attr)
 * @method Course update(string | int | Course $id, array $attr, array $o = [])
 * @method Course delete(string | int | Course $id)
 * @method CourseRepository validate(array $attr, Course | null $model)
 */
class CourseRepository extends Repository
{
    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'name' => 'required|max:255',
        'description' => 'nullable|max:65535',
    ];

    public function boot()
    {
        if ($user = Request::user()) {
            $this->pushCriteria(new OfSchool($user->school));
        }
    }

    public function getRulesForSchool(School $school)
    {
        $id = $school->getKey();

        return $this->rules + [
                'code' => [
                    'bail',
                    'required',
                    'alphdash',
                    Rule::unique('students')->where('school_id', $id),
                ],
                'department_id' => [
                    'required',
                    Rule::exists('departments', 'id')->where('school_id', $id),
                ],
                'discipline_id' => [
                    'nullable',
                    Rule::exists('disciplines', 'id')->where('school_id', $id),
                ],
                'photo_id' => [
                    'nullable',
                    Rule::exists('attachments', 'id')->where('school_id', $id),
                ],
                'semester_id' => [
                    'nullable',
                    Rule::exists('semesters', 'id')->where('school_id', $id),
                ],
            ];
    }

    /**
     * Get update rules.
     *
     * @param array $rules
     * @param array $attributes
     * @param \Scalex\Zero\Models\Course $course
     *
     * @return array
     */
    public function getUpdateRules(array $rules, array $attributes, $course)
    {
        $rules = $this->getRulesForSchool($course->school);

        $rules['code'] = [
            'bail',
            'required',
            'alphdash',
            Rule::unique('courses')
                ->where('school_id', $course->school_id)
                ->ignore($course->getKey()),
        ];

        return array_only($rules, array_keys($attributes));
    }

    /**
     * Create a course in the school.
     *
     * @param \Scalex\Zero\Models\School $school
     * @param array $attributes
     *
     * @return \Scalex\Zero\Models\Course
     */
    public function createForSchool(School $school, array $attributes)
    {
        $this->validateWith($attributes, $this->getRulesForSchool($school));

        $course = new Course($attributes);

        $course->department()->associate($attributes['department_id']);
        $course->discipline()->associate($attributes['discipline_id'] ?? null);
        $course->photo()->associate($attributes['photo_id'] ?? null);
        $course->semester()->associate($attributes['semester_id'] ?? null);

        $this->onCreate($course->save());

        if ($course->photo) {
            $course->photo->related()->save($course);
        }

        return $course;
    }

    /**
     * Update a course.
     *
     * @param \Scalex\Zero\Models\Course $course
     * @param array $attributes
     *
     * @return bool
     */
    public function updating(Course $course, array $attributes)
    {
        $course->department()->associate($attributes['department_id'] ?? $course->department_id);
        $course->discipline()->associate($attributes['discipline_id'] ?? $course->discipline_id);
        $course->photo()->associate($attributes['photo_id'] ?? $course->photo_id);
        $course->semester()->associate($attributes['semester_id'] ?? $course->semester_id);

        return $course->update($attributes);
    }

    public function addPrerequisites(Course $course, array $attributes)
    {
        $constraints = Course::whereSchoolId($course->school_id)
                             ->whereIn('id', $attributes)
                             ->get()
                             ->map(function (Course $course) {
                                 return new Course\Constraint([
                                                                  'constraint_type' => 'course',
                                                                  'constraint_id' => $course->getKey(),
                                                              ]);
                             });

        $course->prerequisites()->saveMany($constraints);
    }

    public function addInstructors(Course $course, array $attributes)
    {
        $teachers = Teacher::whereSchoolId($course->school_id)
                           ->whereIn('id', $attributes)
                           ->get();

        $course->instructors()->saveMany($teachers);
    }

    public function removeInstructors(Course $course, array $attributes)
    {
        $teachers = Teacher::whereSchoolId($course->school_id)
                           ->whereIn('id', $attributes)
                           ->get();

        $course->instructors()->detach($teachers->modelKeys());
    }

    public function findSessions(Course $course, User $user): Collection
    {
        if ($user->person instanceof Teacher or $user->person instanceof Student) {
            return $user->person->sessions()->getQuery()->where('course_id', $course->getKey())->get();
        }

        return collect([]);
    }

    public function findActiveSessions(Course $course, User $user): Collection
    {
        return $this->findSessions($course, $user)->filter(function ($session) {
            return $session->ended_on->isFuture();
        });
    }
}
