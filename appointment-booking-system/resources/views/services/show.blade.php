<x-app-layout>
    <x-slot name="header">
        <x-page-header
            :title="$service->name"
            :subtitle="__('Review service details before editing or scheduling in future phases.')"
        >
            <x-slot name="actions">
                <a href="{{ route('services.edit', $service) }}" class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                    {{ __('Edit Service') }}
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
                    <dt class="text-sm font-medium text-slate-500">{{ __('Category') }}</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-950">{{ $service->category ?: 'Uncategorized' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">{{ __('Status') }}</dt>
                    <dd class="mt-1">
                        <x-status-badge :status="$service->status" />
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">{{ __('Duration') }}</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-950">{{ $service->duration_minutes }} minutes</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-slate-500">{{ __('Price') }}</dt>
                    <dd class="mt-1 text-base font-semibold text-slate-950">${{ number_format((float) $service->price, 2) }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-slate-500">{{ __('Description') }}</dt>
                    <dd class="mt-2 leading-7 text-slate-700">{{ $service->description ?: 'No description has been added for this service.' }}</dd>
                </div>
            </dl>
        </section>

        <aside class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="text-lg font-bold text-slate-950">{{ __('Service Actions') }}</h2>
            <div class="mt-5 space-y-3">
                <a href="{{ route('services.index') }}" class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950">
                    <span>{{ __('Back to Services') }}</span>
                    <span class="text-slate-400">#</span>
                </a>
                <a href="{{ route('services.edit', $service) }}" class="flex items-center justify-between rounded-lg border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:bg-slate-50 hover:text-slate-950">
                    <span>{{ __('Edit Details') }}</span>
                    <span class="text-slate-400">#</span>
                </a>
                <form method="POST" action="{{ route('services.destroy', $service) }}" onsubmit="return confirm('Delete this service?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="flex w-full items-center justify-between rounded-lg border border-rose-200 px-4 py-3 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                        <span>{{ __('Delete Service') }}</span>
                        <span>#</span>
                    </button>
                </form>
            </div>
        </aside>
    </div>
</x-app-layout>
