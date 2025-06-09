<x-app-layout>
    {{-- --}}
    <x-page-header
        title="Detail Kamar"
        :backgroundImageUrl="$room->image_url"
        :prevLink="route('rooms.index')"
        prevText="Semua Kamar" />

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                {{-- Detail Konten Kamar --}}
                <div class="grid grid-cols-1 md:grid-cols-2">
                    {{-- KOLOM KIRI: GAMBAR KAMAR --}}
                    <div class="p-6">
                        <img src="{{ $room->image_url }}" alt="{{ $room->type }}" class="w-full max-w-3xl max-h-[400px] object-cover object-center mx-auto rounded-lg shadow-lg">
                    </div>
                    {{-- KOLOM KANAN: DETAIL TEKS & HARGA --}}
                    <div class="p-6 md:p-8 flex flex-col">
                        <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $room->type }}</h3>

                        <p class="text-xl lg:text-2xl text-indigo-500 dark:text-indigo-400 font-semibold my-3">
                            Rp {{ number_format($room->price, 0, ',', '.') }}
                            <span class="text-base text-gray-600 dark:text-gray-400">/ malam</span>
                        </p>

                        <div class="mt-2 text-sm text-gray-700 dark:text-gray-300 space-y-4">
                            <div>
                                <h4 class="font-semibold uppercase text-gray-500 dark:text-gray-400 tracking-wider">Deskripsi</h4>
                                <p class="whitespace-pre-line">{{ $room->description }}</p>
                            </div>
                            <div>
                                <h4 class="font-semibold uppercase text-gray-500 dark:text-gray-400 tracking-wider">Total Unit Tersedia</h4>
                                <p>{{ $room->quantity }} unit</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BAGIAN FORM RESERVASI --}}
                <div class="p-6 md:p-8 border-t border-gray-200 dark:border-gray-700">
                    @auth
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Buat Reservasi Anda</h4>

                    {{-- Pesan error & sukses --}}
                    @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg"> ... </div>
                    @endif
                    @if (session('success'))
                    <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('reservations.store', $room->id) }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="check_in_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Check-in</label>
                                <input type="date" name="check_in_date" id="check_in_date" value="{{ old('check_in_date') }}" min="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-200" required>
                            </div>
                            <div>
                                <label for="check_out_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Check-out</label>
                                <input type="date" name="check_out_date" id="check_out_date" value="{{ old('check_out_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-200" required>
                            </div>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700">
                            Kirim Permintaan Reservasi
                        </button>
                    </form>
                    @else
                    <div class="text-center">
                        <p class="text-gray-700 dark:text-gray-300">
                            Silakan <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">login</a>
                            atau <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">register</a>
                            untuk membuat reservasi.
                        </p>
                    </div>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</x-app-layout>