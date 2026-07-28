@props([
    'label',
    'name',
])

<div>
    <x-input-label :for="$name" :value="$label" />
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'mt-2 block w-full rounded-md border-slate-300 bg-white text-slate-900 shadow-sm transition focus:border-slate-500 focus:ring-slate-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:focus:border-slate-500 dark:focus:ring-slate-500']) }}
    >
        {{ $slot }}
    </select>
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
