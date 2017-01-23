<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use WatchTower\User;

class OAuthConnectionTest extends TestCase
{
    use DatabaseMigrations;

    protected function mockedSocialteUser()
    {
        $mock = Mockery::mock(SocialiteUser::class);

        $mock->shouldReceive('getId') ->andReturn(1234567890)
            ->shouldReceive('getEmail')->andReturn(str_random(10).'@test.com')
            ->shouldReceive('getNickname')->andReturn('znck')
            ->shouldReceive('getName')->andReturn('Rahul Kadyan')
            ->shouldReceive('getAvatar')->andReturn('https://en.gravatar.com/userimage');
        $mock->token = str_random(64);
        $mock->refreshToken = str_random(64);

        return $mock;
    }

    public function test_it_should_redirect_to_digital_ocean()
    {
        $user = factory(User::class)->create();

        Socialite::shouldReceive('driver->scopes->redirect')->andReturn('digitalocean.com');

        $this->actingAs($user)->visit('/connect/digitalocean')->see('digitalocean.com');
    }

    public function test_it_should_handle_callback_from_digital_ocean()
    {
        $user = factory(User::class)->create();

        $socialite = $this->mockedSocialteUser();
        $socialite->expiresIn = 100000;

        Socialite::shouldReceive('driver->user')->andReturn($socialite);

        $this->actingAs($user)
            ->visit('/connect/digitalocean/callback')
            ->seePageIs('/dashboard')
            ->see('Connected to Digitalocean.')
            ->seeInDatabase('connections', ['owner_id' => $user->getKey(), 'token' => $socialite->token]);
    }
}
