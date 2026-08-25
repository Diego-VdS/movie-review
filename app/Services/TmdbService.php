<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TmdbService
{
    public function searchMovies(string $query)
    {
        return Http::get(
            'https://api.themoviedb.org/3/search/multi',
            [
                'api_key' => config('tmdb.api_key'),
                'query' => $query,
            ]
        )->json();
    }
}