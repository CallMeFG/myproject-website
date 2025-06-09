{{-- resources/views/layouts/partials/footer.blade.php --}}
{{-- Kode Perbaikan --}}
{{-- Kode Perbaikan --}}
<footer class="bg-gray-800 dark:bg-gray-900 text-white border-t border-gray-700">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">

            <div class="mb-6 md:mb-0">
                <a href="{{ route('home') }}" class="flex items-center">
                    <x-application-logo class="h-10 w-auto fill-current text-white" />
                    <span class="ml-3 text-xl font-bold">CallMeHotel</span>
                </a>
                <p class="mt-4 text-sm text-gray-400">
                    Pengalaman menginap tak terlupakan dengan fasilitas terbaik dan pelayanan ramah dari kami.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Link Cepat</h3>
                <ul class="mt-4 space-y-2">
                    <li><a href="{{ route('home') }}" class="text-base text-gray-300 hover:text-white">Beranda</a></li>
                    <li><a href="{{ route('rooms.index') }}" class="text-base text-gray-300 hover:text-white">Kamar</a></li>
                    <li><a href="{{ route('about') }}" class="text-base text-gray-300 hover:text-white">Tentang</a></li>
                    <li><a href="{{ route('contact') }}" class="text-base text-gray-300 hover:text-white">Kontak</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Hubungi Kami</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt fa-fw mt-1 mr-2"></i>
                        <span>Jl. Hotel Impian No. 123, Kota Contoh, Kode Pos 45678</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone fa-fw mt-1 mr-2"></i>
                        <span>(021) 123-4567</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-envelope fa-fw mt-1 mr-2"></i>
                        <span>info@callmehotel.test</span>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Ikuti Kami</h3>
                <div class="flex mt-4 space-x-6">
                    {{-- Ikon LinkedIn --}}
                    <a target="_blank" href="https://www.linkedin.com/in/fathur-rizky-assani" class="text-gray-400 hover:text-white" aria-label="LinkedIn">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    {{-- Ikon Instagram --}}
                    <a target="_blank" href="https://www.instagram.com/rzky.sn_/" class="text-gray-400 hover:text-white" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    {{-- Ikon X (Twitter) --}}
                    <a target="_blank" href="https://x.com/RizkyAs_Dev" class="text-gray-400 hover:text-white" aria-label="X (Twitter)">
                        <i class="fab fa-x-twitter"></i>
                    </a>
                    {{-- Ikon GitHub --}}
                    <a target="_blank" href="https://github.com/CallMeFG/" class="text-gray-400 hover:text-white" aria-label="GitHub">
                        <i class="fab fa-github"></i>
                    </a>
                </div>
            </div>

        </div>

        <div class="mt-8 border-t border-gray-700 pt-8 text-center">
            <p class="text-base text-gray-400">&copy; {{ date('Y') }} CallMeHotel. All rights reserved.</p>
        </div>
    </div>
</footer>