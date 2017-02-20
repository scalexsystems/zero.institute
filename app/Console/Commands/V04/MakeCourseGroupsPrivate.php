<?php

namespace Scalex\Zero\Console\Commands\V04;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Scalex\Zero\Models\Course;
use Scalex\Zero\Models\Group;

class MakeCourseGroupsPrivate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zero:upgrade-0.4-make-course-groups-private';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Course::chunk(100, function (Collection $courses) {
            $courses->map(function ($course) {
                $course->sessions->map(function ($session) {
                    $session->group->type = 'course';
                    $session->group->private = true;
                    $session->group->save();
                });
            });
        });
    }
}
