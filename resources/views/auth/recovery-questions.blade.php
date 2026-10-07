<x-guest-layout>

    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
            Pertanyaan Keamanan
        </h2>

        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Jawab semua pertanyaan sesuai dengan jawaban
            yang kamu masukkan saat registrasi.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-100 p-4 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.recovery.verify') }}">
        @csrf

        <div>
            <x-input-label
                for="recovery_answer_1"
                :value="$user->recovery_question_1"
            />

            <x-text-input
                id="recovery_answer_1"
                class="block mt-1 w-full"
                type="text"
                name="recovery_answer_1"
                required
                autofocus
            />
        </div>

        <div class="mt-4">
            <x-input-label
                for="recovery_answer_2"
                :value="$user->recovery_question_2"
            />

            <x-text-input
                id="recovery_answer_2"
                class="block mt-1 w-full"
                type="text"
                name="recovery_answer_2"
                required
            />
        </div>

        <div class="mt-4">
            <x-input-label
                for="recovery_answer_3"
                :value="$user->recovery_question_3"
            />

            <x-text-input
                id="recovery_answer_3"
                class="block mt-1 w-full"
                type="text"
                name="recovery_answer_3"
                required
            />
        </div>

        <div class="flex items-center justify-end mt-6">

            <a
                href="{{ route('password.request') }}"
                class="underline text-sm text-gray-600 dark:text-gray-400"
            >
                Kembali
            </a>

            <x-primary-button class="ms-4">
                Verifikasi Jawaban
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>