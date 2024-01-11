<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <x-slot name="title">
        <h1 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
            Sign in to your account
        </h1>
    </x-slot>


    <form class="space-y-6" method="POST" action="{{ route('login') }}">
        @csrf
        <!-- Email Address -->
        <div>

            <x-input-label for="email" :value="__('Email Address')" />
            <div class="mt-2">
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                    autocomplete="username" placeholder="bruce@wayne.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                <div class="text-sm">
                    <a href="{{ route('password.request') }}"
                        class="font-semibold text-black hover:text-black">{{ __('Forgot password?') }}</a>
                </div>
            </div>
            <div class="mt-2">
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" placeholder="••••••••" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>

        <div>
            <button type="submit"
                class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                {{ __('Sign in') }}
            </button>
        </div>
    </form>

    <p class="mt-10 text-center text-sm text-gray-500">
        {{ __("Don't have an account yet?") }}
        <a href="{{ route('register') }}"
            class="font-semibold leading-6 text-black hover:text-black">{{ __('Sign Up') }}</a>
    </p>
</x-guest-layout>
