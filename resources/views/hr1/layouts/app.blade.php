<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Movers') }}</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body>
    <div x-data="{ sidebarIsOpen: false }" class="relative flex w-full flex-col md:flex-row">
        <a class="sr-only" href="#main-content">skip to the main content</a>
        <div x-cloak x-show="sidebarIsOpen" class="fixed inset-0 z-20 bg-neutral-950/10 backdrop-blur-sm md:hidden" aria-hidden="true" x-on:click="sidebarIsOpen = false" x-transition.opacity ></div>
        <x-hr1-sidebar />
        <x-hr1-navbar />
            <!-- main content  -->
            <div id="main-content" class="p-4">
                <div class="overflow-y-auto">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/app.js')
    @livewireScripts
</body>
</html>
