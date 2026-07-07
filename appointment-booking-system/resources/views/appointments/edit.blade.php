<x-app-layout>
    <x-slot name="header">
        <x-page-header
            title="Edit Appointment"
            subtitle="Update appointment assignment, schedule, status, and internal notes."
        />
    </x-slot>

    <x-table-card padded>
        @include('appointments.partials.form', [
            'appointment' => $appointment,
            'customers' => $customers,
            'services' => $services,
            'staffMembers' => $staffMembers,
            'statuses' => $statuses,
            'action' => route('appointments.update', $appointment),
            'method' => 'PUT',
            'submitLabel' => 'Update Appointment',
        ])
    </x-table-card>
</x-app-layout>
