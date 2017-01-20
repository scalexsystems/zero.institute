<?php

namespace Scalex\Zero\Repositories;

use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\Models\Attachment;
use Scalex\Zero\Models\Course\Constraint;
use Scalex\Zero\Criteria\OfSchool;
use Scalex\Zero\User;
use Illuminate\Support\Collection;
use Znck\Repositories\Repository;

/**
 * @method Course find(string|int $id)
 * @method Course findBy(string $key, $value)
 * @method Course create(array $attr)
 * @method Course update(string|int|Course $id, array $attr, array $o = [])
 * @method Course delete(string|int|Course $id)
 * @method CourseRepository validate(array $attr, Course|null $model)
 */
class CourseRepository extends Repository
{
    use \Znck\Repositories\Traits\RepositoryHelper;

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
        'code' => 'required|max:255',
        'description' => 'nullable|max:65535',

        'school_id' => 'required|exists:schools,id',
        'group_id' => 'nullable|exists:groups,id',
        'discipline_id' => 'nullable|exists:disciplines,id',
        'department_id' => 'required|exists:departments,id',
        'photo_id' => 'nullable|exists:attachments,id',
    ];

    public function boot() {
        if (current_user()) {
            $this->pushCriteria(new OfSchool(current_user()->school));
        }
    }

    public function creating(Course $course, array $attributes)
    {
        $course->fill($attributes);
        $school = $attributes['school_id'];
        $course->department()->associate(find($attributes, 'department_id'));
        $course->discipline()->associate(find($attributes, 'discipline_id'));
        $course->school()->associate($school);
        if (array_has($attributes, 'semester_id')) {
            $course->semester()->associate(find($attributes, 'semester_id'));
        }
        if (array_has($attributes, 'year_id')) {
            $course->year_id = (int) $attributes['year_id'];
        }

        \Log::debug($course->getAttributes());

        $status = $course->save();

        if ($status) {
            $instructors = $this->getInstructorIds((array) array_get($attributes, 'instructors'), $school);

            if (count($instructors) > 0) {
                $course->instructors()->attach($instructors);
            }

            $prerequisites = $this->getCourseIds((array) array_get($attributes, 'prerequisites'), $school);

            if (count($prerequisites) > 0) {
                $course->prerequisites()->saveMany(
                    collect($prerequisites)->map(function ($id) {
                        return new Constraint([
                            'constraint_type' => 'course',
                            'constraint_id' => $id,
                        ]);
                    })
                );
            }
        }

        return $status;
    }

    public function updating(Course $course, array $attributes)
    {
        $course->fill($attributes);
        $school = $course->school_id;
        if (array_has($attributes, 'department_id')) {
            $course->department()->associate(find($attributes, 'department_id'));
        }
        if (array_has($attributes, 'discipline_id')) {
            $course->discipline()->associate(find($attributes, 'discipline_id'));
        }
        if (array_has($attributes, 'photo_id')) {
            attach_attachment($course, 'photo', find($attributes, 'photo_id', Attachment::class));
        }
        if (array_has($attributes, 'semester_id')) {
            $course->semester()->associate(find($attributes, 'semester_id'));
        }
        if (array_has($attributes, 'year_id')) {
            $course->year_id = (int) $attributes['year_id'];
        }

        $instructors = $this->getInstructorIds((array) array_get($attributes, 'instructors'), $school);
        $course->instructors()->sync($instructors);

        $prerequisites = $this->getCourseIds((array) array_get($attributes, 'prerequisites'), $school);

        if (count($prerequisites) > 0) {
            $all = array_flip($course->prerequisites->pluck('id')->toArray());
            $create = [];

            foreach ($prerequisites as $id) {
                if (array_key_exists($id, $all)) {
                    unset($all[$id]);
                } else {
                    $create[] = $id;
                }
            }

            if (count($all)) {
                $course->prerequisites()->whereIn('id', array_keys($all))->delete();
            }

            if (count($create)) {
                $course->prerequisites()->saveMany(
                    collect($create)->map(function ($id) {
                        return new Constraint([
                            'constraint_type' => 'course',
                            'constraint_id' => $id,
                        ]);
                    })
                );
            }
        }

        return $course->update();
    }

    protected function getInstructorIds(array $instructors, int $school)
    {
        if (count($instructors) === 0) return [];

        return \DB::table('teachers')->select('id')
            ->where('school_id', $school)
            ->whereIn('id', $instructors)
            ->get()->pluck('id')->toArray();
    }

    protected function getCourseIds(array $courses, int $school)
    {
        if (count($courses) === 0) return [];

        return \DB::table('courses')->select('id')
            ->where('school_id', $school)
            ->whereIn('id', $courses)
            ->get()->pluck('id')->toArray();
    }

    public function findSessions(Course $course, User $user): Collection
    {
        if ($user->person instanceof Teacher or $user->person instanceof Student) {
            return $user->person->sessions()->whereCourseId($course->getKey())->get();
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
