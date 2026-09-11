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
        ->fill('@new-step', 'Do a Thnig')
        ->click('@submit-new-step-button')
        ->click('@new-step','Do another Thing')
        ->click('@submit-new-step-button')
        //push the test and run browser
//        ->debug()
        ->click('Create')
        // check after submitting redirect /ideas page
        ->assertPathIs('/ideas');

    // Test - Match the first idea ?
    expect($idea = $user->ideas()->first())->toMatchArray([
        'title' => 'Some Example Title',
        'status' => 'Completed',
        'description' => 'An example description',
        'links' => ['https://laracasts.com', 'https://laracasts.com'],
    ]);
    expect($idea->steps) ->toHaveCount(2);

});
