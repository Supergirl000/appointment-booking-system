@props([
    'title',
    'description',
    'actionText' => null,
    'actionHref' => '#',
])

<div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center transition-colors duration-300 dark:border-slate-700 dark:bg-slate-900">
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-slate-100 text-lg font-bold text-slate-500 transition-colors dark:bg-slate-800 dark:text-slate-300">
        +
    </div>

    <h3 class="mt-4 text-base font-semibold text-slate-950 dark:text-white">{{ $title }}</h3>
    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500 dark:text-slate-400">{{ $description }}</p>

    @if ($actionText)
        <a href="{{ $actionHref }}" class="mt-5 inline-flex w-full items-center justify-center rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-400 focus:ring-offset-2 dark:bg-white dark:text-slate-950 dark:hover:bg-slate-200 dark:focus:ring-slate-500 dark:focus:ring-offset-slate-950 sm:w-auto">
            {{ $actionText }}
        </a>
    @endif
</div>
