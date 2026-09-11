<?php

namespace App\Http\Controllers;

use App\Http\Actions\CreateIdea\CreateIdea;
use App\Http\Requests\IdeaRequest;
use App\Http\Requests\UpdateideaRequest;
use App\Models\Idea;
use App\Models\IdeaStatus;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $user = Auth::user();

        $ideas = $user
            ->ideas()
            ->when(in_array($request->status, IdeaStatus::values()), fn ($query) => $query->where('status', $request->status))
            ->latest()
            ->get();

        return view('idea.index', [
            'ideas' => $ideas,
            'statusCounts' => Idea::statusCounts($user),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IdeaRequest $request, CreateIdea $action)
    {

        $action->handle($request->safe()->all());

        return to_route('idea.index')->with('success', 'Idea created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {

        return view('idea.show', [
            'idea' => $idea,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateideaRequest $request, Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        $data = $request->validated();
        $steps = $data['steps'] ?? [];
        unset($data['steps'], $data['image']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('ideas', 'public');
        }

        DB::transaction(function () use ($idea, $data, $steps): void {
            $idea->update($data);
            $idea->steps()->delete();
            $idea->steps()->createMany(
                collect($steps)
                    ->map(fn (string $description): array => ['description' => $description])
                    ->all()
            );
        });

        return to_route('idea.show', $idea)->with('success', 'Idea updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        $idea->delete();

        return to_route('idea.index');

    }
}
