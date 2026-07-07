<x-app-layout>
    <x-slot name="header">
        <x-page-header
            title="Reports"
            subtitle="Review appointment performance, service demand, status trends, and estimated revenue."
        />
    </x-slot>

    <div class="space-y-6">
        <x-table-card padded>
            <form method="GET" action="{{ route('reports.index') }}" class="grid gap-4 xl:grid-cols-[1fr_1fr_1fr_1fr_auto]">
                <x-form-input label="Date From" name="date_from" type="date" :value="$dateFrom" />

                <x-form-input label="Date To" name="date_to" type="date" :value="$dateTo" />

                <x-form-select label="Service" name="service_id">
                    <option value="">All services</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" @selected((string) $serviceId === (string) $service->id)>{{ $service->name }}</option>
                    @endforeach
                </x-form-select>

                <x-form-select label="Status" name="status">
                    <option value="">All statuses</option>
                    @foreach ($statuses as $option)
                        <option value="{{ $option }}" @selected($status === $option)>{{ ucfirst($option) }}</option>
                    @endforeach
                </x-form-select>

                <div class="flex flex-col gap-2 self-end sm:flex-row">
                    <x-primary-button type="submit">Apply</x-primary-button>
                    <x-secondary-button :href="route('reports.index')">Reset</x-secondary-button>
                </div>
            </form>
        </x-table-card>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-dashboard-card title="Total Appointments" :value="$totalAppointments" detail="All appointments matching the current filters." tone="slate" />
            <x-dashboard-card title="Completed" :value="$completedAppointments" detail="Completed appointments in this report." tone="emerald" />
            <x-dashboard-card title="Confirmed" :value="$confirmedAppointments" detail="Confirmed appointments still scheduled." tone="sky" />
            <x-dashboard-card title="Estimated Revenue" value="${{ number_format((float) $estimatedRevenue, 2) }}" detail="Completed appointments multiplied by service price." tone="amber" />
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Pending Appointments</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">{{ $pendingAppointments }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Cancelled Appointments</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">{{ $cancelledAppointments }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">Completion Rate</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">
                    {{ $totalAppointments > 0 ? number_format(($completedAppointments / $totalAppointments) * 100, 1) : '0.0' }}%
                </p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <x-table-card>
                <x-slot name="header">
                    <h2 class="text-lg font-bold text-slate-950">Most Requested Services</h2>
                    <p class="mt-1 text-sm text-slate-500">Services ranked by appointment volume.</p>
                </x-slot>

                @if ($mostRequestedServices->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Service</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Appointments</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($mostRequestedServices as $row)
                                    <tr>
                                        <td class="px-5 py-4">
                                            <p class="font-semibold text-slate-950">{{ $row->service?->name ?? 'Deleted Service' }}</p>
                                            <p class="mt-1 text-sm text-slate-500">{{ $row->service?->category ?? 'Uncategorized' }}</p>
                                        </td>
                                        <td class="px-5 py-4 text-right text-sm font-semibold text-slate-950">{{ $row->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-6">
                        <x-empty-state title="No service data" description="Service demand will appear once appointments match the current filters." />
                    </div>
                @endif
            </x-table-card>

            <x-table-card>
                <x-slot name="header">
                    <h2 class="text-lg font-bold text-slate-950">Appointments Per Month</h2>
                    <p class="mt-1 text-sm text-slate-500">Monthly appointment volume for the selected range.</p>
                </x-slot>

                @if ($appointmentsPerMonth->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">Month</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">Appointments</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($appointmentsPerMonth as $row)
                                    <tr>
                                        <td class="px-5 py-4 text-sm font-semibold text-slate-950">{{ $row->month }}</td>
                                        <td class="px-5 py-4 text-right text-sm font-semibold text-slate-950">{{ $row->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-6">
                        <x-empty-state title="No monthly data" description="Monthly totals will appear once appointments match the current filters." />
                    </div>
                @endif
            </x-table-card>
        </div>

        <x-table-card>
            <x-slot name="header">
                <h2 class="text-lg font-bold text-slate-950">Status Distribution</h2>
                <p class="mt-1 text-sm text-slate-500">Appointment counts grouped by workflow status.</p>
            </x-slot>

            <div class="grid gap-3 p-5 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($statusDistribution as $label => $count)
                    <div class="rounded-lg border border-slate-200 p-4">
                        <x-status-badge :status="$label" />
                        <p class="mt-4 text-3xl font-bold tracking-tight text-slate-950">{{ $count }}</p>
                    </div>
                @endforeach
            </div>
        </x-table-card>
    </div>
</x-app-layout>
