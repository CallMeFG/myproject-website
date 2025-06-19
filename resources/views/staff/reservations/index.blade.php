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
                    {{-- Form Filter --}}
                    <div class="mb-6 bg-gray-50 dark:bg-gray-700/30 p-4 rounded-md shadow">
                        <form method="GET" action="{{ route('staff.reservations.index') }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
                                {{-- Filter Status --}}
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                                    <select name="status" id="status"
                                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-900 dark:text-gray-200">
                                        <option value="">Semua Status</option>
                                        @foreach ($statuses as $statusValue)
                                        <option value="{{ $statusValue }}" {{ $selectedStatus == $statusValue ? 'selected' : '' }}>
                                            @if($statusValue == 'Pending') Menunggu Konfirmasi
                                            @elseif($statusValue == 'Confirmed') Dikonfirmasi
                                            @elseif($statusValue == 'Cancelled') Dibatalkan
                                            @else {{ $statusValue }}
                                            @endif
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Filter Tanggal Dari --}}
                                <div>
                                    <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check-in Dari</label>
                                    <input type="date" name="date_from" id="date_from" value="{{ $dateFrom ?? '' }}"
                                        class="block w-full pl-3 pr-2 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-900 dark:text-gray-200">
                                </div>

                                {{-- Filter Tanggal Sampai --}}
                                <div>
                                    <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Check-in Sampai</label>
                                    <input type="date" name="date_to" id="date_to" value="{{ $dateTo ?? '' }}"
                                        class="block w-full pl-3 pr-2 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md dark:bg-gray-900 dark:text-gray-200">
                                </div>

                                {{-- Tombol Aksi Filter --}}
                                <div class="flex space-x-2">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Filter
                                    </button>
                                    {{-- Tampilkan link Hapus Filter jika ada filter yang aktif --}}
                                    @if( $selectedStatus || ($dateFrom && $dateTo) )
                                    <a href="{{ route('staff.reservations.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-gray-300 dark:bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-100 uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                        Hapus Filter
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>

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
                                    {{-- MODIFIKASI: Judul kolom diubah dan ditambah --}}
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Akun</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Atas Nama Reservasi</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipe Kamar</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check-in</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Check-out</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Malam</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($reservations as $reservation)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $reservation->id }}</td>

                                    {{-- Data Nama Akun (Tetap ada) --}}
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $reservation->user ? $reservation->user->name : 'N/A' }}</td>

                                    {{-- MODIFIKASI: Tambah kolom data booking_name --}}
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300">{{ $reservation->booking_name }}</td>

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
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('staff.reservations.show', $reservation->id) }}" class="text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 text-xs">
                                                Detail
                                            </a>
                                            <form action="{{ route('staff.reservations.updateStatus', $reservation->id) }}" method="POST" class="inline-flex items-center gap-x-1">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" class="block w-auto rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-700 dark:text-gray-200 sm:text-xs text-xs py-1">
                                                    <option value="Pending" {{ $reservation->status == 'Pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                                    <option value="Confirmed" {{ $reservation->status == 'Confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                                                    <option value="Cancelled" {{ $reservation->status == 'Cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                                </select>
                                                <button type="submit" class="px-2 py-1 bg-blue-600 text-white text-xs font-semibold rounded-md hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                                                    Update
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    {{-- MODIFIKASI: colspan diubah menjadi 9 --}}
                                    <td colspan="9" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
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