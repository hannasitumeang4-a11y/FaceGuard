<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tarik Saldo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold mb-6">
                        Tarik Saldo
                    </h3>

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('withdraw.store') }}">
                        @csrf

                        {{-- NOMINAL --}}
                        <div class="mb-4">
                            <label
                                for="amount"
                                class="block font-medium text-sm mb-2"
                            >
                                Nominal Penarikan
                            </label>

                            <input
                                type="number"
                                name="amount"
                                id="amount"
                                value="{{ old('amount') }}"
                                min="1"
                                required
                                class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Masukkan nominal"
                            >
                        </div>

                        {{-- KETERANGAN --}}
                        <div class="mb-6">
                            <label
                                for="description"
                                class="block font-medium text-sm mb-2"
                            >
                                Keterangan
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                rows="3"
                                class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Keterangan (opsional)"
                            >{{ old('description') }}</textarea>
                        </div>

                        {{-- BUTTON --}}
                        <div class="flex gap-3">

                            <button
                                type="submit"
                                style="color: #ffffff !important; background-color: #dc2626 !important;"
                                class="px-5 py-2.5 font-semibold rounded-lg hover:opacity-90 transition"
                            >
                                Tarik Saldo
                            </button>

                            <a
                                href="{{ route('dashboard') }}"
                                style="color: #ffffff !important; background-color: #6b7280 !important;"
                                class="px-5 py-2.5 font-semibold rounded-lg hover:opacity-90 transition"
                            >
                                Kembali
                            </a>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>

</x-app-layout>