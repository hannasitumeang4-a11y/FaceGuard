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
                    Tarik Saldo
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
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

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
                    Tarik Saldo
                </h1>

                <p
                    class="text-sm mt-2"
                    style="color: #CBD5E1;"
                >
                    Lakukan penarikan saldo dengan mudah dan aman.
                </p>
            </div>

            {{-- FORM CARD --}}
            <div
                class="overflow-hidden shadow-lg sm:rounded-2xl"
                style="
                    background-color: #FFFFFF;
                    border: 1px solid #E2E8F0;
                "
            >
                <div
                    class="p-6 sm:p-8"
                    style="color: #0F1B3D;"
                >

                    {{-- TITLE --}}
                    <div class="mb-6">
                        <h3
                            class="text-lg font-bold"
                            style="color: #0F1B3D;"
                        >
                            Detail Penarikan
                        </h3>

                        <p
                            class="text-sm mt-1"
                            style="color: #64748B;"
                        >
                            Masukkan jumlah saldo yang ingin ditarik.
                        </p>
                    </div>

                    {{-- ERROR --}}
                    @if ($errors->any())
                        <div
                            class="mb-6 rounded-xl p-4"
                            style="
                                background-color: #FEF2F2;
                                border: 1px solid #FECACA;
                            "
                        >
                            <p
                                class="text-sm font-semibold mb-2"
                                style="color: #B91C1C;"
                            >
                                Terjadi kesalahan:
                            </p>

                            <ul class="list-disc list-inside text-sm" style="color: #DC2626;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORM --}}
                    <form method="POST" action="{{ route('withdraw.store') }}">
                        @csrf

                        {{-- AMOUNT --}}
                        <div class="mb-6">
                            <label
                                for="amount"
                                class="block text-sm font-semibold mb-2"
                                style="color: #0F1B3D;"
                            >
                                Jumlah Penarikan
                            </label>

                            <div class="relative">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold"
                                    style="color: #64748B;"
                                >
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    name="amount"
                                    id="amount"
                                    value="{{ old('amount') }}"
                                    min="1"
                                    required
                                    class="w-full rounded-xl py-3 pl-12 pr-4 focus:outline-none focus:ring-2"
                                    style="
                                        border: 1px solid #CBD5E1;
                                        color: #0F1B3D;
                                        background-color: #FFFFFF;
                                    "
                                    placeholder="Masukkan jumlah"
                                >
                            </div>
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="mb-6">
                            <label
                                for="description"
                                class="block text-sm font-semibold mb-2"
                                style="color: #0F1B3D;"
                            >
                                Keterangan
                                <span
                                    class="font-normal"
                                    style="color: #94A3B8;"
                                >
                                    (Opsional)
                                </span>
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                rows="4"
                                class="w-full rounded-xl px-4 py-3 focus:outline-none focus:ring-2"
                                style="
                                    border: 1px solid #CBD5E1;
                                    color: #0F1B3D;
                                    background-color: #FFFFFF;
                                "
                                placeholder="Contoh: Penarikan untuk kebutuhan pribadi"
                            >{{ old('description') }}</textarea>
                        </div>

                        {{-- INFO --}}
                        <div
                            class="rounded-xl p-4 mb-6"
                            style="
                                background-color: #F5F7FB;
                                border: 1px solid #E2E8F0;
                            "
                        >
                            <div class="flex items-start gap-3">
                                <span
                                    class="text-lg"
                                    style="color: #D4A72C;"
                                >
                                    🛡
                                </span>

                                <div>
                                    <p
                                        class="text-sm font-semibold"
                                        style="color: #0F1B3D;"
                                    >
                                        Penarikan Aman
                                    </p>

                                    <p
                                        class="text-xs mt-1"
                                        style="color: #64748B;"
                                    >
                                        Pastikan jumlah penarikan sudah benar
                                        sebelum melanjutkan transaksi.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="flex flex-col sm:flex-row gap-3">

                            <button
                                type="submit"
                                class="flex-1 inline-flex justify-center items-center px-5 py-3 rounded-xl text-sm font-bold text-white transition"
                                style="
                                    background: linear-gradient(
                                        135deg,
                                        #2563EB 0%,
                                        #1D4ED8 100%
                                    );
                                "
                            >
                                Tarik Saldo
                            </button>

                            <a
                                href="{{ route('dashboard') }}"
                                class="flex-1 inline-flex justify-center items-center px-5 py-3 rounded-xl text-sm font-semibold transition"
                                style="
                                    color: #0F1B3D;
                                    background-color: #F5F7FB;
                                    border: 1px solid #E2E8F0;
                                "
                            >
                                Kembali
                            </a>

                        </div>

                    </form>

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