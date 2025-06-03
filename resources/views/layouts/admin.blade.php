<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen">
        <div class="md:hidden fixed top-4 left-4 z-20">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 dark:text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none focus:text-gray-600 dark:focus:text-gray-300">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': sidebarOpen, 'inline-flex': ! sidebarOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! sidebarOpen, 'inline-flex': sidebarOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <aside
            :class="{'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen}"
            class="fixed inset-y-0 left-0 z-10 w-64 bg-gray-800 dark:bg-gray-900 text-white p-4 space-y-2 transform transition duration-300 md:translate-x-0 md:static md:inset-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-2 py-2">
                {{-- Ganti dengan logo Anda jika ada --}}
                <x-application-logo class="block h-9 w-auto fill-current text-white mr-2" />
                <span class="text-xl font-semibold">Admin Panel</span>
            </a>
            <hr class="my-2 border-gray-700">
            <nav class="mt-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.rooms.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('admin.rooms.*') ? 'bg-gray-700' : '' }}">
                    Manajemen Kamar
                </a>
                <a href="{{ route('admin.reservations.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('admin.reservations.*') ? 'bg-gray-700' : '' }}">
                    Manajemen Reservasi
                </a>
                {{-- Tambahkan link untuk Manajemen Kamar nanti --}}
                {{-- <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">Manajemen Kamar</a> --}}
                {{-- Tambahkan link untuk Manajemen Reservasi nanti --}}
                {{-- <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">Manajemen Reservasi</a> --}}
                {{-- Tambahkan link untuk Manajemen User & Staff nanti --}}
                {{-- <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">Manajemen Pengguna</a> --}}

                <hr class="my-2 border-gray-700">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-red-700 w-full text-left">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto pt-16 md:pt-6"> {{-- pt-16 untuk memberi ruang bagi hamburger di mobile --}}
            @if (isset($header))
            <header class="bg-white dark:bg-gray-800 shadow mb-6 sm:rounded-lg">
                <div class="max-w-full mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endif
            {{ $slot }}
        </main>
    </div>
</body>

</html>