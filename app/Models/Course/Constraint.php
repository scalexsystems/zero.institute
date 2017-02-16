<?php

namespace Scalex\Zero\Models\Course;

use Scalex\Zero\Database\BaseModel as Model;
use Scalex\Zero\Models\Course;

/**
 * Class Constraint
 *
 * @deprecated
 */
class Constraint extends Model
{
    protected $table = 'course_constraints';

    protected $fillable = [
        'constraint_type',
        'constraint_id',
    ];

    protected $extend = [];

    protected $with = ['course'];

    public function course()
    {
        return $this->hasOne(Course::class, 'id', 'constraint_id');
    }
}
