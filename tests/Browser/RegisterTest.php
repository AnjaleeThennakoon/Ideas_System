<?php

use Illuminate\support\Facades\Auth;
it('returns a user', function () {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email','john@example.com')
        ->fill('password', 'password123!@#')
        ->click('Create Account')
        ->assertPathIs('/');

    $this->assertAuthenticated();

    expect(Auth::user())-> toMatchArray([
        'name' => 'John Doe',
        'email'=>'john@example.com']);

});


it('requires a valid email', function () {
    visit('/register')
        ->fill('name', 'John Doe')
        ->fill('email','jphn123')
        ->fill('password', 'password123!@#')
        ->click('Create Account')
        ->assertPathIs('/register');

});
