<x-app-layout>
    <x-slot name="header">
        <x-page-header
            title="Settings"
            subtitle="Manage business profile, working hours, appointment rules, and localization preferences."
        />
    </x-slot>

    <div class="space-y-5">
        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('settings.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <x-table-card padded>
                <div class="border-b border-slate-200 pb-4">
                    <h2 class="text-lg font-bold text-slate-950">Business Information</h2>
                    <p class="mt-1 text-sm text-slate-500">Core details shown across appointment operations.</p>
                </div>

                <div class="mt-5 grid gap-6 lg:grid-cols-2">
                    <x-form-input label="Business Name" name="business_name" :value="old('business_name', $settings['business_name'])" required />

                    <x-form-input label="Business Phone" name="business_phone" :value="old('business_phone', $settings['business_phone'])" />

                    <x-form-input label="Business Email" name="business_email" type="email" :value="old('business_email', $settings['business_email'])" />

                    <x-form-input label="Business Address" name="business_address" :value="old('business_address', $settings['business_address'])" />

                    <div class="lg:col-span-2">
                        <x-form-textarea label="Business Description" name="business_description" rows="4" :value="old('business_description', $settings['business_description'])" />
                    </div>
                </div>
            </x-table-card>

            <x-table-card padded>
                <div class="border-b border-slate-200 pb-4">
                    <h2 class="text-lg font-bold text-slate-950">Working Hours</h2>
                    <p class="mt-1 text-sm text-slate-500">Default daily opening and closing times.</p>
                </div>

                <div class="mt-5 grid gap-6 lg:grid-cols-2">
                    <x-form-input label="Opening Time" name="opening_time" type="time" :value="old('opening_time', $settings['opening_time'])" />

                    <x-form-input label="Closing Time" name="closing_time" type="time" :value="old('closing_time', $settings['closing_time'])" />
                </div>
            </x-table-card>

            <x-table-card padded>
                <div class="border-b border-slate-200 pb-4">
                    <h2 class="text-lg font-bold text-slate-950">Appointment Rules</h2>
                    <p class="mt-1 text-sm text-slate-500">Basic rules used by future scheduling workflows.</p>
                </div>

                <div class="mt-5">
                    <x-form-input label="Appointment Slot Duration (minutes)" name="appointment_slot_duration" type="number" min="5" step="5" class="lg:max-w-sm" :value="old('appointment_slot_duration', $settings['appointment_slot_duration'])" required />
                </div>
            </x-table-card>

            <x-table-card padded>
                <div class="border-b border-slate-200 pb-4">
                    <h2 class="text-lg font-bold text-slate-950">Localization</h2>
                    <p class="mt-1 text-sm text-slate-500">Currency and timezone preferences for business operations.</p>
                </div>

                <div class="mt-5 grid gap-6 lg:grid-cols-2">
                    <x-form-input label="Currency" name="currency" :value="old('currency', $settings['currency'])" required />

                    <x-form-select label="Timezone" name="timezone" required>
                        @foreach ($timezones as $timezone)
                            <option value="{{ $timezone }}" @selected(old('timezone', $settings['timezone']) === $timezone)>{{ $timezone }}</option>
                        @endforeach
                    </x-form-select>
                </div>
            </x-table-card>

            <div class="flex justify-end">
                <x-primary-button type="submit">Save Settings</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
