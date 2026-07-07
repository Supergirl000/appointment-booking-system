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
        {{ $attributes->merge(['class' => 'mt-2 block w-full rounded-md border-slate-300 shadow-sm focus:border-slate-500 focus:ring-slate-500']) }}
    >{{ $value }}</textarea>
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
