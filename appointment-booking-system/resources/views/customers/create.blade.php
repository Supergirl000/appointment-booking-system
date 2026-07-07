<x-app-layout>
    <x-slot name="header">
        <x-page-header
            title="Create Customer"
            subtitle="Add customer contact information and notes for future appointment workflows."
        />
    </x-slot>

    <x-table-card padded>
        @include('customers.partials.form', [
            'customer' => $customer,
            'action' => route('customers.store'),
            'submitLabel' => 'Create Customer',
        ])
    </x-table-card>
</x-app-layout>
