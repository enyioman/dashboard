<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */

    function a_user_may_register_for_an_account_but_must_confirm_their_email_address() 
    {
        $this->visit('register')
            ->type('JohnDoe', 'name')
            ->type('john@example.com', 'email')
            ->type('password', 'password')
            ->press('Register');

        $this->see('Please confirm your email address.')
            ->seeInDatabase('users', ['name' => 'JohnDoe', 'verified' => 0]);

        $user = User::whereName('JohnDoe')->first();

        $this->login($user)->see('Could not sign you in.');

        $this->visit("register/confirm/{$user->token}")
             ->see('You are now confirmed. Please login.')
             ->seeInDatabase('users', ['name' => 'JohnDoe', 'verified' => 1]);
    }

    protected function login($user = null)
    {
        $user = $user ?: $this->factory->create('App\User', ['password' => 'password']);
    } 
}
 