<x-app-layout>

    <div class="min-h-screen bg-gradient-to-b from-gray-950 via-gray-900 to-black py-12">

        <div class="max-w-3xl mx-auto px-6">

            <div class="bg-gray-900 rounded-3xl p-8 shadow-xl border border-gray-800">

                <h1 class="text-3xl font-bold text-white mb-8">
                    Edit your review
                </h1>

                <form method="POST" action="{{ route('reviews.update', $review) }}">

                    @csrf
                    @method('PUT')
                    <input
                        type="hidden"
                        name="search"
                        value="{{ request('search') }}">
                    <!-- Rating -->
                    <div class="mb-6" x-data="{ rating: {{ $review->rating }} }">

                        <label class="block text-white font-semibold mb-3">
                            Rating
                        </label>

                        <div class="flex gap-2 text-4xl">

                            @for ($i = 1; $i <= 5; $i++)
                                <button
                                type="button"
                                @click="rating = {{ $i }}"
                                class="transition"
                                :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-600'">
                                ★
                                </button>
                                @endfor

                        </div>

                        <input
                            type="hidden"
                            name="rating"
                            x-model="rating">

                    </div>

                    <!-- Comment -->
                    <div class="mb-6">

                        <label
                            for="comment"
                            class="block text-white font-semibold mb-3">
                            Your opinion
                        </label>

                        <textarea
                            id="comment"
                            name="comment"
                            rows="6"
                            class="w-full rounded-xl bg-gray-800 border border-gray-700 text-white p-4 focus:border-red-500 focus:ring-red-500"
                            required>{{ $review->comment }}</textarea>

                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center gap-4">

                        <button
                            type="submit"
                            class="bg-red-600 hover:bg-red-700 transition text-white px-6 py-3 rounded-xl font-semibold">
                            Save changes
                        </button>

                        <a
                            href="{{ route('movies.show', [
                                'id' => $review->tmdb_id,
                                'type' => $review->type,
                                'search' => request('search')
                            ]) }}"
                            class="text-gray-400 hover:text-white transition">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>