@props(['padded' => false])

<section {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition-colors duration-300 dark:border-slate-800 dark:bg-slate-900']) }}>
    @isset($header)
        <div class="border-b border-slate-200 px-4 py-4 transition-colors duration-300 dark:border-slate-800 sm:px-5">
            {{ $header }}
        </div>
    @endisset

    <div @class(['p-4 sm:p-5' => $padded])>
        {{ $slot }}
    </div>
</section>
