<?php

namespace Scalex\Zero\Repositories;

use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Attachment;
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
        'code' => 'nullable|max:255',
        'description' => 'nullable|max:65535',

        'school_id' => 'required|exists:schools,id',
        'group_id' => 'nullable|exists:groups,id',
        'discipline_id' => 'nullable|exists:disciplines,id',
        'department_id' => 'required|exists:departments,id',
        'photo_id' => 'nullable|exists:attachments,id',
    ];

    public function creating(Course $course, array $attributes)
    {
        $course->fill($attributes);

        $course->department()->associate(find($attributes, 'discipline_id'));
        $course->discipline()->associate(find($attributes, 'discipline_id'));
        $course->group()->associate(find($attributes, 'group_id'));
        $course->school()->associate(find($attributes, 'school_id'));

        attach_attachment($course, 'photo', find($attributes, 'photo_id', Attachment::class));

        return $course->save();
    }

    public function updating(Course $course, array $attributes)
    {
        $course->fill($attributes);

        if (array_has($attributes, 'deparment_id')) {
            $course->department()->associate(find($attributes, 'discipline_id'));
        }
        if (array_has($attributes, 'discipline_id')) {
            $course->discipline()->associate(find($attributes, 'discipline_id'));
        }
        if (array_has($attributes, 'group_id')) {
            $course->group()->associate(find($attributes, 'group_id'));
        }

        if (array_has($attributes, 'deparment_id')) {
            attach_attachment($course, 'photo', find($attributes, 'photo_id', Attachment::class));
        }

        return $course->update();
    }
}
