@props([
    'title',
    'subtitle' => null,
])

<div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-950 sm:text-3xl">{{ $title }}</h1>

        @if ($subtitle)
            <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-500">{{ $subtitle }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex w-full flex-col gap-2 sm:w-auto sm:flex-row sm:items-center sm:justify-end">
            {{ $actions }}
        </div>
    @endisset
</div>
