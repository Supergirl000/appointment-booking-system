@props([
    'title',
    'value',
    'detail' => null,
    'tone' => 'slate',
])

@php
    $tones = [
        'slate' => 'bg-slate-950 text-white',
        'emerald' => 'bg-emerald-600 text-white',
        'amber' => 'bg-amber-500 text-white',
        'sky' => 'bg-sky-600 text-white',
    ];
@endphp

<div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
    <div class="flex items-start justify-between gap-4">
        <div>
            <p class="text-sm font-medium text-slate-500">{{ $title }}</p>
            <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">{{ $value }}</p>
        </div>

        <span class="{{ $tones[$tone] ?? $tones['slate'] }} flex h-10 w-10 items-center justify-center rounded-lg text-sm font-bold">
            {{ substr($title, 0, 1) }}
        </span>
    </div>

    @if ($detail)
        <p class="mt-4 text-sm text-slate-500">{{ $detail }}</p>
    @endif
</div>
