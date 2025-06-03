<x-staff-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Staff Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-2">
        <div class="max-w-full mx-auto">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Selamat datang di Dashboard Staff, {{ Auth::user()->name }}!
                    <p>Peran Anda: {{ Auth::user()->role }}</p>
                </div>
            </div>
        </div>
    </div>
</x-staff-layout>