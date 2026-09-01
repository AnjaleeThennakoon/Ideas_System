<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

it('Log in a user', function () {
    visit('/login')

        ->fill('email','john@example.com')
        ->fill('password', 'password123!@#')
        ->click('@login-button')
        ->assertPathIs('/');

    $this->assertAuthenticated();
});

it('Log out a user', function () {
    $user=User::factory()->create();

    $this->actingAs($user);

    visit('/')->click('log out');
    $this->assertGuest();
});
