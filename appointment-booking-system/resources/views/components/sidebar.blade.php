@props(['mobile' => false])

@php
    $links = [
        ['label' => __('Dashboard'), 'href' => route('dashboard'), 'active' => request()->routeIs('dashboard'), 'icon' => 'D'],
        ['label' => __('Services'), 'href' => route('services.index'), 'active' => request()->routeIs('services.*'), 'icon' => 'S'],
        ['label' => __('Customers'), 'href' => route('customers.index'), 'active' => request()->routeIs('customers.*'), 'icon' => 'C'],
        ['label' => __('Appointments'), 'href' => route('appointments.index'), 'active' => request()->routeIs('appointments.*'), 'icon' => 'A'],
        ['label' => __('Calendar'), 'href' => route('calendar.index'), 'active' => request()->routeIs('calendar.*'), 'icon' => 'M'],
        ['label' => __('Reports'), 'href' => route('reports.index'), 'active' => request()->routeIs('reports.*'), 'icon' => 'R'],
        ['label' => __('Settings'), 'href' => route('settings.index'), 'active' => request()->routeIs('settings.*'), 'icon' => 'G'],
    ];
@endphp

<aside
    @if ($mobile)
        x-cloak
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col border-r border-slate-200 bg-slate-50 px-4 py-5 shadow-2xl transition-colors duration-300 dark:border-slate-800 dark:bg-slate-950 lg:hidden"
    @else
        class="fixed inset-y-0 left-0 z-30 hidden w-72 flex-col border-r border-slate-200 bg-slate-50 px-4 py-5 transition-colors duration-300 dark:border-slate-800 dark:bg-slate-950 lg:flex"
    @endif
>
    <div class="flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-slate-950 text-sm font-bold text-white shadow-sm dark:bg-white dark:text-slate-950">
                AB
            </span>
            <span>
                <span class="block text-base font-bold tracking-tight text-slate-950 dark:text-white">Appointly</span>
                <span class="block text-xs font-medium text-slate-500 dark:text-slate-400">{{ __('Booking Admin') }}</span>
            </span>
        </a>

        @if ($mobile)
            <button type="button" class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-200 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white" @click="sidebarOpen = false">
                <span class="sr-only">{{ __('Close sidebar') }}</span>
                <span class="block h-5 w-5 text-center text-xl leading-4">&times;</span>
            </button>
        @endif
    </div>

    <nav class="mt-8 space-y-1.5">
        @foreach ($links as $link)
            <x-nav-link :href="$link['href']" :active="$link['active']">
                <x-slot name="icon">{{ $link['icon'] }}</x-slot>
                {{ $link['label'] }}
            </x-nav-link>
        @endforeach
    </nav>

    <div class="mt-auto rounded-lg border border-slate-200 bg-white p-4 shadow-sm transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900">
        <p class="text-sm font-semibold text-slate-950 dark:text-white">{{ __('Booking Workspace') }}</p>
        <p class="mt-1 text-xs leading-5 text-slate-500 dark:text-slate-400">{{ __('Manage bookings, reports, and business configuration from one clean workspace.') }}</p>
    </div>
</aside>
