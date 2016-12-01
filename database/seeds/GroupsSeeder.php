<?php

use Illuminate\Database\Seeder;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\School;
use Scalex\Zero\User;
use Symfony\Component\Console\Helper\ProgressBar;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->command->line('Seeding database...');
        $bar = new ProgressBar($this->command->getOutput());
        $bar->setFormat('very_verbose_nomax');
        $bar->setFormat('[%bar%] %memory:6s% | %elapsed:6s% - %message%');
        $bar->start();
        School::all()->each(function ($school, $s) use ($bar) {
            $bar->setMessage("#${s} Creating departments...");
            $bar->advance();
            factory(Group::class, 20)
                ->create(
                    [
                        'school_id' => $school->id,
                        'owner_id' => User::where('school_id', $school->id)->inRandomOrder()->first()->getKey(),
                    ])
                ->each(function (Group $group) use ($bar) {
                    $group->members()->sync(User::inRandomOrder()->take(50)->get());
                    $bar->advance();
                });
        });
        $bar->finish();
    }
}
