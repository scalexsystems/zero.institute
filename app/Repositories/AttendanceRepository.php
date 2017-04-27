<?php namespace Scalex\Zero\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Scalex\Zero\Criteria\Attendance\OfCourseSession;
use Scalex\Zero\Models\Attendance;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\CourseSession;
use Scalex\Zero\Models\Student;
use Scalex\Zero\User;
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

    public function getAttendanceAggregate(User $user, $semester = null, $course= null, $month = 1 )
    {
        $offsetSessionDate = $user->school->session->started_on->addMonth($month - 1);
        $startDate = Carbon::createFromDate($offsetSessionDate->year, $offsetSessionDate->month, 1);
        $endDate = (clone $startDate)->addMonth()->subDay();


        $query = Attendance::whereHas('course_session.course', function ($query) use ($user, $semester) {
            if ($semester) {
                $query->whereHas('semester', function ($q) use ($semester) {
                    return $q->where('id', $semester);
                });
            }
            return $query->where('school_id', $user->school->id);
        });

//            ->whereBetween('date', [$startDate, $endDate])->orderBy('date');




//        if ($course) {
//            $query->whereHas('course_session.course', function ($q) use ($course) {
//                return $q->where('id', $course);
//            });
//        }

        $attendance = $query->get();

        return $this->getStatisticsForAttendance($attendance);
    }

    public function getAttendanceAggregateForCourse(Course $course)
    {
        $attendance = Attendance::whereHas('course_session.course', function ($query) use ($course) {
            return $query->where('id', $course->id);
        })
            ->orderBy('date')
            ->get();


        return $this->getStatisticsForAttendance($attendance);

    }

    public function getStatisticsForAttendance($attendance)
    {
            return !empty($attendance) ?
                $attendance->reduce(function ($attendanceStats, $dailySession) {

                $attendance = array_values($dailySession->attendance);

                $date = (string)Carbon::parse($dailySession->date)->format('Y-m-d');
                if (isset($attendanceStats[$date])) {
                    $attendanceStats[$date] += array_sum($attendance) / count($attendance) * 100;
                } else {
                    $attendanceStats[$date] = array_sum($attendance) / count($attendance) * 100;
                }
                return $attendanceStats;

            }) : [];
    }
}
