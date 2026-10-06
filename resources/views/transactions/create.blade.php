<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Transaksi') }}
            </h2>

            <a
                href="{{ route('dashboard') }}"
                style="color: #4b5563 !important;"
                class="text-sm font-semibold hover:underline"
            >
                Kembali ke Dashboard
            </a>

        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="mb-6">

                        <h3 class="text-lg font-semibold">
                            Tambah Pendapatan / Pengeluaran
                        </h3>

                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Masukkan informasi transaksi yang ingin dicatat.
                        </p>

                    </div>


                    @if ($errors->any())

                        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">

                            <p class="font-semibold text-red-700 dark:text-red-400">
                                Terdapat kesalahan:
                            </p>

                            <ul class="mt-2 list-disc list-inside text-sm text-red-600 dark:text-red-400">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    @if (session('success'))

                        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">

                            <p class="text-sm font-medium text-green-700 dark:text-green-400">
                                {{ session('success') }}
                            </p>

                        </div>

                    @endif


                    <form
                        method="POST"
                        action="{{ route('transactions.store') }}"
                    >

                        @csrf


                        {{-- JENIS TRANSAKSI --}}
                        <div class="mb-6">

                            <label
                                for="type"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Jenis Transaksi
                            </label>

                            <select
                                name="type"
                                id="type"
                                required
                                class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            >

                                <option value="">
                                    Pilih jenis transaksi
                                </option>

                                <option
                                    value="income"
                                    {{ old('type') === 'income' ? 'selected' : '' }}
                                >
                                    Pendapatan
                                </option>

                                <option
                                    value="expense"
                                    {{ old('type') === 'expense' ? 'selected' : '' }}
                                >
                                    Pengeluaran
                                </option>

                            </select>

                        </div>


                        {{-- NOMINAL --}}
                        <div class="mb-6">

                            <label
                                for="amount"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Nominal
                            </label>

                            <div class="mt-2 relative">

                                <span
                                    class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-500 dark:text-gray-400"
                                >
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    name="amount"
                                    id="amount"
                                    value="{{ old('amount') }}"
                                    min="1"
                                    step="1"
                                    required
                                    placeholder="0"
                                    class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white pl-12 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                >

                            </div>

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Masukkan nominal tanpa tanda titik atau koma.
                            </p>

                        </div>


                        {{-- KETERANGAN --}}
                        <div class="mb-6">

                            <label
                                for="description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >
                                Keterangan
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                rows="4"
                                maxlength="1000"
                                placeholder="Contoh: Gaji, belanja, pembayaran listrik, dan sebagainya."
                                class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                            >{{ old('description') }}</textarea>

                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Keterangan bersifat opsional.
                            </p>

                        </div>


                        {{-- INFORMASI KEAMANAN --}}
                        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">

                            <p class="text-sm font-semibold text-blue-800 dark:text-blue-300">
                                Informasi Keamanan
                            </p>

                            <p class="mt-1 text-sm text-blue-700 dark:text-blue-400">
                                Transaksi akan dicatat sebagai aktivitas akun
                                {{ auth()->user()->name }}.
                            </p>

                        </div>


                        {{-- TOMBOL --}}
                        <div class="flex items-center justify-end gap-3">

                            <a
                                href="{{ route('dashboard') }}"
                                style="color: #374151 !important; background-color: #e5e7eb !important;"
                                class="inline-block px-5 py-2.5 rounded-lg font-semibold hover:opacity-80 transition"
                            >
                                Batal
                            </a>


                            <button
                                type="submit"
                                style="color: #ffffff !important; background-color: #2563eb !important; border: none !important; cursor: pointer !important;"
                                class="inline-block px-6 py-2.5 rounded-lg font-semibold hover:opacity-90 transition"
                            >
                                Simpan Transaksi
                            </button>

                        </div>


                    </form>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>