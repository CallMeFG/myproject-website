<x-app-layout> {{-- Menggunakan layout utama dari Breeze --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Kamar: ') }} {{ $room->type }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Kolom Gambar Kamar --}}
                        <div>
                            <img src="{{ $room->image }}" alt="{{ $room->type }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                        </div>

                        {{-- Kolom Detail Kamar --}}
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3">{{ $room->type }}</h3>

                            <p class="text-xl text-indigo-600 dark:text-indigo-400 font-semibold mb-4">
                                Rp {{ number_format($room->price, 0, ',', '.') }} / malam
                            </p>

                            <div class="mb-4">
                                <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300">Deskripsi:</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">
                                    {{ $room->description }}
                                </p>
                            </div>

                            <div class="mb-6">
                                <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300">Total Unit Tersedia untuk Tipe Ini:</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $room->quantity }} unit
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                    (Catatan: Ketersediaan aktual pada tanggal tertentu akan dicek saat proses pemesanan)
                                </p>
                            </div>

                            {{-- Tombol Pesan Sekarang (Placeholder) --}}
                            <button type="button"
                                class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-700 transition ease-in-out duration-150">
                                Pesan Sekarang
                            </button>
                        </div>
                    </div>
                    {{-- Bagian Detail Kamar yang sudah ada sebelumnya --}}
                    {{-- ... (kode untuk gambar, tipe, harga, deskripsi, quantity) ... --}}

                    {{-- Form Reservasi hanya untuk pengguna yang sudah login --}}
                    @auth
                    <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Buat Reservasi</h4>

                        {{-- Tampilkan pesan error validasi jika ada --}}
                        @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 dark:bg-red-700/50 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 rounded">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        {{-- Tampilkan pesan sukses/error dari session (setelah redirect) --}}
                        @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 dark:bg-green-700/50 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 rounded">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if (session('error'))
                        <div class="mb-4 p-4 bg-red-100 dark:bg-red-700/50 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 rounded">
                            {{ session('error') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('reservations.store', $room->id) }}">
                            @csrf
                            {{-- Kita akan membuat rute 'reservations.store' nanti --}}
                            {{-- $room->id akan dilewatkan ke controller untuk mengetahui kamar mana yang dipesan --}}

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="check_in_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Check-in</label>
                                    <input type="date" name="check_in_date" id="check_in_date"
                                        value="{{ old('check_in_date') }}"
                                        min="{{ date('Y-m-d') }}" {{-- Tanggal minimal adalah hari ini --}}
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>
                                </div>
                                <div>
                                    <label for="check_out_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Check-out</label>
                                    <input type="date" name="check_out_date" id="check_out_date"
                                        value="{{ old('check_out_date') }}"
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}" {{-- Tanggal minimal adalah besok --}}
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>
                                </div>
                            </div>

                            {{-- Jika Anda ingin ada input jumlah kamar (meskipun kita sepakat 1 per transaksi untuk awal) --}}
                            {{-- <div>
                <label for="number_of_rooms" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah Kamar</label>
                <input type="number" name="number_of_rooms" id="number_of_rooms" value="1" min="1" max="{{ $room->quantity }}"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-sm" required>
                    </div> --}}


                    <button type="submit"
                        class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:bg-green-500 dark:hover:bg-green-600 dark:focus:ring-green-700 transition ease-in-out duration-150">
                        Kirim Permintaan Reservasi
                    </button>
                    </form>
                </div>
                @else
                {{-- Jika pengguna belum login, tampilkan pesan untuk login/register --}}
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <p class="text-center text-gray-700 dark:text-gray-300">
                        Silakan <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">login</a>
                        atau <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">register</a>
                        untuk membuat reservasi.
                    </p>
                </div>
                @endauth

                <div class="mt-8">
                    <a href="{{ route('rooms.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        &laquo; Kembali ke Daftar Kamar
                    </a>
                </div>
                <div class="mt-8">
                    <a href="{{ route('rooms.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        &laquo; Kembali ke Daftar Kamar
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>