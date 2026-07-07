@props([
    'label',
    'name',
])

<div>
    <x-input-label :for="$name" :value="$label" />
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $attributes->merge(['class' => 'mt-2 block w-full rounded-md border-slate-300 shadow-sm focus:border-slate-500 focus:ring-slate-500']) }}
    >
        {{ $slot }}
    </select>
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
