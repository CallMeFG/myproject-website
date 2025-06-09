<x-customer-layout>
    <h3 class="text-gray-700 dark:text-gray-200 text-3xl font-medium">Dashboard Saya</h3>

    <div class="mt-4 space-y-6">
        {{-- Notifikasi Sukses --}}
        @if (session('success'))
        <div class="p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-700/30 dark:text-green-200" role="alert">
            <span class="font-medium">Berhasil!</span> {{ session('success') }}
        </div>
        @endif

        {{-- FORM UNTUK FILTER DAN SORT --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <form action="{{ route('user.dashboard') }}" method="GET">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        {{-- Filter by Status --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Filter Status</label>
                            <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Semua Status</option>
                                <option value="Pending" @selected(request('status')=='Pending' )>Menunggu Konfirmasi</option>
                                <option value="Confirmed" @selected(request('status')=='Confirmed' )>Dikonfirmasi</option>
                                <option value="Cancelled" @selected(request('status')=='Cancelled' )>Dibatalkan</option>
                            </select>
                        </div>
                        {{-- Sort by Date --}}
                        <div>
                            <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Urutkan Berdasarkan</label>
                            <select id="sort" name="sort" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="created_at_desc" @selected(request('sort', 'created_at_desc' )=='created_at_desc' )>Tanggal Pesan (Terbaru)</option>
                                <option value="created_at_asc" @selected(request('sort')=='created_at_asc' )>Tanggal Pesan (Terlama)</option>
                                <option value="check_in_desc" @selected(request('sort')=='check_in_desc' )>Tanggal Check-in (Mendatang)</option>
                                <option value="check_in_asc" @selected(request('sort')=='check_in_asc' )>Tanggal Check-in (Terlama)</option>
                            </select>
                        </div>
                        {{-- Tombol Terapkan --}}
                        <div>
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- KARTU: Riwayat Reservasi --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                    Riwayat Reservasi Anda
                </h3>

                @if(isset($reservations) && $reservations->count() > 0)
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
                            @forelse ($reservations as $reservation)
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
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada reservasi yang cocok dengan kriteria Anda.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Link untuk Pagination --}}
                <div class="mt-6">
                    {{ $reservations->withQueryString()->links() }}
                </div>
                @else
                <p class="text-gray-500 dark:text-gray-400">Anda belum memiliki riwayat reservasi.</p>
                @endif
            </div>
        </div>
    </div>
</x-customer-layout>