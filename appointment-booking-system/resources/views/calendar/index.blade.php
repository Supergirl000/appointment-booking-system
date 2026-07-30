<x-app-layout>
    <x-slot name="header">
        <x-page-header
            :title="__('Calendar')"
            :subtitle="__('Review appointments by month with quick filters for status, staff, and service.')"
        >
            <x-slot name="actions">
                <x-primary-button :href="route('appointments.create')">{{ __('New Appointment') }}</x-primary-button>
            </x-slot>
        </x-page-header>
    </x-slot>

    @php
        $filterQuery = array_filter([
            'status' => $status,
            'staff_id' => $staffId,
            'service_id' => $serviceId,
        ], fn ($value) => filled($value));

        $weekdays = collect(range(0, 6))->map(fn ($offset) => $month->copy()->startOfWeek()->addDays($offset)->translatedFormat('D'));
    @endphp

    <div class="space-y-5">
        <x-table-card padded>
            <div class="flex flex-col gap-4 xl:flex-row xl:items-end xl:justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Viewing Month') }}</p>
                    <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">{{ $month->translatedFormat('F Y') }}</h2>
                </div>

                <div class="flex flex-wrap gap-2">
                    <x-secondary-button :href="route('calendar.index', array_merge($filterQuery, ['month' => $previousMonth]))">{{ __('Previous') }}</x-secondary-button>
                    <x-primary-button :href="route('calendar.index', array_merge($filterQuery, ['month' => $currentMonth]))">{{ __('Today') }}</x-primary-button>
                    <x-secondary-button :href="route('calendar.index', array_merge($filterQuery, ['month' => $nextMonth]))">{{ __('Next') }}</x-secondary-button>
                </div>
            </div>

            <form method="GET" action="{{ route('calendar.index') }}" class="mt-5 grid gap-4 lg:grid-cols-[1fr_1fr_1fr_auto]">
                <input type="hidden" name="month" value="{{ $month->format('Y-m') }}">

                <x-form-select :label="__('Status')" name="status">
                    <option value="">{{ __('All statuses') }}</option>
                    @foreach ($statuses as $option)
                        <option value="{{ $option }}" @selected($status === $option)>{{ __($option) }}</option>
                    @endforeach
                </x-form-select>

                <x-form-select :label="__('Staff')" name="staff_id">
                    <option value="">{{ __('All staff') }}</option>
                    @foreach ($staffMembers as $staff)
                        <option value="{{ $staff->id }}" @selected((string) $staffId === (string) $staff->id)>{{ $staff->name }}</option>
                    @endforeach
                </x-form-select>

                <x-form-select :label="__('Service')" name="service_id">
                    <option value="">{{ __('All services') }}</option>
                    @foreach ($services as $service)
                        <option value="{{ $service->id }}" @selected((string) $serviceId === (string) $service->id)>{{ $service->name }}</option>
                    @endforeach
                </x-form-select>

                <div class="flex flex-col gap-2 self-end sm:flex-row">
                    <x-primary-button type="submit">{{ __('Apply') }}</x-primary-button>
                    <x-secondary-button :href="route('calendar.index', ['month' => $month->format('Y-m')])">{{ __('Reset') }}</x-secondary-button>
                </div>
            </form>
        </x-table-card>

        <x-table-card>
            <div class="hidden grid-cols-7 border-b border-slate-200 bg-slate-50 lg:grid">
                @foreach ($weekdays as $weekday)
                    <div class="px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">{{ $weekday }}</div>
                @endforeach
            </div>

            <div class="grid gap-3 p-3 sm:grid-cols-2 lg:grid-cols-7 lg:gap-0 lg:p-0">
                @foreach ($calendarDays as $day)
                    @php
                        $dateKey = $day->toDateString();
                        $dayAppointments = $appointmentsByDate->get($dateKey, collect());
                        $isToday = $day->isToday();
                        $isCurrentMonth = $day->isSameMonth($month);
                    @endphp

                    <article @class([
                        'min-h-44 rounded-lg border p-3 lg:rounded-none lg:border-0 lg:border-r lg:border-b',
                        'border-slate-200 bg-white' => $isCurrentMonth && ! $isToday,
                        'border-slate-200 bg-slate-50 text-slate-400' => ! $isCurrentMonth,
                        'border-slate-950 bg-slate-950 text-white ring-2 ring-slate-950 lg:ring-0' => $isToday,
                    ])>
                        <div class="flex items-center justify-between gap-3">
                            <p @class([
                                'text-sm font-bold',
                                'text-slate-950' => $isCurrentMonth && ! $isToday,
                                'text-slate-400' => ! $isCurrentMonth,
                                'text-white' => $isToday,
                            ])>
                                <span class="lg:hidden">{{ $day->translatedFormat('D, ') }}</span>{{ $day->format('j') }}
                            </p>

                            <span @class([
                                'rounded-full px-2 py-0.5 text-xs font-semibold',
                                'bg-slate-100 text-slate-600' => ! $isToday,
                                'bg-white/15 text-white' => $isToday,
                            ])>
                                {{ $dayAppointments->count() }}
                            </span>
                        </div>

                        <div class="mt-3 space-y-2">
                            @forelse ($dayAppointments as $appointment)
                                <a href="{{ route('appointments.show', $appointment) }}" @class([
                                    'block rounded-md border px-3 py-2 transition',
                                    'border-slate-200 bg-white hover:border-slate-300 hover:bg-slate-50' => ! $isToday,
                                    'border-white/20 bg-white/10 hover:bg-white/15' => $isToday,
                                ])>
                                    <div class="flex items-center justify-between gap-2">
                                        <span @class([
                                            'text-xs font-bold',
                                            'text-slate-700' => ! $isToday,
                                            'text-white' => $isToday,
                                        ])>{{ $appointment->appointment_time->format('H:i') }}</span>
                                        <x-status-badge :status="$appointment->status" class="px-2 py-0.5 text-[11px]" />
                                    </div>
                                    <p @class([
                                        'mt-1 truncate text-sm font-semibold',
                                        'text-slate-950' => ! $isToday,
                                        'text-white' => $isToday,
                                    ])>{{ $appointment->customer->full_name }}</p>
                                    <p @class([
                                        'mt-0.5 truncate text-xs',
                                        'text-slate-500' => ! $isToday,
                                        'text-white/70' => $isToday,
                                    ])>{{ $appointment->service->name }}</p>
                                </a>
                            @empty
                                <p @class([
                                    'rounded-md border border-dashed px-3 py-2 text-xs',
                                    'border-slate-200 text-slate-400' => ! $isToday,
                                    'border-white/20 text-white/60' => $isToday,
                                ])>{{ __('No appointments') }}</p>
                            @endforelse
                        </div>
                    </article>
                @endforeach
            </div>
        </x-table-card>
    </div>
</x-app-layout>
