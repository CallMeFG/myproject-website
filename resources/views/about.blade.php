<x-app-layout>
    {{-- BARU: Definisikan judul untuk halaman ini --}}
    <x-slot name="title">
        About
    </x-slot>
    <x-page-header
        title="About"
        :backgroundImageUrl="asset('images/pool.jpg')" />

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-16">

            <section class="text-center">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Mengenal CallMeHotel Lebih Dekat</h1>
                <p class="max-w-3xl mx-auto text-lg text-gray-600 dark:text-gray-400">
                    Selamat datang di CallMeHotel! Kami berkomitmen untuk menyediakan pengalaman menginap yang tak terlupakan. Pelajari lebih lanjut tentang nilai-nilai, perjalanan, dan orang-orang yang membuat kami istimewa.
                </p>
            </section>

            <section>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-eye text-3xl text-blue-500 mr-4"></i>
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Visi Kami</h2>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">
                            Menjadi jaringan hotel terdepan di Indonesia yang dikenal karena pelayanan istimewa, inovasi berkelanjutan, dan kontribusi positif terhadap komunitas lokal.
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-bullseye text-3xl text-blue-500 mr-4"></i>
                            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Misi Kami</h2>
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">
                            Memberikan kenyamanan dan kepuasan maksimal kepada setiap tamu melalui fasilitas modern, staf yang ramah dan profesional, serta pengalaman menginap yang personal dan berkesan.
                        </p>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Perjalanan Kami</h2>
                <div class="relative max-w-2xl mx-auto">
                    <div class="absolute left-1/2 w-0.5 h-full bg-gray-300 dark:bg-gray-700 transform -translate-x-1/2"></div>

                    <div class="relative mb-8">
                        <div class="absolute left-1/2 w-4 h-4 bg-blue-500 rounded-full transform -translate-x-1/2 mt-1.5"></div>
                        <div class="w-full md:w-1/2 md:pr-8 md:text-right">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white">2015 - Awal Mula</h3>
                            <p class="text-gray-600 dark:text-gray-400">CallMeHotel didirikan dengan satu properti kecil dengan mimpi besar untuk mengubah industri perhotelan lokal.</p>
                        </div>
                    </div>
                    <div class="relative mb-8">
                        <div class="absolute left-1/2 w-4 h-4 bg-blue-500 rounded-full transform -translate-x-1/2 mt-1.5"></div>
                        <div class="w-full md:w-1/2 md:pl-8 md:ml-auto">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white">2018 - Ekspansi Pertama</h3>
                            <p class="text-gray-600 dark:text-gray-400">Membuka cabang kedua di kota besar, memperkenalkan standar layanan baru dan fasilitas yang lebih modern.</p>
                        </div>
                    </div>
                    <div class="relative mb-8">
                        <div class="absolute left-1/2 w-4 h-4 bg-blue-500 rounded-full transform -translate-x-1/2 mt-1.5"></div>
                        <div class="w-full md:w-1/2 md:pr-8 md:text-right">
                            <h3 class="font-bold text-lg text-gray-900 dark:text-white">2022 - Penghargaan Digital</h3>
                            <p class="text-gray-600 dark:text-gray-400">Menerima penghargaan untuk sistem reservasi online terbaik yang memberikan kemudahan bagi pelanggan.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <h2 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-12">Di Balik Layar</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="text-center">
                        <img class="w-32 h-32 mx-auto rounded-full shadow-lg mb-4 object-cover" src="{{asset('images/bussinessman.jpg')}}" alt="Foto John Doe">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-white">John Doe</h4>
                        <p class="text-gray-500 dark:text-gray-400">Founder & CEO</p>
                    </div>
                    <div class="text-center">
                        <img class="w-32 h-32 mx-auto rounded-full shadow-lg mb-4 object-cover" src="{{asset('images/man.png') }}" alt="Foto Jane Smith">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Fathur Rizky Assani</h4>
                        <p class="text-gray-500 dark:text-gray-400">Project Manager</p>
                    </div>
                    <div class="text-center">
                        <img class="w-32 h-32 mx-auto rounded-full shadow-lg mb-4 object-cover" src="{{asset('images/produceman.jpg') }}" alt="Foto Alex Johnson">
                        <h4 class="text-xl font-semibold text-gray-900 dark:text-white">Alex Johnson</h4>
                        <p class="text-gray-500 dark:text-gray-400">Customer Service Lead</p>
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>