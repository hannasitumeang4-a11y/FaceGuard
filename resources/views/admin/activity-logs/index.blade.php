<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Security Activity Log
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex justify-between items-center mb-6">

                        <div>
                            <h3 class="text-xl font-bold">
                                Security Activity Log
                            </h3>

                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Monitoring aktivitas keamanan pengguna dalam sistem.
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
                                        Waktu
                                    </th>

                                    <th class="text-left p-3">
                                        User
                                    </th>

                                    <th class="text-left p-3">
                                        Aktivitas
                                    </th>

                                    <th class="text-left p-3">
                                        Status
                                    </th>

                                    <th class="text-left p-3">
                                        IP Address
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse ($logs as $log)

                                    <tr class="border-b dark:border-gray-700">

                                        <td class="p-3">
                                            {{ $log->created_at->format('d M Y H:i:s') }}
                                        </td>

                                        <td class="p-3">
                                            {{ $log->user?->name ?? 'Guest' }}
                                        </td>

                                        <td class="p-3">
                                            {{ $log->activity }}
                                        </td>

                                        <td class="p-3">

                                            @if ($log->status === 'success')

                                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">
                                                    Berhasil
                                                </span>

                                            @else

                                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">
                                                    Gagal
                                                </span>

                                            @endif

                                        </td>

                                        <td class="p-3">
                                            {{ $log->ip_address ?? '-' }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="5" class="p-6 text-center text-gray-500">
                                            Belum ada aktivitas keamanan.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>