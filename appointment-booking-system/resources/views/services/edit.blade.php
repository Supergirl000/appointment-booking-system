<x-app-layout>
    <x-slot name="header">
        <x-page-header
            :title="__('Edit Service')"
            :subtitle="__('Update service details, pricing, duration, and availability.')"
        />
    </x-slot>

    <x-table-card padded>
        @include('services.partials.form', [
            'service' => $service,
            'action' => route('services.update', $service),
            'method' => 'PUT',
            'submitLabel' => __('Update Service'),
        ])
    </x-table-card>
</x-app-layout>
