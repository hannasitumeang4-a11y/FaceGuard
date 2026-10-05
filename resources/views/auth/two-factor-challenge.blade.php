<x-guest-layout>

    <div class="mb-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            Two-Factor Authentication
        </h2>
    </div>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Masukkan kode 6 digit yang ditampilkan oleh aplikasi
        Authenticator kamu untuk melanjutkan login.
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-100 p-4 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form
        method="POST"
        action="{{ route('two-factor.login.store') }}"
    >

        @csrf

        <div>
            <x-input-label
                for="code"
                :value="__('Kode OTP')"
            />

            <x-text-input
                id="code"
                class="block mt-1 w-full"
                type="text"
                name="code"
                inputmode="numeric"
                autocomplete="one-time-code"
                maxlength="6"
                pattern="[0-9]{6}"
                required
                autofocus
            />

            <x-input-error
                :messages="$errors->get('code')"
                class="mt-2"
            />
        </div>

        <div class="flex items-center justify-end mt-4">

            <x-primary-button>
                {{ __('Verifikasi OTP') }}
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>