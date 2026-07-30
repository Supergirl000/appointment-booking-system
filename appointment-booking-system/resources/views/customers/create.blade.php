<x-app-layout>
    <x-slot name="header">
        <x-page-header
            :title="__('Create Customer')"
            :subtitle="__('Add customer contact information and notes for future appointment workflows.')"
        />
    </x-slot>

    <x-table-card padded>
        @include('customers.partials.form', [
            'customer' => $customer,
            'action' => route('customers.store'),
            'submitLabel' => __('Create Customer'),
        ])
    </x-table-card>
</x-app-layout>
