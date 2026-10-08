<x-guest-layout>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Masukkan alamat email akun Anda untuk melanjutkan proses pemulihan password.
    </div>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.question') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <div class="flex items-center justify-end mt-4">

            <x-primary-button>
                Lanjutkan
            </x-primary-button>

        </div>

    </form>

    <div class="mt-4 text-center">
        <a
            href="{{ route('login') }}"
            class="text-sm text-blue-600 hover:text-blue-800"
        >
            Kembali ke Login
        </a>
    </div>

</x-guest-layout>