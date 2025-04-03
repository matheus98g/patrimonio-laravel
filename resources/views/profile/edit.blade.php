<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ ('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <!-- Two-Factor Authentication Section -->
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        {{ ('Two-Factor Authentication') }}
                    </h3>

                    @if (auth()->user()->two_factor_secret)
                        <p class="text-gray-700 dark:text-gray-300 mb-4">
                            Two-Factor Authentication is <strong>enabled</strong>.
                        </p>

                        <!-- QR Code -->
                        <div class="mt-4 flex justify-center">
                            {!! auth()->user()->twoFactorQrCodeSvg() !!}
                        </div>

                        <!-- Recovery Codes -->
                        @php
                            $recoveryCodes = json_decode(auth()->user()->two_factor_recovery_codes, true) ?? [];
                        @endphp

                        @if (!empty($recoveryCodes))
                            <div class="mt-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400">Save these recovery codes securely:</p>
                                <ul class="bg-gray-100 dark:bg-gray-700 p-3 rounded text-sm mt-2">
                                    @foreach ($recoveryCodes as $code)
                                        <li class="font-mono text-gray-900 dark:text-gray-100">{{ $code }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Disable 2FA -->
                        <form method="POST" action="{{ route('two-factor.disable') }}" class="mt-4">
                            @csrf
                            @method('DELETE')
                            <x-primary-button>{{ ('Disable 2FA') }}</x-primary-button>
                        </form>
                    @else
                        <p class="text-gray-700 dark:text-gray-300">
                            Two-Factor Authentication is <strong>disabled</strong>.
                        </p>

                        <!-- Enable 2FA -->
                        <form method="POST" action="{{ route('two-factor.enable') }}" class="mt-4">
                            @csrf
                            <x-primary-button>{{ ('Enable 2FA') }}</x-primary-button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
