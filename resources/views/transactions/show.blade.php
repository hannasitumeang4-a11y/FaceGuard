<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Transaksi') }}
            </h2>

            <a
                href="{{ route('transactions.index') }}"
                style="color: #2563eb !important;"
                class="text-sm font-semibold hover:underline"
            >
                Kembali ke Riwayat
            </a>

        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold">
                        Detail Transaksi
                    </h3>


                    <div class="mt-6 space-y-5">

                        {{-- REFERENCE --}}
                        <div>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Reference
                            </p>

                            <p class="mt-1 font-semibold">
                                {{ $transaction->reference }}
                            </p>

                        </div>


                        {{-- JENIS --}}
                        <div>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Jenis Transaksi
                            </p>

                            @if($transaction->type === 'income')

                                <p class="mt-1 font-semibold text-green-600">
                                    Pendapatan
                                </p>

                            @else

                                <p class="mt-1 font-semibold text-red-600">
                                    Pengeluaran
                                </p>

                            @endif

                        </div>


                        {{-- NOMINAL --}}
                        <div>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Nominal
                            </p>

                            <p class="mt-1 text-2xl font-bold">

                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}

                            </p>

                        </div>


                        {{-- KETERANGAN --}}
                        <div>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Keterangan
                            </p>

                            <p class="mt-1">
                                {{ $transaction->description ?? 'Tidak ada keterangan' }}
                            </p>

                        </div>


                        {{-- STATUS --}}
                        <div>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Status
                            </p>

                            <p class="mt-1 font-semibold text-blue-600">
                                {{ ucfirst($transaction->status) }}
                            </p>

                        </div>


                        {{-- WAKTU --}}
                        <div>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Waktu Transaksi
                            </p>

                            <p class="mt-1">
                                {{ $transaction->created_at->format('d M Y, H:i:s') }}
                            </p>

                        </div>

                    </div>


                    <div class="mt-8 flex items-center justify-end">

                        <a
                            href="{{ route('transactions.index') }}"
                            style="color: #ffffff !important; background-color: #4b5563 !important;"
                            class="px-5 py-2.5 rounded-lg font-semibold hover:opacity-90 transition"
                        >
                            Kembali

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>