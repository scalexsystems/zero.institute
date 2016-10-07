<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Scalex\Zero\Action;
use Scalex\Zero\Models\School;
use Scalex\Zero\User;
use Znck\Trust\Models\Permission;

class SchoolControllerTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function test_it_lists_schools() {
        factory(School::class, 10)->create();

        $this->json('GET', '/api/schools')
            ->seeJsonStructure(
                [
                    'data' => [
                        '*' => ['id', 'name', 'extra'],
                    ],
                    '_meta' => ['pagination'],
                ]
            );
    }

    // FIXME: add test_it_searches_schools

    public function test_it_updates_school() {
        /** @var User $user */
        $user = factory(User::class)->create();

        $user->permissions()->attach(
            Permission::create(['slug' => Action::UPDATE_SCHOOL, 'name' => 'Update school information'])
        );


        $this->json('PUT', '/api/school', ['name' => 'Yo School!'])->seeStatusCode(202);

        $this->seeInDatabase('schools', ['name' => 'Yo School!']);
    }
}
