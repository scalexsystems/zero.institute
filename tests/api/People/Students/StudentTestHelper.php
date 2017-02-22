<?php namespace Test\Api\People\Students;

use Scalex\Zero\Models\Student;

trait StudentTestHelper
{

    /**
     * Create students.
     *
     * @param int $count
     * @param array $attributes
     *
     * @return \Scalex\Zero\Models\Student|\Illuminate\Database\Eloquent\Collection
     */
    protected function createStudent($count = 1, array $attributes = [])
    {
        $school = $this->getSchool();

        $override = ['school_id' => $school->id];

        return factory(Student::class, $count)->create($override + $attributes);
    }


    /**
     * Create students & associated user accounts.
     *
     * @param int $count
     * @param array $attributes
     *
     * @return \Scalex\Zero\Models\Student|\Illuminate\Database\Eloquent\Collection
     */
    protected function createStudentAndUser($count = 1, array $attributes = [])
    {
        $students = $this->createStudent($count, $attributes);

        collect($count === 1 ? [$students] : $students)->each(function ($student) {
            $student->user()->save($this->createUser());
        });

        return $students;
    }
}
