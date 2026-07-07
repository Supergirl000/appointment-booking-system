@props([
    'title',
    'description',
    'actionText' => null,
    'actionHref' => '#',
])

<div class="rounded-lg border border-dashed border-slate-300 bg-white p-8 text-center">
    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-lg bg-slate-100 text-lg font-bold text-slate-500">
        +
    </div>

    <h3 class="mt-4 text-base font-semibold text-slate-950">{{ $title }}</h3>
    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">{{ $description }}</p>

    @if ($actionText)
        <a href="{{ $actionHref }}" class="mt-5 inline-flex w-full items-center justify-center rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 sm:w-auto">
            {{ $actionText }}
        </a>
    @endif
</div>
