<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Scalex\Zero\Models\School;

class SchoolControllerTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function test_it_lists_schools()
    {
        factory(School::class, 10)->create();

        $this->json('GET', '/api/schools')
            ->seeJson()
            ->seeJsonContains(transform(School::paginate()));
    }
}
