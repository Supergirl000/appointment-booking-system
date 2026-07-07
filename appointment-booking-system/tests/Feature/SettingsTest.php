<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_page_requires_authentication(): void
    {
        $this->get(route('settings.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_settings_page(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('settings.index'))
            ->assertOk()
            ->assertSee('Business Information')
            ->assertSee('Working Hours')
            ->assertSee('Appointment Rules')
            ->assertSee('Localization');
    }

    public function test_settings_validation_rules_are_enforced(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('settings.update'), [
            'business_name' => '',
            'business_phone' => str_repeat('1', 51),
            'business_email' => 'not-an-email',
            'appointment_slot_duration' => 4,
            'currency' => '',
            'timezone' => '',
        ])->assertSessionHasErrors([
            'business_name',
            'business_phone',
            'business_email',
            'appointment_slot_duration',
            'currency',
            'timezone',
        ]);
    }

    public function test_settings_are_saved_as_key_value_records(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->put(route('settings.update'), [
            'business_name' => 'Polished Studio',
            'business_phone' => '+1 555 0400',
            'business_email' => 'hello@polished.test',
            'business_address' => '44 Main Street',
            'business_description' => 'Premium appointment-based beauty studio.',
            'opening_time' => '08:30',
            'closing_time' => '17:30',
            'appointment_slot_duration' => 20,
            'currency' => 'USD',
            'timezone' => 'America/New_York',
        ])
            ->assertRedirect(route('settings.index'))
            ->assertSessionHas('success', 'Business settings updated successfully.');

        $this->assertDatabaseHas('settings', [
            'key' => 'business_name',
            'value' => 'Polished Studio',
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'appointment_slot_duration',
            'value' => '20',
        ]);
        $this->assertDatabaseHas('settings', [
            'key' => 'timezone',
            'value' => 'America/New_York',
        ]);

        $this->assertSame('USD', Setting::where('key', 'currency')->value('value'));
    }
}
