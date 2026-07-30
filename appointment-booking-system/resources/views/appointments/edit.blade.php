<x-app-layout>
    <x-slot name="header">
        <x-page-header
            :title="__('Edit Appointment')"
            :subtitle="__('Update appointment assignment, schedule, status, and internal notes.')"
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
            'submitLabel' => __('Update Appointment'),
        ])
    </x-table-card>
</x-app-layout>
