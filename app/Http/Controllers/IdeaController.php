<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreideaRequest;
use App\Http\Requests\UpdateideaRequest;
use App\Models\Idea;
use App\Models\IdeaStatus;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function store(StoreideaRequest $request)
    //    {
    //        $data = $request->validated();
    //        $steps = $data['steps'] ?? [];
    //        unset($data['steps']);
    //
    //        DB::transaction(function () use ($request, $data, $steps): void {
    //            $idea = $request->user()->ideas()->create($data);
    //            $idea->steps()->createMany(
    //                collect($steps)
    //                    ->map(fn (string $description): array => ['description' => $description])
    //                    ->all()
    //            );
    //        });
    //
    //        return to_route('idea.index')
    //            ->with('success', 'idea created');
    //    }
    {
        $idea = Auth::user()->ideas()->create($request->safe()->except(['steps', 'image']));
        $idea->steps()->createMany(
            collect($request->step)->map(fn ($step) => ['description' => $step])
        );
        $imagPath = $request->image->store('ideas', 'public');
        $idea->update([
            'image_path' => $imagPath,
        ]);

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
        return view('idea.edit', [
            'idea' => $idea,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateideaRequest $request, Idea $idea)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Idea $idea)
    {
        $idea->delete();

        return redirect()->route('idea.index');
    }
}
