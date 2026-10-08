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
                    Profile
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

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">


            {{-- HEADER CARD --}}
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
                    ACCOUNT SETTINGS
                </p>

                <h1
                    class="text-2xl font-bold mt-2"
                    style="color: #FFFFFF;"
                >
                    Profil Akun
                </h1>

                <p
                    class="text-sm mt-2"
                    style="color: #CBD5E1;"
                >
                    Kelola informasi pribadi, password, dan keamanan akun Anda.
                </p>

            </div>


            {{-- PROFILE SUMMARY --}}
            <div
                class="mb-6 rounded-2xl p-6 shadow-sm"
                style="
                    background-color: #FFFFFF;
                    border: 1px solid #E2E8F0;
                "
            >

                <div class="flex flex-col sm:flex-row sm:items-center gap-5">

                    <div
                        class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0"
                        style="
                            background-color: #EEF4FF;
                            color: #2563EB;
                        "
                    >

                        <svg
                            class="w-8 h-8"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                cx="12"
                                cy="8"
                                r="3.5"
                                stroke="currentColor"
                                stroke-width="1.7"
                            />

                            <path
                                d="M5 20C5.8 16.7 8.2 15 12 15C15.8 15 18.2 16.7 19 20"
                                stroke="currentColor"
                                stroke-width="1.7"
                                stroke-linecap="round"
                            />
                        </svg>

                    </div>


                    <div class="flex-1">

                        <p
                            class="text-xs font-semibold tracking-widest uppercase"
                            style="color: #D4A72C;"
                        >
                            AKUN FACESHIELD
                        </p>

                        <h2
                            class="text-xl font-bold mt-1"
                            style="color: #0F1B3D;"
                        >
                            {{ $user->name }}
                        </h2>

                        <p
                            class="text-sm mt-1"
                            style="color: #64748B;"
                        >
                            {{ $user->email }}
                        </p>

                    </div>


                    <div
                        class="flex items-center gap-3 rounded-xl px-4 py-3"
                        style="
                            background-color: #F0FDF4;
                            border: 1px solid #BBF7D0;
                        "
                    >

                        <div
                            class="w-9 h-9 rounded-lg flex items-center justify-center"
                            style="
                                background-color: #DCFCE7;
                                color: #16A34A;
                            "
                        >

                            <svg
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m5 12 4 4L19 6"
                                />
                            </svg>

                        </div>

                        <div>

                            <p
                                class="text-xs"
                                style="color: #64748B;"
                            >
                                Status Akun
                            </p>

                            <p
                                class="text-sm font-bold"
                                style="color: #15803D;"
                            >
                                Aktif
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- PROFILE INFORMATION --}}
            <div
                class="mb-6 overflow-hidden shadow-lg sm:rounded-2xl"
                style="
                    background-color: #FFFFFF;
                    border: 1px solid #E2E8F0;
                "
            >

                <div
                    class="p-6 sm:p-8"
                    style="color: #0F1B3D;"
                >

                    <div
                        class="mb-7 pb-5"
                        style="border-bottom: 1px solid #E8EDF5;"
                    >

                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 rounded-xl flex items-center justify-center"
                                style="
                                    background-color: #EEF4FF;
                                    color: #2563EB;
                                "
                            >

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        cx="12"
                                        cy="8"
                                        r="3.5"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                    />

                                    <path
                                        d="M5 20C5.8 16.7 8.2 15 12 15C15.8 15 18.2 16.7 19 20"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h3
                                    class="text-lg font-bold"
                                    style="color: #0F1B3D;"
                                >
                                    Informasi Profil
                                </h3>

                                <p
                                    class="text-sm mt-1"
                                    style="color: #64748B;"
                                >
                                    Perbarui nama dan alamat email akun Anda.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="max-w-2xl">

                        @include('profile.partials.update-profile-information-form')

                    </div>

                </div>

            </div>


            {{-- PASSWORD --}}
            <div
                class="mb-6 overflow-hidden shadow-lg sm:rounded-2xl"
                style="
                    background-color: #FFFFFF;
                    border: 1px solid #E2E8F0;
                "
            >

                <div
                    class="p-6 sm:p-8"
                    style="color: #0F1B3D;"
                >

                    <div
                        class="mb-7 pb-5"
                        style="border-bottom: 1px solid #E8EDF5;"
                    >

                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 rounded-xl flex items-center justify-center"
                                style="
                                    background-color: #EEF4FF;
                                    color: #2563EB;
                                "
                            >

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <rect
                                        x="5"
                                        y="10"
                                        width="14"
                                        height="10"
                                        rx="2"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                    />

                                    <path
                                        d="M8 10V7.5C8 5.3 9.8 3.5 12 3.5C14.2 3.5 16 5.3 16 7.5V10"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h3
                                    class="text-lg font-bold"
                                    style="color: #0F1B3D;"
                                >
                                    Keamanan Password
                                </h3>

                                <p
                                    class="text-sm mt-1"
                                    style="color: #64748B;"
                                >
                                    Perbarui password secara berkala untuk menjaga keamanan akun.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="max-w-2xl">

                        @include('profile.partials.update-password-form')

                    </div>

                </div>

            </div>


            {{-- DELETE ACCOUNT --}}
            <div
                class="mb-6 overflow-hidden shadow-lg sm:rounded-2xl"
                style="
                    background-color: #FFFFFF;
                    border: 1px solid #FECACA;
                "
            >

                <div
                    class="p-6 sm:p-8"
                    style="color: #0F1B3D;"
                >

                    <div
                        class="mb-7 pb-5"
                        style="border-bottom: 1px solid #FEE2E2;"
                    >

                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 rounded-xl flex items-center justify-center"
                                style="
                                    background-color: #FEF2F2;
                                    color: #DC2626;
                                "
                            >

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M5 7H19"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                    />

                                    <path
                                        d="M10 11V16"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                    />

                                    <path
                                        d="M14 11V16"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                    />

                                    <path
                                        d="M7 7L8 19H16L17 7"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linejoin="round"
                                    />

                                    <path
                                        d="M9 7L10 4H14L15 7"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linejoin="round"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h3
                                    class="text-lg font-bold"
                                    style="color: #B91C1C;"
                                >
                                    Hapus Akun
                                </h3>

                                <p
                                    class="text-sm mt-1"
                                    style="color: #64748B;"
                                >
                                    Menghapus akun akan menghilangkan data akun secara permanen.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="max-w-2xl">

                        @include('profile.partials.delete-user-form')

                    </div>

                </div>

            </div>


            {{-- FOOTER --}}
            <div class="text-center mt-6 pb-6">

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