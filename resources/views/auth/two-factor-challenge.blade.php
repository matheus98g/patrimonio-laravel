<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ ('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form for Authenticator App -->
        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf

            <div>
                <x-input-label for="code" :value="('Authentication Code')" />
                <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" required autofocus />
            </div>

            <div class="mt-4">
                <x-primary-button>
                    {{ ('Confirm') }}
                </x-primary-button>
            </div>
        </form>

        <!-- Form for Recovery Codes -->
        <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            {{ ('Lost access to your authentication device? You can use one of your recovery codes instead.') }}
        </div>

        <form method="POST" action="{{ route('two-factor.login') }}">
            @csrf

            <div class="mt-2">
                <x-input-label for="recovery_code" :value="('Recovery Code')" />
                <x-text-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code" />
            </div>

            <div class="mt-4">
                <x-primary-button>
                    {{ ('Confirm with Recovery Code') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
