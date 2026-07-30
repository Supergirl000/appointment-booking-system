<x-app-layout>
    <x-slot name="header">
        <x-page-header
            :title="__('Customers')"
            :subtitle="__('Manage customer contact details, preferences, and notes for future appointments.')"
        >
            <x-slot name="actions">
                <x-primary-button :href="route('customers.create')">{{ __('Create Customer') }}</x-primary-button>
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
            <form method="GET" action="{{ route('customers.index') }}" class="grid gap-4 lg:grid-cols-[1fr_auto]">
                <x-form-input label="Search" name="search" type="search" :value="$search" :placeholder="__('Search by full name, phone, or email')" />

                <div class="flex flex-col gap-2 self-end sm:flex-row">
                    <x-primary-button type="submit">{{ __('Search') }}</x-primary-button>
                    <x-secondary-button :href="route('customers.index')">{{ __('Reset') }}</x-secondary-button>
                </div>
            </form>
        </x-table-card>

        <x-table-card>
            @if ($customers->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Customer') }}</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Phone') }}</th>
                                <th scope="col" class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Email') }}</th>
                                <th scope="col" class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-slate-500">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @foreach ($customers as $customer)
                                <tr class="hover:bg-slate-50/70">
                                    <td class="px-5 py-4">
                                        <div class="font-semibold text-slate-950">{{ $customer->full_name }}</div>
                                        <div class="mt-1 max-w-sm truncate text-sm text-slate-500">{{ $customer->notes ?: 'No notes added' }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ $customer->phone ?: 'Not provided' }}</td>
                                    <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">{{ $customer->email ?: 'Not provided' }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap items-center justify-end gap-2">
                                            <a href="{{ route('customers.show', $customer) }}" class="rounded-md px-2.5 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-950">{{ __('View') }}</a>
                                            <a href="{{ route('customers.edit', $customer) }}" class="rounded-md px-2.5 py-1.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-100 hover:text-slate-950">{{ __('Edit') }}</a>
                                            <form method="POST" action="{{ route('customers.destroy', $customer) }}" onsubmit="return confirm('Delete this customer?');">
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
                    {{ $customers->links() }}
                </div>
            @else
                <div class="p-6">
                    <x-empty-state
                        :title="__('No customers found')"
                        :description="__('Create your first customer record or adjust the search term to find existing customers.')"
                        :action-text="__('Create Customer')"
                        :action-href="route('customers.create')"
                    />
                </div>
            @endif
        </x-table-card>
    </div>
</x-app-layout>
