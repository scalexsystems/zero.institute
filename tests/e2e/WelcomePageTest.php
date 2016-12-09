<?php

class WelcomePageTest extends TestCase
{
    public function test_it_loads_welcome_page()
    {
        $this->visit('/')
             ->see('Zero')
             ->click('Login')
             ->seePageIs('/login');

        $this->visit('/')
              ->click('Register')
              ->seePageIs('/register');
    }
}
