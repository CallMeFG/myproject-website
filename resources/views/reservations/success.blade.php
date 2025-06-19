<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-500 leading-tight">
            Reservasi Berhasil
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                    <div class="p-4 mb-6 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-700/30 dark:text-green-200" role="alert">
                        <span class="font-medium">Berhasil!</span> {{ session('success') }}
                    </div>
                    @endif

                    <div class="text-center mb-6">
                        <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-2xl font-semibold mt-4">Terima Kasih!</h3>
                        <p class="text-gray-600 dark:text-gray-400">Permintaan reservasi Anda sedang menunggu konfirmasi dari staff kami.</p>
                    </div>

                    {{-- Detail Reservasi --}}
                    <div class="border-t border-b border-gray-200 dark:border-gray-700 py-6">
                        <h4 class="text-lg font-semibold mb-4 text-center">Detail Bukti Reservasi</h4>
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                            <div class="space-y-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nomor Reservasi</dt>
                                <dd class="text-base font-semibold text-indigo-600 dark:text-indigo-400">RESV-{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</dd>
                            </div>
                            <div class="space-y-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Pesan</dt>
                                <dd class="text-base">{{ $reservation->created_at->format('d M Y, H:i') }}</dd>
                            </div>
                            <div class="space-y-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Atas Nama</dt>
                                <dd class="text-base font-semibold">{{ $reservation->booking_name }}</dd>
                            </div>
                            <div class="space-y-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipe Kamar</dt>
                                <dd class="text-base">{{ $reservation->room->type }}</dd>
                            </div>
                            <div class="space-y-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Check-in</dt>
                                <dd class="text-base">{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('d M Y') }}</dd>
                            </div>
                            <div class="space-y-1">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Check-out</dt>
                                <dd class="text-base">{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('d M Y') }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Rincian Pembayaran --}}
                    <div class="py-6 space-y-3">
                        <div class="flex justify-between items-center text-gray-600 dark:text-gray-300">
                            <span>Harga per Malam</span>
                            <span>Rp {{ number_format($reservation->room->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center text-gray-600 dark:text-gray-300">
                            <span>Jumlah Malam</span>
                            <span>{{ $reservation->total_nights }} malam</span>
                        </div>
                        <div class="flex justify-between items-center font-semibold text-lg text-gray-900 dark:text-white border-t border-gray-200 dark:border-gray-700 pt-3 mt-2">
                            <span>Total Pembayaran</span>
                            <span class="text-indigo-600 dark:text-indigo-400">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="mt-8 text-center">
                        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>