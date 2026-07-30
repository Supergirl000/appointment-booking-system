@php
    $method = $method ?? 'POST';
    $submitLabel = $submitLabel ?? 'Save Service';
@endphp

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf

    @if (! in_array(strtoupper($method), ['GET', 'POST'], true))
        @method($method)
    @endif

    <div class="grid gap-6 lg:grid-cols-2">
        <x-form-input label="Service Name" name="name" :value="old('name', $service->name)" required autofocus />

        <x-form-input :label="__('Category')" name="category" :value="old('category', $service->category)" placeholder="{{ __('Skin Care, Massage, Nails') }}" />

        <x-form-input :label="__('Duration (minutes)')" name="duration_minutes" type="number" min="5" step="5" :value="old('duration_minutes', $service->duration_minutes)" required />

        <x-form-input :label="__('Price')" name="price" type="number" min="0" step="0.01" :value="old('price', $service->price)" required />

        <x-form-select :label="__('Status')" name="status" required>
            @foreach (['active' => 'Active', 'inactive' => 'Inactive'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $service->status ?? 'active') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </x-form-select>
    </div>

    <x-form-textarea :label="__('Description')" name="description" rows="5" :value="old('description', $service->description)" placeholder="{{ __('Describe what clients can expect from this service.') }}" />

    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">
        <x-secondary-button :href="route('services.index')">{{ __('Cancel') }}</x-secondary-button>
        <x-primary-button type="submit">{{ $submitLabel }}</x-primary-button>
    </div>
</form>
