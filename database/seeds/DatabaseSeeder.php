<?php

use Illuminate\Database\Seeder;
use Scalex\Zero\User;

class DatabaseSeeder extends Seeder
{
    public function run() {
        factory(User::class, 50)->create();
    }
}
