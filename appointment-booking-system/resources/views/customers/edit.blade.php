<x-app-layout>
    <x-slot name="header">
        <x-page-header
            :title="__('Edit Customer')"
            :subtitle="__('Update customer contact details, preferences, and notes.')"
        />
    </x-slot>

    <x-table-card padded>
        @include('customers.partials.form', [
            'customer' => $customer,
            'action' => route('customers.update', $customer),
            'method' => 'PUT',
            'submitLabel' => __('Update Customer'),
        ])
    </x-table-card>
</x-app-layout>
