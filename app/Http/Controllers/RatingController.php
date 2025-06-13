<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RatingController extends Controller
{
        public function store(Request $request, Restaurant $restaurant)
    {
        $request->validate([
            'score' => 'required|integer|between:1,5',
            'comment' => 'nullable|string',
        ]);
    
        $restaurant->ratings()->create([
            'user_id' => auth()->id(),
            'score' => $request->score,
            'comment' => $request->comment,
        ]);
    
        return back();
    }
}
