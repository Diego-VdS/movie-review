<x-app-layout>

    <div class="min-h-screen bg-gradient-to-b from-gray-950 via-gray-900 to-black py-12">

        <div class="max-w-6xl mx-auto px-6">
            <div class="mb-6">
                <button
                    type="button"
                    onclick="history.back()"
                    class="inline-flex items-center gap-2 text-gray-400 hover:text-white transition cursor-pointer">
                    <span class="text-xl">←</span> Back
                </button>
            </div>
            <div class="bg-gray-900 rounded-3xl p-8 shadow-xl border border-gray-800">

                <div class="flex flex-col md:flex-row gap-8">

                    <div class="md:w-1/3">
                        @if (!empty($movie['poster_path']))
                            <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                                class="rounded-2xl shadow-lg w-full">
                        @endif
                    </div>

                    <div class="md:w-2/3">

                        <h1 class="text-5xl font-extrabold text-white">
                            {{ $movie['title'] ?? $movie['name'] }}
                        </h1>

                        <div class="flex gap-4 mt-4 text-gray-400 text-sm">

                            @if (!empty($movie['release_date']))
                                <span>
                                    📅 {{ $movie['release_date'] }}
                                </span>
                            @endif

                            @if (!empty($movie['first_air_date']))
                                <span>
                                    📺 {{ $movie['first_air_date'] }}
                                </span>
                            @endif

                        </div>

                        <h2 class="text-white text-xl font-semibold mt-8">
                            Overview
                        </h2>

                        <p class="text-gray-300 mt-3 leading-relaxed">
                            {{ $movie['overview'] ?? 'No description available.' }}
                        </p>

                        <div class="mt-8">

                            <h3 class="text-white text-xl font-semibold mb-3">
                                Your rating
                            </h3>

                            @if ($review)

                                <div class="flex gap-2 text-4xl">

                                    @for ($i = 1; $i <= 5; $i++)
                                        <span
                                            class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-600' }}">
                                            ★
                                        </span>
                                    @endfor

                                </div>

                                <p class="text-gray-400 mt-3">
                                    You already reviewed this title.
                                </p>

                                @if ($review->comment)
                                    <div class="mt-4 bg-gray-800 rounded-xl p-4">

                                        <p class="text-gray-300">
                                            {{ $review->comment }}
                                        </p>

                                    </div>
                                @endif
                            @else
                                <!-- User has not reviewed yet -->
                                <div x-data="{ rating: 0, hover: 0, open: false }">

                                    <div class="flex gap-2 text-4xl cursor-pointer">

                                        @for ($i = 1; $i <= 5; $i++)
                                            <button type="button" @mouseenter="hover = {{ $i }}"
                                                @mouseleave="hover = 0"
                                                @click="rating = {{ $i }}; open = true">
                                                <span
                                                    :class="(hover >= {{ $i }} || rating >= {{ $i }}) ?
                                                    'text-yellow-400' :
                                                    'text-gray-600'">
                                                    ★
                                                </span>
                                            </button>
                                        @endfor

                                    </div>

                                    <div x-show="open" x-transition class="mt-6">

                                        <form method="POST" action="{{ route('reviews.store') }}">

                                            @csrf

                                            <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">

                                            <input type="hidden" name="type"
                                                value="{{ request()->route('type') }}">

                                            <input type="hidden" name="rating" x-model="rating">

                                            <textarea name="comment" rows="4" placeholder="Write your opinion..."
                                                class="w-full rounded-xl bg-gray-800 border border-gray-700 text-white p-4"></textarea>

                                            <button type="submit"
                                                class="mt-4 bg-red-600 hover:bg-red-700 transition text-white px-6 py-3 rounded-xl font-semibold">
                                                Save review
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>