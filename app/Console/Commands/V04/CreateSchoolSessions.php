<?php

namespace Scalex\Zero\Console\Commands\V04;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Semester;
use Scalex\Zero\Models\Session;

class CreateSchoolSessions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zero:upgrade-0.4-create-school-sessions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create sessions for schools';

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
        School::chunk(100, function (Collection $schools) {
            $schools->map(function (School $school) {
                $this->createDefaultSession($school);
            });
        });
    }

    /**
     * @param \Scalex\Zero\Models\School $school
     */
    protected function createDefaultSession(School $school)
    {
        if ($school->session instanceof Session) {
            return;
        }

        $semester = Semester::where('school_id', $school->id)->first();

        // Create a semester.
        if (!$semester) {
            $semester = new Semester(['name' => 'Change Semester Name']);
            $semester->school()->associate($semester);
            $semester->save();
        }

        $session = new Session([
            'name' => $school->name,
            'started_on' => Carbon::parse('+1 week'),
            'ended_on' => Carbon::parse('+1 month'),
        ]);

        $session->school()->associate($school);
        $session->semester()->associate($semester);
        $session->save();

        $school->session()->associate($session);
        $school->save();
    }
}
