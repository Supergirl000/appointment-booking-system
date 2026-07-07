@php
    $method = $method ?? 'POST';
    $submitLabel = $submitLabel ?? 'Save Customer';
@endphp

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf

    @if (! in_array(strtoupper($method), ['GET', 'POST'], true))
        @method($method)
    @endif

    <div class="grid gap-6 lg:grid-cols-2">
        <x-form-input label="Full Name" name="full_name" :value="old('full_name', $customer->full_name)" required autofocus />

        <x-form-input label="Phone" name="phone" :value="old('phone', $customer->phone)" placeholder="+1 555 0101" />

        <div class="lg:col-span-2">
            <x-form-input label="Email" name="email" type="email" :value="old('email', $customer->email)" placeholder="customer@example.com" />
        </div>
    </div>

    <x-form-textarea label="Notes" name="notes" rows="5" :value="old('notes', $customer->notes)" placeholder="Add customer preferences, reminders, or important context." />

    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">
        <x-secondary-button :href="route('customers.index')">Cancel</x-secondary-button>
        <x-primary-button type="submit">{{ $submitLabel }}</x-primary-button>
    </div>
</form>
