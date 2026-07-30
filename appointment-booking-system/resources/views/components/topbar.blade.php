<header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur transition-colors duration-300 dark:border-slate-800 dark:bg-slate-950/90">
    <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3">
            <button type="button" class="rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white lg:hidden" @click="sidebarOpen = true">
                <span class="sr-only">{{ __('Open sidebar') }}</span>
                <span class="block h-0.5 w-5 bg-current"></span>
                <span class="mt-1.5 block h-0.5 w-5 bg-current"></span>
                <span class="mt-1.5 block h-0.5 w-5 bg-current"></span>
            </button>

            <div>
                <p class="text-sm font-semibold text-slate-950 dark:text-white">{{ __('Admin Dashboard') }}</p>
                <p class="hidden text-xs text-slate-500 dark:text-slate-400 sm:block">{{ __('Manage bookings with a clean operational workspace.') }}</p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <x-language-switcher />
            <x-theme-toggle />

            <a href="{{ route('appointments.create') }}" class="hidden rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-200 dark:hover:border-slate-600 dark:hover:bg-slate-800 dark:hover:text-white sm:inline-flex">
                {{ __('New Appointment') }}
            </a>

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center gap-3 rounded-lg border border-slate-200 bg-white px-2.5 py-2 text-left shadow-sm transition hover:border-slate-300 dark:border-slate-700 dark:bg-slate-900 dark:hover:border-slate-600">
                        <span class="flex h-8 w-8 items-center justify-center rounded-md bg-slate-950 text-xs font-bold text-white dark:bg-white dark:text-slate-950">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                        <span class="hidden sm:block">
                            <span class="block text-sm font-semibold leading-4 text-slate-950 dark:text-white">{{ Auth::user()->name }}</span>
                            <span class="block max-w-36 truncate text-xs text-slate-500 dark:text-slate-400">{{ Auth::user()->email }}</span>
                        </span>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</header>
