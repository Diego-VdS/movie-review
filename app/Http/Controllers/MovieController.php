<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Services\TmdbService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function __construct(
        private TmdbService $tmdb
    ) {}

    public function index(Request $request)
    {
        $movies = [];

        if ($request->filled('search')) {
            $movies = $this->tmdb->searchMovies(
                $request->search
            );
        }

        return view('movies.index', [
            'movies' => $movies
        ]);
    }

    public function show($id, $type)
    {
        $movie = Http::get(
            "https://api.themoviedb.org/3/{$type}/{$id}",
            [
                'api_key' => config('tmdb.api_key')
            ]
        )->json();

        $review = Review::where('user_id', auth()->id())
            ->where('tmdb_id', $id)
            ->where('type', $type)
            ->first();

        return view('movies.show', [
            'movie' => $movie,
            'review' => $review
        ]);
    }
}