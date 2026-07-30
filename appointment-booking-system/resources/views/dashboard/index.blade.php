<x-app-layout>
    <x-slot name="header">
        <x-page-header
            :title="__('Dashboard')"
            :subtitle="__('A focused command center for tracking appointments, customers, and service readiness.')"
        >
            <x-slot name="actions">
                <a href="{{ route('appointments.create') }}" class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                    {{ __('New Appointment') }}
                </a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="space-y-6">
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-dashboard-card :title="__('Today\'s Appointments')" :value="$todaysAppointmentsCount" :detail="__('Bookings scheduled for the current business day.')" tone="slate" />
            <x-dashboard-card :title="__('Upcoming')" :value="$upcomingAppointmentsCount" :detail="__('Appointments scheduled after today.')" tone="sky" />
            <x-dashboard-card :title="__('Customers')" :value="$customersCount" :detail="__('Total customer records in the system.')" tone="emerald" />
            <x-dashboard-card :title="__('Services')" :value="$servicesCount" :detail="__('Total bookable services in the catalog.')" tone="amber" />
        </div>

        <div class="grid gap-6 xl:grid-cols-[1fr_360px]">
            <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-5 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-bold text-slate-950">{{ __('Today\'s Schedule') }}</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ __('Appointments scheduled for the current business day.') }}</p>
                    </div>
                </div>

                @if ($todaysAppointments->count())
                    <div class="space-y-3">
                        @foreach ($todaysAppointments as $appointment)
                            <a href="{{ route('appointments.show', $appointment) }}" class="flex flex-col gap-3 rounded-lg border border-slate-200 px-4 py-4 transition hover:border-slate-300 hover:bg-slate-50 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <p class="font-semibold text-slate-950">{{ $appointment->customer->full_name }}</p>
                                    <p class="mt-1 text-sm text-slate-500">{{ $appointment->service->name }}{{ $appointment->staff ? ' with '.$appointment->staff->name : '' }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-semibold text-slate-700">{{ $appointment->appointment_time->format('H:i') }}</span>
                                    <x-status-badge :status="$appointment->status" />
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <x-empty-state
                        :title="__('No appointments scheduled today')"
                        :description="__('Create an appointment to start building today\'s schedule.')"
                        :action-text="__('Create Appointment')"
                        :action-href="route('appointments.create')"
                    />
                @endif
            </section>

            <aside class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-lg font-bold text-slate-950">{{ __('Quick Actions') }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ __('Shortcuts for the workflows this admin area will support.') }}</p>

                <div class="mt-5 space-y-3">
                    <a href="{{ route('appointments.create') }}" class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950">
                        <span>{{ __('New Appointment') }}</span>
                        <span class="text-slate-400">+</span>
                    </a>
                    <a href="{{ route('customers.create') }}" class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950">
                        <span>{{ __('Add Customer') }}</span>
                        <span class="text-slate-400">+</span>
                    </a>
                    <a href="{{ route('services.create') }}" class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950">
                        <span>{{ __('Add Service') }}</span>
                        <span class="text-slate-400">+</span>
                    </a>
                    <a href="#" class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950">
                        <span>{{ __('View Calendar') }}</span>
                        <span class="text-slate-400">#</span>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>
