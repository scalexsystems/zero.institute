<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Scalex\Zero\Models\Department;
use Scalex\Zero\Models\Discipline;
use Scalex\Zero\Models\Employee;
use Scalex\Zero\Models\School;
use Scalex\Zero\Models\Student;
use Scalex\Zero\Models\Teacher;
use Scalex\Zero\User;
use Symfony\Component\Console\Helper\ProgressBar;

class DatabaseSeeder extends Seeder
{
    const SCHOOLS = 3;
    const DEPARTMENTS = 5;
    const DISCIPLINES = 2;

    const STUDENTS = 20;
    const TEACHERS = 8;
    const EMPLOYEES = 5;

    public function run() {
        $this->command->line('Seeding database...');
        $bar = new ProgressBar($this->command->getOutput());
        $bar->setFormat('very_verbose_nomax');
        $bar->setFormat('[%bar%] %memory:6s% | %elapsed:6s% - %message%');
        $bar->setMessage('Creating schools with factory...');
        $bar->start();
        $schools = factory(School::class, self::SCHOOLS)->create();
        foreach ($schools as $s => $school) {
            $bar->setMessage("#${s} Creating departments...");
            $bar->advance();
            $departments = factory(Department::class, self::DEPARTMENTS)->create(['school_id' => $school->id]);
            $bar->setMessage("#${s} Creating disciplines...");
            $bar->advance();
            $disciplines = factory(Discipline::class, self::DISCIPLINES)->create(['school_id' => $school->id]);
            $people = new Collection();
            foreach ($departments as $d => $department) {
                foreach ($disciplines as $e => $discipline) {
                    for ($i = 0; $i < self::STUDENTS; ++$i) {
                        $bar->setMessage("#${s} Creating students (${d}.${e}.${i}/".$departments->count().")...");
                        $bar->advance();
                        $people->push(factory(Student::class)
                                          ->create([
                                                       'school_id' => $school->id,
                                                       'department_id' => $department->id,
                                                       'discipline_id' => $discipline->id,
                                                   ]));
                    }
                }
                $bar->setMessage("#${s} Creating teachers (${d}/".$departments->count().")...");
                $bar->advance();
                $people->merge(factory(Teacher::class, self::TEACHERS)
                                   ->create([
                                                'school_id' => $school->id,
                                                'department_id' => $department->id,
                                            ]));
                $bar->setMessage("#${s} Creating employees (${d}/".$departments->count().")...");
                $bar->advance();
                $people->merge(factory(Employee::class, self::EMPLOYEES)
                                   ->create([
                                                'school_id' => $school->id,
                                                'department_id' => $department->id,
                                            ]));
            }
            $bar->setMessage("#${s} Creating user accounts...");
            $bar->advance();
            foreach ($people as $p => $person) {
                factory(User::class)
                    ->create([
                                 'school_id' => $school->id,
                                 'person_type' => $person->getMorphClass(),
                                 'person_id' => $person->getKey(),
                             ]);
                $bar->setMessage("#${s} Creating user accounts (${p}/".$people->count().")...");
                $bar->display();
            }
            $bar->advance();
        }
        $bar->finish();

        $this->call(GroupsSeeder::class);

        $this->command->line('');
        $this->command->line('<info>Database ready!</info>');
    }
}
