<?php

use App\Models\Idea;
use App\Models\IdeaStatus;
use App\Models\User;

// ─────────────────────────────────────────────
// TEST 1: Create a new idea
// ─────────────────────────────────────────────
it('creates a new idea', function () {
    $this->actingAs($user = User::factory()->create());

    visit('/ideas')
        ->click('@create-idea-button')
        ->fill('title', 'Some Example Title')
        ->click('@button-status-completed')
        ->fill('description', 'An example description')
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
        ->assertPathIs('/ideas');

    $idea = $user->ideas()->first();

    expect($idea)->not->toBeNull();
    expect($idea)->toMatchArray([
        'title'       => 'Some Example Title',
        'description' => 'An example description',
    ]);
    expect($idea->status)->toBe(IdeaStatus::COMPLETED);
    expect($idea->links)->toBe(['https://laracasts.com', 'https://laravel.com']);
    expect($idea->steps)->toHaveCount(2);
});

