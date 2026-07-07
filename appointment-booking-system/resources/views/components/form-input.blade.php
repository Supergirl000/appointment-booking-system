@props([
    'label',
    'name',
    'type' => 'text',
    'value' => null,
])

<div>
    <x-input-label :for="$name" :value="$label" />
    <x-text-input
        :id="$name"
        :name="$name"
        :type="$type"
        class="mt-2 block w-full"
        :value="$value"
        {{ $attributes }}
    />
    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
