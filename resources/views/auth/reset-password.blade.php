<x-guest-layout>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Jawaban keamanan benar. Silakan buat password baru untuk akun Anda.
    </div>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.reset') }}">
        @csrf

        <!-- Password Baru -->
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

        <!-- Konfirmasi Password -->
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

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Ubah Password
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>