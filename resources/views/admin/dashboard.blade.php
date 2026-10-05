<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="text-xl font-bold mb-2">
                        FaceGuard Admin Panel
                    </h3>

                    <p class="mb-4">
                        Selamat datang, {{ auth()->user()->name }}.
                    </p>

                    <div class="p-4 bg-green-100 text-green-800 rounded-lg">
                        Akses Admin berhasil. Kamu memiliki hak akses administrator.
                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>