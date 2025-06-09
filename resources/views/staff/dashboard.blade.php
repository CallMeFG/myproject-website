<x-staff-layout> {{-- Menggunakan layout staff yang sudah Anda miliki --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Staff Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            {{-- BAGIAN 1: KARTU STATISTIK OPERASIONAL --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 tracking-wider">Menunggu Konfirmasi</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $pendingReservationsCount }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 tracking-wider">Jadwal Check-in Hari Ini</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $checkInsTodayCount }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 tracking-wider">Jadwal Check-out Hari Ini</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $checkOutsTodayCount }}</p>
                </div>
            </div>

            {{-- BAGIAN 2: TABEL RESERVASI PERLU TINDAKAN --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Reservasi Perlu Tindakan</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Pemesan</th>
                                    <th scope="col" class="px-6 py-3">Tipe Kamar</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Pesan</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $statusClasses = [
                                'Menunggu Konfirmasi' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
                                'Pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
                                ];
                                @endphp
                                @forelse($reservationsNeedingAction as $booking)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $booking->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $booking->room->type ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $booking->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full {{ $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center">Tidak ada reservasi yang perlu tindakan saat ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-staff-layout>