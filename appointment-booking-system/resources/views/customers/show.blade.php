<x-app-layout>
    <x-slot name="header">
        <x-page-header
            :title="$customer->full_name"
            subtitle="Review customer contact details and appointment history."
        >
            <x-slot name="actions">
                <a href="{{ route('customers.edit', $customer) }}" class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                    Edit Customer
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
        <div class="space-y-6">
            <section class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <dl class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Full Name</dt>
                        <dd class="mt-1 text-base font-semibold text-slate-950">{{ $customer->full_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Phone</dt>
                        <dd class="mt-1 text-base font-semibold text-slate-950">{{ $customer->phone ?: 'Not provided' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Email</dt>
                        <dd class="mt-1 text-base font-semibold text-slate-950">{{ $customer->email ?: 'Not provided' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-slate-500">Created</dt>
                        <dd class="mt-1 text-base font-semibold text-slate-950">{{ $customer->created_at?->format('M d, Y') }}</dd>
                    </div>
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-slate-500">Notes</dt>
                        <dd class="mt-2 leading-7 text-slate-700">{{ $customer->notes ?: 'No notes have been added for this customer.' }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-5">
                    <h2 class="text-lg font-bold text-slate-950">Appointment History</h2>
                    <p class="mt-1 text-sm text-slate-500">Past and upcoming appointments for this customer will appear here in a later phase.</p>
                </div>

                <x-empty-state
                    title="No appointment history yet"
                    description="The appointments module has not been built yet. Once it is available, this section will show this customer's booking history."
                />
            </section>
        </div>

        <aside class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-bold text-slate-950">Customer Actions</h2>
            <div class="mt-5 space-y-3">
                <a href="{{ route('customers.index') }}" class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950">
                    <span>Back to Customers</span>
                    <span class="text-slate-400">#</span>
                </a>
                <a href="{{ route('customers.edit', $customer) }}" class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950">
                    <span>Edit Details</span>
                    <span class="text-slate-400">#</span>
                </a>
                <form method="POST" action="{{ route('customers.destroy', $customer) }}" onsubmit="return confirm('Delete this customer?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex w-full items-center justify-between rounded-lg border border-rose-200 px-4 py-3 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                        <span>Delete Customer</span>
                        <span>#</span>
                    </button>
                </form>
            </div>
        </aside>
    </div>
</x-app-layout>
