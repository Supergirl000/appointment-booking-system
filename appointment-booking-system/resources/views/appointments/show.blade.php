<x-app-layout>
    <x-slot name="header">
        <x-page-header
            title="Appointment Details"
            subtitle="Review the customer, service, staff assignment, schedule, and current status."
        >
            <x-slot name="actions">
                <a href="{{ route('appointments.edit', $appointment) }}" class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                    Edit Appointment
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    @if (session('success'))
        <div class="mb-5 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid gap-6 xl:grid-cols-[1fr_320px]">
        <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
            <dl class="grid gap-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-slate-500">Customer</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-950">{{ $appointment->customer->full_name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Service</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-950">{{ $appointment->service->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Staff</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-950">{{ $appointment->staff?->name ?: 'Unassigned' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Status</dt>
                    <dd class="mt-1">
                        <x-status-badge :status="$appointment->status" />
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Date</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-950">{{ $appointment->appointment_date->format('M d, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">Time</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-950">{{ $appointment->appointment_time->format('H:i') }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-slate-500">Notes</dt>
                    <dd class="mt-2 leading-7 text-slate-700">{{ $appointment->notes ?: 'No notes have been added for this appointment.' }}</dd>
                </div>
            </dl>
        </section>

        <aside class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-bold text-slate-950">Appointment Actions</h2>
            <div class="mt-5 space-y-3">
                <a href="{{ route('appointments.index') }}" class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950">
                    <span>Back to Appointments</span>
                    <span class="text-slate-400">#</span>
                </a>
                <a href="{{ route('appointments.edit', $appointment) }}" class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950">
                    <span>Edit Details</span>
                    <span class="text-slate-400">#</span>
                </a>
                <form method="POST" action="{{ route('appointments.destroy', $appointment) }}" onsubmit="return confirm('Delete this appointment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex w-full items-center justify-between rounded-lg border border-rose-200 px-4 py-3 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                        <span>Delete Appointment</span>
                        <span>#</span>
                    </button>
                </form>
            </div>
        </aside>
    </div>
</x-app-layout>
