<x-app-layout> {{-- Menggunakan layout utama publik --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tentang CallMeHotel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold mb-4">Tentang Kami</h3>
                    <p class="mb-4">
                        Selamat datang di CallMeHotel! Kami berkomitmen untuk menyediakan pengalaman menginap yang tak terlupakan bagi setiap tamu kami.
                        Dengan fasilitas modern, pelayanan ramah, dan lokasi yang strategis, kami adalah pilihan ideal untuk perjalanan bisnis maupun liburan Anda.
                    </p>
                    <p class="mb-4">
                        Hotel kami menawarkan berbagai tipe kamar yang dirancang untuk memenuhi kebutuhan Anda, mulai dari kamar single yang nyaman hingga suite keluarga yang luas.
                        Setiap kamar dilengkapi dengan fasilitas terbaik untuk memastikan kenyamanan Anda.
                    </p>
                    <p>
                        Tim kami selalu siap membantu Anda 24/7. Jangan ragu untuk menghubungi kami jika Anda memiliki pertanyaan atau permintaan khusus.
                    </p>
                    {{-- Anda bisa menambahkan lebih banyak konten di sini --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>