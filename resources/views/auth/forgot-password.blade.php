<x-guest-layout>

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Lupa Password
        </h2>

        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Masukkan email yang digunakan saat mendaftar.
            Selanjutnya kamu akan diminta menjawab pertanyaan keamanan.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-md bg-green-100 p-4 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.recovery.email') }}">
        @csrf

        <div>
            <x-input-label
                for="email"
                :value="__('Email')"
            />

            <x-text-input
                id="email"
                class="block mt-1 w-full"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="email"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>

        <div class="flex items-center justify-end mt-6">

            <a
                href="{{ route('login') }}"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900"
            >
                Kembali ke Login
            </a>

            <x-primary-button class="ms-4">
                Lanjut
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>