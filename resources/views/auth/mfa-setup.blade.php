<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>FaceShield - Setup MFA</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-md">

        <!-- Judul -->
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800">
                FaceShield
            </h1>

            <p class="text-gray-500 mt-2">
                Setup Two-Factor Authentication
            </p>
        </div>


        <!-- Instruksi -->
        <div class="mt-6">

            <p class="text-sm text-gray-600 text-center">
                Scan QR Code berikut menggunakan
                <strong>Google Authenticator</strong>.
            </p>

        </div>


        <!-- QR CODE -->
        <div class="flex justify-center mt-6">

            <div class="border rounded-xl p-4 bg-white">

                {!! $user->twoFactorQrCodeSvg() !!}

            </div>

        </div>


        <!-- OTP -->
        <div class="mt-6">

            <p class="text-sm text-gray-600 text-center">
                Setelah QR Code berhasil dipindai,
                masukkan kode OTP 6 digit dari Google Authenticator.
            </p>

        </div>


        <!-- Form Konfirmasi -->
        <form method="POST"
              action="/user/confirmed-two-factor-authentication"
              class="mt-6">

            @csrf

            <label
                for="code"
                class="block text-sm font-medium text-gray-700"
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

                class="mt-2 w-full rounded-lg border-gray-300 shadow-sm
                       focus:border-indigo-500 focus:ring-indigo-500"

                placeholder="Masukkan 6 digit OTP"
            >


            <!-- Error -->
            @if ($errors->any())

                <div class="mt-3 text-sm text-red-600">

                    @foreach ($errors->all() as $error)

                        <p>{{ $error }}</p>

                    @endforeach

                </div>

            @endif


            <!-- Button -->
            <button
                type="submit"
                class="mt-5 w-full bg-indigo-600 hover:bg-indigo-700
                       text-white font-semibold py-3 rounded-lg"
            >
                Verifikasi OTP
            </button>

        </form>


        <!-- Keterangan -->
        <div class="mt-5 text-center">

            <p class="text-xs text-gray-500">
                Setelah OTP berhasil diverifikasi,
                kamu akan diarahkan ke Dashboard.
            </p>

        </div>

    </div>

</body>
</html>