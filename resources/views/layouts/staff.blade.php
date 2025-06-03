<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Staff Panel - {{ config('app.name', 'Laravel') }}</title>

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

            <a href="{{ route('staff.dashboard') }}" class="flex items-center px-2 py-2">
                <svg class="h-9 w-auto fill-current text-white mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                </svg>
                <span class="text-xl font-semibold">Staff Panel</span>
            </a>

            <hr class="my-2 border-gray-700">

            <nav class="mt-4 space-y-1">
                <a href="{{ route('staff.dashboard') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('staff.dashboard') ? 'bg-gray-700' : '' }}">
                    Dashboard
                </a>
                {{-- TAMBAHKAN LINK INI --}}
                <a href="{{ route('staff.reservations.index') }}"
                    class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('staff.reservations.index') ? 'bg-gray-700' : '' }}">
                    Manajemen Reservasi
                </a>

                <hr class="my-2 border-gray-700">
                {{-- ... Tombol Logout ... --}}
                {{-- Link Manajemen Reservasi untuk Staff (Placeholder yang dikomentari dengan benar) --}}
                {{--
                <a href="#" 
                   class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                    Manajemen Reservasi (Segera Hadir)
                </a>
                --}}

                <hr class="my-2 border-gray-700">

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="block py-2.5 px-4 rounded transition duration-200 hover:bg-red-700 w-full text-left">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 p-4 md:p-6 lg:p-8 overflow-y-auto pt-16 md:pt-6">
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