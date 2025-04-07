<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'Movers') }}</title>
  @vite('resources/css/app.css')
  @livewireStyles
</head>
<body class="bg-blue-100 text-gray-900 font-sans">
    <div class="min-h-screen">
        <!-- Alpine.js container for menu state -->
        <div x-data="{ open: false, hasScrolled: false }" x-init="window.addEventListener('scroll', () => { hasScrolled = window.scrollY > 0 })" :class="'bg-gray-200 opacity-90': hasScrolled }" class="sticky top-0 transition-colors duration-300 z-40">

            <!-- Header -->
            <header class="grid grid-cols-3 md:grid-cols-4 items-center p-4 min-h-[10vh] bg-blue-100">
                <div class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex space-x-8 text-lg col-span-2 justify-center">
                    <a href="#" class="hover:text-blue-600">Home</a>
                    <a href="#Services" class="hover:text-blue-600">Services</a>
                    <a href="#features" class="hover:text-blue-600">Features</a>
                    <a href="#contact" class="hover:text-blue-600">Contact</a>
                </nav>

                <div class="flex justify-end items-center space-x-4">
                    <a href="/login" class="hidden md:block px-10 py-2 bg-blue-900 text-gray-200 font-semibold rounded-md hover:bg-blue-700 transition">
                        Login
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <button @click="open = !open" class="md:hidden focus:outline-none justify-self-end">
                    <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </header>

            <!-- Mobile Sidebar Menu -->
            <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-x-full" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform -translate-x-full" class="fixed inset-0 z-50 flex" style="display: none;">
                <!-- Sidebar content -->
                <div class="bg-gray-100 w-64 p-6 space-y-6">
                    <button @click="open = false" class="text-gray-700 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <nav class="space-y-4 text-lg">
                        <a href="#" class="block hover:text-blue-600">Home</a>
                        <a href="#Services" class="block hover:text-blue-600">Services</a>
                        <a href="#features" class="block hover:text-blue-600">Features</a>
                        <a href="#contact" class="block hover:text-blue-600">Contact</a>
                    </nav>
                    <a href="/login" class="w-full block text-center px-6 py-3 bg-blue-900 text-gray-200 font-semibold rounded-md hover:bg-blue-700 transition">
                        Employee Login
                    </a>
                </div>
                <!-- Overlay to close sidebar when clicked outside -->
                <div class="flex-1 bg-black opacity-50" @click="open = false"></div>
            </div>
        </div>

        <!-- Hero Section -->
        <section class="flex flex-col-reverse md:flex-row items-center p-8 md:p-16 space-y-8 md:space-y-0 md:space-x-8">
            <!-- Text Content -->
            <div class="flex-1 text-center md:text-left space-y-6">
                <h2 class="text-4xl md:text-6xl font-bold leading-tight">
                    Transform Your <span class="text-blue-800">HR Operations</span>
                </h2>
                <p class="text-gray-600 text-lg">
                    Our integrated HR solution simplifies employee management, payroll processing, and compensation & benefits administration. Automate payrolls, ensure compliance, and empower your workforce with intuitive tools designed for modern businesses.
                </p>
                <div class="flex justify-center md:justify-start space-x-4">
                    <a href="#Services" class="bg-blue-900 px-6 py-3 border border-blue-900 text-gray-200 font-semibold rounded-md hover:bg-blue-700 transition">
                        Explore Services
                    </a>
                    <a href="#features" class="px-6 py-3 border border-blue-900 text-blue-900 font-semibold rounded-md hover:bg-blue-50 transition">
                        View Features
                    </a>
                </div>
            </div>

            <!-- Image Content -->
            <div class="relative flex justify-center items-center">
                <div class="overflow-hidden w-[300px] sm:w-[400px] lg:w-[450px]">
                    <div class="image-container flex transition-transform duration-500 ease-in-out" style="transform: translateX(-100%); transition: transform 0.5s ease-in-out;">
                        <div class="w-full h-full flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" alt="Payroll Processing" class="w-full h-full object-cover rounded-lg shadow-xl">
                        </div>
                        <div class="w-full h-full flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1469&q=80" alt="Benefits Management" class="w-full h-full object-cover rounded-lg shadow-xl">
                        </div>
                        <div class="w-full h-full flex-shrink-0">
                            <img src="https://images.unsplash.com/photo-1643576780112-d390f5de9241?q=80&w=2078&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Benefits Management" class="w-full h-full object-cover rounded-lg shadow-xl">
                        </div>
                    </div>
                </div>
            </div>
        </section>

