<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>
        @if (isset($title))
        {{ $title }} - {{ config('app.name', 'Laravel') }}
        @else
        {{ config('app.name', 'Laravel') }}
        @endif
    </title>

    <link rel="icon" href="{{ asset('images/letter-c.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: true }" class="flex h-screen bg-gray-100 dark:bg-gray-900">

        <aside class="flex-shrink-0 bg-gray-800 text-white flex flex-col transition-all duration-300"
            :class="sidebarOpen ? 'w-64' : 'w-20'">

            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-700">
                <a href="{{ route('home') }}" class="flex items-center" x-show="sidebarOpen">
                    <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    <span class="ml-2 font-semibold whitespace-nowrap">CallMeHotel</span>
                </a>
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-md hover:bg-gray-700"><i class="fas fa-bars"></i></button>
            </div>

            <div class="flex flex-col justify-between flex-1 overflow-y-auto">
                <nav class="mt-4 px-2 space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                        <i class="fas fa-home fa-fw text-center" style="width: 1.25rem;"></i>
                        <span class="ml-4 whitespace-nowrap" x-show="sidebarOpen">Kembali ke Beranda</span>
                    </a>
                    <hr class="my-2 border-gray-700">
                    <a href="{{ route('user.dashboard') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('user.dashboard') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-tachometer-alt fa-fw text-center" style="width: 1.25rem;"></i>
                        <span class="ml-4 whitespace-nowrap" x-show="sidebarOpen">Dashboard</span>
                    </a>
                    <a href="{{ route('user.profile.edit') }}" class="flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 {{ request()->routeIs('user.profile.edit') ? 'bg-gray-700' : '' }}">
                        <i class="fas fa-user-circle fa-fw text-center" style="width: 1.25rem;"></i>
                        <span class="ml-4 whitespace-nowrap" x-show="sidebarOpen">Profil</span>
                    </a>
                </nav>

                <div class="px-2 pb-2">
                    <hr class="my-2 border-gray-700">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center py-2.5 px-4 rounded transition duration-200 hover:bg-red-700 text-left">
                            <i class="fas fa-sign-out-alt fa-fw text-center" style="width: 1.25rem;"></i>
                            <span class="ml-4 whitespace-nowrap" x-show="sidebarOpen">{{ __('Log Out') }}</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-end items-center p-4 bg-white dark:bg-gray-800 shadow-md">
                <div class="text-gray-800 dark:text-gray-200">
                    Selamat datang, {{ Auth::user()->name }}
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="container mx-auto px-6 py-8">{{ $slot }}</div>
            </main>
        </div>
    </div>
    @stack('scripts')
</body>

</html>