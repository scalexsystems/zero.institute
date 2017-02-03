<?php

use Illuminate\Support\Arr;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Illuminate\Foundation\Testing\DatabaseTransactions;
    use \Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    protected $anUser;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication() {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @param array $attributes
     *
     * @return \Scalex\Zero\User
     */
    public function createUser($attributes = [], $count = 1) {
        return factory(Scalex\Zero\User::class, $count)->create($attributes);
    }

    public function givePermissionTo(Scalex\Zero\User $user, string $permission) {
        Znck\Trust\Models\Permission::create(['slug' => $permission, 'name' => $permission]);

        $user->grantPermission($permission);
    }

    public function seeResources(string $type, array $ids) {
        $actual = collect(collect((array)$this->decodeResponseJson())->get($type))->pluck('id')->toArray();

        $this->assertEquals(Arr::sortRecursive($actual), Arr::sortRecursive($ids));
    }

    /**
     * Get school.
     *
     * @return mixed|\Scalex\Zero\Models\School
     */
    public function getSchool() {
        return $this->getUser()->school;
    }

    /**
     * Create user.
     *
     * @return \Scalex\Zero\User
     */
    public function getUser() {
        return $this->anUser ?? ($this->anUser = $this->createUser());
    }

    public function getUserWithPerson(string $type = 'student') {
        $user = $this->getUser();

        $person = factory(morph_model($type))->create(['school_id' => $this->getSchool()->id]);

        $user->person()->associate($person);

        $user->save();

        return $user;
    }
}
