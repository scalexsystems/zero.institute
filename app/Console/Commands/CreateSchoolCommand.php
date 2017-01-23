<?php

namespace Scalex\Zero\Console\Commands;

use DB;
use Illuminate\Console\Command;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\User;
use Znck\Trust\Models\Role;

class CreateSchoolCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zero:create {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new school';

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
        $schoolName = $this->argument('name');
        if (!$schoolName) {
            $schoolName = $this->ask('Institute\'s Name');
        }
        $schoolSlug = $this->ask('Institute\'s Username');

        $num = 1;
        $inputs = [];
        while ($num--) {
            $name = $this->ask('Administrator\'s Name');
            $email = $this->ask('Administrator\'s Email');
            $type = $this->choice('Role of Administrator?', ['Teacher', 'Employee']);
            $inputs[] = compact('name', 'email', 'type');
        }

        try {
            DB::beginTransaction();
            if (!$this->confirm('Do you want to create the school with given details?')) {
                return false;
            }


            $school = new School(
                [
                    'slug' => $schoolSlug,
                    'name' => $schoolName,
                    'verified' => false,
                ]
            );

            if (!$school->save()) {
                $this->warn('There are some errors in your input. (school)');
                throw new Exception();
            }
            $this->line('Created school.');

            $inputs = $this->addAdminUsers($school, $inputs);
            $this->printSchoolInfo($school, $inputs);

            DB::commit();

            \Cache::forget('schools.count');
        } catch (Exception $e) {
            DB::rollBack();
            throw  $e;
        }

        return true;
    }

    /**
     * @param School $school
     * @param $inputs
     *
     * @throws Exception
     *
     * @return mixed
     */
    protected function addAdminUsers(School $school, $inputs)
    {
        $role = Role::where('slug', 'admin')->first();
        foreach ($inputs as $key => $input) {
            $user = new User(
                [
                    'name' => $input['name'],
                    'email' => $input['email'],
                ]
            );
            $user->password = $inputs[$key]['password'] = str_random(8);
            $user->school()->associate($school);

            if (!$user->save()) {
                $this->warn('There are some errors in your input. (user)');
                throw new Exception();
            }

            $person = $input['type'] === 'Teacher' ? new Teacher() : new Employee();
            $person->first_name = $input['name'];
            $person->school_id = $school->getKey();
            $person->save();
            $user->person()->associate($person);
            $user->save();

            $user->roles()->save($role);
            $this->line('Created user with admin role.');
        }

        return $inputs;
    }

    /**
     * @param School $school
     * @param array $inputs
     */
    protected function printSchoolInfo(School $school, array $inputs)
    {
        $this->comment('INSTITUTE INFORMATION');
        $this->line("Name: {$school->name}");
        $this->line("URL: zero.institute");

        $this->comment('OWNER INFORMATION');
        $this->table(['Name', 'Email', 'Type', 'Password'], $inputs);
    }
}
