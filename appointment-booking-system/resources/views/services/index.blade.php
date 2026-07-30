<x-app-layout>
    <x-slot name="header">
        <x-page-header
            :title="__('Services')"
            :subtitle="__('Manage the bookable salon and spa services offered to customers.')"
        >
            <x-slot name="actions">
                <x-primary-button :href="route('services.create')">{{ __('Create Service') }}</x-primary-button>
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
            <form method="GET" action="{{ route('services.index') }}" class="grid gap-4 lg:grid-cols-[1fr_220px_auto]">
                <x-form-input label="Search" name="search" type="search" :value="$search" :placeholder="__('Search by service name or category')" />

                <x-form-select :label="__('Status')" name="status">
                    <option value="">{{ __('All statuses') }}</option>
                    <option value="active" @selected($status === 'active')>{{ __('Active') }}</option>
                    <option value="inactive" @selected($status === 'inactive')>{{ __('Inactive') }}</option>
                </x-form-select>

                <div class="flex flex-col gap-2 self-end sm:flex-row">
                    <x-primary-button type="submit">{{ __('Filter') }}</x-primary-button>
                    <x-secondary-button :href="route('services.index')">{{ __('Reset') }}</x-secondary-button>
                </div>
            </form>
        </x-table-card>

        <x-table-card>
            @if ($services->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Service') }}</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Duration') }}</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Price') }}</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Status') }}</th>
                                <th scope="col" class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach ($services as $service)
                                <tr class="hover:bg-slate-50/70">
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-slate-950">{{ $service->name }}</div>
                                        <div class="mt-1 text-sm text-slate-500">{{ $service->category ?: 'Uncategorized' }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ $service->duration_minutes }} min</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-950">${{ number_format((float) $service->price, 2) }}</td>
                                    <td class="whitespace-nowrap px-5 py-4">
                                        <x-status-badge :status="$service->status" />
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap items-center justify-end gap-2">
                                            <a href="{{ route('services.show', $service) }}" class="rounded-md px-2.5 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-950">{{ __('View') }}</a>
                                            <a href="{{ route('services.edit', $service) }}" class="rounded-md px-2.5 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-950">{{ __('Edit') }}</a>
                                            <form method="POST" action="{{ route('services.destroy', $service) }}" onsubmit="return confirm('Delete this service?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-md px-2.5 py-1.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                                                    {{ __('Delete') }}
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
                    {{ $services->links() }}
                </div>
            @else
                <div class="p-6">
                    <x-empty-state
                        :title="__('No services found')"
                        :description="__('Create your first service or adjust the search filters to find existing services.')"
                        :action-text="__('Create Service')"
                        :action-href="route('services.create')"
                    />
                </div>
            @endif
        </x-table-card>
    </div>
</x-app-layout>
