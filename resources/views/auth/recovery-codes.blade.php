<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Recovery Codes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-lg font-semibold mb-3">
                        MFA Recovery Codes
                    </h3>

                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
                        Simpan kode berikut di tempat yang aman.
                        Kode ini dapat digunakan untuk masuk ke akun
                        jika kamu tidak dapat mengakses aplikasi Authenticator.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">

                        @foreach ($recoveryCodes as $code)

                            <div class="border rounded-lg p-3 bg-gray-50 dark:bg-gray-700 font-mono text-center">
                                {{ $code }}
                            </div>

                        @endforeach

                    </div>

                    <div class="flex gap-3">

                        <a href="{{ route('security') }}"
                           style="padding: 10px 20px; background-color: gray; color: white; border-radius: 8px;">
                            Kembali
                        </a>

                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>