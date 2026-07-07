<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'business_name' => 'Lumina Wellness Studio',
            'business_phone' => '+1 555 0300',
            'business_email' => 'hello@luminawellness.test',
            'business_address' => '120 Market Street, Suite 4, Springfield',
            'business_description' => 'A polished demo appointment business for salons, spas, clinics, and consulting teams.',
            'opening_time' => '08:30',
            'closing_time' => '18:00',
            'appointment_slot_duration' => '30',
            'currency' => 'USD',
            'timezone' => 'America/New_York',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
