<x-app-layout>
    <x-slot name="header">
        <x-page-header
            title="Edit Service"
            subtitle="Update service details, pricing, duration, and availability."
        />
    </x-slot>

    <x-table-card padded>
        @include('services.partials.form', [
            'service' => $service,
            'action' => route('services.update', $service),
            'method' => 'PUT',
            'submitLabel' => 'Update Service',
        ])
    </x-table-card>
</x-app-layout>
