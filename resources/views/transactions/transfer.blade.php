<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
            Transfer Keluar
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold mb-6">
                        Transfer ke Pengguna Lain
                    </h3>

                    <form method="POST" action="{{ route('transfer.store') }}">

                        @csrf

                        <div class="mb-4">

                            <label class="block text-sm font-medium mb-2">
                                Penerima
                            </label>

                            <div class="relative">
                                <input
                                    type="text"
                                    id="recipient_search"
                                    placeholder="Cari nama atau email penerima..."
                                    autocomplete="off"
                                    class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                                >

                                <input
                                    type="hidden"
                                    name="recipient_user_id"
                                    id="recipient_user_id"
                                    required
                                >

                                <div
                                    id="recipient_results"
                                    class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg hidden"
                                >
                                    @foreach($users as $user)
                                        <button
                                            type="button"
                                            class="recipient-option w-full text-left px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-600"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ strtolower($user->name) }}"
                                            data-email="{{ strtolower($user->email) }}"
                                        >
                                            <span class="font-medium">
                                                {{ $user->name }}
                                            </span>
                                            <span class="text-sm text-gray-500 dark:text-gray-300">
                                                — {{ $user->email }}
                                            </span>
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            @error('recipient_user_id')
                                <p class="text-sm text-red-600 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        <div class="mb-4">

                            <label class="block text-sm font-medium mb-2">
                                Nominal Transfer
                            </label>

                            <input
                                type="number"
                                name="amount"
                                min="1"
                                value="{{ old('amount') }}"
                                class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                                placeholder="Masukkan nominal"
                                required
                            >

                            @error('amount')
                                <p class="text-sm text-red-600 mt-1">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        <div class="mb-6">

                            <label class="block text-sm font-medium mb-2">
                                Keterangan
                            </label>

                            <textarea
                                name="description"
                                rows="3"
                                class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                                placeholder="Keterangan transfer (opsional)"
                            >{{ old('description') }}</textarea>

                        </div>


                        <button
                            type="submit"
                            class="px-5 py-2.5 bg-blue-600 text-white font-semibold rounded-lg hover:opacity-90"
                        >
                            Transfer
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script>
        const searchInput = document.getElementById('recipient_search');
        const userIdInput = document.getElementById('recipient_user_id');
        const results = document.getElementById('recipient_results');
        const options = document.querySelectorAll('.recipient-option');

        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let found = false;

            options.forEach(option => {
                const name = option.dataset.name;
                const email = option.dataset.email;

                if (
                    keyword === '' ||
                    name.includes(keyword) ||
                    email.includes(keyword)
                ) {
                    option.classList.remove('hidden');
                    found = true;
                } else {
                    option.classList.add('hidden');
                }
            });

            if (found && keyword !== '') {
                results.classList.remove('hidden');
            } else {
                results.classList.add('hidden');
            }

            userIdInput.value = '';
        });

        options.forEach(option => {
            option.addEventListener('click', function () {
                searchInput.value =
                    this.querySelector('.font-medium').textContent.trim()
                    + ' — '
                    + this.querySelector('.text-sm').textContent.trim().replace(/^—\s*/, '');

                userIdInput.value = this.dataset.id;

                results.classList.add('hidden');
            });
        });

        document.addEventListener('click', function (event) {
            if (!searchInput.contains(event.target) &&
                !results.contains(event.target)) {
                results.classList.add('hidden');
            }
        });
    </script>

</x-app-layout>