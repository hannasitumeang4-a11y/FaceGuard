```blade
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Setup MFA - FaceShield</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system,
                BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[#0B1533]">

    <div class="min-h-screen flex items-center justify-center px-5 py-10 relative overflow-hidden">

        {{-- Background decoration --}}
        <div class="absolute top-[-180px] left-[-180px] w-[450px] h-[450px] rounded-full bg-blue-600/10 blur-3xl"></div>

        <div class="absolute bottom-[-220px] right-[-180px] w-[500px] h-[500px] rounded-full bg-blue-500/10 blur-3xl"></div>


        {{-- Main Card --}}
        <div class="relative z-10 w-full max-w-[1050px] min-h-[620px] bg-white rounded-[28px] shadow-2xl overflow-hidden grid lg:grid-cols-2">


            {{-- LEFT SIDE --}}
            <div class="hidden lg:flex bg-[#0F1B3D] relative p-12 flex-col justify-between overflow-hidden">

                {{-- Decorative circles --}}
                <div class="absolute top-0 right-0 w-72 h-72 border border-white/5 rounded-full translate-x-1/2 -translate-y-1/2"></div>

                <div class="absolute bottom-[-100px] left-[-100px] w-72 h-72 border border-white/5 rounded-full"></div>


                {{-- Logo --}}
                <div class="relative z-10 flex items-center gap-3">

                    <div class="w-11 h-11 rounded-xl bg-white flex items-center justify-center">

                        <svg
                            class="w-6 h-6 text-[#0F1B3D]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M9.5 12l1.7 1.7L15 10"
                            />
                        </svg>

                    </div>

                    <div>
                        <div class="text-white font-bold text-lg">
                            FaceShield
                        </div>

                        <div class="text-slate-400 text-xs">
                            Digital Banking
                        </div>
                    </div>

                </div>


                {{-- Center --}}
                <div class="relative z-10">

                    <div class="w-20 h-20 rounded-2xl bg-blue-500/10 border border-blue-400/20 flex items-center justify-center mb-7">

                        <svg
                            class="w-10 h-10 text-[#D4A72C]"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.6"
                                d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7.5-4.5-7.5-9V7l7.5-4z"
                            />

                            <rect
                                x="8"
                                y="9"
                                width="8"
                                height="7"
                                rx="1.5"
                                stroke-width="1.6"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.6"
                                d="M10 9V7a2 2 0 014 0v2"
                            />

                        </svg>

                    </div>


                    <h1 class="text-[38px] leading-tight font-bold text-white max-w-md">
                        Lindungi akun Anda
                        <span class="text-[#D4A72C]">
                            dengan keamanan berlapis.
                        </span>
                    </h1>

                    <p class="mt-5 text-slate-400 leading-relaxed max-w-md">
                        Aktifkan Two-Factor Authentication untuk menambahkan
                        lapisan keamanan tambahan pada akun FaceShield Anda.
                    </p>


                    {{-- Security --}}
                    <div class="mt-8 flex items-center gap-3">

                        <div class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-white/5 border border-white/10">

                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>

                            <span class="text-xs text-slate-300">
                                Perlindungan akun aktif
                            </span>

                        </div>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="relative z-10 text-xs text-slate-500">
                    © {{ date('Y') }} FaceShield
                </div>

            </div>


            {{-- RIGHT SIDE --}}
            <div class="flex items-center justify-center px-7 py-10 sm:px-14 lg:px-16">

                <div class="w-full max-w-[390px]">


                    {{-- Mobile Logo --}}
                    <div class="lg:hidden flex justify-center mb-7">

                        <div class="w-14 h-14 rounded-2xl bg-[#0F1B3D] flex items-center justify-center">

                            <svg
                                class="w-7 h-7 text-[#D4A72C]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M9.5 12l1.7 1.7L15 10"
                                />
                            </svg>

                        </div>

                    </div>


                    {{-- Header --}}
                    <div class="text-center mb-7">

                        {{-- Authenticator Icon --}}
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center mb-5">

                            <svg
                                class="w-8 h-8 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <rect
                                    x="5"
                                    y="3"
                                    width="14"
                                    height="18"
                                    rx="2"
                                    stroke-width="1.7"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-width="1.7"
                                    d="M9 7h6"
                                />

                                <circle
                                    cx="9"
                                    cy="12"
                                    r="1"
                                    fill="currentColor"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="1"
                                    fill="currentColor"
                                />

                                <circle
                                    cx="15"
                                    cy="12"
                                    r="1"
                                    fill="currentColor"
                                />

                                <circle
                                    cx="9"
                                    cy="16"
                                    r="1"
                                    fill="currentColor"
                                />

                                <circle
                                    cx="12"
                                    cy="16"
                                    r="1"
                                    fill="currentColor"
                                />

                                <circle
                                    cx="15"
                                    cy="16"
                                    r="1"
                                    fill="currentColor"
                                />

                            </svg>

                        </div>


                        <div class="text-sm font-semibold text-blue-600 mb-2">
                            PENGATURAN KEAMANAN
                        </div>

                        <h2 class="text-[30px] font-bold text-[#0F1B3D]">
                            Setup MFA
                        </h2>

                        <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                            Scan QR Code menggunakan
                            <span class="font-semibold text-slate-700">
                                Google Authenticator
                            </span>
                            untuk mengaktifkan keamanan dua faktor.
                        </p>

                    </div>


                    {{-- QR CODE --}}
                    <div class="flex justify-center mb-6">

                        <div class="p-4 rounded-2xl border border-slate-200 bg-white shadow-sm">

                            {!! $user->twoFactorQrCodeSvg() !!}

                        </div>

                    </div>


                    {{-- OTP Information --}}
                    <div class="rounded-xl bg-slate-50 border border-slate-100 px-4 py-3 mb-5">

                        <p class="text-xs text-slate-500 text-center leading-relaxed">

                            Setelah QR Code berhasil dipindai,
                            masukkan kode OTP 6 digit dari
                            aplikasi Authenticator Anda.

                        </p>

                    </div>


                    {{-- Form --}}
                    <form
                        method="POST"
                        action="/user/confirmed-two-factor-authentication"
                    >

                        @csrf


                        {{-- OTP --}}
                        <div>

                            <label
                                for="code"
                                class="block text-sm font-semibold text-slate-700 text-center"
                            >
                                Kode OTP
                            </label>

                            <input
                                id="code"
                                name="code"
                                type="text"
                                inputmode="numeric"
                                maxlength="6"
                                autocomplete="one-time-code"
                                required
                                autofocus
                                placeholder="000000"
                                class="mt-3 w-full h-14 rounded-xl border border-slate-200 bg-slate-50 text-center text-2xl tracking-[0.5em] font-semibold text-[#0F1B3D] outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            >

                        </div>


                        {{-- Error --}}
                        @if ($errors->any())

                            <div class="mt-3 rounded-xl bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-600">

                                @foreach ($errors->all() as $error)

                                    <p>{{ $error }}</p>

                                @endforeach

                            </div>

                        @endif


                        {{-- Button --}}
                        <button
                            type="submit"
                            class="w-full h-12 mt-6 rounded-xl bg-[#0F1B3D] hover:bg-blue-700 text-white text-sm font-semibold transition duration-200 shadow-lg shadow-blue-900/10"
                        >
                            Verifikasi & Aktifkan
                        </button>

                    </form>


                    {{-- Information --}}
                    <div class="mt-6 flex items-center justify-center gap-2 text-xs text-slate-400">

                        <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.7"
                                d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                            />
                        </svg>

                        Akun Anda akan lebih aman dengan MFA

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
```