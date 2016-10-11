<?php

use Illuminate\Database\Seeder;
use Scalex\Zero\Models\Group;
use Scalex\Zero\Models\School;
use Scalex\Zero\User;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->command->line('Seeding database...');
        School::all()->each(function ($school) {
            factory(Group::class, 20)
                ->create(['school_id' => $school->id])
                ->each(function (Group $group) {
                    $group->members()->sync(User::inRandomOrder()->take(50)->get());
                });
        });
    }
}
