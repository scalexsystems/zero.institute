<?php

use Illuminate\Database\Seeder;
use Scalex\Zero\Models\School;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(School::class, 50)->create(['verified' => true]);
    }
}
