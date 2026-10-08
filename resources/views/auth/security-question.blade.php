<x-guest-layout>

    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Jawab pertanyaan keamanan yang Anda buat saat registrasi untuk melanjutkan pemulihan password.
    </div>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.verify') }}">
        @csrf

        <div>
            <x-input-label
                for="security_question"
                :value="__('Pertanyaan Keamanan')"
            />

            <div class="mt-2 p-3 rounded-lg bg-gray-100 dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-300">
                {{ $securityQuestion }}
            </div>
        </div>

        <div class="mt-4">
            <x-input-label
                for="security_answer"
                :value="__('Jawaban')"
            />

            <x-text-input
                id="security_answer"
                class="block mt-1 w-full"
                type="text"
                name="security_answer"
                required
                autofocus
            />

            <x-input-error
                :messages="$errors->get('security_answer')"
                class="mt-2"
            />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                Lanjutkan
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>