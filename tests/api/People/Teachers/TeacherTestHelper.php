<?php namespace Tests\Api\People\Parents;


use Scalex\Zero\Models\Teacher;

trait TeacherTestHelper
{
    public function createTeacher($count = 1, array $attributes)
    {
        $school = $this->getSchool();

        $override = ['school_id' => $school->id];

        return factory(Teacher::class, $count)->create($override + $attributes);
    }

    public function createTeacherAsAdmin(array $attributes)
    {
        $teacher = $this->createTeacher(1, $attributes);
        $this->assignRoleTo($teacher->user, 'admin');
        return $teacher;
    }
}