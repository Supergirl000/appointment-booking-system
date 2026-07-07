<x-app-layout>
    <x-slot name="header">
        <x-page-header
            title="Create Appointment"
            subtitle="Schedule a customer with a service, optional staff member, date, time, and status."
        />
    </x-slot>

    <x-table-card padded>
        @include('appointments.partials.form', [
            'appointment' => $appointment,
            'customers' => $customers,
            'services' => $services,
            'staffMembers' => $staffMembers,
            'statuses' => $statuses,
            'action' => route('appointments.store'),
            'submitLabel' => 'Create Appointment',
        ])
    </x-table-card>
</x-app-layout>
