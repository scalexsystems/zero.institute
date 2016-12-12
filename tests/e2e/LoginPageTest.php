<?php

use Scalex\Zero\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginPageTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    public function test_it_can_login_with_password()
    {
        $user = factory(User::class)->create();

        $this->visit('/login')
             ->type($user->email, 'email')
             ->type('passwod', 'password')
             ->press('Login')
             ->seePageIs('/login')
             ->see('These credentials do not match our records.');
    }
}
