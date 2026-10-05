<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Security Settings
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold mb-4">
                        Two-Factor Authentication
                    </h3>

                    {{-- SUCCESS MESSAGE --}}
                    @if (session('status') === 'two-factor-authentication-enabled')
                        <div class="mb-4 p-4 bg-blue-100 text-blue-800 rounded">
                            MFA berhasil dibuat. Silakan scan QR Code dan
                            konfirmasi dengan kode dari Authenticator.
                        </div>
                    @endif

                    @if (session('status') === 'two-factor-authentication-confirmed')
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            MFA berhasil dikonfirmasi dan sekarang aktif.
                        </div>
                    @endif

                    {{-- ERROR MESSAGE --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                            <strong>Terjadi kesalahan:</strong>

                            <ul class="mt-2 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif


                    {{-- MFA BELUM DIBUAT --}}
                    @if (!auth()->user()->two_factor_secret)

                        <div class="border rounded-lg p-6">

                            <p class="mb-4">
                                MFA belum diaktifkan.
                            </p>

                            <form method="POST"
                                  action="{{ route('two-factor.enable') }}">

                                @csrf

                                <button type="submit"
                                        style="padding: 10px 20px; background-color: blue; color: white; border-radius: 8px;">
                                    Enable MFA
                                </button>

                            </form>

                        </div>


                    {{-- MFA SUDAH DIBUAT TAPI BELUM DIKONFIRMASI --}}
                    @elseif (!auth()->user()->two_factor_confirmed_at)

                        <div class="border rounded-lg p-6">

                            <h4 class="text-lg font-semibold mb-4">
                                Setup Authenticator
                            </h4>

                            <p class="mb-4 text-gray-600 dark:text-gray-300">
                                Scan QR Code berikut menggunakan Google
                                Authenticator atau Microsoft Authenticator.
                            </p>

                            {{-- QR CODE --}}
                            <div class="mb-6">
                                {!! auth()->user()->twoFactorQrCodeSvg() !!}
                            </div>

                            <p class="mb-4">
                                Masukkan kode 6 digit yang muncul pada
                                aplikasi Authenticator.
                            </p>

                            {{-- CONFIRM FORM --}}
                            <form method="POST"
                                  action="{{ route('two-factor.confirm') }}">

                                @csrf

                                <div class="mb-4">

                                    <label for="code"
                                           class="block text-sm font-medium mb-2">
                                        Kode Authenticator
                                    </label>

                                    <input
                                        id="code"
                                        name="code"
                                        type="text"
                                        inputmode="numeric"
                                        pattern="[0-9]{6}"
                                        maxlength="6"
                                        required
                                        autocomplete="one-time-code"
                                        class="border rounded-lg p-2 w-48"
                                    >

                                </div>

                                <button type="submit"
                                        style="padding: 10px 20px; background-color: green; color: white; border-radius: 8px;">
                                    Confirm MFA
                                </button>

                            </form>

                        </div>


                    {{-- MFA SUDAH AKTIF --}}
                    @else

                        <div class="border rounded-lg p-6">

                            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                                <strong>MFA Aktif ✓</strong>
                                <br>
                                Akun kamu sekarang sudah menggunakan
                                Two-Factor Authentication.
                            </div>

                            <p class="mb-4">
                                Authenticator berhasil dikonfigurasi.
                            </p>

                            {{-- RECOVERY CODES --}}
                            <a href="{{ route('recovery-codes') }}"
   style="display: inline-block; padding: 10px 20px; background-color: gray; color: white; border-radius: 8px;">
    Lihat Recovery Codes
</a>

                        </div>

                    @endif

                </div>

            </div>

        </div>
    </div>

</x-app-layout>