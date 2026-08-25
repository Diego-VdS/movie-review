<x-app-layout>

    <div class="min-h-screen bg-gradient-to-b from-gray-950 via-gray-900 to-black py-12">

        <div class="max-w-7xl mx-auto px-6">

            <div class="mb-10">

                <h1 class="text-5xl font-extrabold text-white tracking-tight">
                    Movie Revieuwer
                </h1>

                <p class="text-gray-400 mt-3">
                    Give and read opinions on movies and tv series.
                </p>

            </div>

            <form method="GET" class="mb-12 flex gap-3">

                <input name="search" value="{{ request('search') }}" placeholder="Search movies or series..."
                    class="w-full md:w-96 rounded-xl bg-gray-800 border border-gray-700 text-white px-5 py-3 focus:ring-2 focus:ring-red-500 focus:outline-none">

                <button
                    class="bg-red-600 hover:bg-red-700 transition text-white px-6 py-3 rounded-xl font-semibold shadow-lg">
                    Search
                </button>

            </form>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">

                @foreach ($movies['results'] ?? [] as $movie)
                    @if (($movie['media_type'] ?? '') === 'person')
                        @continue
                    @endif

                    <a href="{{ route('movies.show', ['id' => $movie['id'], 'type' => $movie['media_type']]) }}"
                        class="block bg-gray-900 rounded-2xl overflow-hidden shadow-xl border border-gray-800 
                hover:-translate-y-2 transition duration-300">

                        @if (!empty($movie['poster_path']))
                            <div class="overflow-hidden">

                                <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                                    class="w-full h-72 object-cover hover:scale-110 transition duration-500">

                            </div>
                        @endif

                        <div class="p-4">

                            <h2 class="text-white font-bold text-lg truncate"
                                title="{{ $movie['title'] ?? $movie['name'] }}">
                                {{ $movie['title'] ?? $movie['name'] }}
                            </h2>

                            <p class="text-red-400 text-xs mt-1 uppercase font-semibold">
                                {{ ($movie['media_type'] ?? '') === 'tv' ? 'TV Series' : 'Movie' }}
                            </p>

                            <p class="text-gray-500 text-xs mt-1">
                                {{ $movie['release_date'] ?? ($movie['first_air_date'] ?? 'Unknown date') }}
                            </p>

                            @if (!empty($movie['overview']))
                                @php
                                    $isLong = strlen($movie['overview']) > 80;
                                @endphp

                                <div x-data="{ open: false }">

                                    <p x-show="!open" class="text-gray-300 text-sm mt-3 leading-relaxed">
                                        {{ Str::limit($movie['overview'], 80) }}
                                    </p>

                                    @if ($isLong)
                                        <p x-show="open" class="text-gray-300 text-sm mt-3 leading-relaxed">
                                            {{ $movie['overview'] }}
                                        </p>

                                        <button @click="open = !open"
                                            class="mt-3 text-red-400 hover:text-red-300 text-sm font-semibold">

                                            <span x-show="!open">
                                                Read more
                                            </span>

                                            <span x-show="open">
                                                Show less
                                            </span>

                                        </button>
                                    @endif

                                </div>
                            @endif

                        </div>

                    </a>
                @endforeach

            </div>

            @if (empty($movies['results']))
                <div class="text-center text-gray-400 mt-20">

                    <p class="text-2xl">
                        🔎 Search for a movie or series
                    </p>

                    <p class="mt-2">
                        Try "Batman", "Breaking Bad" or "Avatar"
                    </p>

                </div>
            @endif

        </div>

    </div>

</x-app-layout>