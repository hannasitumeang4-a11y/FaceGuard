<x-guest-layout>

```
<div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
    Untuk melanjutkan, silakan konfirmasi password akun kamu terlebih dahulu.
</div>

@if ($errors->any())
    <div class="mb-4 text-sm text-red-600">
        {{ $errors->first() }}
    </div>
@endif

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <div>
        <x-input-label for="password" :value="__('Password')" />

        <x-text-input
            id="password"
            class="block mt-1 w-full"
            type="password"
            name="password"
            required
            autocomplete="current-password"
            autofocus
        />

        <x-input-error
            :messages="$errors->get('password')"
            class="mt-2"
        />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-primary-button>
            {{ __('Confirm Password') }}
        </x-primary-button>
    </div>

</form>
```

</x-guest-layout>
