<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request)
    {
        $request->validate([
            'tmdb_id' => 'required',
            'type' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required'
        ]);

        $exists = Review::where('user_id', Auth::id())
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
            'user_id' => Auth::id(),
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

    public function edit(Review $review)
    {
        $this->authorize('update', $review);

        return view('reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required'
        ]);

        $review->update($validated);

        return redirect()->route('movies.show', [
            'id' => $review->tmdb_id,
            'type' => $review->type,
        ])->with('success', 'Review updated!');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return back()->with(
            'success',
            'Review deleted!'
        );
    }
}
