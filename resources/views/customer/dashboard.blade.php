<x-customer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard Saya') }}
        </h2>
    </x-slot>

    {{-- Konten utama dashboard pengguna --}}
    <div class="space-y-6">
        {{-- Notifikasi Sukses --}}
        @if (session('success'))
        <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-700/30 dark:text-green-200" role="alert">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </div>
        @endif

        {{-- KARTU 1: Riwayat Reservasi --}}
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
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipe Kamar</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check-in</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check-out</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal Pesan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($reservations as $reservation)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-50">{{ $reservation->room ? $reservation->room->type : 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('d M Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($reservation->status == 'Pending' || $reservation->status == 'Menunggu Konfirmasi')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-500/30 dark:text-yellow-200">Menunggu Konfirmasi</span>
                                    @elseif($reservation->status == 'Confirmed' || $reservation->status == 'Dikonfirmasi')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-500/30 dark:text-green-200">Dikonfirmasi</span>
                                    @elseif($reservation->status == 'Cancelled' || $reservation->status == 'Dibatalkan')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-500/30 dark:text-red-300">Dibatalkan</span>
                                    @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">{{ $reservation->status }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200">{{ $reservation->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-gray-700 dark:text-gray-300">Anda belum memiliki riwayat reservasi.</p>
                @endif
            </div>
        </div>

        {{-- KARTU 2: Profil Singkat (opsional) --}}
        {{-- Kita bisa tampilkan ini agar pengguna tidak perlu ke halaman profil hanya untuk melihat data dasar --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    Profil Singkat
                </h3>
                <div class="space-y-2">
                    <p><span class="font-medium text-gray-700 dark:text-gray-300">Nama:</span> <span class="text-gray-900 dark:text-gray-100">{{ Auth::user()->name }}</span></p>
                    <p><span class="font-medium text-gray-700 dark:text-gray-300">Email:</span> <span class="text-gray-900 dark:text-gray-100">{{ Auth::user()->email }}</span></p>
                    <p class="mt-3"><a href="{{ route('user.profile.edit') }}" class="text-sm text-indigo-500 hover:underline">Kelola Profil & Password &rarr;</a></p>
                </div>
            </div>
        </div>
    </div>
</x-customer-layout>