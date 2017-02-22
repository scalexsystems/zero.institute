<?php

namespace Scalex\Zero\Console\Commands\V04;

use DB;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Course\Constraint;

class MoveCourseConstraints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zero:upgrade-0.4-move-course-constraints';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move course prerequisites from course_constraints table to course_prerequisite table';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Constraint::chunk(100, function (Collection $constraints) {
            $constraints->each(function (Constraint $constraint) {
                if ($constraint->constraint_type === 'course') {
                    Course::find($constraint->course_id)->prerequisites()->attach($constraint->constraint_id);
                } else {
                    $this->warn("Constraint #{$constraint->id} is of type {$constraint->constraint_type}. Ignoring it.");
                }
            });
        });

        DB::delete('DELETE FROM "course_constraints" WHERE "course_constraints"."constraint_type" = \'course\'');
    }
}
