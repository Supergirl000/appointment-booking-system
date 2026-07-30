@php
    $currentLocale = app()->getLocale();
    $locales = [
        'en' => ['label' => 'EN', 'name' => __('English')],
        'fr' => ['label' => 'FR', 'name' => __('French')],
    ];
@endphp

<div class="inline-flex rounded-lg border border-slate-200 bg-white p-1 shadow-sm transition dark:border-slate-700 dark:bg-slate-900" aria-label="{{ __('Language switcher') }}">
    @foreach ($locales as $locale => $language)
        <a
            href="{{ route('language.switch', $locale) }}"
            @class([
                'rounded-md px-2.5 py-1.5 text-xs font-bold transition focus:outline-none focus:ring-2 focus:ring-slate-300 dark:focus:ring-slate-600',
                'bg-slate-950 text-white dark:bg-white dark:text-slate-950' => $currentLocale === $locale,
                'text-slate-500 hover:bg-slate-100 hover:text-slate-950 dark:text-slate-300 dark:hover:bg-slate-800 dark:hover:text-white' => $currentLocale !== $locale,
            ])
            title="{{ $language['name'] }}"
        >
            <span class="sr-only">{{ $language['name'] }}</span>
            {{ $language['label'] }}
        </a>
    @endforeach
</div>