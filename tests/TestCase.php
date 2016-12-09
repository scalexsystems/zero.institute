<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Illuminate\Foundation\Testing\DatabaseTransactions;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function createAnUser($attributes = []) {
        return factory(Scalex\Zero\User::class)->create($attributes);
    }

    public function givePermissionTo(Scalex\Zero\User $user, string $permission) {
        Znck\Trust\Models\Permission::create(['slug' => $permission, 'name' => $permission]);

        $user->givePermission($permission);
    }
}
