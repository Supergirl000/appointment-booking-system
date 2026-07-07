@props(['active' => false])

@php
$classes = $active
    ? 'group flex items-center gap-3 rounded-lg bg-white px-3 py-2.5 text-sm font-semibold text-slate-950 shadow-sm ring-1 ring-slate-200'
    : 'group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-500 transition hover:bg-white/80 hover:text-slate-950 hover:shadow-sm';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @isset($icon)
        <span class="{{ $active ? 'bg-slate-950 text-white' : 'bg-slate-200 text-slate-600 group-hover:bg-slate-950 group-hover:text-white' }} flex h-8 w-8 shrink-0 items-center justify-center rounded-md text-xs font-bold transition">
            {{ $icon }}
        </span>
    @endisset

    {{ $slot }}
</a>
