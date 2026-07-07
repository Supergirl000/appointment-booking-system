<x-app-layout>
    <x-slot name="header">
        <x-page-header
            title="Create Service"
            subtitle="Add a bookable service with duration, pricing, and availability status."
        />
    </x-slot>

    <x-table-card padded>
        @include('services.partials.form', [
            'service' => $service,
            'action' => route('services.store'),
            'submitLabel' => 'Create Service',
        ])
    </x-table-card>
</x-app-layout>
