<x-app-layout>
    {{-- BARU: Definisikan judul untuk halaman ini --}}
    <x-slot name="title">
        ContactHey, Cortana.
    </x-slot>

    <x-page-header
        title="Kontak"
        :backgroundImageUrl="asset('images/hero-hotel.jpg')" />

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold mb-6">Kontak Kami</h3>

                    {{-- Tampilkan pesan sukses/error dari session (setelah redirect) --}}
                    @if (session('contact_success'))
                    <div class="mb-6 p-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-700/30 dark:text-green-300" role="alert">
                        {{ session('contact_success') }}
                    </div>
                    @endif
                    @if (session('contact_error'))
                    <div class="mb-6 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-700/30 dark:text-red-300" role="alert">
                        {{ session('contact_error') }}
                    </div>
                    @endif
                    @if ($errors->any()) {{-- Untuk error validasi --}}
                    <div class="mb-6 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-700/30 dark:text-red-300">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif


                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Kolom Detail Kontak & Peta --}}
                        <div>
                            <div class="mb-8">
                                <h4 class="text-lg font-semibold mb-2">Detail Kontak CallMeHotel:</h4>
                                <p class="mb-1"><strong>Alamat:</strong> Jl. Nasution, Pekanbaru marpoyan, Kode Pos 28284</p>
                                <p class="mb-1"><strong>Telepon:</strong> (012) 998-7766</p>
                                <p class="mb-1"><strong>Email:</strong> callmestartofficial19@gmail.com</p>
                                <p class="mb-1"><strong>Jam Operasional:</strong> Buka 24 Jam</p>
                            </div>
                            <div>
                                <h4 class="text-lg font-semibold mb-2">Lokasi Kami:</h4>
                                <div class="aspect-w-16 aspect-h-9 bg-gray-200 dark:bg-gray-700 rounded-md flex items-center justify-center">
                                    {{-- Ganti src dengan embed code Google Maps Anda --}}
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d45137.8963237198!2d101.43133208119754!3d0.5038162786244086!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5ab80690ee7b1%3A0x94dde92c3823dbe4!2sPekanbaru%2C%20Pekanbaru%20City%2C%20Riau!5e0!3m2!1sen!2sid!4v1749657788289!5m2!1sen!2sid"
                                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom Form Kontak --}}
                        <div>
                            <h4 class="text-lg font-semibold mb-3">Kirim Pesan Kepada Kami</h4>
                            <form action="{{ route('contact.submit') }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Anda</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-200 sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email Anda</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-200 sm:text-sm">
                                </div>
                                <div class="mb-4">
                                    <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subjek</label>
                                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-200 sm:text-sm">
                                </div>
                                <div class="mb-6">
                                    <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pesan Anda</label>
                                    <textarea name="message" id="message" rows="5" required
                                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-900 dark:text-gray-200 sm:text-sm">{{ old('message') }}</textarea>
                                </div>
                                <div>
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-600 dark:focus:ring-indigo-700">
                                        Kirim Pesan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>