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
    <body class="font-sans text-gray-900 antialiased transition-colors duration-300 dark:text-slate-100">
        <div class="relative flex min-h-screen flex-col items-center bg-gray-100 pt-6 transition-colors duration-300 dark:bg-slate-950 sm:justify-center sm:pt-0">
            <div class="absolute right-4 top-4">
                <x-theme-toggle />
            </div>

            <div>
                <a href="/">
                    <x-application-logo class="h-20 w-20 fill-current text-gray-500 transition-colors dark:text-slate-400" />
                </a>
            </div>

            <div class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md transition-colors duration-300 dark:border dark:border-slate-800 dark:bg-slate-900 sm:max-w-md sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
