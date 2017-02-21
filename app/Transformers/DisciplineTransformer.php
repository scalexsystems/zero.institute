<?php namespace Scalex\Zero\Transformers;

use Scalex\Zero\Models\Discipline;
use Znck\Transformers\Transformer;

class DisciplineTransformer extends Transformer
{
    public function index(Discipline $discipline)
    {
        return [
            'name' => (string)$discipline->name,
            'short_name' => (string)$discipline->short_name,
            'stats' => [
                'student' => $discipline->students_count ?? 0,
            ],
        ];
    }
}
