```blade
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>FaceShield | Digital Banking</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        }
    </script>

</head>


<body class="min-h-screen bg-[#F7F9FC] text-[#0F1B3D]">


    <!-- ========================================================= -->
    <!-- FIXED NAVBAR -->
    <!-- ========================================================= -->

    <nav
        class="fixed top-0 left-0 right-0 z-50
               bg-white/90 backdrop-blur-xl
               border-b border-slate-200/80
               shadow-sm"
    >

        <div
            class="max-w-7xl
                   mx-auto
                   px-6
                   lg:px-10
                   h-[78px]
                   flex
                   items-center
                   justify-between"
        >


            <!-- ================================================= -->
            <!-- LEFT TOP TEXT -->
            <!-- ================================================= -->

            <a
                href="/"
                class="flex items-center gap-3"
            >

                <!-- Small Shield -->

                <div
                    class="w-9 h-9
                           rounded-lg
                           bg-[#0F1B3D]
                           flex
                           items-center
                           justify-center"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 text-white"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3l7 4v5c0 4.5-3 7.8-7 9-4-1.2-7-4.5-7-9V7l7-4z"
                        />

                    </svg>

                </div>


                <!-- TEXT -->

                <div class="hidden sm:block">

                    <p
                        class="text-sm
                               font-bold
                               tracking-wide
                               text-[#0F1B3D]"
                    >
                        FaceShield
                    </p>

                    <p
                        class="text-[11px]
                               text-slate-500
                               tracking-wide"
                    >
                        Digital Banking
                    </p>

                </div>

            </a>



            <!-- ================================================= -->
            <!-- RIGHT BUTTONS -->
            <!-- ================================================= -->

            <div
                class="flex
                       items-center
                       gap-2
                       sm:gap-3"
            >

                <a
                    href="{{ route('login') }}"
                    class="px-4
                           sm:px-5
                           py-2.5
                           text-sm
                           font-semibold
                           text-[#0F1B3D]
                           hover:text-blue-600
                           transition"
                >
                    Login
                </a>


                <a
                    href="{{ route('register') }}"
                    class="px-4
                           sm:px-5
                           py-2.5
                           rounded-lg
                           bg-[#0F1B3D]
                           hover:bg-[#172653]
                           text-white
                           text-sm
                           font-semibold
                           shadow-md
                           shadow-slate-300
                           transition"
                >
                    Buka Rekening
                </a>

            </div>

        </div>

    </nav>



    <!-- ========================================================= -->
    <!-- BACKGROUND DECORATION -->
    <!-- ========================================================= -->

    <div class="fixed inset-0 -z-10 overflow-hidden">

        <div
            class="absolute
                   top-[-180px]
                   left-1/2
                   -translate-x-1/2
                   w-[600px]
                   h-[600px]
                   rounded-full
                   bg-blue-100/50
                   blur-3xl"
        ></div>

        <div
            class="absolute
                   bottom-[-250px]
                   right-[-150px]
                   w-[500px]
                   h-[500px]
                   rounded-full
                   bg-indigo-100/40
                   blur-3xl"
        ></div>

    </div>



    <!-- ========================================================= -->
    <!-- MAIN -->
    <!-- ========================================================= -->

    <main class="pt-[78px]">


        <!-- ===================================================== -->
        <!-- HERO -->
        <!-- ===================================================== -->

        <section
            class="relative
                   max-w-5xl
                   mx-auto
                   px-6
                   pt-14
                   pb-20
                   text-center"
        >


            <!-- ================================================= -->
            <!-- LARGE LOGO -->
            <!-- ================================================= -->

            <div
                class="flex
                       flex-col
                       items-center"
            >

                <!-- Logo Container -->

                <div
                    class="relative
                           w-32
                           h-32
                           rounded-[32px]
                           bg-white
                           border
                           border-slate-200
                           shadow-xl
                           shadow-slate-200/80
                           flex
                           items-center
                           justify-center"
                >

                    <div
                        class="absolute
                               inset-[-10px]
                               rounded-[40px]
                               border
                               border-blue-100"
                    ></div>


                    <div
                        class="w-24
                               h-24
                               rounded-[26px]
                               bg-gradient-to-br
                               from-[#0F1B3D]
                               to-[#2563EB]
                               flex
                               items-center
                               justify-center
                               shadow-xl"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-14 h-14 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.4"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 3l7 4v5c0 4.5-3 7.8-7 9-4-1.2-7-4.5-7-9V7l7-4z"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12l2 2 4-4"
                            />

                        </svg>

                    </div>

                </div>



                <!-- BRAND -->

                <div class="mt-7">

                    <h1
                        class="text-4xl
                               sm:text-5xl
                               font-bold
                               tracking-tight
                               text-[#0F1B3D]"
                    >
                        FaceShield
                    </h1>


                    <div
                        class="mt-3
                               flex
                               items-center
                               justify-center
                               gap-3"
                    >

                        <span
                            class="w-12
                                   h-px
                                   bg-[#D4A72C]"
                        ></span>

                        <p
                            class="text-sm
                                   uppercase
                                   tracking-[0.25em]
                                   font-medium
                                   text-slate-500"
                        >
                            Digital Banking
                        </p>

                        <span
                            class="w-12
                                   h-px
                                   bg-[#D4A72C]"
                        ></span>

                    </div>

                </div>

            </div>



            <!-- ================================================= -->
            <!-- HERO TEXT -->
            <!-- ================================================= -->

            <div class="mt-12">

                <p
                    class="inline-flex
                           items-center
                           gap-2
                           px-4
                           py-2
                           rounded-full
                           bg-blue-50
                           border
                           border-blue-100
                           text-blue-700
                           text-sm
                           font-medium"
                >

                    <span
                        class="w-2
                               h-2
                               rounded-full
                               bg-green-500"
                    ></span>

                    Perbankan Digital yang Aman

                </p>


                <h2
                    class="mt-6
                           text-4xl
                           sm:text-5xl
                           lg:text-6xl
                           font-bold
                           leading-tight
                           tracking-tight"
                >

                    Transaksi lebih mudah,

                    <span
                        class="block
                               text-blue-600"
                    >
                        keamanan lebih kuat.
                    </span>

                </h2>


                <p
                    class="mt-6
                           mx-auto
                           max-w-2xl
                           text-lg
                           leading-8
                           text-slate-500"
                >

                    Kelola rekening dan transaksi Anda dengan nyaman
                    melalui layanan perbankan digital yang dilengkapi
                    teknologi verifikasi wajah untuk menjaga keamanan
                    setiap akses.

                </p>

            </div>



            <!-- ================================================= -->
            <!-- BUTTONS -->
            <!-- ================================================= -->

            <div
                class="mt-9
                       flex
                       flex-col
                       sm:flex-row
                       justify-center
                       gap-4"
            >

                <a
                    href="{{ route('login') }}"
                    class="group
                           inline-flex
                           items-center
                           justify-center
                           gap-3
                           px-8
                           py-4
                           rounded-xl
                           bg-[#0F1B3D]
                           hover:bg-[#172653]
                           text-white
                           font-semibold
                           shadow-xl
                           shadow-slate-300
                           transition"
                >

                    Masuk ke Akun

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5
                               group-hover:translate-x-1
                               transition"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13 7l5 5m0 0l-5 5m5-5H6"
                        />

                    </svg>

                </a>


                <a
                    href="{{ route('register') }}"
                    class="inline-flex
                           items-center
                           justify-center
                           px-8
                           py-4
                           rounded-xl
                           bg-white
                           border
                           border-slate-300
                           hover:border-blue-400
                           hover:bg-blue-50
                           text-[#0F1B3D]
                           font-semibold
                           transition"
                >

                    Buka Rekening

                </a>

            </div>



            <!-- ================================================= -->
            <!-- TRUST -->
            <!-- ================================================= -->

            <div
                class="mt-8
                       flex
                       flex-wrap
                       justify-center
                       items-center
                       gap-x-8
                       gap-y-3
                       text-sm
                       text-slate-500"
            >

                <div class="flex items-center gap-2">

                    <span
                        class="w-5
                               h-5
                               rounded-full
                               bg-green-100
                               text-green-600
                               flex
                               items-center
                               justify-center
                               text-xs
                               font-bold"
                    >
                        ✓
                    </span>

                    Transaksi Aman

                </div>


                <div class="flex items-center gap-2">

                    <span
                        class="w-5
                               h-5
                               rounded-full
                               bg-green-100
                               text-green-600
                               flex
                               items-center
                               justify-center
                               text-xs
                               font-bold"
                    >
                        ✓
                    </span>

                    Verifikasi Wajah

                </div>


                <div class="flex items-center gap-2">

                    <span
                        class="w-5
                               h-5
                               rounded-full
                               bg-green-100
                               text-green-600
                               flex
                               items-center
                               justify-center
                               text-xs
                               font-bold"
                    >
                        ✓
                    </span>

                    Layanan 24/7

                </div>

            </div>

        </section>



        <!-- ========================================================= -->
        <!-- BANKING SERVICES -->
        <!-- ========================================================= -->

        <section
            class="bg-white
                   border-y
                   border-slate-200"
        >

            <div
                class="max-w-6xl
                       mx-auto
                       px-6
                       lg:px-10
                       py-16"
            >

                <div class="text-center mb-10">

                    <p
                        class="text-sm
                               font-semibold
                               uppercase
                               tracking-wider
                               text-blue-600"
                    >
                        Layanan FaceShield
                    </p>


                    <h3
                        class="mt-2
                               text-3xl
                               font-bold
                               text-[#0F1B3D]"
                    >
                        Perbankan dalam satu platform
                    </h3>


                    <p
                        class="mt-3
                               max-w-xl
                               mx-auto
                               text-slate-500"
                    >
                        Semua kebutuhan transaksi Anda dapat dilakukan
                        dengan mudah dan tetap mengutamakan keamanan.

                    </p>

                </div>



                <div
                    class="grid
                           md:grid-cols-3
                           gap-6"
                >


                    <!-- TRANSFER -->

                    <div
                        class="group
                               bg-[#F7F9FC]
                               rounded-2xl
                               border
                               border-slate-200
                               p-7
                               hover:bg-white
                               hover:border-blue-200
                               hover:shadow-xl
                               hover:-translate-y-1
                               transition"
                    >

                        <div
                            class="w-14
                                   h-14
                                   rounded-2xl
                                   bg-blue-100
                                   text-blue-600
                                   flex
                                   items-center
                                   justify-center"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-7 h-7"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M7 17l9-9m0 0H8m8 0v8"
                                />

                            </svg>

                        </div>


                        <h4
                            class="mt-6
                                   text-lg
                                   font-bold
                                   text-[#0F1B3D]"
                        >
                            Transfer Dana
                        </h4>


                        <p
                            class="mt-2
                                   text-sm
                                   leading-6
                                   text-slate-500"
                        >
                            Kirim dana dengan mudah dan lakukan
                            konfirmasi transaksi secara aman.

                        </p>

                    </div>



                    <!-- SECURITY -->

                    <div
                        class="group
                               bg-[#F7F9FC]
                               rounded-2xl
                               border
                               border-slate-200
                               p-7
                               hover:bg-white
                               hover:border-blue-200
                               hover:shadow-xl
                               hover:-translate-y-1
                               transition"
                    >

                        <div
                            class="w-14
                                   h-14
                                   rounded-2xl
                                   bg-indigo-100
                                   text-indigo-600
                                   flex
                                   items-center
                                   justify-center"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-7 h-7"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3l7 4v5c0 4.5-3 7.8-7 9-4-1.2-7-4.5-7-9V7l7-4z"
                                />

                            </svg>

                        </div>


                        <h4
                            class="mt-6
                                   text-lg
                                   font-bold
                                   text-[#0F1B3D]"
                        >
                            Keamanan Wajah
                        </h4>


                        <p
                            class="mt-2
                                   text-sm
                                   leading-6
                                   text-slate-500"
                        >
                            Verifikasi identitas menggunakan
                            Face Recognition dan Liveness Detection.

                        </p>

                    </div>



                    <!-- 24/7 -->

                    <div
                        class="group
                               bg-[#F7F9FC]
                               rounded-2xl
                               border
                               border-slate-200
                               p-7
                               hover:bg-white
                               hover:border-blue-200
                               hover:shadow-xl
                               hover:-translate-y-1
                               transition"
                    >

                        <div
                            class="w-14
                                   h-14
                                   rounded-2xl
                                   bg-amber-100
                                   text-amber-600
                                   flex
                                   items-center
                                   justify-center"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-7 h-7"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.7"
                            >

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 7v5l3 2"
                                />

                            </svg>

                        </div>


                        <h4
                            class="mt-6
                                   text-lg
                                   font-bold
                                   text-[#0F1B3D]"
                        >
                            Akses 24/7
                        </h4>


                        <p
                            class="mt-2
                                   text-sm
                                   leading-6
                                   text-slate-500"
                        >
                            Kelola akun dan kebutuhan transaksi
                            kapan saja melalui layanan digital.

                        </p>

                    </div>

                </div>

            </div>

        </section>



        <!-- ========================================================= -->
        <!-- SECURITY CTA -->
        <!-- ========================================================= -->

        <section
            class="max-w-6xl
                   mx-auto
                   px-6
                   lg:px-10
                   py-16"
        >

            <div
                class="rounded-3xl
                       bg-[#0F1B3D]
                       px-8
                       py-12
                       lg:px-14
                       text-center
                       relative
                       overflow-hidden"
            >

                <div
                    class="absolute
                           -top-24
                           -right-24
                           w-64
                           h-64
                           rounded-full
                           border
                           border-white/10"
                ></div>


                <div
                    class="absolute
                           -bottom-32
                           -left-20
                           w-72
                           h-72
                           rounded-full
                           border
                           border-white/10"
                ></div>


                <div class="relative">

                    <div
                        class="mx-auto
                               w-16
                               h-16
                               rounded-2xl
                               bg-white/10
                               border
                               border-white/10
                               flex
                               items-center
                               justify-center"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-8 h-8 text-blue-300"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.5"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 3l7 4v5c0 4.5-3 7.8-7 9-4-1.2-7-4.5-7-9V7l7-4z"
                            />

                        </svg>

                    </div>


                    <h3
                        class="mt-6
                               text-3xl
                               font-bold
                               text-white"
                    >
                        Keamanan adalah prioritas kami.
                    </h3>


                    <p
                        class="mt-4
                               max-w-2xl
                               mx-auto
                               text-white/60
                               leading-7"
                    >
                        FaceShield menggunakan teknologi biometrik
                        untuk membantu memastikan bahwa hanya Anda
                        yang dapat mengakses akun dan melakukan transaksi.

                    </p>


                    <a
                        href="{{ route('register') }}"
                        class="inline-flex
                               mt-7
                               px-7
                               py-3.5
                               rounded-xl
                               bg-white
                               hover:bg-slate-100
                               text-[#0F1B3D]
                               font-semibold
                               transition"
                    >
                        Mulai Menggunakan FaceShield
                    </a>

                </div>

            </div>

        </section>

    </main>



    <!-- ========================================================= -->
    <!-- FOOTER -->
    <!-- ========================================================= -->

    <footer
        class="bg-[#0B132B]
               text-white"
    >

        <div
            class="max-w-6xl
                   mx-auto
                   px-6
                   lg:px-10
                   py-8
                   flex
                   flex-col
                   sm:flex-row
                   items-center
                   justify-between
                   gap-4"
        >

            <div class="flex items-center gap-3">

                <div
                    class="w-9
                           h-9
                           rounded-lg
                           bg-blue-600
                           flex
                           items-center
                           justify-center"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.5"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3l7 4v5c0 4.5-3 7.8-7 9-4-1.2-7-4.5-7-9V7l7-4z"
                        />

                    </svg>

                </div>


                <div>

                    <p class="font-semibold">
                        FaceShield
                    </p>

                    <p class="text-xs text-white/40">
                        Digital Banking
                    </p>

                </div>

            </div>


            <p class="text-sm text-white/40">
                © {{ date('Y') }} FaceShield. All rights reserved.
            </p>

        </div>

    </footer>


</body>

</html>
```