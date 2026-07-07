@php
    $method = $method ?? 'POST';
    $submitLabel = $submitLabel ?? 'Save Appointment';
    $appointmentDate = old('appointment_date', $appointment->appointment_date?->format('Y-m-d'));
    $appointmentTime = old('appointment_time', $appointment->appointment_time ? $appointment->appointment_time->format('H:i') : null);
@endphp

<form method="POST" action="{{ $action }}" class="space-y-6">
    @csrf

    @if (! in_array(strtoupper($method), ['GET', 'POST'], true))
        @method($method)
    @endif

    <div class="grid gap-6 lg:grid-cols-2">
        <x-form-select label="Customer" name="customer_id" required>
            <option value="">Select a customer</option>
            @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" @selected((string) old('customer_id', $appointment->customer_id) === (string) $customer->id)>
                    {{ $customer->full_name }}
                </option>
            @endforeach
        </x-form-select>

        <x-form-select label="Service" name="service_id" required>
            <option value="">Select a service</option>
            @foreach ($services as $service)
                <option value="{{ $service->id }}" @selected((string) old('service_id', $appointment->service_id) === (string) $service->id)>
                    {{ $service->name }} - {{ $service->duration_minutes }} min
                </option>
            @endforeach
        </x-form-select>

        <x-form-select label="Staff (optional)" name="staff_id">
            <option value="">No staff assigned</option>
            @foreach ($staffMembers as $staff)
                <option value="{{ $staff->id }}" @selected((string) old('staff_id', $appointment->staff_id) === (string) $staff->id)>
                    {{ $staff->name }}{{ $staff->role ? ' - '.$staff->role : '' }}
                </option>
            @endforeach
        </x-form-select>

        <x-form-select label="Status" name="status" required>
            @foreach ($statuses as $status)
                <option value="{{ $status }}" @selected(old('status', $appointment->status ?? 'pending') === $status)>
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </x-form-select>

        <x-form-input label="Appointment Date" name="appointment_date" type="date" :value="$appointmentDate" required />

        <x-form-input label="Appointment Time" name="appointment_time" type="time" :value="$appointmentTime" required />
    </div>

    <x-form-textarea label="Notes" name="notes" rows="5" :value="old('notes', $appointment->notes)" placeholder="Add internal notes, customer preferences, or preparation details." />

    <div class="flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">
        <x-secondary-button :href="route('appointments.index')">Cancel</x-secondary-button>
        <x-primary-button type="submit">{{ $submitLabel }}</x-primary-button>
    </div>
</form>
