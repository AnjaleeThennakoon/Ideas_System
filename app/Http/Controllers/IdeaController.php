<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreideaRequest;
use App\Http\Requests\UpdateideaRequest;
use App\Models\Idea;
use App\Models\IdeaStatus;
use Auth;
use Illuminate\Http\Request;

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
            ->when(in_array($request->status,IdeaStatus::values()),fn ($query) => $query->where('status', $request->status))
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
    public function store(StoreideaRequest $request):void
    {
        dd('persist the idea');
//        $data = $request->validated();
//
//        $data['links'] = $request->filled('links')
//            ? [$request->links]
//            : [];
//
//        $idea = $request->user()->ideas()->create($data);
//
//        return redirect()->route('idea.show', $idea);
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
        //
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
        //
    }
}
