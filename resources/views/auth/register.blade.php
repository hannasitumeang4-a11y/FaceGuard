<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register - FaceShield</title>

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
                                d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4z"
                            />

                            <circle
                                cx="12"
                                cy="11"
                                r="2.5"
                                stroke-width="1.6"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-width="1.6"
                                d="M8.5 16c.9-1.2 2.1-1.8 3.5-1.8s2.6.6 3.5 1.8"
                            />

                        </svg>

                    </div>


                    <h1 class="text-[38px] leading-tight font-bold text-white max-w-md">

                        Mulai perjalanan

                        <span class="text-[#D4A72C]">
                            banking yang aman.
                        </span>

                    </h1>


                    <p class="mt-5 text-slate-400 leading-relaxed max-w-md">

                        Buat akun FaceShield dan nikmati pengalaman
                        perbankan digital dengan keamanan berbasis
                        verifikasi wajah.

                    </p>


                    {{-- Security --}}
                    <div class="mt-8 flex items-center gap-3">

                        <div class="flex items-center gap-2 px-4 py-2.5 rounded-full bg-white/5 border border-white/10">

                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>

                            <span class="text-xs text-slate-300">
                                Registrasi aman & terlindungi
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
                    <div class="mb-7">

                        <div class="text-sm font-semibold text-blue-600 mb-2">
                            BUAT AKUN BARU
                        </div>

                        <h2 class="text-[32px] font-bold text-[#0F1B3D]">
                            Buka Rekening
                        </h2>

                        <p class="mt-2 text-sm text-slate-500">
                            Lengkapi data Anda untuk membuat akun FaceShield.
                        </p>

                    </div>


                    {{-- Register Form --}}
                    <form method="POST" action="{{ route('register') }}">

                        @csrf


                        {{-- Name --}}
                        <div>

                            <label
                                for="name"
                                class="block text-sm font-semibold text-slate-700"
                            >
                                Nama Lengkap
                            </label>

                            <div class="relative mt-2">

                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">

                                    <svg
                                        class="w-5 h-5 text-slate-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <circle
                                            cx="12"
                                            cy="8"
                                            r="3"
                                            stroke-width="1.7"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-width="1.7"
                                            d="M5 20c0-3.3 3.1-6 7-6s7 2.7 7 6"
                                        />

                                    </svg>

                                </div>


                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    placeholder="Masukkan nama lengkap"
                                    class="w-full h-12 pl-12 pr-4 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >

                            </div>


                            @if ($errors->get('name'))

                                <p class="mt-2 text-sm text-red-500">
                                    {{ $errors->first('name') }}
                                </p>

                            @endif

                        </div>


                        {{-- Email --}}
                        <div class="mt-4">

                            <label
                                for="email"
                                class="block text-sm font-semibold text-slate-700"
                            >
                                Email
                            </label>

                            <div class="relative mt-2">

                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">

                                    <svg
                                        class="w-5 h-5 text-slate-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M4 6h16v12H4z"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M4 7l8 6 8-6"
                                        />

                                    </svg>

                                </div>


                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="username"
                                    placeholder="nama@email.com"
                                    class="w-full h-12 pl-12 pr-4 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >

                            </div>


                            @if ($errors->get('email'))

                                <p class="mt-2 text-sm text-red-500">
                                    {{ $errors->first('email') }}
                                </p>

                            @endif

                        </div>


                        {{-- Password --}}
                        <div class="mt-4">

                            <label
                                for="password"
                                class="block text-sm font-semibold text-slate-700"
                            >
                                Password
                            </label>

                            <div class="relative mt-2">

                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">

                                    <svg
                                        class="w-5 h-5 text-slate-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M6 10V8a6 6 0 0112 0v2"
                                        />

                                        <rect
                                            x="4"
                                            y="10"
                                            width="16"
                                            height="10"
                                            rx="2"
                                            stroke-width="1.7"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-width="1.7"
                                            d="M12 14v2"
                                        />

                                    </svg>

                                </div>


                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Buat password"
                                    class="w-full h-12 pl-12 pr-4 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >

                            </div>


                            @if ($errors->get('password'))

                                <p class="mt-2 text-sm text-red-500">
                                    {{ $errors->first('password') }}
                                </p>

                            @endif

                        </div>


                        {{-- Confirm Password --}}
                        <div class="mt-4">

                            <label
                                for="password_confirmation"
                                class="block text-sm font-semibold text-slate-700"
                            >
                                Konfirmasi Password
                            </label>

                            <div class="relative mt-2">

                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">

                                    <svg
                                        class="w-5 h-5 text-slate-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M6 10V8a6 6 0 0112 0v2"
                                        />

                                        <rect
                                            x="4"
                                            y="10"
                                            width="16"
                                            height="10"
                                            rx="2"
                                            stroke-width="1.7"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-width="1.7"
                                            d="M12 14v2"
                                        />

                                    </svg>

                                </div>


                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Ulangi password"
                                    class="w-full h-12 pl-12 pr-4 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >

                            </div>


                            @if ($errors->get('password_confirmation'))

                                <p class="mt-2 text-sm text-red-500">
                                    {{ $errors->first('password_confirmation') }}
                                </p>

                            @endif

                        </div>


                        {{-- Security Question --}}
                        <div class="mt-4">

                            <label
                                for="security_question"
                                class="block text-sm font-semibold text-slate-700"
                            >
                                Pertanyaan Keamanan
                            </label>

                            <div class="relative mt-2">

                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">

                                    <svg
                                        class="w-5 h-5 text-slate-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M8 10h8M8 14h5"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.7"
                                            d="M5 4h14a2 2 0 012 2v9a2 2 0 01-2 2h-7l-4 4v-4H5a2 2 0 01-2-2V6a2 2 0 012-2z"
                                        />

                                    </svg>

                                </div>


                                <input
                                    id="security_question"
                                    type="text"
                                    name="security_question"
                                    value="{{ old('security_question') }}"
                                    required
                                    placeholder="Contoh: Siapa nama hewan peliharaan saya?"
                                    class="w-full h-12 pl-12 pr-4 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >

                            </div>


                            @if ($errors->get('security_question'))

                                <p class="mt-2 text-sm text-red-500">
                                    {{ $errors->first('security_question') }}
                                </p>

                            @endif

                        </div>


                        {{-- Security Answer --}}
                        <div class="mt-4">

                            <label
                                for="security_answer"
                                class="block text-sm font-semibold text-slate-700"
                            >
                                Jawaban Keamanan
                            </label>

                            <div class="relative mt-2">

                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">

                                    <svg
                                        class="w-5 h-5 text-slate-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="8"
                                            stroke-width="1.7"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            stroke-width="1.7"
                                            d="M9.5 9.5a2.5 2.5 0 115 0c0 1.8-2.5 2-2.5 3.5"
                                        />

                                        <circle
                                            cx="12"
                                            cy="16"
                                            r=".7"
                                            fill="currentColor"
                                            stroke="none"
                                        />

                                    </svg>

                                </div>


                                <input
                                    id="security_answer"
                                    type="text"
                                    name="security_answer"
                                    value="{{ old('security_answer') }}"
                                    required
                                    placeholder="Masukkan jawaban Anda"
                                    class="w-full h-12 pl-12 pr-4 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-700 outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                                >

                            </div>


                            @if ($errors->get('security_answer'))

                                <p class="mt-2 text-sm text-red-500">
                                    {{ $errors->first('security_answer') }}
                                </p>

                            @endif

                        </div>


                        {{-- Register Button --}}
                        <button
                            type="submit"
                            class="w-full h-12 mt-6 rounded-xl bg-[#0F1B3D] hover:bg-blue-700 text-white text-sm font-semibold transition duration-200 shadow-lg shadow-blue-900/10"
                        >
                            Buat Akun
                        </button>

                    </form>


                    {{-- Login --}}
                    <div class="mt-6 text-center">

                        <p class="text-sm text-slate-500">
                            Sudah memiliki akun?
                        </p>

                        <a
                            href="{{ route('login') }}"
                            class="inline-block mt-1 text-sm font-bold text-blue-600 hover:text-[#0F1B3D]"
                        >
                            Masuk ke Akun →
                        </a>

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

                        Data Anda terlindungi dengan aman

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>
</html>