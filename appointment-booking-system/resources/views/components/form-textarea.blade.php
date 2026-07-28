@props([
    'label',
    'name',
    'value' => null,
    'rows' => 5,
])

<div>
    <x-input-label :for="$name" :value="$label" />
    <textarea
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'mt-2 block w-full rounded-md border-slate-300 bg-white text-slate-900 shadow-sm transition placeholder:text-slate-400 focus:border-slate-500 focus:ring-slate-500 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500 dark:focus:border-slate-500 dark:focus:ring-slate-500']) }}
    >{{ $value }}</textarea>
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
