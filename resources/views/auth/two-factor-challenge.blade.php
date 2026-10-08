```blade
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Verifikasi Keamanan - FaceShield</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
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


                {{-- Center Security --}}
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
                                d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
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
                        Satu langkah lagi
                        <span class="text-[#D4A72C]">
                            untuk masuk.
                        </span>
                    </h1>

                    <p class="mt-5 text-slate-400 leading-relaxed max-w-md">
                        Verifikasi dua faktor membantu memastikan bahwa
                        hanya Anda yang dapat mengakses akun FaceShield.
                    </p>


                    {{-- Security Status --}}
                    <div class="mt-8 flex items-center gap-3">

                        <div class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-white/5 border border-white/10">

                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>

                            <span class="text-xs text-slate-300">
                                Verifikasi keamanan aktif
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
                    <div class="lg:hidden flex justify-center mb-8">

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
                    <div class="text-center mb-8">

                        {{-- OTP Icon --}}
                        <div class="mx-auto w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center mb-5">

                            <svg
                                class="w-8 h-8 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <rect
                                    x="4"
                                    y="4"
                                    width="16"
                                    height="16"
                                    rx="3"
                                    stroke-width="1.7"
                                />

                                <circle cx="9" cy="10" r="1" fill="currentColor"></circle>
                                <circle cx="15" cy="10" r="1" fill="currentColor"></circle>

                                <path
                                    stroke-linecap="round"
                                    stroke-width="1.7"
                                    d="M8 15h8"
                                />

                            </svg>

                        </div>


                        <div class="text-sm font-semibold text-blue-600 mb-2">
                            VERIFIKASI KEAMANAN
                        </div>

                        <h2 class="text-[30px] font-bold text-[#0F1B3D]">
                            Verifikasi OTP
                        </h2>

                        <p class="mt-3 text-sm text-slate-500 leading-relaxed">
                            Masukkan kode 6 digit dari aplikasi
                            <span class="font-semibold text-slate-700">
                                Authenticator
                            </span>
                            Anda untuk melanjutkan.
                        </p>

                    </div>


                    {{-- Error --}}
                    @if ($errors->any())

                        <div class="mb-5 rounded-xl bg-red-50 border border-red-100 px-4 py-3 text-sm text-red-600">

                            <div class="flex items-start gap-2">

                                <svg
                                    class="w-5 h-5 flex-shrink-0 mt-0.5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="9"
                                        stroke-width="1.7"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-width="1.7"
                                        d="M12 8v4"
                                    />

                                    <circle
                                        cx="12"
                                        cy="15.5"
                                        r=".7"
                                        fill="currentColor"
                                    />

                                </svg>

                                <span>
                                    {{ $errors->first() }}
                                </span>

                            </div>

                        </div>

                    @endif


                    {{-- Form --}}
                    <form
                        method="POST"
                        action="{{ route('two-factor.login.store') }}"
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
                                type="text"
                                name="code"
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                maxlength="6"
                                pattern="[0-9]{6}"
                                required
                                autofocus
                                placeholder="000000"
                                class="mt-3 w-full h-14 rounded-xl border border-slate-200 bg-slate-50 text-center text-2xl tracking-[0.5em] font-semibold text-[#0F1B3D] outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            >

                            @if ($errors->get('code'))

                                <p class="mt-2 text-sm text-red-500 text-center">
                                    {{ $errors->first('code') }}
                                </p>

                            @endif

                        </div>


                        {{-- Verify Button --}}
                        <button
                            type="submit"
                            class="w-full h-12 mt-7 rounded-xl bg-[#0F1B3D] hover:bg-blue-700 text-white text-sm font-semibold transition duration-200 shadow-lg shadow-blue-900/10"
                        >
                            Verifikasi OTP
                        </button>

                    </form>


                    {{-- Information --}}
                    <div class="mt-7 p-4 rounded-xl bg-slate-50 border border-slate-100">

                        <div class="flex gap-3">

                            <svg
                                class="w-5 h-5 text-[#D4A72C] flex-shrink-0"
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

                            <p class="text-xs text-slate-500 leading-relaxed">
                                Jangan bagikan kode OTP Anda kepada siapa pun.
                                FaceShield tidak pernah meminta kode keamanan
                                melalui telepon atau pesan.
                            </p>

                        </div>

                    </div>


                    {{-- Security --}}
                    <div class="mt-7 flex justify-center items-center gap-2 text-xs text-slate-400">

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

                        Koneksi dan data Anda terlindungi dengan aman

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
```