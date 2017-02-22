<?php namespace Scalex\Zero\Services;

use Scalex\Zero\Models\Employee;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Models\Teacher;

class PeopleStatisticsService
{
    /**
     * @var \Scalex\Zero\Models\School
     */
    protected $school;

    /**
     * @var \Illuminate\Contracts\Cache\Repository
     */
    protected $cache;

    /**
     * PeopleStatisticsService constructor.
     *
     * @param \Scalex\Zero\Models\School|int $school
     */
    public function __construct($school)
    {
        $this->school = $school instanceof School ? $school->getKey() : $school;
        $this->cache = cache();
    }

    /**
     * Student stats.
     *
     * @return array
     */
    public function student()
    {
        return $this->cache->rememberForever($this->getStudentCacheKey(), function () {
            return ['count' => repository(Student::class)->count()];
        });
    }

    /**
     * Teacher stats.
     *
     * @return array
     */
    public function teacher()
    {
        return $this->cache->rememberForever($this->getTeacherCacheKey(), function () {
            return ['count' => repository(Teacher::class)->count()];
        });
    }

    /**
     * Employee stats.
     *
     * @return array
     */
    public function employee()
    {
        return $this->cache->rememberForever($this->getEmployeeCacheKey(), function () {
            return ['count' => repository(Employee::class)->count()];
        });
    }

    /**
     * Cache key for student stats.
     *
     * @return string
     */
    public function getStudentCacheKey(): string
    {
        return schoolScopeCacheKey('stats.student', $this->school);
    }

    /**
     * Cache key for teacher stats.
     *
     * @return string
     */
    public function getTeacherCacheKey(): string
    {
        return schoolScopeCacheKey('stats.teacher', $this->school);
    }

    /**
     * Cache key for employee stats.
     *
     * @return string
     */
    public function getEmployeeCacheKey(): string
    {
        return schoolScopeCacheKey('stats.employee', $this->school);
    }
}
