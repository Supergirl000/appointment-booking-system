<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <x-theme-script />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 transition-colors duration-300 dark:text-slate-100">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-slate-100 transition-colors duration-300 dark:bg-slate-950">
            <x-sidebar />

            <div
                x-cloak
                x-show="sidebarOpen"
                x-transition.opacity
                class="fixed inset-0 z-40 bg-slate-950/70 lg:hidden"
                @click="sidebarOpen = false"
            ></div>

            <x-sidebar mobile />

            <div class="lg:pl-72">
                <x-topbar />

                <main class="px-3 py-5 sm:px-6 sm:py-6 lg:px-8">
                    <div class="mx-auto max-w-7xl">
                        @isset($header)
                            <div class="mb-6">
                                {{ $header }}
                            </div>
                        @endisset

                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
