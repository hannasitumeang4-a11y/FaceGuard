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
                    Security Settings
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
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

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
                    ACCOUNT SECURITY
                </p>

                <h1
                    class="text-2xl font-bold mt-2"
                    style="color: #FFFFFF;"
                >
                    Security Settings
                </h1>

                <p
                    class="text-sm mt-2"
                    style="color: #CBD5E1;"
                >
                    Kelola keamanan akun FaceShield Anda dengan aman.
                </p>
            </div>

            {{-- STATUS --}}
            @if (session('status') === 'two-factor-authentication-enabled')
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
                        Two-factor authentication berhasil diaktifkan.
                    </p>
                </div>
            @endif

            @if (session('status') === 'two-factor-authentication-confirmed')
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
                        Two-factor authentication berhasil dikonfirmasi.
                    </p>
                </div>
            @endif

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

                    <ul
                        class="list-disc list-inside text-sm"
                        style="color: #DC2626;"
                    >
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- SECURITY CARD --}}
            <div
                class="overflow-hidden shadow-lg sm:rounded-2xl"
                style="
                    background-color: #FFFFFF;
                    border: 1px solid #E2E8F0;
                "
            >
                <div class="p-6 sm:p-8">

                    {{-- TITLE --}}
                    <div class="mb-6">
                        <div class="flex items-center gap-3">

                            <div
                                class="w-11 h-11 rounded-xl flex items-center justify-center"
                                style="
                                    background-color: #EFF6FF;
                                    color: #2563EB;
                                "
                            >
                                🛡
                            </div>

                            <div>
                                <h3
                                    class="text-lg font-bold"
                                    style="color: #0F1B3D;"
                                >
                                    Two-Factor Authentication
                                </h3>

                                <p
                                    class="text-sm mt-1"
                                    style="color: #64748B;"
                                >
                                    Tambahkan lapisan keamanan tambahan pada akun Anda.
                                </p>
                            </div>

                        </div>
                    </div>

                    {{-- 2FA NOT ENABLED --}}
                    @if (!auth()->user()->two_factor_secret)

                        <div
                            class="rounded-xl p-5 mb-6"
                            style="
                                background-color: #F8FAFC;
                                border: 1px solid #E2E8F0;
                            "
                        >
                            <p
                                class="text-sm font-semibold"
                                style="color: #0F1B3D;"
                            >
                                Status Keamanan
                            </p>

                            <div class="flex items-center gap-2 mt-2">
                                <span
                                    class="w-2.5 h-2.5 rounded-full"
                                    style="background-color: #EF4444;"
                                ></span>

                                <span
                                    class="text-sm"
                                    style="color: #64748B;"
                                >
                                    Two-factor authentication belum aktif.
                                </span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('two-factor.enable') }}">
                            @csrf

                            <button
                                type="submit"
                                class="w-full inline-flex justify-center items-center px-5 py-3 rounded-xl text-sm font-bold text-white transition"
                                style="
                                    background: linear-gradient(
                                        135deg,
                                        #2563EB 0%,
                                        #1D4ED8 100%
                                    );
                                "
                            >
                                Aktifkan Two-Factor Authentication
                            </button>
                        </form>

                    @else

                        {{-- 2FA ENABLED --}}
                        <div
                            class="rounded-xl p-5 mb-6"
                            style="
                                background-color: #F0FDF4;
                                border: 1px solid #BBF7D0;
                            "
                        >
                            <div class="flex items-center gap-3">

                                <div
                                    class="w-10 h-10 rounded-full flex items-center justify-center"
                                    style="
                                        background-color: #DCFCE7;
                                        color: #15803D;
                                    "
                                >
                                    ✓
                                </div>

                                <div>
                                    <p
                                        class="text-sm font-bold"
                                        style="color: #166534;"
                                    >
                                        Two-factor authentication aktif
                                    </p>

                                    <p
                                        class="text-xs mt-1"
                                        style="color: #15803D;"
                                    >
                                        Akun Anda mendapatkan perlindungan tambahan.
                                    </p>
                                </div>

                            </div>
                        </div>

                        {{-- CONFIRMATION --}}
                        @if (!auth()->user()->two_factor_confirmed_at)

                            <div
                                class="rounded-xl p-5 mb-6"
                                style="
                                    background-color: #F8FAFC;
                                    border: 1px solid #E2E8F0;
                                "
                            >

                                <h4
                                    class="text-base font-bold"
                                    style="color: #0F1B3D;"
                                >
                                    Konfirmasi Authenticator
                                </h4>

                                <p
                                    class="text-sm mt-2"
                                    style="color: #64748B;"
                                >
                                    Scan QR Code menggunakan aplikasi authenticator,
                                    kemudian masukkan kode 6 digit untuk mengonfirmasi.
                                </p>

                                <div
                                    class="mt-5 flex justify-center p-4 rounded-xl"
                                    style="
                                        background-color: #FFFFFF;
                                        border: 1px solid #E2E8F0;
                                    "
                                >
                                    {!! auth()->user()->twoFactorQrCodeSvg() !!}
                                </div>

                                <form
                                    method="POST"
                                    action="{{ route('two-factor.confirm') }}"
                                    class="mt-5"
                                >
                                    @csrf

                                    <label
                                        for="code"
                                        class="block text-sm font-semibold mb-2"
                                        style="color: #0F1B3D;"
                                    >
                                        Kode Authenticator
                                    </label>

                                    <input
                                        type="text"
                                        name="code"
                                        id="code"
                                        inputmode="numeric"
                                        maxlength="6"
                                        autocomplete="one-time-code"
                                        required
                                        class="w-full rounded-xl px-4 py-3 text-center tracking-widest text-lg font-bold focus:outline-none focus:ring-2"
                                        style="
                                            border: 1px solid #CBD5E1;
                                            color: #0F1B3D;
                                            background-color: #FFFFFF;
                                        "
                                        placeholder="000000"
                                    >

                                    <button
                                        type="submit"
                                        class="w-full mt-4 inline-flex justify-center items-center px-5 py-3 rounded-xl text-sm font-bold text-white transition"
                                        style="
                                            background: linear-gradient(
                                                135deg,
                                                #2563EB 0%,
                                                #1D4ED8 100%
                                            );
                                        "
                                    >
                                        Konfirmasi Kode
                                    </button>

                                </form>

                            </div>

                        @else

                            {{-- RECOVERY CODES --}}
                            <div
                                class="rounded-xl p-5"
                                style="
                                    background-color: #F8FAFC;
                                    border: 1px solid #E2E8F0;
                                "
                            >

                                <div class="flex items-start gap-3">

                                    <div
                                        class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                                        style="
                                            background-color: #FFF7E6;
                                            color: #D4A72C;
                                        "
                                    >
                                        🔑
                                    </div>

                                    <div>
                                        <h4
                                            class="text-base font-bold"
                                            style="color: #0F1B3D;"
                                        >
                                            Recovery Codes
                                        </h4>

                                        <p
                                            class="text-sm mt-1"
                                            style="color: #64748B;"
                                        >
                                            Gunakan recovery codes jika Anda kehilangan
                                            akses ke aplikasi authenticator.
                                        </p>
                                    </div>

                                </div>

                                <a
                                    href="{{ route('recovery-codes') }}"
                                    class="mt-5 w-full inline-flex justify-center items-center px-5 py-3 rounded-xl text-sm font-bold transition"
                                    style="
                                        color: #0F1B3D;
                                        background-color: #F5F7FB;
                                        border: 1px solid #E2E8F0;
                                    "
                                >
                                    Lihat Recovery Codes
                                </a>

                            </div>

                        @endif

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