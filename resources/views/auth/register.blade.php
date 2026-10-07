<x-guest-layout>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label
                for="name"
                :value="__('Name')"
            />

            <x-text-input
                id="name"
                class="block mt-1 w-full"
                type="text"
                name="name"
                :value="old('name')"
                required
                autofocus
                autocomplete="name"
            />

            <x-input-error
                :messages="$errors->get('name')"
                class="mt-2"
            />
        </div>


        <!-- Email Address -->
        <div class="mt-4">
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
                autocomplete="username"
            />

            <x-input-error
                :messages="$errors->get('email')"
                class="mt-2"
            />
        </div>


        <!-- Password -->
        <div class="mt-4">
            <x-input-label
                for="password"
                :value="__('Password')"
            />

            <x-text-input
                id="password"
                class="block mt-1 w-full"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />

            <x-input-error
                :messages="$errors->get('password')"
                class="mt-2"
            />
        </div>


        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label
                for="password_confirmation"
                :value="__('Confirm Password')"
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


        <!--
        |--------------------------------------------------------------------------
        | RECOVERY QUESTIONS
        |--------------------------------------------------------------------------
        -->


        <!-- Recovery Question 1 -->
        <div class="mt-6">
            <x-input-label
                for="recovery_question_1"
                value="Pertanyaan Keamanan 1"
            />

            <select
                id="recovery_question_1"
                name="recovery_question_1"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700
                       dark:bg-gray-900 dark:text-gray-300
                       focus:border-indigo-500 focus:ring-indigo-500
                       rounded-md shadow-sm"
                required
            >
                <option value="">-- Pilih Pertanyaan --</option>

                <option
                    value="Siapa nama hewan peliharaan pertama Anda?"
                    {{ old('recovery_question_1') == 'Siapa nama hewan peliharaan pertama Anda?' ? 'selected' : '' }}
                >
                    Siapa nama hewan peliharaan pertama Anda?
                </option>

                <option
                    value="Apa nama kota kelahiran Anda?"
                    {{ old('recovery_question_1') == 'Apa nama kota kelahiran Anda?' ? 'selected' : '' }}
                >
                    Apa nama kota kelahiran Anda?
                </option>

                <option
                    value="Apa makanan favorit Anda?"
                    {{ old('recovery_question_1') == 'Apa makanan favorit Anda?' ? 'selected' : '' }}
                >
                    Apa makanan favorit Anda?
                </option>

                <option
                    value="Siapa nama teman masa kecil Anda?"
                    {{ old('recovery_question_1') == 'Siapa nama teman masa kecil Anda?' ? 'selected' : '' }}
                >
                    Siapa nama teman masa kecil Anda?
                </option>
            </select>

            <x-input-error
                :messages="$errors->get('recovery_question_1')"
                class="mt-2"
            />
        </div>


        <!-- Recovery Answer 1 -->
        <div class="mt-4">
            <x-input-label
                for="recovery_answer_1"
                value="Jawaban Pertanyaan 1"
            />

            <x-text-input
                id="recovery_answer_1"
                class="block mt-1 w-full"
                type="text"
                name="recovery_answer_1"
                :value="old('recovery_answer_1')"
                required
                autocomplete="off"
            />

            <x-input-error
                :messages="$errors->get('recovery_answer_1')"
                class="mt-2"
            />
        </div>


        <!-- Recovery Question 2 -->
        <div class="mt-6">
            <x-input-label
                for="recovery_question_2"
                value="Pertanyaan Keamanan 2"
            />

            <select
                id="recovery_question_2"
                name="recovery_question_2"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700
                       dark:bg-gray-900 dark:text-gray-300
                       focus:border-indigo-500 focus:ring-indigo-500
                       rounded-md shadow-sm"
                required
            >
                <option value="">-- Pilih Pertanyaan --</option>

                <option
                    value="Apa nama guru favorit Anda?"
                    {{ old('recovery_question_2') == 'Apa nama guru favorit Anda?' ? 'selected' : '' }}
                >
                    Apa nama guru favorit Anda?
                </option>

                <option
                    value="Apa nama sekolah dasar Anda?"
                    {{ old('recovery_question_2') == 'Apa nama sekolah dasar Anda?' ? 'selected' : '' }}
                >
                    Apa nama sekolah dasar Anda?
                </option>

                <option
                    value="Apa kota favorit Anda?"
                    {{ old('recovery_question_2') == 'Apa kota favorit Anda?' ? 'selected' : '' }}
                >
                    Apa kota favorit Anda?
                </option>

                <option
                    value="Apa nama panggilan Anda saat kecil?"
                    {{ old('recovery_question_2') == 'Apa nama panggilan Anda saat kecil?' ? 'selected' : '' }}
                >
                    Apa nama panggilan Anda saat kecil?
                </option>
            </select>

            <x-input-error
                :messages="$errors->get('recovery_question_2')"
                class="mt-2"
            />
        </div>


        <!-- Recovery Answer 2 -->
        <div class="mt-4">
            <x-input-label
                for="recovery_answer_2"
                value="Jawaban Pertanyaan 2"
            />

            <x-text-input
                id="recovery_answer_2"
                class="block mt-1 w-full"
                type="text"
                name="recovery_answer_2"
                :value="old('recovery_answer_2')"
                required
                autocomplete="off"
            />

            <x-input-error
                :messages="$errors->get('recovery_answer_2')"
                class="mt-2"
            />
        </div>


        <!-- Recovery Question 3 -->
        <div class="mt-6">
            <x-input-label
                for="recovery_question_3"
                value="Pertanyaan Keamanan 3"
            />

            <select
                id="recovery_question_3"
                name="recovery_question_3"
                class="block mt-1 w-full border-gray-300 dark:border-gray-700
                       dark:bg-gray-900 dark:text-gray-300
                       focus:border-indigo-500 focus:ring-indigo-500
                       rounded-md shadow-sm"
                required
            >
                <option value="">-- Pilih Pertanyaan --</option>

                <option
                    value="Apa nama film favorit Anda?"
                    {{ old('recovery_question_3') == 'Apa nama film favorit Anda?' ? 'selected' : '' }}
                >
                    Apa nama film favorit Anda?
                </option>

                <option
                    value="Apa nama tempat liburan favorit Anda?"
                    {{ old('recovery_question_3') == 'Apa nama tempat liburan favorit Anda?' ? 'selected' : '' }}
                >
                    Apa nama tempat liburan favorit Anda?
                </option>

                <option
                    value="Apa makanan yang paling Anda sukai?"
                    {{ old('recovery_question_3') == 'Apa makanan yang paling Anda sukai?' ? 'selected' : '' }}
                >
                    Apa makanan yang paling Anda sukai?
                </option>

                <option
                    value="Siapa tokoh yang Anda kagumi?"
                    {{ old('recovery_question_3') == 'Siapa tokoh yang Anda kagumi?' ? 'selected' : '' }}
                >
                    Siapa tokoh yang Anda kagumi?
                </option>
            </select>

            <x-input-error
                :messages="$errors->get('recovery_question_3')"
                class="mt-2"
            />
        </div>


        <!-- Recovery Answer 3 -->
        <div class="mt-4">
            <x-input-label
                for="recovery_answer_3"
                value="Jawaban Pertanyaan 3"
            />

            <x-text-input
                id="recovery_answer_3"
                class="block mt-1 w-full"
                type="text"
                name="recovery_answer_3"
                :value="old('recovery_answer_3')"
                required
                autocomplete="off"
            />

            <x-input-error
                :messages="$errors->get('recovery_answer_3')"
                class="mt-2"
            />
        </div>


        <!-- Buttons -->
        <div class="flex items-center justify-end mt-6">

            <a
                class="underline text-sm text-gray-600 dark:text-gray-400
                       hover:text-gray-900 dark:hover:text-gray-100
                       rounded-md focus:outline-none focus:ring-2
                       focus:ring-offset-2 focus:ring-indigo-500
                       dark:focus:ring-offset-gray-800"
                href="{{ route('login') }}"
            >
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>

        </div>

    </form>

</x-guest-layout>