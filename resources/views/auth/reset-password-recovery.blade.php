<x-guest-layout>

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Buat Password Baru
        </h2>

        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Jawaban keamanan berhasil diverifikasi.
            Silakan buat password baru untuk akun kamu.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-100 p-4 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.recovery.reset.store') }}">
        @csrf

        <div>
            <x-input-label
                for="password"
                :value="__('Password Baru')"
            />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autofocus
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>

        <div class="mt-4">
            <x-input-label
                for="password_confirmation"
                :value="__('Konfirmasi Password Baru')"
            />

            <x-text-input
                id="password_confirmation"
                class="block mt-1 w-full"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password_confirmation')"
                class="mt-2"
            />
        </div>

        <div class="flex items-center justify-end mt-6">

            <x-primary-button>
                Simpan Password Baru
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>