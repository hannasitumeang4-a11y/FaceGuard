<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

```
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">

                <h3 class="text-lg font-semibold">
                    TEST DASHBOARD BARU
                </h3>

                <p class="mt-2">
                    {{ __("You're logged in!") }}
                </p>

                <div style="margin-top: 20px;">
                    <a href="{{ route('security') }}"
                       style="display: inline-block; padding: 10px 20px; background-color: blue; color: white; text-decoration: none; border-radius: 8px;">
                        Security Settings
                    </a>
                </div>

            </div>
        </div>

    </div>
</div>
```

</x-app-layout>
