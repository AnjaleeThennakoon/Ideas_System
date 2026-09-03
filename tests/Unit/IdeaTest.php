<?php

use App\Models\Idea;
use App\Models\user;

test('it belongs to a user', function (): void {
    $idea = Idea::factory()->create();

    expect($idea->user)->toBeInstanceOf(user::class);
});

test('it can have steps', function (): void {
    $idea = Idea::factory()->create();

    expect($idea->steps)->toBeEmpty();

    $idea->steps()->create([
        'description' => 'Do the thing',
    ]);

    expect($idea->fresh()->steps)->toHaveCount(1);
});
