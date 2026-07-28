@props(['active' => false])

@php
$classes = $active
    ? 'group flex items-center gap-3 rounded-lg bg-white px-3 py-2.5 text-sm font-semibold text-slate-950 shadow-sm ring-1 ring-slate-200 transition dark:bg-slate-900 dark:text-white dark:ring-slate-700'
    : 'group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-500 transition hover:bg-white/80 hover:text-slate-950 hover:shadow-sm dark:text-slate-400 dark:hover:bg-slate-900/80 dark:hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @isset($icon)
        <span class="{{ $active ? 'bg-slate-950 text-white dark:bg-white dark:text-slate-950' : 'bg-slate-200 text-slate-600 group-hover:bg-slate-950 group-hover:text-white dark:bg-slate-800 dark:text-slate-300 dark:group-hover:bg-white dark:group-hover:text-slate-950' }} flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-xs font-bold transition">
            {{ $icon }}
        </span>
    @endisset

    {{ $slot }}
</a>
