<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Reservasi #') }}{{ $reservation->id }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8"> {{-- max-w-4xl agar tidak terlalu lebar --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100 space-y-6">

                    <div>
                        <a href="{{ route('admin.reservations.index') }}" class="inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:underline mb-6">
                            <svg class="w-4 h-4 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0l4 4M1 5l4-4" />
                            </svg>
                            Kembali ke Daftar Reservasi
                        </a>
                    </div>

                    <div class="border-b border-gray-200 dark:border-gray-700 pb-4">
                        <h3 class="text-lg font-semibold">Informasi Pemesan:</h3>
                        <div class="mt-2 space-y-1 text-sm">
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Nama:</span> {{ $reservation->user ? $reservation->user->name : 'N/A' }}</p>
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Email:</span> {{ $reservation->user ? $reservation->user->email : 'N/A' }}</p>
                            {{-- Tambahkan detail pengguna lain jika ada dan relevan --}}
                        </div>
                    </div>

                    <div class="border-b border-gray-200 dark:border-gray-700 py-4">
                        <h3 class="text-lg font-semibold">Informasi Kamar:</h3>
                        <div class="mt-2 space-y-1 text-sm">
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Tipe Kamar:</span> {{ $reservation->room ? $reservation->room->type : 'N/A' }}</p>
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Harga per Malam:</span> Rp {{ number_format($reservation->room ? $reservation->room->price : 0, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="py-4">
                        <h3 class="text-lg font-semibold">Detail Reservasi:</h3>
                        <div class="mt-2 space-y-1 text-sm">
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Tanggal Check-in:</span> {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('l, d F Y') }}</p>
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Tanggal Check-out:</span> {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('l, d F Y') }}</p>
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Total Malam:</span> {{ $reservation->total_nights }} malam</p>
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Total Harga:</span> <span class="font-bold text-lg">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</span></p>
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Status Reservasi:</span>
                                @if($reservation->status == 'Pending' || $reservation->status == 'Menunggu Konfirmasi')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-500/30 dark:text-yellow-200">Menunggu Konfirmasi</span>
                                @elseif($reservation->status == 'Confirmed' || $reservation->status == 'Dikonfirmasi')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-500/30 dark:text-green-200">Dikonfirmasi</span>
                                @elseif($reservation->status == 'Cancelled' || $reservation->status == 'Dibatalkan')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-500/30 dark:text-red-300">Dibatalkan</span>
                                @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">{{ $reservation->status }}</span>
                                @endif
                            </p>
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Tanggal Pemesanan:</span> {{ $reservation->created_at->format('l, d F Y, H:i:s') }}</p>
                            <p><span class="font-medium text-gray-600 dark:text-gray-400">Terakhir Diupdate:</span> {{ $reservation->updated_at->format('l, d F Y, H:i:s') }}</p>
                        </div>
                    </div>

                    {{-- Nanti di sini bisa ditambahkan aksi untuk Admin, misalnya tombol untuk mengubah status atau lainnya --}}

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>