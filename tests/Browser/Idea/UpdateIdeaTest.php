<?php

use App\Models\Idea;
use App\Models\IdeaStatus;
use App\Models\User;

// TEST 2: Edit an existing idea

it('shows the initial input state',function (){
    $this ->actingAs($user =  User::factory()->create());

    $idea =Idea::factory()->for($user)->create();
    visit(route('idea.show',$idea))
        ->click('@edit-idea-button')
        ->assertValue('title',$idea->title)
        ->assertValue('description',$idea->description)
        ->assertValue('status',$idea->status->value);
});

it('edits an existing idea', function () {
    $this->actingAs($user = User::factory()->create());

    // Create an idea with steps for this user
    $idea = Idea::factory()->for($user)->create([
        'title'       => 'Original Title',
        'description' => 'Original description',
        'status'      => IdeaStatus::PENDING,
    ]);

    $idea->steps()->createMany([
        ['description' => 'Original step 1'],
        ['description' => 'Original step 2'],
    ]);

    // Visit show page and open edit modal
    visit("/ideas/{$idea->id}")
        ->click('@edit-idea-button')
        ->fill('title', 'Some Example Title')
        ->click('@button-status-completed')
        ->fill('description', 'An example description')
        ->fill('@new-link', 'https://laracasts.com')
        ->click('@submit-new-link-button')
        ->fill('@new-link', 'https://laravel.com')
        ->click('@submit-new-link-button')
        ->fill('@new-step', 'Do a Thing')
        ->click('@submit-new-step-button')
        ->fill('@new-step', 'Do another Thing')
        ->click('@submit-new-step-button')
        ->click('@submit-idea')
        ->assertPathIs("/ideas/{$idea->id}");

    $idea->refresh();

    expect($idea)->toMatchArray([
        'title'       => 'Some Example Title',
        'description' => 'An example description',
    ]);
    expect($idea->status)->toBe(IdeaStatus::COMPLETED);
    expect($idea->links)->toBe(['https://laracasts.com', 'https://laravel.com']);
    expect($idea->steps)->toHaveCount(2);
});
