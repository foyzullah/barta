<x-app-layout>
    <!-- Barta Create Post Card -->
    @include('components.create_post', ['image' => auth()->user()->picture])
    <!-- /Barta Create Post Card -->

    <!-- Newsfeed -->
    <section id="newsfeed" class="space-y-6">
        <!-- Barta Card -->
        @foreach ($posts as $post)
            <article class="bg-white border-2 border-black rounded-lg shadow mx-auto max-w-none px-4 py-5 sm:px-6">
                <!-- Barta Card Top -->
                <header>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <!-- User Avatar -->
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full object-cover"
                                    src="{{ asset('storage/avatars/' . $post->user->picture) }}"
                                    alt="{{ $post->user->first_name }}" />
                            </div>
                            <!-- /User Avatar -->

                            <!-- User Info -->
                            <div class="text-gray-900 flex flex-col min-w-0 flex-1">
                                <a href="{{ route('profile.show', $post->user_id) }}"
                                    class="hover:underline font-semibold line-clamp-1">
                                    {{ $post->user->first_name . ' ' . $post->user->last_name }}
                                </a>

                                <a href="{{ route('profile.show', $post->user_id) }}"
                                    class="hover:underline text-sm text-gray-500 line-clamp-1">
                                    {{ strtolower('@' . $post->user->first_name) }}
                                </a>
                            </div>
                            <!-- /User Info -->
                        </div>

                        <!-- Card Action Dropdown -->
                        @if ($post->user_id === auth()->user()->id)
                            @include('components.post_card_dropdown')
                        @endif
                        <!-- /Card Action Dropdown -->
                    </div>
                </header>

                <!-- Content -->
                <a href="{{ route('posts.show', $post->id) }}">
                    <div class="py-4 text-gray-700 font-normal">
                        <p>
                            {{ $post->description }}
                        </p>
                    </div>
                </a>

                <!-- Date Created & View Stat -->
                <div class="flex items-center gap-2 text-gray-500 text-xs my-2">
                    <span class="">6 minutes ago</span>
                    <span class="">•</span>
                    <span>450 views</span>
                </div>

                <!-- Barta Card Bottom -->
                <footer class="border-t border-gray-200 pt-2">
                    <!-- Card Bottom Action Buttons -->
                    <div class="flex items-center justify-between">
                        <div class="flex gap-8 text-gray-600">
                            <!-- Comment Button -->
                            <a href="./single.html" type="button"
                                class="-m-2 flex gap-2 text-xs items-center rounded-full p-2 text-gray-600 hover:text-gray-800">
                                <span class="sr-only">Comment</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.444 3 12c0 2.104.859 4.023 2.273 5.48.432.447.74 1.04.586 1.641a4.483 4.483 0 01-.923 1.785A5.969 5.969 0 006 21c1.282 0 2.47-.402 3.445-1.087.81.22 1.668.337 2.555.337z" />
                                </svg>


                                <p>{{ count($post->comments) }}</p>
                            </a>
                            <!-- /Comment Button -->
                        </div>
                    </div>
                    <!-- /Card Bottom Action Buttons -->
                </footer>
                <!-- /Barta Card Bottom -->
            </article>
        @endforeach
        <!-- /Barta Card -->
    </section>
    <!-- /Newsfeed -->
</x-app-layout>
