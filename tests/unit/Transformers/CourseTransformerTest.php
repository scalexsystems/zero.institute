<?php

use Scalex\Zero\Models\Course;
use Scalex\Zero\Transformers\CourseTransformer;

class CourseTransformerTest extends TestCase
{
    public function test_it_has_correct_output_format()
    {
        $group = factory(Course::class)->create();
        $transformer = new CourseTransformer();

        $transfored = $transformer->index($group);

        $keys = [
            'name', // Required.
            'code', // Required.
            'photo', // Required.
            'description', // Required.
            'department_id', // UI; Multiple places.
            'instructor_id',
            'group_id',
        ];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $transfored);
        }
    }
}
