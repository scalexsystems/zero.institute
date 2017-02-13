<?php namespace Scalex\Zero\Events\Employee;


use Scalex\Zero\Models\Employee;

class EmployeePhotoUpdated extends AbstractEmployeeEvent
{
    public $photo;

    public function __construct(Employee $employee)
    {
        parent::__construct($employee);

        $this->photo = $employee->getPhotoUrl();
    }


}