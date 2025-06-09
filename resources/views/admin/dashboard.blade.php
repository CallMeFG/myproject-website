<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">

            {{-- BAGIAN 1: KARTU STATISTIK --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 tracking-wider">Pendapatan Bulan Ini</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($totalRevenueThisMonth, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 tracking-wider">Reservasi Baru (Hari Ini)</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $newBookingsToday }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 tracking-wider">Pelanggan Baru (Bulan Ini)</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $newCustomersThisMonth }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 tracking-wider">Total Unit Kamar</h3>
                    <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-white">{{ $totalRoomUnits }}</p>
                </div>
            </div>

            {{-- BAGIAN 2: GRAFIK --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tipe Kamar Terpopuler</h3>
                    <canvas id="popularRoomsChart" data-labels="{{ json_encode($popularRoomsChartLabels) }}" data-data="{{ json_encode($popularRoomsChartData) }}"></canvas>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Reservasi 7 Hari Terakhir</h3>
                    <canvas id="dailyReservationsChart" data-labels="{{ json_encode($dailyChartLabels) }}" data-data="{{ json_encode($dailyChartData) }}"></canvas>
                </div>
            </div>

            {{-- BAGIAN 3: TABEL RESERVASI TERBARU --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ $latestBookings->count() }} Reservasi Terbaru</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Pemesan</th>
                                    <th scope="col" class="px-6 py-3">Tipe Kamar</th>
                                    <th scope="col" class="px-6 py-3">Tanggal Check-in</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $statusClasses = [
                                'Dikonfirmasi' => 'bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100',
                                'Menunggu Konfirmasi' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
                                'Pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100',
                                'Dibatalkan' => 'bg-red-100 text-red-800 dark:bg-red-700 dark:text-red-100',
                                ];
                                @endphp
                                @forelse($latestBookings as $booking)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $booking->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $booking->room->type ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</td>
                                    <td class="px-6 py-4"><span class="px-2 py-1 text-xs font-semibold leading-tight rounded-full {{ $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-800' }}">{{ $booking->status }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center">Belum ada data reservasi.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Grafik 1 (Tipe Kamar)
            const popularCanvas = document.getElementById('popularRoomsChart');
            new Chart(popularCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: JSON.parse(popularCanvas.dataset.labels),
                    datasets: [{
                        label: 'Jumlah Pesanan',
                        data: JSON.parse(popularCanvas.dataset.data),
                        backgroundColor: ['rgba(59, 130, 246, 0.7)', 'rgba(16, 185, 129, 0.7)', 'rgba(239, 68, 68, 0.7)', 'rgba(245, 158, 11, 0.7)', 'rgba(139, 92, 246, 0.7)'],
                        hoverOffset: 4
                    }]
                }
            });

            // Inisialisasi Grafik 2 (Tren Harian)
            const dailyCanvas = document.getElementById('dailyReservationsChart');
            new Chart(dailyCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: JSON.parse(dailyCanvas.dataset.labels),
                    datasets: [{
                        label: 'Reservasi Baru',
                        data: JSON.parse(dailyCanvas.dataset.data),
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    // BARU: Tambahkan opsi ini untuk menyembunyikan legenda
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>