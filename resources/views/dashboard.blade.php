<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-700/30 dark:text-green-200" role="alert"> {{-- Teks pesan sukses di mode gelap sudah cukup terang --}}
                <span class="font-medium">Berhasil!</span> {{ session('success') }}
            </div>
            @endif

            {{-- Riwayat Reservasi --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Riwayat Reservasi Anda
                    </h3>

                    @if(isset($reservations) && $reservations->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    {{-- Header Tabel: dark:text-gray-300 seharusnya cukup terlihat, bisa diganti ke dark:text-gray-200 jika ingin lebih terang --}}
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tipe Kamar
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Check-in
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Check-out
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Total Malam
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Total Harga
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal Pesan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach ($reservations as $reservation)
                                <tr>
                                    {{-- Data Tabel: PERBAIKAN WARNA TEKS UNTUK MODE GELAP --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-50"> {{-- Tipe Kamar lebih terang --}}
                                        {{ $reservation->room ? $reservation->room->type : 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200"> {{-- Tanggal lebih terang --}}
                                        {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200"> {{-- Tanggal lebih terang --}}
                                        {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200 text-center">
                                        {{ $reservation->total_nights }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">
                                        Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        {{-- Status badges sudah memiliki warna sendiri yang kontras --}}
                                        @if($reservation->status == 'Pending' || $reservation->status == 'Menunggu Konfirmasi')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-500/30 dark:text-yellow-200">
                                            Menunggu Konfirmasi
                                        </span>
                                        @elseif($reservation->status == 'Confirmed' || $reservation->status == 'Dikonfirmasi')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-500/30 dark:text-green-200">
                                            Dikonfirmasi
                                        </span>
                                        @elseif($reservation->status == 'Cancelled' || $reservation->status == 'Dibatalkan')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-500/30 dark:text-red-300">
                                            Dibatalkan
                                        </span>
                                        @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                            {{ $reservation->status }}
                                        </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200"> {{-- Tanggal pesan lebih terang --}}
                                        {{ $reservation->created_at->format('d M Y, H:i') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    {{-- Teks jika tidak ada reservasi --}}
                    <p class="text-gray-700 dark:text-gray-300">Anda belum memiliki riwayat reservasi.</p>
                    @endif
                </div>
            </div>

            {{-- Profil Pengguna --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                        Profil Saya
                    </h3>
                    <div class="space-y-2">
                        {{-- PERBAIKAN WARNA TEKS PROFIL UNTUK MODE GELAP --}}
                        <p><span class="font-medium text-gray-700 dark:text-gray-300">Nama:</span> <span class="text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</span></p>
                        <p><span class="font-medium text-gray-700 dark:text-gray-300">Email:</span> <span class="text-gray-900 dark:text-gray-100">{{ Auth::user()->email }}</span></p>
                        <p class="mt-3"><a href="{{ route('profile.edit') }}" class="inline-block px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 transition ease-in-out duration-150">Edit Profil & Password</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>