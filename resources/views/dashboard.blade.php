<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>

    </x-slot>


    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- WELCOME --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold">
                        FaceShield Dashboard
                    </h3>

                    <p class="mt-2">
                        Selamat datang, {{ auth()->user()->name }}!
                    </p>

                    <p class="mt-2 text-sm text-green-600">
                        Two-Factor Authentication aktif.
                    </p>

                </div>

            </div>


            {{-- RINGKASAN KEUANGAN --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

                {{-- SALDO --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6">

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Saldo
                        </p>

                        <h3 class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
                            Rp {{ number_format($saldo, 0, ',', '.') }}
                        </h3>

                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Saldo tersedia
                        </p>

                    </div>

                </div>


                {{-- PENDAPATAN --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6">

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Total Pendapatan
                        </p>

                        <h3 class="mt-2 text-2xl font-bold text-green-600">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </h3>

                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Total uang masuk
                        </p>

                    </div>

                </div>


                {{-- PENGELUARAN --}}
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6">

                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Total Pengeluaran
                        </p>

                        <h3 class="mt-2 text-2xl font-bold text-red-600">
                            Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
                        </h3>

                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Total uang keluar
                        </p>

                    </div>

                </div>

            </div>


            {{-- AKTIVITAS --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex items-center justify-between">

                        <h3 class="text-lg font-semibold">
                            Aktivitas Terbaru
                        </h3>

                        {{-- RIWAYAT TRANSAKSI --}}
                        <a
                            href="{{ route('transactions.index') }}"
                            style="color: #2563eb !important; font-weight: 600 !important;"
                            class="text-sm hover:underline"
                        >
                            Lihat Semua
                        </a>

                    </div>


                    @if(count($activities) > 0)

                        <div class="mt-4 space-y-4">

                            @foreach($activities as $activity)

                                <div class="flex items-center justify-between border-b border-gray-200 dark:border-gray-700 pb-4">

                                    <div>

                                        <p class="font-medium">
                                            {{ $activity['title'] }}
                                        </p>

                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $activity['description'] }}
                                        </p>

                                    </div>

                                    <div class="text-right">

                                        <p class="font-semibold
                                            {{ $activity['type'] === 'income'
                                                ? 'text-green-600'
                                                : 'text-red-600' }}">

                                            {{ $activity['type'] === 'income' ? '+' : '-' }}
                                            Rp {{ number_format($activity['amount'], 0, ',', '.') }}

                                        </p>

                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $activity['date'] }}
                                        </p>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="mt-4 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center">

                            <p class="text-gray-500 dark:text-gray-400">
                                Belum ada aktivitas transaksi.
                            </p>

                            <p class="text-sm text-gray-400 dark:text-gray-500 mt-1">
                                Aktivitas pendapatan dan pengeluaran akan muncul di sini.
                            </p>

                        </div>

                    @endif

                </div>

            </div>


            {{-- MENU --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mt-6">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold">
                        Menu
                    </h3>


                    <div class="mt-4 flex flex-wrap gap-3">

                        {{-- TAMBAH TRANSAKSI --}}
                        <a
                            href="{{ route('transactions.create') }}"
                            style="color: #ffffff !important; background-color: #2563eb !important;"
                            class="inline-block px-5 py-2.5 font-semibold rounded-lg hover:opacity-90 transition"
                        >
                            Tambah Transaksi
                        </a>


                        {{-- RIWAYAT TRANSAKSI --}}
                        <a
                            href="{{ route('transactions.index') }}"
                            style="color: #ffffff !important; background-color: #4b5563 !important;"
                            class="inline-block px-5 py-2.5 font-semibold rounded-lg hover:opacity-90 transition"
                        >
                            Riwayat Transaksi
                        </a>


                        {{-- SECURITY SETTINGS --}}
                        <a
                            href="{{ route('security') }}"
                            style="color: #ffffff !important; background-color: #4f46e5 !important;"
                            class="inline-block px-5 py-2.5 font-semibold rounded-lg hover:opacity-90 transition"
                        >
                            Security Settings
                        </a>


                        {{-- PROFILE --}}
                        <a
                            href="{{ route('profile.edit') }}"
                            style="color: #ffffff !important; background-color: #4b5563 !important;"
                            class="inline-block px-5 py-2.5 font-semibold rounded-lg hover:opacity-90 transition"
                        >
                            Profile
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>