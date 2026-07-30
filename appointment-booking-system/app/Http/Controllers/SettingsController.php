<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingsRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SettingsController extends Controller
{
    private const DEFAULTS = [
        'business_name' => 'Appointly Salon & Spa',
        'business_phone' => '',
        'business_email' => '',
        'business_address' => '',
        'business_description' => '',
        'opening_time' => '09:00',
        'closing_time' => '18:00',
        'appointment_slot_duration' => '30',
        'currency' => 'USD',
        'timezone' => 'UTC',
    ];

    public function index(): View
    {
        return view('settings.index', [
            'settings' => $this->settings(),
            'timezones' => timezone_identifiers_list(),
        ]);
    }

    public function update(UpdateSettingsRequest $request): RedirectResponse
    {
        foreach ($request->validated() as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()
            ->route('settings.index')
            ->with('success', __('Business settings updated successfully.'));
    }

    private function settings(): array
    {
        $storedSettings = Setting::whereIn('key', array_keys(self::DEFAULTS))
            ->pluck('value', 'key')
            ->all();

        return array_merge(self::DEFAULTS, $storedSettings);
    }
}
