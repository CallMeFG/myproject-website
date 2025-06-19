<x-staff-layout>
    <x-slot name="header">
        {{ __('Status Kamar') }}
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tipe Kamar</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Unit</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sedang Terpakai</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tersedia</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga / Malam</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($rooms as $room)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $room->type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700 dark:text-gray-200">{{ $room->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-red-600 dark:text-red-400 font-semibold">{{ $room->in_use_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-green-600 dark:text-green-400 font-bold">{{ $room->available_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right text-gray-700 dark:text-gray-200">Rp {{ number_format($room->price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data kamar.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-staff-layout>                           