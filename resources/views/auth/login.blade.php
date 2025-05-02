<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#e6f0f8] px-4">
        <div class="w-full max-w-sm bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-semibold text-center text-[#305c88] mb-6">Login ke Akunmu</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full border-2 border-[#305c88] rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-[#27496d]" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full border-2 border-[#305c88] rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-[#27496d]"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-[#305c88] text-[#305c88] shadow-sm focus:ring-[#305c88]" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Ingat Saya') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-[#305c88] hover:text-blue-800" href="{{ route('password.request') }}">
                            {{ __('Lupa Password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ml-3 bg-[#305c88] hover:bg-[#1f3f66] text-white rounded-md py-2 px-6">
                        {{ __('Login') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>