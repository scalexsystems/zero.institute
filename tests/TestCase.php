<?php

use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use Illuminate\Foundation\Testing\DatabaseMigrations;
    use Illuminate\Foundation\Testing\DatabaseTransactions;
    use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;

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
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @param array $attributes
     *
     * @return \Scalex\Zero\User
     */
    public function createUser($attributes = [], $count = 1)
    {
        return factory(Scalex\Zero\User::class, $count)->create($attributes)->first();
    }

    /**
     * @param \Scalex\Zero\User|string $userOrPermissionString
     * @param string|null $permission
     *
     * @return $this
     */
    public function givePermissionTo($userOrPermissionString, string $permission = null)
    {
        if (is_null($permission)) {
            $permission = $userOrPermissionString;
            $userOrPermissionString = $this->getUser();
        }

        Znck\Trust\Models\Permission::create(['slug' => $permission, 'name' => $permission]);

        $userOrPermissionString->grantPermission($permission)->refreshPermissions();

        return $this;
    }

    public function seeResources(TestResponse $response, string $type, array $ids, string $key = 'id')
    {
        $actual = collect(collect((array)$response->decodeResponseJson())->get($type))->pluck($key)->toArray();

        $this->assertEquals(Arr::sortRecursive($actual), Arr::sortRecursive($ids));

        return $this;
    }

    /**
     * Get school.
     *
     * @return mixed|\Scalex\Zero\Models\School
     */
    public function getSchool()
    {
        return $this->getUser()->school;
    }

    /**
     * Create user.
     *
     * @return \Scalex\Zero\User
     */
    public function getUser()
    {
        return $this->anUser ?? ($this->anUser = $this->createUser());
    }

    public function getResponseJson(TestResponse $response)
    {
        return json_decode($response->getContent());
    }

    public function getUserWithPerson(string $type = 'student')
    {
        $user = $this->getUser();

        $person = factory(morph_model($type))->create(['school_id' => $this->getSchool()->id]);

        $user->person()->associate($person);

        $user->save();

        return $user;
    }

    public function postFile($uri, $files = [], $data = [], $headers = [])
    {
        $server = $this->transformHeadersToServerVars($headers);

        return $this->call('POST', $uri, $data, [], $files, $server);
    }

    public function getSomeFile($name = 'foo.txt', $contents = null)
    {
        $path = Faker\Factory::create()->image('/tmp');

        return new UploadedFile($path, $name, null, null, null, true);
    }

    public function getSomeImage($name = 'foo.png')
    {
        $image = imagecreate(30, 30);
        imagejpeg($image, '/tmp/'.$name);

        return new UploadedFile('/tmp/'.$name, $name, 'image/jpeg', null, null, true);
    }

    public function assignRoleTo(\Scalex\Zero\User $user, string $role)
    {
        $role = \Znck\Trust\Models\Role::create(['slug' => $role, 'name' => $role]);
        $user->assignRole($role);
    }
}
