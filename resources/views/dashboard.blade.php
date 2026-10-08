<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>FaceShield - Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        body {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system,
                BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .navbar-shadow {
            box-shadow: 0 2px 15px rgba(15, 27, 61, 0.06);
        }

        .card-shadow {
            box-shadow: 0 8px 30px rgba(15, 27, 61, 0.07);
        }

        .hero-shadow {
            box-shadow: 0 15px 45px rgba(15, 27, 61, 0.14);
        }

    </style>

</head>


<body class="bg-[#F5F7FB] text-[#0F1B3D]">


    <!-- ===================================================== -->
    <!-- FIXED NAVBAR -->
    <!-- ===================================================== -->

    <nav class="fixed top-0 left-0 right-0 z-50
                bg-white border-b border-gray-100 navbar-shadow">

        <div class="max-w-7xl mx-auto px-6 lg:px-10">

            <div class="h-20 flex items-center justify-between">


                <!-- LOGO -->

                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3">

                    <div class="w-11 h-11 rounded-xl bg-[#0F1B3D]
                                flex items-center justify-center">

                        <svg width="25"
                             height="25"
                             viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">

                            <path
                                d="M12 3L19 7V12C19 16.5 16.1 19.8 12 21C7.9 19.8 5 16.5 5 12V7L12 3Z"
                                stroke="white"
                                stroke-width="1.7"
                                stroke-linejoin="round"/>

                            <path
                                d="M9 12L11 14L15 10"
                                stroke="#D4A72C"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>

                        </svg>

                    </div>


                    <div>

                        <div class="font-bold text-[#0F1B3D] text-lg">
                            FaceShield
                        </div>

                        <div class="text-xs text-gray-400">
                            Digital Banking
                        </div>

                    </div>

                </a>


                <!-- NAVIGATION -->

                <div class="flex items-center gap-7">


                    <!-- DASHBOARD -->

                    <a href="{{ route('dashboard') }}"
                       class="hidden sm:flex items-center gap-2
                              text-sm font-semibold text-[#0F1B3D]
                              relative h-20">

                        <span>
                            Dashboard
                        </span>

                        <span class="absolute bottom-0 left-0 right-0
                                     h-0.5 bg-[#2563EB]">
                        </span>

                    </a>


                    <div class="hidden sm:block h-8 w-px bg-gray-200"></div>


                    <!-- USER -->

<div class="relative" x-data="{ open: false }">

    <button
        type="button"
        @click="open = !open"
        class="flex items-center gap-3 focus:outline-none"
    >

        <div class="w-9 h-9 rounded-full bg-[#EAF0FF]
                    flex items-center justify-center">

            <svg width="18"
                 height="18"
                 viewBox="0 0 24 24"
                 fill="none"
                 xmlns="http://www.w3.org/2000/svg">

                <circle
                    cx="12"
                    cy="8"
                    r="3.5"
                    stroke="#2563EB"
                    stroke-width="1.7"/>

                <path
                    d="M5 20C5.8 16.7 8.2 15 12 15C15.8 15 18.2 16.7 19 20"
                    stroke="#2563EB"
                    stroke-width="1.7"
                    stroke-linecap="round"/>

            </svg>

        </div>

        <span class="hidden sm:block text-sm font-semibold text-[#0F1B3D]">
            {{ auth()->user()->name }}
        </span>

        <svg
            class="w-4 h-4 text-gray-500 transition-transform"
            :class="{ 'rotate-180': open }"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
            />
        </svg>

    </button>


                        <!-- DROPDOWN -->

                        <div
                            x-show="open"
                            @click.outside="open = false"
                            x-transition
                            class="absolute right-0 top-full mt-3 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-50"
                            style="display: none;"
                        >

                            <a
                                href="{{ route('profile.edit') }}"
                                class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 rounded-t-xl"
                            >
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-gray-50 rounded-b-xl"
                                >
                                    Log Out
                                </button>

                            </form>

                        </div>

                    </div>
                    
                </div>

            </div>

        </div>

    </nav>



    <!-- ===================================================== -->
    <!-- MAIN -->
    <!-- ===================================================== -->

    <main class="pt-20 min-h-screen">


        <!-- ================================================= -->
        <!-- PAGE HEADER -->
        <!-- ================================================= -->

        <section class="bg-white border-b border-gray-100">

            <div class="max-w-7xl mx-auto px-6 lg:px-10 py-9">

                <p class="text-xs font-bold tracking-[0.2em]
                          text-[#2563EB] uppercase">

                    Overview

                </p>


                <h1 class="mt-2 text-3xl md:text-4xl font-bold
                           text-[#0F1B3D]">

                    Dashboard

                </h1>


                <p class="mt-2 text-gray-500">

                    Kelola aktivitas dan transaksi keuangan Anda
                    dengan mudah.

                </p>

            </div>

        </section>



        <!-- ================================================= -->
        <!-- CONTENT -->
        <!-- ================================================= -->

        <div class="max-w-7xl mx-auto px-6 lg:px-10 py-10">


            <!-- ================================================= -->
            <!-- WELCOME HERO -->
            <!-- ================================================= -->

            <div class="relative overflow-hidden rounded-[28px]
                        bg-[#0F1B3D] hero-shadow mb-8">


                <!-- DECORATION -->

                <div class="absolute -right-20 -top-28
                            w-80 h-80 rounded-full
                            border border-white/10">
                </div>


                <div class="absolute -right-10 -bottom-32
                            w-72 h-72 rounded-full
                            bg-[#2563EB]/20">
                </div>


                <div class="absolute right-48 -bottom-24
                            w-52 h-52 rounded-full
                            bg-[#D4A72C]/5">
                </div>



                <div class="relative p-8 md:p-10">


                    <div class="flex flex-col md:flex-row
                                md:items-center
                                md:justify-between gap-8">


                        <!-- WELCOME -->

                        <div>

                            <div class="flex items-center gap-2 mb-4">

                                <div class="w-2 h-2 rounded-full
                                            bg-[#D4A72C]">
                                </div>

                                <span class="text-xs uppercase
                                             tracking-[0.18em]
                                             text-[#D4A72C]
                                             font-semibold">

                                    FaceShield Digital Banking

                                </span>

                            </div>


                            <h2 class="text-2xl md:text-3xl
                                       font-bold text-white">

                                Selamat datang,
                                {{ auth()->user()->name }}!

                            </h2>


                            <p class="mt-3 text-white/60
                                      text-sm md:text-base">

                                Kelola transaksi dan keamanan akun
                                Anda dalam satu tempat.

                            </p>


                            <!-- SECURITY STATUS -->

                            <div class="mt-6 inline-flex items-center
                                        gap-3 px-4 py-3 rounded-xl
                                        bg-green-400/10
                                        border border-green-400/20">

                                <div class="w-2.5 h-2.5 rounded-full
                                            bg-green-400">
                                </div>

                                <span class="text-sm font-medium
                                             text-green-300">

                                    Two-Factor Authentication aktif.

                                </span>

                            </div>

                        </div>


                        <!-- SECURITY ICON -->

                        <div class="hidden md:flex w-24 h-24
                                    rounded-3xl
                                    bg-white/10
                                    border border-white/10
                                    items-center justify-center">

                            <svg width="48"
                                 height="48"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 xmlns="http://www.w3.org/2000/svg">

                                <path
                                    d="M12 3L19 7V12C19 16.5 16.1 19.8 12 21C7.9 19.8 5 16.5 5 12V7L12 3Z"
                                    stroke="white"
                                    stroke-width="1.4"
                                    stroke-linejoin="round"/>

                                <path
                                    d="M9 12L11 14L15 10"
                                    stroke="#D4A72C"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"/>

                            </svg>

                        </div>

                    </div>

                </div>

            </div>



            <!-- ================================================= -->
            <!-- FINANCIAL SUMMARY -->
            <!-- ================================================= -->

            <div class="mb-5">

                <div class="flex items-center gap-2">

                    <div class="w-1.5 h-6 rounded-full bg-[#2563EB]">
                    </div>

                    <h2 class="text-xl font-bold text-[#0F1B3D]">

                        Ringkasan Keuangan

                    </h2>

                </div>

            </div>


            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">


                <!-- SALDO -->

                <div class="bg-white rounded-[24px]
                            border border-gray-100
                            card-shadow overflow-hidden">

                    <div class="p-7">


                        <div class="flex items-start
                                    justify-between">

                            <div>

                                <p class="text-sm font-medium
                                          text-gray-500">

                                    Saldo

                                </p>


                                <h3 class="mt-3 text-2xl
                                           md:text-3xl font-bold
                                           text-[#0F1B3D]">

                                    Rp {{ number_format($saldo, 0, ',', '.') }}

                                </h3>

                            </div>


                            <div class="w-12 h-12 rounded-2xl
                                        bg-[#EAF0FF]
                                        flex items-center justify-center">

                                <svg width="23"
                                     height="23"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     xmlns="http://www.w3.org/2000/svg">

                                    <rect
                                        x="3"
                                        y="6"
                                        width="18"
                                        height="13"
                                        rx="2"
                                        stroke="#2563EB"
                                        stroke-width="1.7"/>

                                    <path
                                        d="M3 10H21"
                                        stroke="#2563EB"
                                        stroke-width="1.7"/>

                                    <circle
                                        cx="16"
                                        cy="14.5"
                                        r="1.5"
                                        fill="#2563EB"/>

                                </svg>

                            </div>

                        </div>


                        <div class="mt-6 flex items-center gap-2
                                    text-xs text-gray-400">

                            <span class="w-1.5 h-1.5 rounded-full
                                         bg-[#2563EB]">
                            </span>

                            Saldo tersedia

                        </div>

                    </div>

                </div>



                <!-- PENDAPATAN -->

                <div class="bg-white rounded-[24px]
                            border border-gray-100
                            card-shadow overflow-hidden">

                    <div class="p-7">


                        <div class="flex items-start
                                    justify-between">

                            <div>

                                <p class="text-sm font-medium
                                          text-gray-500">

                                    Total Pendapatan

                                </p>


                                <h3 class="mt-3 text-2xl
                                           md:text-3xl font-bold
                                           text-green-600">

                                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}

                                </h3>

                            </div>


                            <div class="w-12 h-12 rounded-2xl
                                        bg-green-50
                                        flex items-center justify-center">

                                <svg width="23"
                                     height="23"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     xmlns="http://www.w3.org/2000/svg">

                                    <path
                                        d="M12 19V5"
                                        stroke="#16A34A"
                                        stroke-width="1.7"
                                        stroke-linecap="round"/>

                                    <path
                                        d="M7 10L12 5L17 10"
                                        stroke="#16A34A"
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"/>

                                    <path
                                        d="M5 20H19"
                                        stroke="#16A34A"
                                        stroke-width="1.7"
                                        stroke-linecap="round"/>

                                </svg>

                            </div>

                        </div>


                        <div class="mt-6 flex items-center gap-2
                                    text-xs text-gray-400">

                            <span class="w-1.5 h-1.5 rounded-full
                                         bg-green-500">
                            </span>

                            Total uang masuk

                        </div>

                    </div>

                </div>



                <!-- PENGELUARAN -->

                <div class="bg-white rounded-[24px]
                            border border-gray-100
                            card-shadow overflow-hidden">

                    <div class="p-7">


                        <div class="flex items-start
                                    justify-between">

                            <div>

                                <p class="text-sm font-medium
                                          text-gray-500">

                                    Total Pengeluaran

                                </p>


                                <h3 class="mt-3 text-2xl
                                           md:text-3xl font-bold
                                           text-red-600">

                                    Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}

                                </h3>

                            </div>


                            <div class="w-12 h-12 rounded-2xl
                                        bg-red-50
                                        flex items-center justify-center">

                                <svg width="23"
                                     height="23"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     xmlns="http://www.w3.org/2000/svg">

                                    <path
                                        d="M12 5V19"
                                        stroke="#DC2626"
                                        stroke-width="1.7"
                                        stroke-linecap="round"/>

                                    <path
                                        d="M7 14L12 19L17 14"
                                        stroke="#DC2626"
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"/>

                                    <path
                                        d="M5 4H19"
                                        stroke="#DC2626"
                                        stroke-width="1.7"
                                        stroke-linecap="round"/>

                                </svg>

                            </div>

                        </div>


                        <div class="mt-6 flex items-center gap-2
                                    text-xs text-gray-400">

                            <span class="w-1.5 h-1.5 rounded-full
                                         bg-red-500">
                            </span>

                            Total uang keluar

                        </div>

                    </div>

                </div>

            </div>



            <!-- ================================================= -->
            <!-- RECENT ACTIVITY -->
            <!-- ================================================= -->

            <div class="bg-white rounded-[24px]
                        border border-gray-100
                        card-shadow overflow-hidden mb-8">


                <!-- HEADER -->

                <div class="px-7 py-6
                            border-b border-gray-100
                            flex items-center
                            justify-between">

                    <div class="flex items-center gap-4">

                        <div class="w-12 h-12 rounded-2xl
                                    bg-[#EAF0FF]
                                    flex items-center justify-center">

                            <svg width="22"
                                 height="22"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 xmlns="http://www.w3.org/2000/svg">

                                <path
                                    d="M3 12C3 12 6 6 12 6C18 6 21 12 21 12C21 12 18 18 12 18C6 18 3 12 3 12Z"
                                    stroke="#2563EB"
                                    stroke-width="1.7"/>

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="2.5"
                                    stroke="#2563EB"
                                    stroke-width="1.7"/>

                            </svg>

                        </div>


                        <div>

                            <h3 class="font-bold text-[#0F1B3D]">

                                Aktivitas Terbaru

                            </h3>

                            <p class="text-sm text-gray-500 mt-1">

                                Riwayat transaksi terbaru Anda.

                            </p>

                        </div>

                    </div>


                    <a href="{{ route('transactions.index') }}"
                       class="hidden sm:flex items-center gap-2
                              text-sm font-semibold
                              text-[#2563EB]
                              hover:text-[#0F1B3D]
                              transition">

                        Lihat Semua

                        <span>→</span>

                    </a>

                </div>



                <!-- ACTIVITY LIST -->

                <div class="p-7">


                    @if(count($activities) > 0)

                        <div class="space-y-2">

                            @foreach($activities as $activity)

                                <div class="flex items-center
                                            justify-between
                                            gap-5
                                            p-4 rounded-2xl
                                            hover:bg-[#F8FAFF]
                                            transition">


                                    <div class="flex items-center gap-4">


                                        <!-- ICON -->

                                        <div class="w-11 h-11 rounded-xl
                                                    flex items-center
                                                    justify-center
                                                    {{ $activity['type'] === 'income'
                                                        ? 'bg-green-50'
                                                        : 'bg-red-50' }}">

                                            @if($activity['type'] === 'income')

                                                <svg width="20"
                                                     height="20"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">

                                                    <path
                                                        d="M12 19V5"
                                                        stroke="#16A34A"
                                                        stroke-width="1.7"
                                                        stroke-linecap="round"/>

                                                    <path
                                                        d="M7 10L12 5L17 10"
                                                        stroke="#16A34A"
                                                        stroke-width="1.7"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"/>

                                                </svg>

                                            @else

                                                <svg width="20"
                                                     height="20"
                                                     viewBox="0 0 24 24"
                                                     fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">

                                                    <path
                                                        d="M12 5V19"
                                                        stroke="#DC2626"
                                                        stroke-width="1.7"
                                                        stroke-linecap="round"/>

                                                    <path
                                                        d="M7 14L12 19L17 14"
                                                        stroke="#DC2626"
                                                        stroke-width="1.7"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"/>

                                                </svg>

                                            @endif

                                        </div>


                                        <!-- DESCRIPTION -->

                                        <div>

                                            <p class="font-semibold
                                                      text-[#0F1B3D]">

                                                {{ $activity['title'] }}

                                            </p>

                                            <p class="text-sm text-gray-500
                                                      mt-1">

                                                {{ $activity['description'] }}

                                            </p>

                                        </div>

                                    </div>


                                    <!-- AMOUNT -->

                                    <div class="text-right
                                                shrink-0">

                                        <p class="font-bold
                                                  {{ $activity['type'] === 'income'
                                                      ? 'text-green-600'
                                                      : 'text-red-600' }}">

                                            {{ $activity['type'] === 'income'
                                                ? '+'
                                                : '-' }}

                                            Rp {{ number_format($activity['amount'], 0, ',', '.') }}

                                        </p>


                                        <p class="text-xs text-gray-400 mt-1">

                                            {{ $activity['date'] }}

                                        </p>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="rounded-2xl
                                    border border-dashed
                                    border-gray-200
                                    bg-[#FAFBFD]
                                    p-10 text-center">


                            <div class="mx-auto w-14 h-14 rounded-2xl
                                        bg-[#EAF0FF]
                                        flex items-center
                                        justify-center">

                                <svg width="25"
                                     height="25"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     xmlns="http://www.w3.org/2000/svg">

                                    <path
                                        d="M6 4H18C19.1 4 20 4.9 20 6V18C20 19.1 19.1 20 18 20H6C4.9 20 4 19.1 4 18V6C4 4.9 4.9 4 6 4Z"
                                        stroke="#2563EB"
                                        stroke-width="1.5"/>

                                    <path
                                        d="M8 9H16"
                                        stroke="#2563EB"
                                        stroke-width="1.5"
                                        stroke-linecap="round"/>

                                    <path
                                        d="M8 13H14"
                                        stroke="#2563EB"
                                        stroke-width="1.5"
                                        stroke-linecap="round"/>

                                </svg>

                            </div>


                            <p class="mt-4 font-semibold
                                      text-[#0F1B3D]">

                                Belum ada aktivitas transaksi.

                            </p>


                            <p class="text-sm text-gray-400 mt-1">

                                Aktivitas pendapatan dan pengeluaran
                                akan muncul di sini.

                            </p>

                        </div>

                    @endif

                </div>

            </div>



            <!-- ================================================= -->
            <!-- QUICK MENU -->
            <!-- ================================================= -->

            <div class="mb-4">

                <div class="flex items-center gap-2">

                    <div class="w-1.5 h-6 rounded-full bg-[#D4A72C]">
                    </div>

                    <h2 class="text-xl font-bold text-[#0F1B3D]">

                        Menu Utama

                    </h2>

                </div>

                <p class="mt-2 ml-4 text-sm text-gray-500">

                    Akses cepat ke fitur FaceShield.

                </p>

            </div>



            <div class="grid grid-cols-2 md:grid-cols-3
                        lg:grid-cols-6 gap-4 mb-10">


                <!-- TAMBAH TRANSAKSI -->

                <a href="{{ route('transactions.create') }}"
                   class="group bg-white rounded-2xl
                          border border-gray-100
                          card-shadow p-5
                          hover:-translate-y-1
                          hover:shadow-xl
                          transition duration-200">

                    <div class="w-11 h-11 rounded-xl
                                bg-[#EAF0FF]
                                flex items-center
                                justify-center
                                group-hover:bg-[#2563EB]
                                transition">

                        <svg width="21"
                             height="21"
                             viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">

                            <path
                                d="M12 5V19"
                                stroke="#2563EB"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                class="group-hover:stroke-white"/>

                            <path
                                d="M5 12H19"
                                stroke="#2563EB"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                class="group-hover:stroke-white"/>

                        </svg>

                    </div>


                    <p class="mt-4 text-sm font-semibold
                              text-[#0F1B3D]">

                        Tambah Transaksi

                    </p>

                    <p class="mt-1 text-xs text-gray-400">

                        Catat transaksi

                    </p>

                </a>



                <!-- TRANSFER -->

                <a href="{{ route('transfer.create') }}"
                   class="group bg-white rounded-2xl
                          border border-gray-100
                          card-shadow p-5
                          hover:-translate-y-1
                          hover:shadow-xl
                          transition duration-200">

                    <div class="w-11 h-11 rounded-xl
                                bg-green-50
                                flex items-center
                                justify-center
                                group-hover:bg-green-600
                                transition">

                        <svg width="21"
                             height="21"
                             viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">

                            <path
                                d="M7 7H17"
                                stroke="#16A34A"
                                stroke-width="1.7"
                                stroke-linecap="round"/>

                            <path
                                d="M13 3L17 7L13 11"
                                stroke="#16A34A"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>

                            <path
                                d="M17 17H7"
                                stroke="#16A34A"
                                stroke-width="1.7"
                                stroke-linecap="round"/>

                            <path
                                d="M11 13L7 17L11 21"
                                stroke="#16A34A"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>

                        </svg>

                    </div>


                    <p class="mt-4 text-sm font-semibold
                              text-[#0F1B3D]">

                        Transfer

                    </p>

                    <p class="mt-1 text-xs text-gray-400">

                        Kirim dana

                    </p>

                </a>



                <!-- TARIK SALDO -->

                <a href="{{ route('withdraw.create') }}"
                   class="group bg-white rounded-2xl
                          border border-gray-100
                          card-shadow p-5
                          hover:-translate-y-1
                          hover:shadow-xl
                          transition duration-200">

                    <div class="w-11 h-11 rounded-xl
                                bg-red-50
                                flex items-center
                                justify-center
                                group-hover:bg-red-600
                                transition">

                        <svg width="21"
                             height="21"
                             viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">

                            <path
                                d="M12 19V5"
                                stroke="#DC2626"
                                stroke-width="1.7"
                                stroke-linecap="round"/>

                            <path
                                d="M7 10L12 5L17 10"
                                stroke="#DC2626"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>

                            <path
                                d="M5 20H19"
                                stroke="#DC2626"
                                stroke-width="1.7"
                                stroke-linecap="round"/>

                        </svg>

                    </div>


                    <p class="mt-4 text-sm font-semibold
                              text-[#0F1B3D]">

                        Tarik Saldo

                    </p>

                    <p class="mt-1 text-xs text-gray-400">

                        Tarik dana

                    </p>

                </a>



                <!-- RIWAYAT -->

                <a href="{{ route('transactions.index') }}"
                   class="group bg-white rounded-2xl
                          border border-gray-100
                          card-shadow p-5
                          hover:-translate-y-1
                          hover:shadow-xl
                          transition duration-200">

                    <div class="w-11 h-11 rounded-xl
                                bg-purple-50
                                flex items-center
                                justify-center
                                group-hover:bg-purple-600
                                transition">

                        <svg width="21"
                             height="21"
                             viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">

                            <circle
                                cx="12"
                                cy="12"
                                r="8"
                                stroke="#7C3AED"
                                stroke-width="1.7"/>

                            <path
                                d="M12 8V12L15 14"
                                stroke="#7C3AED"
                                stroke-width="1.7"
                                stroke-linecap="round"/>

                        </svg>

                    </div>


                    <p class="mt-4 text-sm font-semibold
                              text-[#0F1B3D]">

                        Riwayat

                    </p>

                    <p class="mt-1 text-xs text-gray-400">

                        Lihat transaksi

                    </p>

                </a>



                <!-- SECURITY -->

                <a href="{{ route('security') }}"
                   class="group bg-white rounded-2xl
                          border border-gray-100
                          card-shadow p-5
                          hover:-translate-y-1
                          hover:shadow-xl
                          transition duration-200">

                    <div class="w-11 h-11 rounded-xl
                                bg-[#EEF4FF]
                                flex items-center
                                justify-center
                                group-hover:bg-[#2563EB]
                                transition">

                        <svg width="21"
                             height="21"
                             viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">

                            <path
                                d="M12 3L19 7V12C19 16.5 16.1 19.8 12 21C7.9 19.8 5 16.5 5 12V7L12 3Z"
                                stroke="#2563EB"
                                stroke-width="1.7"
                                stroke-linejoin="round"/>

                            <path
                                d="M9 12L11 14L15 10"
                                stroke="#2563EB"
                                stroke-width="1.7"
                                stroke-linecap="round"
                                stroke-linejoin="round"/>

                        </svg>

                    </div>


                    <p class="mt-4 text-sm font-semibold
                              text-[#0F1B3D]">

                        Security

                    </p>

                    <p class="mt-1 text-xs text-gray-400">

                        Keamanan akun

                    </p>

                </a>



                <!-- PROFILE -->

                <a href="{{ route('profile.edit') }}"
                   class="group bg-white rounded-2xl
                          border border-gray-100
                          card-shadow p-5
                          hover:-translate-y-1
                          hover:shadow-xl
                          transition duration-200">

                    <div class="w-11 h-11 rounded-xl
                                bg-gray-100
                                flex items-center
                                justify-center
                                group-hover:bg-[#0F1B3D]
                                transition">

                        <svg width="21"
                             height="21"
                             viewBox="0 0 24 24"
                             fill="none"
                             xmlns="http://www.w3.org/2000/svg">

                            <circle
                                cx="12"
                                cy="8"
                                r="3.5"
                                stroke="#475569"
                                stroke-width="1.7"/>

                            <path
                                d="M5 20C5.8 16.7 8.2 15 12 15C15.8 15 18.2 16.7 19 20"
                                stroke="#475569"
                                stroke-width="1.7"
                                stroke-linecap="round"/>

                        </svg>

                    </div>


                    <p class="mt-4 text-sm font-semibold
                              text-[#0F1B3D]">

                        Profile

                    </p>

                    <p class="mt-1 text-xs text-gray-400">

                        Pengaturan akun

                    </p>

                </a>

            </div>



            <!-- ================================================= -->
            <!-- SECURITY FOOTER -->
            <!-- ================================================= -->

            <div class="flex flex-col sm:flex-row
                        items-center justify-center gap-2
                        text-xs text-gray-400 pb-10">

                <div class="flex items-center gap-2">

                    <svg width="17"
                         height="17"
                         viewBox="0 0 24 24"
                         fill="none"
                         xmlns="http://www.w3.org/2000/svg">

                        <path
                            d="M12 3L19 7V12C19 16.5 16.1 19.8 12 21C7.9 19.8 5 16.5 5 12V7L12 3Z"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linejoin="round"/>

                    </svg>

                    <span>
                        Dilindungi oleh keamanan FaceShield
                    </span>

                </div>

                <span class="hidden sm:block">
                    •
                </span>

                <span>
                    Digital Banking Security
                </span>

            </div>

        </div>

    </main>


</body>

</html>