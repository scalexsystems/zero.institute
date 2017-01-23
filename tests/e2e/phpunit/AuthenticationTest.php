<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use WatchTower\User;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_should_redirect_unauthenticated_user()
    {
        $this->visit('/dashboard')
             ->seePageIs('/login');
    }

    public function test_user_can_login()
    {
        $user = factory(User::class)->create();

        $this->visit('/login')
            ->type($user->email, 'email')
            ->type('secret', 'password')
            ->press('Login')
            ->seePageIs('/dashboard');
    }

    public function test_user_can_register()
    {
        $this->visit('/register')
            ->type('Rahul Kadyan', 'name')
            ->type('rahul@example.com', 'email')
            ->type('secret', 'password')
            ->type('secret', 'password_confirmation')
            ->press('Register')
            ->seeInDatabase('users', ['name' => 'Rahul Kadyan', 'email' => 'rahul@example.com'])
            ->seePageIs('/dashboard');
    }
}
