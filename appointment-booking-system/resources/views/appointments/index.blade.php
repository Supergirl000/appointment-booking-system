<x-app-layout>
    <x-slot name="header">
        <x-page-header
            title="Appointments"
            subtitle="Manage customer bookings, assigned services, staff, dates, times, and appointment status."
        >
            <x-slot name="actions">
                <x-primary-button :href="route('appointments.create')">Create Appointment</x-primary-button>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="space-y-5">
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <x-table-card padded>
            <form method="GET" action="{{ route('appointments.index') }}" class="grid gap-4 xl:grid-cols-[1fr_200px_200px_auto]">
                <x-form-input label="Search" name="search" type="search" :value="$search" placeholder="Search by customer or service" />

                <x-form-select label="Status" name="status">
                    <option value="">All statuses</option>
                    @foreach (['pending', 'confirmed', 'completed', 'cancelled'] as $option)
                        <option value="{{ $option }}" @selected($status === $option)>{{ ucfirst($option) }}</option>
                    @endforeach
                </x-form-select>

                <x-form-input label="Date" name="date" type="date" :value="$date" />

                <div class="flex flex-col gap-2 self-end sm:flex-row">
                    <x-primary-button type="submit">Filter</x-primary-button>
                    <x-secondary-button :href="route('appointments.index')">Reset</x-secondary-button>
                </div>
            </form>
        </x-table-card>

        <x-table-card>
            @if ($appointments->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Appointment</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Service</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Staff</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Status</th>
                                <th scope="col" class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach ($appointments as $appointment)
                                <tr class="hover:bg-slate-50/70">
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-slate-950">{{ $appointment->customer->full_name }}</div>
                                        <div class="mt-1 text-sm text-slate-500">{{ $appointment->appointment_date->format('M d, Y') }} at {{ $appointment->appointment_time->format('H:i') }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ $appointment->service->name }}</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ $appointment->staff?->name ?: 'Unassigned' }}</td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <x-status-badge :status="$appointment->status" />
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap items-center justify-end gap-2">
                                            <a href="{{ route('appointments.show', $appointment) }}" class="rounded-md px-2.5 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-950">View</a>
                                            <a href="{{ route('appointments.edit', $appointment) }}" class="rounded-md px-2.5 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-950">Edit</a>
                                            <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" onsubmit="return confirm('Delete this appointment?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-md px-2.5 py-1.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="border-t border-slate-200 px-5 py-4">
                    {{ $appointments->links() }}
                </div>
            @else
                <div class="p-6">
                    <x-empty-state
                        title="No appointments found"
                        description="Create your first appointment or adjust the search and filter options."
                        action-text="Create Appointment"
                        :action-href="route('appointments.create')"
                    />
                </div>
            @endif
        </x-table-card>
    </div>
</x-app-layout>
