<?php namespace Tests\Api\People\Teachers;

use Scalex\Zero\Models\Teacher;

trait TeacherTestHelper
{
    public function createTeacher($count = 1, array $attributes = [])
    {
        $school = $this->getSchool();

        $override = ['school_id' => $school->id];

        $teachers = factory(Teacher::class, $count)->create($override + $attributes);

        return $count === 1 ? $teachers->first() : $teachers;
    }

    public function createTeacherAsAdmin(array $attributes)
    {
        $teacher = $this->createTeacher(1, $attributes);
        $this->assignRoleTo($teacher->user, 'admin');

        return $teacher;
    }

    /**
     * Create teachers & associated user accounts.
     *
     * @param int $count
     * @param array $attributes
     *
     * @return \Scalex\Zero\Models\Teacher|\Illuminate\Database\Eloquent\Collection
     */
    protected function createTeacherAndUser($count = 1, array $attributes = [])
    {
        $teachers = $this->createTeacher($count, $attributes);

        collect($count === 1 ? [$teachers] : $teachers)->each(function (Teacher $teacher) {
            $teacher->user()->save($this->createUser());
        });

        return $teachers;
    }
}
