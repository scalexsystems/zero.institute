<?php namespace Scalex\Zero\Criteria\Attendance;

use Znck\Repositories\Contracts\Criteria;
use Znck\Repositories\Contracts\Repository;

class ofCourseSession implements Criteria
{
    protected $ids;

    public function __construct($ids)
    {
        $this->ids = $ids;
    }

    public function apply($model, Repository $repository)
    {
        if (is_numeric($this->ids)) {
            $model->where('course_session_id', $this->ids);
        } elseif (is_array($this->ids)) {
            $model->whereIn('course_session_id', $this->ids);
        }
    }
}