<x-app-layout>
    <form action="{{ route('profile.update', $user->id) }}" enctype="multipart/form-data" method="POST">
        @csrf
        @method('patch')
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-xl font-semibold leading-7 text-gray-900">
                    {{ __('Edit Profile') }}
                </h2>
                <p class="mt-1 text-sm leading-6 text-gray-600">
                    {{ __('This information will be displayed publicly so be careful what you share.') }}
                </p>

                <div class="mt-10 border-b border-gray-900/10 pb-12">
                    <div class="col-span-full mt-10 pb-10">
                        <label for="photo"
                            class="block text-sm font-medium leading-6 text-gray-900">{{ __('Photo') }}</label>
                        <div class="mt-2 flex items-center gap-x-3">
                            <input class="hidden" type="file" name="picture" id="picture" />
                            <img id="preview" class="h-32 w-32 rounded-full"
                                src="https://avatars.githubusercontent.com/u/831997" alt="Ahmed Shamim Hasan Shaon" />
                            <label for="picture">
                                <div
                                    class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    {{ __('Change') }}
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <div class="sm:col-span-3">
                            <x-input-label for="first_name" :value="__('First name')" />
                            <div class="mt-2">
                                <x-text-input id="first_name" name="first_name" type="text" :value="old('first_name', $user->first_name)"
                                    required autofocus autocomplete="first_name" />
                                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <x-input-label for="last_name" :value="__('Last name')" />
                            <div class="mt-2">
                                <x-text-input id="last_name" name="last_name" type="text" :value="old('last_name', $user->last_name)" required
                                    autofocus autocomplete="last_name" />
                                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="email" :value="__('Email address')" />
                            <div class="mt-2">
                                <x-text-input id="email" name="email" type="text" :value="old('email', $user->email)" required
                                    autofocus autocomplete="email" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>
                        </div>

                        <div class="col-span-full">
                            <x-input-label for="name" :value="__('Password')" />
                            <div class="mt-2">
                                <input type="password" name="password" id="password" autocomplete="password"
                                    class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-full">
                        <x-input-label for="bio" :value="__('Bio')" />
                        <div class="mt-2">
                            <textarea id="bio" name="bio" rows="3"
                                class="block w-full rounded-md border-0 p-2 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-600 sm:text-sm sm:leading-6">{{ $user->bio }}</textarea>
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-600">
                            {{ __('Write a few sentences about yourself.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <a href="{{ route('profile.show', $user->id) }}" class="text-sm font-semibold leading-6 text-gray-900">
                Cancel
            </a>
            <button type="submit"
                class="rounded-md bg-gray-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</x-app-layout>
