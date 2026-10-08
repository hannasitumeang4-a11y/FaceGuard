<x-app-layout>

    <style>
        /*
        * Hanya untuk halaman Transfer Keluar.
        * Navbar/logo Laravel bawaan disembunyikan khusus di halaman ini.
        */
        nav {
            display: none !important;
        }

        header {
            display: none !important;
        }
    </style>


    {{-- HEADER FACESHIELD --}}
    <div
        class="border-b"
        style="
            background-color: #FFFFFF;
            border-color: #E2E8F0;
        "
    >

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">

            <div>

                <p
                    class="text-xs font-bold tracking-widest uppercase"
                    style="color: #D4A72C;"
                >
                    FACESHIELD
                </p>

                <h2
                    class="font-semibold text-xl mt-1"
                    style="color: #0F1B3D;"
                >
                    Transfer Keluar
                </h2>

            </div>

            <div class="mt-4">

                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center text-sm font-semibold px-4 py-2 rounded-lg transition"
                    style="
                        color: #0F1B3D;
                        background-color: #F5F7FB;
                        border: 1px solid #E2E8F0;
                    "
                >
                    ← Kembali ke Dashboard
                </a>

            </div>

        </div>

    </div>


    <div
        class="py-12 min-h-screen"
        style="
            background: linear-gradient(180deg, #F5F7FB 0%, #EEF3FA 100%);
        "
    >

        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">


            {{-- HEADER CARD --}}
            <div
                class="mb-6 rounded-2xl p-6 shadow-sm"
                style="
                    background: linear-gradient(135deg, #0F1B3D 0%, #1D3B82 100%);
                    border-left: 5px solid #D4A72C;
                "
            >

                <p
                    class="text-xs font-semibold tracking-widest uppercase"
                    style="color: #D4A72C;"
                >
                    FINANCIAL ACTIVITY
                </p>

                <h1
                    class="text-2xl font-bold mt-2"
                    style="color: #FFFFFF;"
                >
                    Transfer Keluar
                </h1>

                <p
                    class="text-sm mt-2"
                    style="color: #CBD5E1;"
                >
                    Kirim saldo dengan mudah, cepat, dan aman.
                </p>

            </div>


            {{-- FORM CARD --}}
            <div
                class="overflow-hidden shadow-lg sm:rounded-2xl"
                style="
                    background-color: #FFFFFF;
                    border: 1px solid #E2E8F0;
                "
            >

                <div
                    class="p-6 sm:p-8"
                    style="color: #0F1B3D;"
                >

                    {{-- JUDUL FORM --}}
                    <div
                        class="mb-7 pb-5"
                        style="border-bottom: 1px solid #E8EDF5;"
                    >

                        <div class="flex items-center gap-4">

                            <div
                                class="w-12 h-12 rounded-xl flex items-center justify-center"
                                style="
                                    background-color: #FFF7E0;
                                    color: #D4A72C;
                                "
                            >

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                                    />

                                </svg>

                            </div>

                            <div>

                                <h3
                                    class="text-lg font-bold"
                                    style="color: #0F1B3D;"
                                >
                                    Transfer Saldo
                                </h3>

                                <p
                                    class="text-sm mt-1"
                                    style="color: #64748B;"
                                >
                                    Masukkan penerima dan nominal transfer.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- ERROR --}}
                    @if ($errors->any())

                        <div
                            class="mb-6 p-4 rounded-xl"
                            style="
                                background-color: #FEF2F2;
                                border: 1px solid #FECACA;
                                color: #B91C1C;
                            "
                        >

                            <p class="font-semibold text-sm mb-2">
                                Terdapat kesalahan:
                            </p>

                            <ul class="list-disc list-inside text-sm">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    @endif


                    {{-- SUCCESS --}}
                    @if (session('success'))

                        <div
                            class="mb-6 p-4 rounded-xl"
                            style="
                                background-color: #F0FDF4;
                                border: 1px solid #BBF7D0;
                                color: #15803D;
                            "
                        >

                            <p class="font-semibold text-sm">
                                ✓ {{ session('success') }}
                            </p>

                        </div>

                    @endif


                    <form
                        method="POST"
                        action="{{ route('transfer.store') }}"
                    >

                        @csrf


                        {{-- PENERIMA --}}
                        <div class="mb-6">

                            <label
                                for="recipient_search"
                                class="block font-semibold text-sm mb-2"
                                style="color: #0F1B3D;"
                            >
                                Penerima
                            </label>

                            <div class="relative">

                                <input
                                    type="text"
                                    id="recipient_search"
                                    autocomplete="off"
                                    placeholder="Cari nama atau email penerima"
                                    class="w-full rounded-lg"
                                    style="
                                        border: 1px solid #CBD5E1;
                                        background-color: #FFFFFF;
                                        color: #0F1B3D;
                                    "
                                >

                                <input
                                    type="hidden"
                                    name="recipient_user_id"
                                    id="recipient_user_id"
                                >


                                {{-- HASIL PENCARIAN --}}
                                <div
                                    id="recipient_results"
                                    class="hidden absolute z-20 w-full mt-2 rounded-xl shadow-lg overflow-hidden"
                                    style="
                                        background-color: #FFFFFF;
                                        border: 1px solid #E2E8F0;
                                    "
                                >

                                    @foreach ($users as $user)

                                        <div
                                            class="recipient-option px-4 py-3 cursor-pointer transition"
                                            data-id="{{ $user->id }}"
                                            data-name="{{ strtolower($user->name) }}"
                                            data-email="{{ strtolower($user->email) }}"
                                        >

                                            <p
                                                class="font-medium text-sm"
                                                style="color: #0F1B3D;"
                                            >
                                                {{ $user->name }}
                                            </p>

                                            <p
                                                class="text-sm"
                                                style="color: #64748B;"
                                            >
                                                — {{ $user->email }}
                                            </p>

                                        </div>

                                    @endforeach

                                </div>

                            </div>

                        </div>


                        {{-- NOMINAL --}}
                        <div class="mb-6">

                            <label
                                for="amount"
                                class="block font-semibold text-sm mb-2"
                                style="color: #0F1B3D;"
                            >
                                Nominal Transfer
                            </label>

                            <div class="relative">

                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold"
                                    style="color: #64748B;"
                                >
                                    Rp
                                </span>

                                <input
                                    type="number"
                                    name="amount"
                                    id="amount"
                                    value="{{ old('amount') }}"
                                    min="1"
                                    step="1"
                                    required
                                    class="w-full rounded-lg pl-12"
                                    style="
                                        border: 1px solid #CBD5E1;
                                        background-color: #FFFFFF;
                                        color: #0F1B3D;
                                    "
                                    placeholder="Masukkan nominal"
                                >

                            </div>

                        </div>


                        {{-- KETERANGAN --}}
                        <div class="mb-6">

                            <label
                                for="description"
                                class="block font-semibold text-sm mb-2"
                                style="color: #0F1B3D;"
                            >
                                Keterangan
                            </label>

                            <textarea
                                name="description"
                                id="description"
                                rows="3"
                                maxlength="1000"
                                class="w-full rounded-lg"
                                style="
                                    border: 1px solid #CBD5E1;
                                    background-color: #FFFFFF;
                                    color: #0F1B3D;
                                "
                                placeholder="Keterangan (opsional)"
                            >{{ old('description') }}</textarea>

                        </div>


                        {{-- INFORMASI --}}
                        <div
                            class="mb-7 rounded-xl p-4"
                            style="
                                background-color: #FFF9E8;
                                border: 1px solid #F4E2A8;
                            "
                        >

                            <div class="flex items-start gap-3">

                                <div
                                    class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                                    style="
                                        background-color: #FFF0B8;
                                        color: #B88900;
                                    "
                                >

                                    <svg
                                        class="w-5 h-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="M12 9v4m0 4h.01M10.3 3h3.4L21 19H3L10.3 3Z"
                                        />

                                    </svg>

                                </div>

                                <div>

                                    <p
                                        class="text-sm font-semibold"
                                        style="color: #0F1B3D;"
                                    >
                                        Periksa Transfer
                                    </p>

                                    <p
                                        class="text-xs mt-1 leading-5"
                                        style="color: #64748B;"
                                    >
                                        Pastikan penerima, nominal, dan
                                        keterangan sudah sesuai sebelum
                                        melakukan transfer.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- BUTTON --}}
                        <div class="flex gap-3">

                            <button
                                type="submit"
                                class="px-6 py-3 font-semibold rounded-lg transition shadow-sm"
                                style="
                                    color: #FFFFFF;
                                    background: linear-gradient(135deg, #2563EB, #1D4ED8);
                                    border: none;
                                "
                            >
                                Kirim Transfer
                            </button>

                            <a
                                href="{{ route('dashboard') }}"
                                class="px-6 py-3 font-semibold rounded-lg transition"
                                style="
                                    color: #475569;
                                    background-color: #F1F5F9;
                                    border: 1px solid #E2E8F0;
                                "
                            >
                                Kembali
                            </a>

                        </div>

                    </form>

                </div>

            </div>


            {{-- FOOTER --}}
            <div class="text-center mt-6">

                <p
                    class="text-xs"
                    style="color: #94A3B8;"
                >
                    🛡 Dilindungi oleh keamanan FaceShield
                    <span style="color: #CBD5E1;">•</span>
                    Digital Banking Security
                </p>

            </div>

        </div>

    </div>


    {{-- SEARCH RECIPIENT --}}
    <script>
        const searchInput = document.getElementById('recipient_search');
        const userIdInput = document.getElementById('recipient_user_id');
        const results = document.getElementById('recipient_results');
        const options = document.querySelectorAll('.recipient-option');

        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let found = false;

            options.forEach(option => {
                const name = option.dataset.name;
                const email = option.dataset.email;

                if (
                    keyword === '' ||
                    name.includes(keyword) ||
                    email.includes(keyword)
                ) {
                    option.classList.remove('hidden');
                    found = true;
                } else {
                    option.classList.add('hidden');
                }
            });

            if (found && keyword !== '') {
                results.classList.remove('hidden');
            } else {
                results.classList.add('hidden');
            }

            userIdInput.value = '';
        });

        options.forEach(option => {
            option.addEventListener('click', function () {
                searchInput.value =
                    this.querySelector('.font-medium').textContent.trim()
                    + ' — '
                    + this.querySelector('.text-sm').textContent.trim().replace(/^—\s*/, '');

                userIdInput.value = this.dataset.id;

                results.classList.add('hidden');
            });
        });

        document.addEventListener('click', function (event) {
            if (
                !searchInput.contains(event.target) &&
                !results.contains(event.target)
            ) {
                results.classList.add('hidden');
            }
        });
    </script>

</x-app-layout>