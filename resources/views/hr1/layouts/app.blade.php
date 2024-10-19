<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Movers') }}</title>
    @livewireStyles
    @vite('resources/css/app.css')
</head>
<body x-data="{ open: false, rotate: false }" class="bg-blue-100 flex">
    <!-- Sidebar Component -->
    <x-hr1-sidebar />
    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Navbar Component -->
        <x-hr1-navbar />
        <x-breadcrumbs />
        <!-- Main Content -->
        <main :class="open ? 'ml-72' : 'ml-0'" class="flex-1 p-6 transition-transform duration-300 ease-in-out">
            @yield('content')
        </main>
    </div>
    @livewireScripts
    @vite('resources/js/app.js')
</body>
</html>
