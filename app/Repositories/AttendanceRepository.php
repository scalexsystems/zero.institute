<?php namespace Scalex\Zero\Repositories;

use Illuminate\Support\Collection;
use Scalex\Zero\Criteria\Attendance\OfCourseSession;
use Scalex\Zero\Models\Attendance;
use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\Models\Student;
use Znck\Repositories\Repository;

/**
 * @method Attendance find(string|int $id)
 * @method Attendance findBy(string $key, $value)
 * @method Attendance create(array $attr)
 * @method Attendance update(string|int|Attendance $id, array $attr, array $o = [])
 * @method Attendance delete(string|int|Attendance $id)
 * @method AttendanceRepository validate(array $attr, Attendance|null $model)
 */
class AttendanceRepository extends Repository
{
    use \Znck\Repositories\Traits\RepositoryHelper;

    /**
     * Class name of the Eloquent model.
     *
     * @var string
     */
    protected $model = Attendance::class; 

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [
        'students' => 'required|array',
        'date' => 'required|date'
    ];

    public function getAttendanceFor(Student $student, CourseSession $session)
    {
        return $this->pushCriteria(new OfCourseSession($session->id))
            ->where('student_id', $student->id)->get();
    }

    public function takeAttendance(Collection $students, CourseSession $session)
    {



    }
}
