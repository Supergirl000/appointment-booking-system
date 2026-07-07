@props(['padded' => false])

<section {{ $attributes->merge(['class' => 'overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm']) }}>
    @isset($header)
        <div class="border-b border-slate-200 px-4 py-4 sm:px-5">
            {{ $header }}
        </div>
    @endisset

    <div @class(['p-4 sm:p-5' => $padded])>
        {{ $slot }}
    </div>
</section>
