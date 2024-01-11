<x-guest-layout>

    <x-slot name="title">
        <h1 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">
            {{ __('Create a new account') }}
        </h1>
    </x-slot>

    <form class="space-y-6" method="POST" action="{{ route('register') }}">
        @csrf
        <!-- First Name -->
        <div>
            <x-input-label for="name" :value="__('First Name')" />
            <div class="mt-2">
                <x-text-input id="first_name" type="text" name="first_name" :value="old('first_name')" required autofocus
                    autocomplete="first_name" placeholder="Muhammad" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>
        </div>

        {{-- Last Name  --}}
        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <div class="mt-2">
                <x-text-input id="last_name" type="text" name="last_name" :value="old('last_name')" required autofocus
                    autocomplete="last_name" placeholder="Alp Arslan" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>

        {{-- Email Address  --}}
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <div class="mt-2">
                <x-text-input id="email" type="email" name="email" :value="old('email')" required
                    autocomplete="email" placeholder="alp.arslan@mail.com" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>

        {{-- Password  --}}
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <div class="mt-2">
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                    placeholder="••••••••" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        </div>

        <div>
            <button type="submit"
                class="flex w-full justify-center rounded-md bg-black px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-black">
                {{ __('Register') }}
            </button>
        </div>
    </form>

    <p class="mt-10 text-center text-sm text-gray-500">
        {{ __('Already a member?') }}
        <a href="{{ route('login') }}"
            class="font-semibold leading-6 text-black hover:text-black">{{ __('Sign In') }}</a>
    </p>
</x-guest-layout>
