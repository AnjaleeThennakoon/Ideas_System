<?php

namespace App\Http\Controllers;
use App\Models\IdeaStatus;
use Illuminate\Http\Request;

use App\Models\Idea;
use App\Http\Requests\StoreideaRequest;
use App\Http\Requests\UpdateideaRequest;
use Auth;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ideas = auth::user()
            ->ideas()
            ->when($request-> status, fn($query, $status)=>$query->where('status',$status))
            ->get();

        $Counts = Auth::user()->ideas()
            ->selectRaw('status,count(*)as count')
            ->groupBy('status')
            ->pluck('count','status');

         $statusCount= collect(IdeaStatus::cases())
            ->mapWithKeys(fn($status) => [
                $status->value =>$Counts->get($status->value,0),
            ])
             ->put("all",Auth::user()->ideas()->count());

        return view('idea.index', [
            'ideas' => $ideas,
            'statusCounts' => $Counts,
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
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Idea $idea)
    {
        //
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
