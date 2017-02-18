<?php namespace Scalex\Zero\Transformers\Course;

use Scalex\Zero\Models\Course\Constraint;
use Znck\Transformers\Transformer;

/**
 * Class ConstraintTransformer
 *
 * @deprecated 
 */
class ConstraintTransformer extends Transformer
{
    protected $defaultIncludes = ['course'];

    public function show(Constraint $model)
    {
        return $model->toArray();
    }

    public function index(Constraint $model)
    {
        return $model->toArray();
    }

    public function includeCourse(Constraint $model)
    {
        return $this->item($model->course);
    }
}
