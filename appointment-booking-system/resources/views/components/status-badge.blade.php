@props(['status'])

@php
    $tone = match ($status) {
        'active', 'completed' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'confirmed' => 'bg-sky-50 text-sky-700 ring-sky-200',
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-200',
        'inactive' => 'bg-slate-100 text-slate-600 ring-slate-200',
        'cancelled' => 'bg-rose-50 text-rose-700 ring-rose-200',
        default => 'bg-slate-100 text-slate-600 ring-slate-200',
    };
@endphp

<span {{ $attributes->merge(['class' => $tone.' inline-flex rounded-full px-2.5 py-1 text-xs font-semibold capitalize ring-1']) }}>
    {{ $slot->isEmpty() ? $status : $slot }}
</span>
