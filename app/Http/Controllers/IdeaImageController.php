<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaImageController extends Controller
{
    public function destroy(Idea $idea){
        //authorize
        Gate::authorize('workWith',$idea);
        Storage::disk('Public')->delete($idea->image->image_path);
        $idea->update(['image_path' => null]);

        return back();

    }
}
