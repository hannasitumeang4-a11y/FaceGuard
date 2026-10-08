<x-app-layout>

    <style>
        nav {
            display: none !important;
        }

        header {
            display: none !important;
        }
    </style>

    {{-- HEADER --}}
    <div
        class="border-b"
        style="
            background-color: #FFFFFF;
            border-color: #E2E8F0;
        "
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">

            <div>
                <p
                    class="text-xs font-bold tracking-widest uppercase"
                    style="color: #D4A72C;"
                >
                    FACESHIELD
                </p>

                <h2
                    class="font-semibold text-xl mt-1"
                    style="color: #0F1B3D;"
                >
                    Riwayat Transaksi
                </h2>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-sm font-semibold px-4 py-2 rounded-lg transition"
                    style="
                        color: #0F1B3D;
                        background-color: #F5F7FB;
                        border: 1px solid #E2E8F0;
                    "
                >
                    ← Kembali ke Dashboard
                </a>
            </div>

        </div>
    </div>

    {{-- CONTENT --}}
    <div
        class="py-12 min-h-screen"
        style="
            background: linear-gradient(
                180deg,
                #F5F7FB 0%,
                #EEF3FA 100%
            );
        "
    >
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- HERO CARD --}}
            <div
                class="mb-6 rounded-2xl p-6 shadow-sm"
                style="
                    background: linear-gradient(
                        135deg,
                        #0F1B3D 0%,
                        #1D3B82 100%
                    );
                    border-left: 5px solid #D4A72C;
                "
            >
                <p
                    class="text-xs font-semibold tracking-widest uppercase"
                    style="color: #D4A72C;"
                >
                    FINANCIAL ACTIVITY
                </p>

                <h1
                    class="text-2xl font-bold mt-2"
                    style="color: #FFFFFF;"
                >
                    Riwayat Transaksi
                </h1>

                <p
                    class="text-sm mt-2"
                    style="color: #CBD5E1;"
                >
                    Lihat seluruh aktivitas transaksi keuangan Anda dengan mudah dan aman.
                </p>
            </div>

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))
                <div
                    class="mb-6 rounded-xl p-4"
                    style="
                        background-color: #F0FDF4;
                        border: 1px solid #BBF7D0;
                    "
                >
                    <p
                        class="text-sm font-semibold"
                        style="color: #15803D;"
                    >
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            {{-- TRANSACTION CARD --}}
            <div
                class="overflow-hidden shadow-lg sm:rounded-2xl"
                style="
                    background-color: #FFFFFF;
                    border: 1px solid #E2E8F0;
                "
            >
                <div class="p-6 sm:p-8">

                    {{-- TITLE --}}
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                        <div>
                            <h3
                                class="text-lg font-bold"
                                style="color: #0F1B3D;"
                            >
                                Daftar Transaksi
                            </h3>

                            <p
                                class="text-sm mt-1"
                                style="color: #64748B;"
                            >
                                Riwayat aktivitas keuangan Anda.
                            </p>
                        </div>

                        <a
                            href="{{ route('transactions.create') }}"
                            class="inline-flex justify-center items-center px-4 py-2.5 rounded-xl text-sm font-bold text-white transition"
                            style="
                                background: linear-gradient(
                                    135deg,
                                    #2563EB 0%,
                                    #1D4ED8 100%
                                );
                            "
                        >
                            + Tambah Transaksi
                        </a>

                    </div>

                    {{-- TRANSACTIONS --}}
                    @if ($transactions->count() > 0)

                        <div class="space-y-4">

                            @foreach ($transactions as $transaction)

                                <div
                                    class="rounded-2xl p-5 transition"
                                    style="
                                        background-color: #F8FAFC;
                                        border: 1px solid #E2E8F0;
                                    "
                                >

                                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                                        {{-- LEFT --}}
                                        <div class="flex items-start gap-4">

                                            <div
                                                class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0"
                                                style="
                                                    background-color:
                                                    {{ $transaction->type === 'income' ? '#DCFCE7' : '#FEE2E2' }};
                                                    color:
                                                    {{ $transaction->type === 'income' ? '#15803D' : '#DC2626' }};
                                                "
                                            >
                                                {{ $transaction->type === 'income' ? '↓' : '↑' }}
                                            </div>

                                            <div>

                                                <div class="flex flex-wrap items-center gap-2">

                                                    <p
                                                        class="font-bold"
                                                        style="color: #0F1B3D;"
                                                    >
                                                        {{ $transaction->description ?: 'Transaksi' }}
                                                    </p>

                                                    <span
                                                        class="text-xs font-semibold px-2.5 py-1 rounded-full"
                                                        style="
                                                            background-color:
                                                            {{ $transaction->type === 'income' ? '#DCFCE7' : '#FEE2E2' }};
                                                            color:
                                                            {{ $transaction->type === 'income' ? '#15803D' : '#B91C1C' }};
                                                        "
                                                    >
                                                        {{ $transaction->type === 'income' ? 'Pendapatan' : 'Pengeluaran' }}
                                                    </span>

                                                </div>

                                                <div
                                                    class="text-xs mt-2"
                                                    style="color: #64748B;"
                                                >
                                                    {{ $transaction->created_at->format('d M Y') }}
                                                    •
                                                    {{ $transaction->created_at->format('H:i') }}
                                                </div>

                                                <div
                                                    class="text-xs mt-1"
                                                    style="color: #94A3B8;"
                                                >
                                                    Ref: {{ $transaction->reference }}
                                                </div>

                                            </div>

                                        </div>

                                        {{-- RIGHT --}}
                                        <div class="flex items-center justify-between lg:justify-end gap-5">

                                            <div class="text-left lg:text-right">

                                                <p
                                                    class="text-lg font-bold"
                                                    style="
                                                        color:
                                                        {{ $transaction->type === 'income' ? '#15803D' : '#DC2626' }};
                                                    "
                                                >
                                                    {{ $transaction->type === 'income' ? '+' : '-' }}
                                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                                </p>

                                                <span
                                                    class="inline-block text-xs font-semibold px-2.5 py-1 rounded-full mt-1"
                                                    style="
                                                        background-color: #F1F5F9;
                                                        color: #475569;
                                                    "
                                                >
                                                    {{ ucfirst($transaction->status) }}
                                                </span>

                                            </div>

                                            <a
                                                href="{{ route('transactions.show', $transaction) }}"
                                                class="inline-flex items-center justify-center px-4 py-2 rounded-lg text-xs font-semibold transition"
                                                style="
                                                    color: #1D4ED8;
                                                    background-color: #EFF6FF;
                                                    border: 1px solid #BFDBFE;
                                                "
                                            >
                                                Detail
                                            </a>

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        {{-- EMPTY STATE --}}
                        <div
                            class="text-center py-12 rounded-2xl"
                            style="
                                background-color: #F8FAFC;
                                border: 1px dashed #CBD5E1;
                            "
                        >

                            <div
                                class="w-14 h-14 mx-auto rounded-full flex items-center justify-center text-2xl mb-4"
                                style="
                                    background-color: #EFF6FF;
                                    color: #2563EB;
                                "
                            >
                                ₿
                            </div>

                            <h3
                                class="text-lg font-bold"
                                style="color: #0F1B3D;"
                            >
                                Belum Ada Transaksi
                            </h3>

                            <p
                                class="text-sm mt-2 mb-5"
                                style="color: #64748B;"
                            >
                                Belum ada aktivitas transaksi yang tercatat.
                            </p>

                            <a
                                href="{{ route('transactions.create') }}"
                                class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-bold text-white"
                                style="
                                    background: linear-gradient(
                                        135deg,
                                        #2563EB 0%,
                                        #1D4ED8 100%
                                    );
                                "
                            >
                                + Tambah Transaksi
                            </a>

                        </div>

                    @endif

                </div>
            </div>

            {{-- FOOTER --}}
            <div class="text-center mt-6">
                <p
                    class="text-xs"
                    style="color: #94A3B8;"
                >
                    🛡 Dilindungi oleh keamanan FaceShield
                    <span style="color: #CBD5E1;">•</span>
                    Digital Banking Security
                </p>
            </div>

        </div>
    </div>

</x-app-layout>