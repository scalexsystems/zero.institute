<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Attendance;
use Znck\Transformers\Transformer;


class AttendanceTransformer extends Transformer
{
    
    public function show(Attendance $model) {
        return $model->toArray();
    }
    
    public function index(Attendance $model) {
        return $model->toArray();
    }
}
