<x-admin-layout> {{-- Memanggil layout admin --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    {{-- Pembungkus konten utama agar rapi --}}
    <div class="py-2 md:py-6 lg:py-8">
        <div class="max-w-full mx-auto"> {{-- Bisa juga sm:px-6 lg:px-8 jika ingin ada padding samping --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Selamat datang di Dashboard Admin, {{ Auth::user()->name }}!
                    <p>Peran Anda: {{ Auth::user()->role }}</p>
                    {{-- Konten dashboard admin lainnya akan ditambahkan di sini --}}
                </div>
            </div>

            {{-- Contoh blok konten tambahan --}}
            {{--
            <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Konten atau statistik admin lainnya bisa di sini.
                </div>
            </div> 
            --}}
        </div>
    </div>
</x-admin-layout>