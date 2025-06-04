<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Selamat Datang di CallMeHotel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                        Kamar Unggulan Kami
                    </h3>

                    @if(isset($featuredRooms) && $featuredRooms->count())
                    <div class="swiper-container featured-rooms-slider group relative"
                        data-loop="{{ $featuredRooms->count() > 1 ? 'true' : 'false' }}"> {{-- TAMBAHKAN ATRIBUT DATA INI --}}
                        <div class="swiper-wrapper">
                            @foreach ($featuredRooms as $room)
                            <div class="swiper-slide">
                                <div class="relative rounded-lg shadow-lg overflow-hidden aspect-video bg-gray-300 dark:bg-gray-700">
                                    <img src="{{ $room->image_url }}"
                                        alt="{{ $room->type }}"
                                        class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/40 to-transparent"></div>
                                    <div class="absolute bottom-0 left-0 p-4 md:p-6 text-white">
                                        <h4 class="text-xl md:text-2xl font-bold">{{ $room->type }}</h4>
                                        <p class="text-lg md:text-xl text-yellow-400 font-semibold">
                                            Rp {{ number_format($room->price, 0, ',', '.') }} <span class="text-sm opacity-80">/ malam</span>
                                        </p>
                                        <p class="text-sm mt-1 mb-3 hidden md:block opacity-90">
                                            {{ Str::limit($room->description, 100) }}
                                        </p>
                                        <a href="{{ route('rooms.show', $room->id) }}"
                                            class="mt-3 inline-block px-4 py-2 text-sm font-medium text-center text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600 dark:focus:ring-blue-800 transition ease-in-out duration-150">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next text-white p-2 rounded-full transition-opacity duration-300 opacity-0 group-hover:opacity-100 hover:bg-black/50 right-2 md:right-4"></div>
                        <div class="swiper-button-prev text-white p-2 rounded-full transition-opacity duration-300 opacity-0 group-hover:opacity-100 hover:bg-black/50 left-2 md:left-4"></div>

                        <div class="swiper-pagination text-center mt-4 relative"></div> {{-- 'relative' agar tidak tertimpa tombol nav --}}
                    </div>
                    @else
                    <p class="text-gray-500 dark:text-gray-400">Belum ada kamar unggulan untuk ditampilkan saat ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Inisialisasi SwiperJS --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Helper function untuk mengecek apakah string adalah URL absolut
            // window.isUrl = function(string) {
            //     try {
            //         new URL(string);
            //         return true;
            //     } catch (_) {
            //         return false;
            //     }
            // };

            const featuredRoomsSliderElement = document.querySelector('.featured-rooms-slider');

            if (featuredRoomsSliderElement) {
                // Ambil nilai data-loop dari elemen HTML
                const loopenabled = "featuredRoomsSliderElement.dataset.loop === 'true';"

                var featuredRoomsSlider = new Swiper(featuredRoomsSliderElement, {
                    // Opsi Swiper
                    loop: loopEnabled, // Gunakan variabel boolean JavaScript
                    slidesPerView: 1,
                    spaceBetween: 20,
                    grabCursor: true,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    }
                });
            } else {
                console.log('Elemen .featured-rooms-slider tidak ditemukan.');
            }
        });
    </script>
    @endpush
</x-app-layout>