<?php

namespace Scalex\Zero\Console\Commands\V04;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Scalex\Zero\Models\School;
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
            $schools->map(function ($school) {
                if (!$school->session) {
                    $session = new Session([

                        'name' => $school->name,
                        'started_on' => \Carbon\Carbon::parse('+1 week'),
                        'ended_on' => \Carbon\Carbon::parse('+1 month'),
                    ]);

                    $session->school()->associate($school);
                    $session->save();
                    $school->session()->associate($session);
                    $school->save();
                }
            });
        });
    }
}
