
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Appointly') }}</title>

    <x-theme-script />

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-slate-900 antialiased">

@if (request()->routeIs('login'))

    <!-- Premium login layout -->
    <main class="min-h-screen bg-slate-100 lg:grid lg:grid-cols-2">

        <!-- Left branding panel -->
        <section class="relative isolate hidden min-h-screen flex-col justify-between overflow-hidden bg-[#101d3a] p-10 text-white lg:flex xl:p-16">

            <!-- Background decoration -->
            <div class="pointer-events-none absolute -right-40 -top-40 h-96 w-96 rounded-full bg-indigo-500/20 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-40 -left-32 h-96 w-96 rounded-full bg-blue-500/20 blur-3xl"></div>

            <!-- Brand -->
            <a href="/" class="relative z-10 flex items-center gap-3">
                <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-500 text-white shadow-lg shadow-indigo-950/30">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-7 w-7"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <rect x="3" y="5" width="18" height="16" rx="2"/>
                        <path d="M7 3v4M17 3v4M3 10h18M8 15l2.5 2.5L16 12"/>
                    </svg>
                </span>

                <span class="text-2xl font-extrabold tracking-tight">
                    Appointly
                </span>
            </a>

            <!-- Main branding content -->
            <div class="relative z-10 mx-auto w-full max-w-xl py-14">

                <!-- Calendar illustration -->
                <div class="mb-12 rounded-3xl border border-white/15 bg-white/10 p-6 shadow-2xl backdrop-blur-sm">
                    <div class="mb-6 flex items-center justify-between">
                        <div>
                            <p class="text-xs uppercase tracking-widest text-indigo-200">
                                Your schedule
                            </p>
                            <h2 class="mt-1 text-xl font-bold text-white">
                                September 2026
                            </h2>
                        </div>
                        <span class="rounded-xl bg-indigo-400/20 p-3 text-indigo-200">
                            &#10003;
                        </span>
                    </div>

                    <div class="grid grid-cols-7 gap-2 text-center text-sm">
                        @foreach (['M','T','W','T','F','S','S'] as $day)
                            <div class="py-2 font-semibold text-indigo-200">
                                {{ $day }}
                            </div>
                        @endforeach

                        @for ($day = 1; $day <= 28; $day++)
                            <div class="{{ $day === 22
                                ? 'bg-indigo-400 text-white shadow-lg'
                                : 'bg-white/10 text-slate-200' }}
                                rounded-lg py-2">
                                {{ $day }}
                            </div>
                        @endfor
                    </div>

                    <div class="mt-6 flex items-center gap-3 rounded-xl border border-white/10 bg-white/10 p-4">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-400/20 text-emerald-300">
                            &#10003;
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-white">
                                Appointment confirmed
                            </p>
                            <p class="text-xs text-slate-300">
                                Your business, organized.
                            </p>
                        </div>
                    </div>
                </div>

                <h1 class="text-4xl font-extrabold leading-tight tracking-tight xl:text-5xl">
                    Scheduling,
                    <span class="text-indigo-300">
                        made simple.
                    </span>
                </h1>

                <p class="mt-5 max-w-md text-base leading-8 text-slate-300">
                    Manage appointments, organize clients, and simplify your
                    daily workflow with one intuitive workspace.
                </p>
            </div>

            <p class="relative z-10 text-sm text-slate-400">
                &copy; {{ date('Y') }} Appointly. All rights reserved.
            </p>
        </section>

        <!-- Right login panel -->
        <section class="relative flex min-h-screen flex-col bg-white px-6 py-8 sm:px-12 lg:px-16 xl:px-24">

            <!-- Top controls -->
            <div class="flex items-center justify-between gap-4">
                <a href="/" class="flex items-center gap-2 text-lg font-bold text-slate-900 lg:invisible">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-700 text-white">
                        &#10003;
                    </span>
                    Appointly
                </a>

                <div class="flex items-center gap-2">
                    <x-language-switcher />
                    <x-theme-toggle />
                </div>
            </div>

            <!-- Login form container -->
            <div class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center py-12">

                @if (session('demo_restricted'))
                    <div class="mb-5 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-800">
                        {{ session('demo_restricted') }}
                    </div>
                @endif

                {{ $slot }}

            </div>

            <p class="text-center text-xs text-slate-400">
                Secure appointment management with Appointly
            </p>
        </section>

    </main>

@else

    <!-- Original layout for other guest pages -->
    <div class="relative flex min-h-screen flex-col items-center bg-gray-100 pt-6 transition-colors duration-300 dark:bg-slate-950 sm:justify-center sm:pt-0">

        <div class="absolute right-4 top-4 flex items-center gap-2">
            <x-language-switcher />
            <x-theme-toggle />
        </div>

        <div>
            <a href="/">
                <x-application-logo class="h-20 w-20 fill-current text-gray-500 transition-colors dark:text-slate-400" />
            </a>
        </div>

        <div class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md transition-colors duration-300 dark:border dark:border-slate-800 dark:bg-slate-900 sm:max-w-md sm:rounded-lg">
            @if (session('demo_restricted'))
                <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-800 dark:border-amber-500/30 dark:bg-amber-500/10 dark:text-amber-200">
                    {{ session('demo_restricted') }}
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>

@endif

</body>
</html>
