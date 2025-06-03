<x-staff-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Reservasi (Staff)') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-6">Daftar Semua Reservasi</h3>

                    @if(session('success'))
                    <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-700/30 dark:text-green-300" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-700/30 dark:text-red-300" role="alert">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Pemesan</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipe Kamar</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check-in</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check-out</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Malam</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th> {{-- Kolom untuk ubah status --}}
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($reservations as $reservation)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reservation->id }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $reservation->user ? $reservation->user->name : 'N/A' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $reservation->room ? $reservation->room->type : 'N/A' }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('d M Y') }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('d M Y') }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 text-center">{{ $reservation->total_nights }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
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
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium">
                                        <form action="{{ route('staff.reservations.updateStatus', $reservation->id) }}" method="POST" class="inline-flex items-center gap-x-2">
                                            @csrf
                                            @method('PATCH') {{-- Atau PUT --}}
                                            <select name="status" class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-gray-200 sm:text-xs text-xs {{-- Ukuran teks dikecilkan --}} py-1">
                                                {{-- Opsi status disesuaikan dengan alur kerja Anda --}}
                                                <option value="Pending" {{ $reservation->status == 'Pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                                <option value="Confirmed" {{ $reservation->status == 'Confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                                <option value="Cancelled" {{ $reservation->status == 'Cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                                {{-- Tambahkan status lain jika perlu, misal: 'Checked-in', 'Checked-out', 'No Show' --}}
                                            </select>
                                            <button type="submit" class="px-2 py-1 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 transition ease-in-out duration-150">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                                        Belum ada data reservasi.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-6">
                        {{ $reservations->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-staff-layout>