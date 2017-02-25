<?php namespace Tests\Api\People\Employees;

use Scalex\Zero\Models\Employee;

trait EmployeeTestHelper
{
    public function createEmployee($count = 1, array $attributes = [])
    {
        $school = $this->getSchool();

        $override = ['school_id' => $school->id];

        $employees = factory(Employee::class, $count)->create($override + $attributes);

        return $count === 1 ? $employees->first() : $employees;
    }

    /**
     * Create employees & associated user accounts.
     *
     * @param int $count
     * @param array $attributes
     *
     * @return \Scalex\Zero\Models\Employee|\Illuminate\Database\Eloquent\Collection
     */
    protected function createEmployeeAndUser($count = 1, array $attributes = [])
    {
        $employees = $this->createEmployee($count, $attributes);

        collect($count === 1 ? [$employees] : $employees)->each(function (Employee $employee) {
            $employee->user()->save($this->createUser());
        });

        return $employees;
    }
}