<!-- Services Section -->
<section id="Services" class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-4">HR Services</h2>
        <p class="text-gray-600 text-center max-w-2xl mx-auto mb-12">Comprehensive tools to manage your workforce efficiently</p>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Employee Management -->
            <div class="bg-blue-50 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-blue-800 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Employee Management</h3>
                <p class="text-gray-600">Streamline employee lifecycle from with centralized records, document management, and performance tracking.</p>
            </div>

            <!-- Payroll Management -->
            <div class="bg-blue-50 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-blue-800 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Payroll Management</h3>
                <p class="text-gray-600">Automate payroll processing with tax calculations, direct deposits, and compliance reporting. Reduce errors and save time with our streamlined system.</p>
            </div>

            <!-- Compensation and Benefits -->
            <div class="bg-blue-50 p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-blue-800 mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-3">Compensation & Benefits</h3>
                <p class="text-gray-600">Design competitive compensation packages and manage benefits programs including health insurance, retirement plans, and employee perks.</p>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="py-16 bg-blue-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-center mb-4">Features</h2>
        <p class="text-gray-600 text-center max-w-2xl mx-auto mb-12">Powerful tools to optimize your HR operations</p>

        <div class="grid md:grid-cols-2 gap-8">
            <!-- Left Column -->
            <div class="space-y-8">
                <!-- Feature 1 -->
                <div class="flex items-start space-x-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Employee Database</h3>
                        <p class="text-gray-600">Centralized employee records with secure access controls and customizable fields for all personnel information.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="flex items-start space-x-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Automated Payroll</h3>
                        <p class="text-gray-600">Process payroll automatically with tax calculations, direct deposit, and compliance with local regulations.</p>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-8">
                <!-- Feature 3 -->
                <div class="flex items-start space-x-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Benefits Administration</h3>
                        <p class="text-gray-600">Manage health insurance, retirement plans, and other benefits with easy enrollment and tracking.</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="flex items-start space-x-4">
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-800" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Compensation Analytics</h3>
                        <p class="text-gray-600">Benchmark salaries and analyze compensation structures to maintain competitive pay packages.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        <!-- Footer Section -->
        <footer id="contact" class="bg-blue-900 py-10 text-white">
            <div class="container mx-auto px-6 md:flex md:justify-between">
                <!-- Left Content -->
                <div class="space-y-4 mb-6 md:mb-0">
                    <div class="flex items-center space-x-2">
                        <span class="text-xl font-bold">Movers</span>
                    </div>
                    <p class="text-blue-200">
                        Get Moving with Movers.
                    </p>
                </div>

                <!-- Center Links -->
                <div class="grid grid-cols-2 gap-8 mb-6 md:mb-0">
                    <div class="space-y-2">
                        <h4 class="font-semibold text-lg">Services</h4>
                        <a href="#" class="block text-blue-200 hover:text-white">Payroll Management</a>
                        <a href="#" class="block text-blue-200 hover:text-white">Compensation Planning</a>
                        <a href="#" class="block text-blue-200 hover:text-white">Benefits Administration</a>
                    </div>
                    <div class="space-y-2">
                        <h4 class="font-semibold text-lg">Company</h4>
                        <a href="#" class="block text-blue-200 hover:text-white">About Us</a>
                        <a href="#" class="block text-blue-200 hover:text-white">Careers</a>
                        <a href="#" class="block text-blue-200 hover:text-white">Contact</a>
                    </div>
                </div>

                <!-- Right Contact Info -->
                <div class="space-y-4">
                    <h4 class="font-semibold text-lg">Contact Us</h4>
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 mt-1 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span>123 HR Avenue, Quezon City, Philippines</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <span>mail@hr1.moverstaxi.com</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <span>+63 123 456 7890</span>
                    </div>
                </div>
            </div>
            <div class="border-t border-blue-800 mt-10 pt-6 text-center text-blue-300">
                <p>    &copy; {{ date('Y') }} MoversTaxi. Get Moving with Movers.</p>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const images = document.querySelectorAll('.image-container div');
            const imageContainer = document.querySelector('.image-container');
            const totalImages = images.length;
            let currentIndex = 0;

            function showNextImage() {
                currentIndex++;

                if (currentIndex >= totalImages) {
                    currentIndex = 0;
                    imageContainer.style.transition = 'none';
                    imageContainer.style.transform = `translateX(0%)`;
                    setTimeout(() => {
                        imageContainer.style.transition = 'transform 0.5s ease-in-out';
                    }, 50);
                }

                const translateX = -currentIndex * 100;
                imageContainer.style.transform = `translateX(${translateX}%)`;

                setTimeout(showNextImage, 3000);
            }

            showNextImage();
        });
    </script>
</body>
</html>
