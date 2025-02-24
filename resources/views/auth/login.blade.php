<x-guest-layout>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 bg-white dark:bg-gray-900 border dark:border-gray-700 rounded-lg">


        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Email') }}</label>
                    <div class="mt-2">
                        <x-text-input id="email" name="email" type="email" autocomplete="email" required class="block w-full rounded-md bg-white dark:bg-gray-800 dark:text-gray-100 px-3 py-1.5 text-base text-gray-900 dark:outline-gray-600 outline-1 outline-gray-300 placeholder:text-gray-400 dark:placeholder:text-gray-600 focus:outline-2 focus:outline-indigo-600 sm:text-sm" :value="old('email')" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('Senha') }}</label>
                        <div class="text-sm">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    {{ __('Esqueceu a senha?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="mt-2">
                        <x-text-input id="password" name="password" type="password" required autocomplete="current-password" class="block w-full rounded-md bg-white dark:bg-gray-800 dark:text-gray-100 px-3 py-1.5 text-base text-gray-900 dark:outline-gray-600 outline-1 outline-gray-300 placeholder:text-gray-400 dark:placeholder:text-gray-600 focus:outline-2 focus:outline-indigo-600 sm:text-sm" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center text-gray-900 dark:text-gray-100">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Lembrar de mim') }}</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <x-primary-button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 dark:bg-indigo-700 dark:hover:bg-indigo-600">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            {{-- <p class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
               Não tem uma conta?
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">{{ __('Registrar') }}</a>
            </p> --}}
        </div>
    </div>
</x-guest-layout>
