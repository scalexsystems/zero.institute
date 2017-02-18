<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Semester;
use Znck\Transformers\Transformer;

class SemesterTransformer extends Transformer
{
    public function show(Semester $model)
    {
        return $model->toArray();
    }
    
    public function index(Semester $semester)
    {
        return [
            'name' => (string)$semester->name
        ];
    }
}
