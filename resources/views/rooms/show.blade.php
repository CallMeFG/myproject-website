<x-app-layout>
    <x-page-header
        title="Detail Kamar"
        :backgroundImageUrl="$room->image_url"
        :prevLink="route('rooms.index')"
        prevText="Semua Kamar" />

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Bagian ini dibungkus dengan Alpine.js untuk fungsionalitas dinamis --}}
            <div x-data="{
                checkIn: '{{ old('check_in_date') }}',
                checkOut: '{{ old('check_out_date') }}',
                pricePerNight: {{ $room->price }},
                totalNights: 0,
                totalPrice: 0,
                availableUnits: {{ $room->quantity }},
                isLoading: false,
                errorMessage: '',
                calculateTotal() {
                    const date1 = new Date(this.checkIn);
                    const date2 = new Date(this.checkOut);
                    if (this.checkIn && this.checkOut && date2 > date1) {
                        const diffTime = Math.abs(date2 - date1);
                        this.totalNights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                        this.totalPrice = this.totalNights * this.pricePerNight;
                    } else {
                        this.totalNights = 0;
                        this.totalPrice = 0;
                    }
                    this.updateAvailability(); // Panggil pengecekan ketersediaan setelah kalkulasi harga
                },
                async updateAvailability() {
                    if (!this.checkIn || !this.checkOut || new Date(this.checkOut) <= new Date(this.checkIn)) {
                        this.availableUnits = {{ $room->quantity }};
                        this.errorMessage = '';
                        return;
                    }

                    this.isLoading = true;
                    this.errorMessage = '';
                    try {
                        const response = await fetch(`/api/rooms/{{ $room->id }}/availability?check_in_date=${this.checkIn}&check_out_date=${this.checkOut}`);
                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(errorData.message || 'Gagal mengecek ketersediaan.');
                        }
                        const data = await response.json();
                        this.availableUnits = data.available_units;
                    } catch (error) {
                        console.error('Error fetching availability:', error);
                        this.errorMessage = 'Gagal memuat ketersediaan unit. Pastikan tanggal valid.';
                        this.availableUnits = 'N/A';
                    } finally {
                        this.isLoading = false;
                    }
                }
            }" x-init="calculateTotal()" class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">

                {{-- Detail Konten Kamar --}}
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6">
                        <img src="{{ $room->image_url }}" alt="{{ $room->type }}" class="w-full max-w-3xl max-h-[400px] object-cover object-center mx-auto rounded-lg shadow-lg">
                    </div>
                    <div class="p-6 md:p-8 flex flex-col">
                        <h3 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $room->type }}</h3>
                        <p class="text-xl lg:text-2xl text-indigo-500 dark:text-indigo-400 font-semibold my-3">
                            Rp {{ number_format($room->price, 0, ',', '.') }}
                            <span class="text-base text-gray-600 dark:text-gray-400">/ malam</span>
                        </p>
                        <div class="mt-2 text-sm text-gray-700 dark:text-gray-300 space-y-4">
                            <div>
                                <h4 class="font-semibold uppercase text-gray-500 dark:text-gray-400 tracking-wider">Deskripsi</h4>
                                <p class="whitespace-pre-line">{{ $room->description }}</p>
                            </div>
                            <div class="mt-6">
                                <h4 class="font-semibold uppercase text-gray-500 dark:text-gray-400 tracking-wider">Fasilitas Kamar</h4>
                                <ul class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2 text-gray-700 dark:text-gray-300">
                                    {{-- Fasilitas untuk Kamar Single Standard (ID: 1) --}}
                                    @if($room->id == 1)
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>1 Single Bed</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>AC split dengan remote control</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>TV LED 32" dengan saluran kabel</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Meja kerja dengan kursi ekonomis</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Lemari pakaian built-in</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Kamar mandi pribadi dengan shower</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Wi-Fi gratis berkecepatan tinggi</span></li>
                                    @endif

                                    {{-- Fasilitas untuk Kamar Double Deluxe (ID: 2) --}}
                                    @if($room->id == 2)
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>1 Double Bed / 2 Twin Bed</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Pemandangan Kota</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Smart TV 55" dengan Netflix dan streaming apps</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Meja makan untuk 2 orang</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Mini bar lengkap dengan wine cooler</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Kamar mandi mewah dengan bathtub dan separate shower</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Wi-Fi premium speed</span></li>
                                    @endif

                                    {{-- Fasilitas untuk Suite Keluarga (ID: 3) --}}
                                    @if($room->id == 3)
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>2 Kamar Tidur Terpisah</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Ruang Tamu Terpisah</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Sofa set keluarga dengan coffee table</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Dapur Kecil</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Extra bed tersedia (biaya tambahan)</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Meja makan untuk 4 orang</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>2 Kamar Mandi</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Wi-Fi gratis di seluruh area</span></li>
                                    @endif

                                    {{-- Fasilitas untuk Kamar Ekonomi Twin (ID: 4) --}}
                                    @if($room->id == 4)
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>2 Twin Bed</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Hair dryer</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>AC split dengan dual zone control</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>TV LED 42" dengan premium channels</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Kamar mandi modern dengan rain shower</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Wi-Fi Gratis</span></li>
                                    @endif

                                    {{-- Fasilitas untuk Deluxe Suite (ID: 7) --}}
                                    @if($room->id == 7)
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>King Size Bed</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Premium bath amenities</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Smart TV 50" dengan international channels</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Premium AC system dengan air purifier</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Balkon pribadi dengan garden furniture</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Wi-Fi premium</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>24/7 concierge service</span></li>
                                    @endif

                                    {{-- Fasilitas untuk Premium Maximum Plus (ID: 8) --}}
                                    @if($room->id == 8)
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Separate living room dengan premium furniture</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>65" OLED Smart TV dengan surround sound system</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Personal butler service 24/7</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Full kitchenette dengan premium appliances</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Dining area dengan seating untuk 4 orang</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Master bathroom dengan marble bathtub & separate shower</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Sistem Audio Premium</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Infinity pool access dengan private cabana</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Airport transfer (gratis) </span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Laundry service (gratis)</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Wi-Fi premium dengan dedicated bandwidth</span></li>
                                    <li class="flex items-center"><i class="fas fa-check-circle text-green-500 mr-2"></i><span>Premium toiletries dan daily amenities</span></li>
                                    @endif
                                </ul>
                            </div>

                            {{-- SPESIFIKASI KAMAR --}}
                            <div class="mt-6">
                                <h4 class="font-semibold uppercase text-gray-500 dark:text-gray-400 tracking-wider">Spesifikasi</h4>
                                <div class="mt-2 text-gray-700 dark:text-gray-300">
                                    @if($room->id == 1) {{-- Kamar Single Standard --}}
                                    <p>Luas Kamar: 18-20 m²</p>
                                    <p>Tempat Tidur: Single bed (90 cm x 200 cm)</p>
                                    <p>Kapasitas: 1 orang</p>
                                    <p>Lantai: Parket premium</p>
                                    <p>Pencahayaan: LED ambient + lampu baca dinding</p>
                                    @elseif($room->id == 2) {{-- Kamar Double Deluxe --}}
                                    <p>Luas Kamar: 45-50 m²</p>
                                    <p>Tempat Tidur: King size bed (180 cm x 200 cm)</p>
                                    <p>Luas Kamar: 45-50 m²</p>
                                    <p>Kapasitas: 2 orang</p>
                                    <p>Lantai: Marble premium</p>
                                    <p>Jendela: Floor-to-ceiling windows</p>
                                    <p>Balkon: Private balcony dengan city view</p>
                                    @elseif($room->id == 3) {{-- Suite Keluarga --}}
                                    <p>Luas Kamar: 65-70 m²</p>
                                    <p>Kamar Tidur: 2 kamar terpisah</p>
                                    <p>Tempat Tidur: 1 Queen bed (160x200cm) + 2 Single beds (90x200cm)</p>
                                    <p>Kapasitas: 4 orang (2 dewasa + 2 anak) </p>
                                    <p>Ruang Tamu: Living room terpisah 15 m²</p>
                                    <p>Kamar Mandi: 2 kamar mandi</p>
                                    @elseif($room->id == 4) {{-- Kamar Ekonomi Twin --}}
                                    <p>Luas Kamar: 25-28 m²</p>
                                    <p>Tempat Tidur: 2 Single beds (90 cm x 200 cm)</p>
                                    <p>Kapasitas: 2 orang</p>
                                    <p>Lantai: Industrial concrete flooring</p>
                                    <p>Dinding: Exposed brick wall feature</p>
                                    <p>Tinggi Langit-langit: 3.5 meter</p>
                                    @elseif($room->id == 7) {{-- Deluxe Suite --}}
                                    <p>Luas Kamar: 40-45 m²</p>
                                    <p>Tempat Tidur: King size bed (180 cm x 200 cm)</p>
                                    <p>Kapasitas: 2 orang</p>
                                    <p>Interior Design: Natural wood & stone elements</p>
                                    <p>Pencahayaan: Warm ambient lighting system</p>
                                    <p>Pemandangan: Garden view atau Pool view</p>
                                    @elseif($room->id == 8) {{-- Premium Maximum Plus --}}
                                    <p>Luas Kamar: 80-90 m² </p>
                                    <p>Tempat Tidur: California King bed (200 cm x 200 cm) </p>
                                    <p>Kapasitas: 2 orang + 1 extra bed</p>
                                    <p>Lantai: Premium marble dengan heated flooring</p>
                                    <p>Pemandangan: Panoramic ocean & infinity pool view</p>
                                    <p>Balkon: Private terrace 20 m² dengan outdoor jacuzzi</p>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <h4 class="font-semibold uppercase text-gray-500 dark:text-gray-400 tracking-wider">Unit Tersedia (Untuk Tanggal Pilihan)</h4>
                                <p class="text-lg font-bold text-gray-900 dark:text-gray-200">
                                    <span x-show="isLoading">Mengecek...</span>
                                    <span x-show="!isLoading" x-text="availableUnits + ' unit'"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BAGIAN FORM RESERVASI --}}
                <div class="p-6 md:p-8 border-t border-gray-200 dark:border-gray-700">
                    @auth
                    <h4 class="text-xl font-semibold text-gray-800 dark:text-gray-100 mb-4">Buat Reservasi Anda</h4>
                    {{-- Pesan error validasi Laravel --}}
                    @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 rounded-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    {{-- Pesan error dari session atau API --}}
                    <div x-show="errorMessage" class="mb-4 p-4 bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 rounded-lg" x-text="errorMessage"></div>
                    @if (session('error'))
                    <div class="mb-4 p-4 bg-red-100 text-red-800 dark:bg-red-900/40 dark:text-red-300 rounded-lg">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('reservations.store', $room->id) }}">
                        @csrf
                        <div class="mb-4">
                            <label for="booking_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Atas Nama</label>
                            <input type="text" name="booking_name" id="booking_name" value="{{ old('booking_name', Auth::user()->name) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500" required>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label for="check_in_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Check-in</label>
                                <input type="date" name="check_in_date" id="check_in_date" x-model="checkIn" @change="calculateTotal()" min="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                            <div>
                                <label for="check_out_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Check-out</label>
                                <input type="date" name="check_out_date" id="check_out_date" x-model="checkOut" @change="calculateTotal()" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm dark:bg-gray-700 dark:text-gray-200 focus:border-indigo-500 focus:ring-indigo-500" required>
                            </div>
                        </div>

                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg space-y-2">
                            <div class="flex justify-between items-center text-gray-800 dark:text-gray-200">
                                <span class="font-medium">Total Malam:</span>
                                <span class="font-semibold text-lg" x-text="totalNights > 0 ? totalNights + ' malam' : '-'">-</span>
                            </div>
                            <div class="flex justify-between items-center text-gray-900 dark:text-white">
                                <span class="font-medium">Total Harga:</span>
                                <span class="font-bold text-xl text-indigo-600 dark:text-indigo-400" x-text="totalPrice > 0 ? 'Rp ' + totalPrice.toLocaleString('id-ID') : 'Rp 0'">Rp 0</span>
                            </div>
                        </div>

                        <button type="submit" class="mt-6 w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50" :disabled="isLoading || availableUnits <= 0 || !checkIn || !checkOut">
                            <span x-show="isLoading">Mohon Tunggu...</span>
                            <span x-show="!isLoading && (availableUnits > 0 && checkIn && checkOut)">Kirim Permintaan Reservasi</span>
                            <span x-show="!isLoading && availableUnits <= 0 && checkIn && checkOut">Unit Tidak Tersedia</span>
                            <span x-show="!isLoading && (!checkIn || !checkOut)">Pilih Tanggal</span>
                        </button>
                    </form>
                    @else
                    <div class="text-center">
                        <p class="text-gray-700 dark:text-gray-300">
                            Silakan <a href="{{ route('login') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">login</a> atau <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-semibold">register</a> untuk membuat reservasi.
                        </p>
                    </div>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</x-app-layout>