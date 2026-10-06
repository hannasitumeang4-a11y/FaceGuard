<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Riwayat Transaksi') }}
            </h2>

            <a
                href="{{ route('transactions.create') }}"
                style="color: #ffffff !important; background-color: #2563eb !important;"
                class="px-4 py-2 rounded-lg font-semibold hover:opacity-90 transition"
            >
                Tambah Transaksi
            </a>

        </div>

    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))

                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">

                    <p class="text-sm font-medium text-green-700 dark:text-green-400">
                        {{ session('success') }}
                    </p>

                </div>

            @endif


            {{-- TRANSAKSI --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex items-center justify-between">

                        <div>

                            <h3 class="text-lg font-semibold">
                                Semua Transaksi
                            </h3>

                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Daftar pendapatan dan pengeluaran akun Anda.
                            </p>

                        </div>

                        <a
                            href="{{ route('dashboard') }}"
                            style="color: #2563eb !important;"
                            class="text-sm font-semibold hover:underline"
                        >
                            Kembali ke Dashboard
                        </a>

                    </div>


                    @if($transactions->count() > 0)

                        <div class="mt-6 overflow-x-auto">

                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">

                                <thead>

                                    <tr>

                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase"
                                        >
                                            Tanggal
                                        </th>

                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase"
                                        >
                                            Jenis
                                        </th>

                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase"
                                        >
                                            Keterangan
                                        </th>

                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase"
                                        >
                                            Nominal
                                        </th>

                                        <th
                                            class="px-4 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase"
                                        >
                                            Status
                                        </th>

                                        <th
                                            class="px-4 py-3 text-right text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase"
                                        >
                                            Aksi
                                        </th>

                                    </tr>

                                </thead>


                                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">

                                    @foreach($transactions as $transaction)

                                        <tr>

                                            {{-- TANGGAL --}}
                                            <td class="px-4 py-4 whitespace-nowrap">

                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $transaction->created_at->format('d M Y') }}
                                                </p>

                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $transaction->created_at->format('H:i') }}
                                                </p>

                                            </td>


                                            {{-- JENIS --}}
                                            <td class="px-4 py-4 whitespace-nowrap">

                                                @if($transaction->type === 'income')

                                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                                        Pendapatan
                                                    </span>

                                                @else

                                                    <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                        Pengeluaran
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- KETERANGAN --}}
                                            <td class="px-4 py-4">

                                                <p class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $transaction->description ?? 'Tidak ada keterangan' }}
                                                </p>

                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ $transaction->reference }}
                                                </p>

                                            </td>


                                            {{-- NOMINAL --}}
                                            <td class="px-4 py-4 whitespace-nowrap">

                                                @if($transaction->type === 'income')

                                                    <span
                                                        class="font-semibold text-green-600"
                                                    >
                                                        + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                                    </span>

                                                @else

                                                    <span
                                                        class="font-semibold text-red-600"
                                                    >
                                                        - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                                    </span>

                                                @endif

                                            </td>


                                            {{-- STATUS --}}
                                            <td class="px-4 py-4 whitespace-nowrap">

                                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>

                                            </td>


                                            {{-- AKSI --}}
                                            <td class="px-4 py-4 whitespace-nowrap text-right">

                                                <a
                                                    href="{{ route('transactions.show', $transaction) }}"
                                                    style="color: #2563eb !important;"
                                                    class="text-sm font-semibold hover:underline"
                                                >
                                                    Detail
                                                </a>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @else

                        <div class="mt-6 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-8 text-center">

                            <p class="text-gray-500 dark:text-gray-400">
                                Belum ada transaksi.
                            </p>

                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
                                Tambahkan pendapatan atau pengeluaran untuk melihat riwayat transaksi.
                            </p>

                            <div class="mt-4">

                                <a
                                    href="{{ route('transactions.create') }}"
                                    style="color: #ffffff !important; background-color: #2563eb !important;"
                                    class="inline-block px-5 py-2.5 rounded-lg font-semibold hover:opacity-90 transition"
                                >
                                    Tambah Transaksi
                                </a>

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>