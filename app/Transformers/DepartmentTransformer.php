<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Department;
use Znck\Transformers\Transformer;

class DepartmentTransformer extends Transformer
{
    protected $defaultIncludes = ['head'];

    public function show(Department $department)
    {
        return [
            'name' => (string)$department->name,
            'short_name' => (string)$department->short_name,
            'head_id' => $department->head_id,
            'academic' => (bool)$department->academic,
            'stats' => [
                'student' => $department->student_count ?? 0,
                'teacher' => $department->teacher_count ?? 0,
                'employee' => $department->employee_count ?? 0,
            ],
        ];
    }

    public function index(Department $department)
    {
        return $this->show($department);
    }

    public function includeHead(Department $department)
    {
        return $department->head
            ? $this->item($department->head)
            : $this->null();
    }
}
