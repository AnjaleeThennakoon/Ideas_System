<?php

use App\Models\User;

it('Log in a user', function (): void {
    visit('/login')

        ->fill('email', 'john@example.com')
        ->fill('password', 'password123!@#')
        ->click('@login-button')
        ->assertPathIs('/');

    $this->assertAuthenticated();
});

it('Log out a user', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user);

    visit('/')->click('log out');
    $this->assertGuest();
});
