<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            User Management
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-6">

                        <div>
                            <h3 class="text-xl font-bold">
                                Daftar Pengguna
                            </h3>

                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Monitoring akun dan status keamanan pengguna.
                            </p>
                        </div>

                        <a href="{{ route('admin.dashboard') }}"
                           style="padding: 8px 16px; background-color: gray; color: white; border-radius: 6px;">
                            Kembali
                        </a>

                    </div>

                    <div class="overflow-x-auto">

                        <table class="w-full border-collapse">

                            <thead>

                                <tr class="border-b dark:border-gray-600">

                                    <th class="text-left p-3">
                                        Nama
                                    </th>

                                    <th class="text-left p-3">
                                        Email
                                    </th>

                                    <th class="text-left p-3">
                                        Role
                                    </th>

                                    <th class="text-left p-3">
                                        MFA
                                    </th>

                                    <th class="text-left p-3">
                                        Dibuat
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($users as $user)

                                    <tr class="border-b dark:border-gray-700">

                                        <td class="p-3">
                                            {{ $user->name }}
                                        </td>

                                        <td class="p-3">
                                            {{ $user->email }}
                                        </td>

                                        <td class="p-3">

                                            @if ($user->role === 'admin')

                                                <span class="px-2 py-1 text-xs rounded bg-purple-100 text-purple-800">
                                                    Admin
                                                </span>

                                            @else

                                                <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-800">
                                                    User
                                                </span>

                                            @endif

                                        </td>

                                        <td class="p-3">

                                            @if ($user->two_factor_confirmed_at)

                                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">
                                                    Aktif
                                                </span>

                                            @else

                                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">
                                                    Belum Aktif
                                                </span>

                                            @endif

                                        </td>

                                        <td class="p-3">
                                            {{ $user->created_at->format('d M Y') }}
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>