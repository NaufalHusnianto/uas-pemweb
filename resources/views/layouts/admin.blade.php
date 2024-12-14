<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <!-- Navbar -->
        <nav class="bg-white shadow-md border-b border-gray-200">
            <div class="container mx-auto px-4 py-3 flex items-center justify-between">
                <!-- Brand -->
                <a href="{{ route('admin') }}" class="text-xl font-bold text-gray-800 hover:text-blue-600 flex gap-4">
                    <x-application-logo class="h-6 w-auto fill-current" />
                    Admin Panel
                </a>

                <!-- Toggle Button for Sidebar (Mobile) -->
                <button
                    id="menu-toggle"
                    class="md:hidden text-gray-600 hover:text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-200"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>

                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="hidden md:flex items-center">
                    @csrf
                    <button
                        class="bg-red-500 hover:bg-red-600 text-white text-sm font-medium px-4 py-2 rounded-md">
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        <!-- Sidebar + Main Content -->
        <div class="flex">
            <!-- Sidebar -->
            <aside
                id="sidebar"
                class="w-64 bg-gray-800 text-gray-100 min-h-screen transform -translate-x-full md:translate-x-0 md:relative fixed md:block transition-transform duration-200 ease-in-out"
            >
                <div class="px-4 py-6">
                    <a href="{{ route('admin') }}" class="block text-2xl font-semibold mb-8 text-center text-white">
                        Admin Panel
                    </a>
                    <nav class="space-y-4">
                        <a href="{{ route('admin') }}" class="block px-4 py-2 rounded-md hover:bg-gray-600 {{ request()->routeIs('admin') ? 'bg-gray-700' : '' }}">Dashboard</a>
                        <a href="{{ route('admin.product.index') }}" class="block px-4 py-2 rounded-md hover:bg-gray-600 {{ request()->is('admin/product*') ? 'bg-gray-700' : '' }}">Manage Products</a>
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-8">
                {{ $slot }}
            </main>
        </div>

        <!-- Scripts for Sidebar Toggle -->
        <script>
            const toggleButton = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');

            toggleButton.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        </script>
    </body>
</html>
