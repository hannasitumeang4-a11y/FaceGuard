<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>FaceShield</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-xl rounded-2xl p-10 w-full max-w-lg text-center">

        <h1 class="text-4xl font-bold text-gray-800">
            FaceShield
        </h1>

        <p class="mt-3 text-gray-500">
            Sistem Keamanan Akses Berbasis
            Face Detection, Face Recognition,
            dan Liveness Detection
        </p>


        <div class="mt-8 flex justify-center gap-4">

            <a
                href="{{ route('login') }}"
                class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-semibold"
            >
                Login
            </a>


            <a
                href="{{ route('register') }}"
                class="px-6 py-3 border border-indigo-600 text-indigo-600 hover:bg-indigo-50 rounded-lg font-semibold"
            >
                Registrasi
            </a>

        </div>

    </div>

</body>

</html>