<?php

use App\Models\Idea;
use App\Models\User;

it('create a new idea', function () {
    $this->actingAs($user = User::factory()->create());   // create user and authenticate

    // create idea
    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'Some Example Title')
        ->click('@button-status-completed')
        ->fill('description', 'An example description')
        ->fill('@new-link', 'https://laracasts.com')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->debug()
        ->click('Create')
        ->assertPathIs('/ideas');

    // Test - Match the first idea ?
    expect($user->ideas()->first())->toMatchArray([
        'title' => 'Some Example Title',
        'status' => 'Completed',
        'description' => 'An example description',
        'link' => ['https://laracasts.com', 'https://laracasts.com'],
    ]);

});
