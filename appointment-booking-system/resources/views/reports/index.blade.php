<x-app-layout>
    <x-slot name="header">
        <x-page-header
            :title="__('Reports')"
            :subtitle="__('Review appointment performance, service demand, status trends, and estimated revenue.')"
        />
    </x-slot>

    <div class="space-y-6">
        <x-table-card padded>
            <form method="GET" action="{{ route('reports.index') }}" class="grid gap-4 xl:grid-cols-[1fr_1fr_1fr_1fr_auto]">
                <x-form-input :label="__('Date From')" name="date_from" type="date" :value="$dateFrom" />

                <x-form-input :label="__('Date To')" name="date_to" type="date" :value="$dateTo" />

                <x-form-select :label="__('Service')" name="service_id">
                    <option value="">{{ __('All services') }}</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" @selected((string) $serviceId === (string) $service->id)>{{ $service->name }}</option>
                    @endforeach
                </x-form-select>

                <x-form-select :label="__('Status')" name="status">
                    <option value="">{{ __('All statuses') }}</option>
                    @foreach ($statuses as $option)
                        <option value="{{ $option }}" @selected($status === $option)>{{ __($option) }}</option>
                    @endforeach
                </x-form-select>

                <div class="flex flex-col gap-2 self-end sm:flex-row">
                    <x-primary-button type="submit">{{ __('Apply') }}</x-primary-button>
                    <x-secondary-button :href="route('reports.index')">{{ __('Reset') }}</x-secondary-button>
                </div>
            </form>
        </x-table-card>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <x-dashboard-card :title="__('Total Appointments')" :value="$totalAppointments" :detail="__('All appointments matching the current filters.')" tone="slate" />
            <x-dashboard-card :title="__('Completed')" :value="$completedAppointments" :detail="__('Completed appointments in this report.')" tone="emerald" />
            <x-dashboard-card :title="__('Confirmed')" :value="$confirmedAppointments" :detail="__('Confirmed appointments still scheduled.')" tone="sky" />
            <x-dashboard-card :title="__('Estimated Revenue')" value="${{ number_format((float) $estimatedRevenue, 2) }}" :detail="__('Completed appointments multiplied by service price.')" tone="amber" />
        </div>

        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Pending Appointments') }}</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">{{ $pendingAppointments }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Cancelled Appointments') }}</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">{{ $cancelledAppointments }}</p>
            </div>
            <div class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Completion Rate') }}</p>
                <p class="mt-3 text-3xl font-bold tracking-tight text-slate-950">
                    {{ $totalAppointments > 0 ? number_format(($completedAppointments / $totalAppointments) * 100, 1) : '0.0' }}%
                </p>
            </div>
        </div>

        <div class="grid gap-6 xl:grid-cols-2">
            <x-table-card>
                <x-slot name="header">
                    <h2 class="text-lg font-bold text-slate-950">{{ __('Most Requested Services') }}</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('Services ranked by appointment volume.') }}</p>
                </x-slot>

                @if ($mostRequestedServices->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Service') }}</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Appointments') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach ($mostRequestedServices as $row)
                                    <tr>
                                        <td class="px-5 py-4">
                                            <p class="font-semibold text-slate-950">{{ $row->service?->name ?? __('Deleted Service') }}</p>
                                            <p class="mt-1 text-sm text-slate-500">{{ $row->service?->category ?? __('Uncategorized') }}</p>
                                        </td>
                                        <td class="px-5 py-4 text-right text-sm font-semibold text-slate-950">{{ $row->total }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-6">
                        <x-empty-state :title="__('No service data')" :description="__('Service demand will appear once appointments match the current filters.')" />
                    </div>
                @endif
            </x-table-card>

            <x-table-card>
                <x-slot name="header">
                    <h2 class="text-lg font-bold text-slate-950">{{ __('Appointments Per Month') }}</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('Monthly appointment volume for the selected range.') }}</p>
                </x-slot>

                @if ($appointmentsPerMonth->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Month') }}</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Appointments') }}</th>
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
                        <x-empty-state :title="__('No monthly data')" :description="__('Monthly totals will appear once appointments match the current filters.')" />
                    </div>
                @endif
            </x-table-card>
        </div>

        <x-table-card>
            <x-slot name="header">
                <h2 class="text-lg font-bold text-slate-950">{{ __('Status Distribution') }}</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ __('Appointment counts grouped by workflow status.') }}</p>
            </x-slot>

            <div class="grid gap-3 p-5 sm:grid-cols-2 xl:grid-cols-4">
                @foreach ($statusDistribution as $label => $count)
                    <div class="rounded-lg border border-slate-200 p-4 dark:border-slate-800">
                        <x-status-badge :status="$label" />
                        <p class="mt-4 text-3xl font-bold tracking-tight text-slate-950 dark:text-white">{{ $count }}</p>
                    </div>
                @endforeach
            </div>
        </x-table-card>
    </div>
</x-app-layout>
