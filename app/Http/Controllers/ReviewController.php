<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'tmdb_id' => 'required',
        'type' => 'required',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required'
    ]);

    $exists = Review::where('user_id', auth()->id())
        ->where('tmdb_id', $request->tmdb_id)
        ->where('type', $request->type)
        ->exists();


    if ($exists) {
        return back()->with(
            'error',
            'You already reviewed this title.'
        );
    }


    Review::create([
        'user_id' => auth()->id(),
        'tmdb_id' => $request->tmdb_id,
        'type' => $request->type,
        'rating' => $request->rating,
        'comment' => $request->comment
    ]);


    return back()->with(
        'success',
        'Review saved!'
    );
}
}