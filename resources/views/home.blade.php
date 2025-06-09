<x-app-layout>
    {{-- BARU: Definisikan judul untuk halaman ini --}}
    <x-slot name="title">
        Home
    </x-slot>
    {{-- ... (Hero Section tetap sama seperti yang sudah Anda setujui) ... --}}
    <section class="bg-gray-700 dark:bg-gray-900 text-white py-20 md:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4">
                Selamat Datang di CallMeHotel
            </h1>
            <p class="text-lg md:text-xl text-gray-300 dark:text-gray-400 mb-8 max-w-2xl mx-auto">
                Nikmati pengalaman menginap tak terlupakan dengan fasilitas terbaik dan pelayanan ramah dari kami.
            </p>
            <a href="{{ route('rooms.index') }}"
                class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg text-lg transition duration-300">
                Lihat Pilihan Kamar
            </a>
        </div>
    </section>

    {{-- 2. BAGIAN KAMAR UNGGULAN KAMI --}}
    <section class="bg-gray-800 dark:bg-gray-800 py-12 md:py-16">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-3xl font-semibold text-white dark:text-white mb-8 md:mb-10 text-center">
                Kamar Unggulan Kami
            </h3>

            @if(isset($featuredRooms) && $featuredRooms->count() >= 1)
            {{-- Kontainer untuk kartu-kartu horizontal. Kita akan mengurangi gap di sini. --}}
            {{-- Sebelumnya mungkin 'gap-8'. Kita coba 'gap-4' untuk jarak vertikal antar kartu. --}}
            <div class="grid grid-cols-1 gap-4">
                @foreach ($featuredRooms as $room)
                {{-- Kartu Kamar Horizontal --}}
                <div class="bg-white dark:bg-gray-700 rounded-xl shadow-xl overflow-hidden md:flex transform transition-all duration-300 ease-in-out hover:shadow-2xl hover:-translate-y-1 hover:scale-[1.02]">
                    {{-- Bagian Gambar (Kiri di layar md ke atas) --}}
                    <div class="md:w-5/12 lg:w-4/12 flex-shrink-0">
                        <div class="w-full h-64 md:h-full bg-gray-300 dark:bg-gray-600"> {{-- Tinggi gambar diatur di sini --}}
                            <img src="{{ $room->image_url }}"
                                alt="{{ $room->type }}"
                                class="w-full h-full object-cover">
                        </div>
                    </div>
                    {{-- Bagian Teks Detail (Kanan di layar md ke atas) --}}
                    <div class="p-5 md:p-6 lg:p-8 flex flex-col justify-between md:w-7/12 lg:w-8/12">
                        <div>
                            <h4 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-50 mb-1.5">{{ $room->type }}</h4>
                            <p class="text-lg text-indigo-600 dark:text-indigo-400 font-semibold mb-3">
                                Rp {{ number_format($room->price, 0, ',', '.') }} <span class="text-sm text-gray-600 dark:text-gray-400">/ malam</span>
                            </p>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mb-4 leading-relaxed">
                                {{ Str::limit($room->description, 160) }}
                            </p>
                        </div>
                        <div class="mt-auto pt-3 md:pt-4">
                            <a href="{{ route('rooms.show', $room->id) }}"
                                class="inline-block w-full sm:w-auto text-center px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 transition ease-in-out duration-150">
                                Lihat Detail & Pesan
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-400 dark:text-gray-300 text-center">Belum ada kamar unggulan untuk ditampilkan saat ini.</p>
            @endif
        </div>
    </section>

    {{-- SECTION LAYANAN KAMI --}}
    <section class="bg-gray-100 dark:bg-gray-900 py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-8 md:mb-10 text-center">
                Layanan Kami
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Item Layanan 1 --}}
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg text-center">
                    {{-- MODIFIKASI: Ganti div placeholder dengan tag img --}}
                    <img src="{{ asset('images/services.png') }}" alt="Layanan Concierge" class="mx-auto mb-4 w-16 h-16">
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Layanan Concierge 24 Jam</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Staf concierge kami siap membantu Anda kapan saja.
                    </p>
                </div>
                {{-- Item Layanan 2 --}}
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg text-center">
                    {{-- MODIFIKASI: Ganti div placeholder dengan tag img --}}
                    <img src="{{ asset('images/restaurant-service.png') }}" alt="Restoran & Kafe" class="mx-auto mb-4 w-16 h-16">

                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Restoran & Kafe</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Nikmati hidangan lezat di restoran dan kafe kami.
                    </p>
                </div>

                {{-- Item Layanan 3 --}}
                <div class="bg-white dark:bg-gray-700 p-6 rounded-lg shadow-lg text-center">
                    {{-- MODIFIKASI: Ganti div placeholder dengan tag img --}}
                    <img src="{{ asset('images/laundry.png') }}" alt="Antar-Jemput Bandara" class="mx-auto mb-4 w-16 h-16">

                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-2">Laundry & Dry Cleaning</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Jaga pakaian Anda tetap bersih dan rapi dengan layanan laundry profesional kami.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION FITUR UNGGULAN KAMI (Menempel, Sudut Tajam) --}}
    <section class="py-12 md:py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-10 md:mb-12 text-center">
                Fitur Unggulan Kami
            </h3>

            {{-- MODIFIKASI: Dihapus 'space-y-10' untuk menghilangkan jarak vertikal antar kartu --}}
            <div class="space-y-0">
                {{-- Item Fitur 1 (Gambar Kiri, Teks Kanan) --}}
                {{-- MODIFIKASI: Dihapus 'rounded-xl' dan 'shadow-lg'. Padding ditambahkan ke dalam. --}}
                <div class="bg-gray-100 dark:bg-gray-900">
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/2">
                            {{-- KODE GAMBAR: Pastikan gambar Anda ada di public/images/ --}}
                            <img src="{{ asset('images/spa.jpg') }}" alt="Wellness Center" class="w-full h-full object-cover">
                        </div>
                        <div class="md:w-1/2 p-8 md:p-12 text-center md:text-left">
                            <h4 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-3">Wellness Center & Spa</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                                Manjakan diri Anda di pusat kebugaran dan spa kami yang mewah. Nikmati berbagai perawatan relaksasi dan fasilitas modern untuk menyegarkan tubuh dan pikiran Anda.
                            </p>
                            <a href="#" class="inline-block text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                                Kunjungi Wellness Center &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Item Fitur 2 (Teks Kiri, Gambar Kanan) --}}
                <div class="bg-gray-100 dark:bg-gray-900">
                    <div class="flex flex-col md:flex-row-reverse items-center">
                        <div class="md:w-1/2">
                            <img src="{{ asset('images/pool.jpg') }}" alt="Kolam Renang Indah" class="w-full h-full object-cover">
                        </div>
                        <div class="md:w-1/2 p-8 md:p-12 text-center md:text-left">
                            <h4 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-3">Kolam Renang Eksklusif</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                                Bersantai dan berenang di kolam renang kami yang dirancang dengan indah, menawarkan pemandangan menakjubkan dan suasana yang tenang untuk semua tamu.
                            </p>
                            <a href="#" class="inline-block text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                                Lihat Kolam Renang &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Item Fitur 3 (Gambar Kiri, Teks Kanan) --}}
                <div class="bg-gray-100 dark:bg-gray-900">
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="md:w-1/2">
                            <img src="{{ asset('images/resto.jpg') }}" alt="Restoran Mewah" class="w-full h-full object-cover">
                        </div>
                        <div class="md:w-1/2 p-8 md:p-12 text-center md:text-left">
                            <h4 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-3">Santapan Kuliner Terbaik</h4>
                            <p class="text-gray-600 dark:text-gray-300 mb-4 leading-relaxed">
                                Restoran kami menyajikan beragam hidangan lokal dan internasional yang disiapkan oleh koki berpengalaman, menggunakan bahan-bahan segar berkualitas.
                            </p>
                            <a href="#" class="inline-block text-blue-600 dark:text-blue-400 font-semibold hover:underline">
                                Jelajahi Menu Kami &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION BARU: TESTIMONI PELANGGAN (sesuai contoh gambar) --}}
    <section class="py-12 md:py-16 bg-white dark:bg-gray-900 border-y dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-semibold text-gray-900 dark:text-gray-100 mb-10 md:mb-12 text-center">
                Apa Kata Mereka
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Contoh Testimoni 1 --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 p-8 rounded-lg shadow-lg text-center flex flex-col items-center">
                    <img src="{{ asset('images/person1.jpg') }}" alt="Jean Smith" class="w-24 h-24 rounded-full mb-6 shadow-md object-cover">
                    {{-- Ganti dengan path gambar Anda, contoh: https://via.placeholder.com/100x100 --}}
                    <p class="text-gray-600 dark:text-gray-300 italic mb-6 leading-relaxed text-sm">
                        "Sungai kecil bernama Duden mengalir di dekat tempat mereka dan memasoknya dengan regelialia yang diperlukan. Ini adalah negara paradisematik."
                    </p>
                    <p class="font-semibold text-gray-800 dark:text-gray-50 mt-auto">- Jean Smith</p>
                </div>
                {{-- Contoh Testimoni 2 --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 p-8 rounded-lg shadow-lg text-center flex flex-col items-center">
                    <img src="{{ asset('images/person2.jpg') }}" alt="John Doe" class="w-24 h-24 rounded-full mb-6 shadow-md object-cover">
                    {{-- Ganti dengan path gambar Anda, contoh: https://via.placeholder.com/100x100 --}}
                    <p class="text-gray-600 dark:text-gray-300 italic mb-6 leading-relaxed text-sm">
                        "Bahkan Pointing yang maha kuasa tidak memiliki kendali atas teks-teks buta, itu hampir merupakan kehidupan yang tidak ortografis suatu hari nanti."
                    </p>
                    <p class="font-semibold text-gray-800 dark:text-gray-50 mt-auto">- John Doe</p>
                </div>
                {{-- Contoh Testimoni 3 --}}
                <div class="bg-gray-50 dark:bg-gray-700/50 p-8 rounded-lg shadow-lg text-center flex flex-col items-center">
                    <img src="{{ asset('images/person3.jpg') }}" alt="Jane Doe" class="w-24 h-24 rounded-full mb-6 shadow-md object-cover">
                    {{-- Ganti dengan path gambar Anda, contoh: https://via.placeholder.com/100x100 --}}
                    <p class="text-gray-600 dark:text-gray-300 italic mb-6 leading-relaxed text-sm">
                        "Ketika dia mencapai perbukitan pertama dari pegunungan Italic, dia memiliki pandangan terakhir dari kampung halamannya, Booksgrove."
                    </p>
                    <p class="font-semibold text-gray-800 dark:text-gray-50 mt-auto">- Jane Doe</p>
                </div>
            </div>
            {{-- Jika ingin ada pagination/slider untuk testimoni, bisa ditambahkan di sini nanti --}}
            {{-- <div class="text-center mt-8"> titik-titik pagination </div> --}}
        </div>
    </section>
</x-app-layout>