<?php

use App\Models\idea;
use App\Models\Step;
use App\Models\user;
use Illuminate\Support\Collection as SupportCollection;
use mysql_xdevapi\Collection;

test('it belongs to a user', function () {
    $idea= Idea::factory() ->create();

    expect($idea->user)->toBeInstanceOf(User::class);
});

test('it can have steps',function (){
    $idea= Idea::factory()->create();

    expect($idea->steps)->toBeEmpty();

    $idea->steps()->create([
        'description' => 'Do the thing',
    ]);

    expect($idea->fresh()->steps)->toHaveCount(1);
});
