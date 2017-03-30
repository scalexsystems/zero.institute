<?php namespace Scalex\Zero\Repositories;

use Carbon\Carbon;
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
        'date' => 'required|date|before:tomorrow'
    ];

    public function getAttendanceFor(Student $student, CourseSession $session)
    {
        $attendances = $session->attendances;
        $studentId = $student->id;
        return $attendances->transform(function ($attendance) use ($studentId) {
            return collect($attendance)->except('attendance')
                ->merge([ 'attendance' => data_get($attendance->attendance, $studentId)]);

        });
    }

    public function takeAttendance(array $students, CourseSession $session, $date)
    {
        $attendance = new Attendance();
        $attendance->date = $date;
        $attendance->course_session()->associate($session);
        $attendance->attendance = $students;
        $attendance->save();
    }

    public function getAttendanceAggregate()
    {
        $attendance = Attendance::get();

        return $attendance->reduce(function ($attendanceStats, $dailySession) {

            $attendance = array_values($dailySession->attendance);
            $date = (string) Carbon::parse($dailySession->date)->format('Y-m-d');
            if (isset($attendanceStats[$date])) {
                $attendanceStats[$date] += array_sum($attendance);
            } else {
                $attendanceStats[$date] = array_sum($attendance);
            }
            return $attendanceStats;

        });
    }

}
