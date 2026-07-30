<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Staff;
use App\Models\User;
use Database\Seeders\DemoUserSeeder;
use Database\Seeders\PrivateAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DemoModeTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_account_can_login_and_access_normal_admin_pages(): void
    {
        $this->seed(DemoUserSeeder::class);

        $this->post(route('login'), [
            'email' => 'demo@lumiere.com',
            'password' => 'demo123',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticatedAs(User::where('email', 'demo@lumiere.com')->first());

        foreach ($this->normalAdminRoutes() as $route) {
            $this->get($route)->assertOk();
        }
    }

    public function test_demo_account_can_perform_allowed_portfolio_crud_actions(): void
    {
        $demo = User::factory()->create(['is_demo' => true]);
        [$customer, $service, $staff] = $this->appointmentDependencies();

        $this->actingAs($demo)->post(route('services.store'), [
            'name' => 'Demo Consultation',
            'category' => 'Consulting',
            'duration_minutes' => 30,
            'price' => 75,
            'description' => 'Demo-safe service record.',
            'status' => 'active',
        ])->assertRedirect();

        $createdService = Service::where('name', 'Demo Consultation')->firstOrFail();

        $this->actingAs($demo)->put(route('services.update', $createdService), [
            'name' => 'Updated Demo Consultation',
            'category' => 'Consulting',
            'duration_minutes' => 45,
            'price' => 95,
            'description' => 'Updated demo-safe service record.',
            'status' => 'inactive',
        ])->assertRedirect(route('services.show', $createdService));

        $this->actingAs($demo)->post(route('customers.store'), [
            'full_name' => 'Demo Customer',
            'phone' => '+1 555 0199',
            'email' => 'demo.customer@example.com',
            'notes' => 'Portfolio test customer.',
        ])->assertRedirect();

        $createdCustomer = Customer::where('email', 'demo.customer@example.com')->firstOrFail();

        $this->actingAs($demo)->put(route('customers.update', $createdCustomer), [
            'full_name' => 'Updated Demo Customer',
            'phone' => '+1 555 0198',
            'email' => 'updated.demo.customer@example.com',
            'notes' => 'Updated portfolio test customer.',
        ])->assertRedirect(route('customers.show', $createdCustomer));

        $this->actingAs($demo)->post(route('appointments.store'), [
            'customer_id' => $customer->id,
            'service_id' => $service->id,
            'staff_id' => $staff->id,
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '10:30',
            'status' => 'pending',
            'notes' => 'Portfolio appointment test.',
        ])->assertRedirect();

        $appointment = Appointment::where('customer_id', $customer->id)->firstOrFail();

        $this->actingAs($demo)->put(route('appointments.update', $appointment), [
            'customer_id' => $customer->id,
            'service_id' => $service->id,
            'staff_id' => null,
            'appointment_date' => now()->addDays(2)->toDateString(),
            'appointment_time' => '14:00',
            'status' => 'confirmed',
            'notes' => 'Demo status changed.',
        ])->assertRedirect(route('appointments.show', $appointment));

        $this->assertDatabaseHas('services', ['id' => $createdService->id, 'status' => 'inactive']);
        $this->assertDatabaseHas('customers', ['id' => $createdCustomer->id, 'full_name' => 'Updated Demo Customer']);
        $this->assertDatabaseHas('appointments', ['id' => $appointment->id, 'status' => 'confirmed']);
    }

    public function test_demo_account_cannot_perform_restricted_direct_http_actions(): void
    {
        $demo = User::factory()->create([
            'name' => 'Demo Admin',
            'email' => 'demo@lumiere.com',
            'password' => Hash::make('password'),
            'is_demo' => true,
        ]);
        [$customer, $service, $staff] = $this->appointmentDependencies();
        $appointment = $this->makeAppointment($customer, $service, $staff);

        $this->actingAs($demo)
            ->from(route('services.index'))
            ->delete(route('services.destroy', $service))
            ->assertRedirect(route('services.index'))
            ->assertSessionHas('demo_restricted', 'This action is disabled in demo mode.');
        $this->assertDatabaseHas('services', ['id' => $service->id]);

        $this->actingAs($demo)
            ->from(route('customers.index'))
            ->delete(route('customers.destroy', $customer))
            ->assertRedirect(route('customers.index'))
            ->assertSessionHas('demo_restricted', 'This action is disabled in demo mode.');
        $this->assertDatabaseHas('customers', ['id' => $customer->id]);

        $this->actingAs($demo)
            ->from(route('appointments.index'))
            ->delete(route('appointments.destroy', $appointment))
            ->assertRedirect(route('appointments.index'))
            ->assertSessionHas('demo_restricted', 'This action is disabled in demo mode.');
        $this->assertDatabaseHas('appointments', ['id' => $appointment->id]);

        $this->actingAs($demo)
            ->from(route('settings.index'))
            ->put(route('settings.update'), $this->settingsPayload(['business_name' => 'Changed Demo Business']))
            ->assertRedirect(route('settings.index'))
            ->assertSessionHas('demo_restricted', 'This action is disabled in demo mode.');
        $this->assertDatabaseMissing('settings', ['key' => 'business_name', 'value' => 'Changed Demo Business']);

        $this->actingAs($demo)
            ->from(route('profile.edit'))
            ->patch(route('profile.update'), ['name' => 'Changed Demo', 'email' => 'changed@example.test'])
            ->assertRedirect(route('profile.edit'))
            ->assertSessionHas('demo_restricted', 'This action is disabled in demo mode.');
        $this->assertSame('Demo Admin', $demo->refresh()->name);
        $this->assertSame('demo@lumiere.com', $demo->email);

        $this->actingAs($demo)
            ->from(route('profile.edit'))
            ->put(route('password.update'), [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->assertRedirect(route('profile.edit'))
            ->assertSessionHas('demo_restricted', 'This action is disabled in demo mode.');
        $this->assertTrue(Hash::check('password', $demo->refresh()->password));

        $this->actingAs($demo)
            ->from(route('profile.edit'))
            ->delete(route('profile.destroy'), ['password' => 'password'])
            ->assertRedirect(route('profile.edit'))
            ->assertSessionHas('demo_restricted', 'This action is disabled in demo mode.');
        $this->assertNotNull($demo->fresh());
    }

    public function test_demo_profile_page_shows_disabled_mode_message(): void
    {
        $demo = User::factory()->create(['is_demo' => true]);

        $this->actingAs($demo)
            ->get(route('profile.edit'))
            ->assertOk()
            ->assertSee('Profile changes are disabled in demo mode.')
            ->assertSee('Password changes are disabled in demo mode.')
            ->assertSee('Account deletion is disabled in demo mode.')
            ->assertDontSee('Once your account is deleted, all of its resources and data will be permanently deleted.');
    }

    public function test_private_admin_seeder_uses_environment_credentials_without_demo_restrictions(): void
    {
        $this->withPrivateAdminEnvironment('owner@example.test', 'private-demo-password');

        $this->seed(PrivateAdminSeeder::class);

        $admin = User::where('email', 'owner@example.test')->firstOrFail();

        $this->assertSame('RugosTech Admin', $admin->name);
        $this->assertFalse($admin->is_demo);
        $this->assertTrue(Hash::check('private-demo-password', $admin->password));

        $this->post(route('login'), [
            'email' => 'owner@example.test',
            'password' => 'private-demo-password',
        ])->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_private_admin_is_not_affected_by_demo_restrictions(): void
    {
        $admin = User::factory()->create(['is_demo' => false]);
        [$customer, $service, $staff] = $this->appointmentDependencies();
        $appointment = $this->makeAppointment($customer, $service, $staff);

        $this->actingAs($admin)->delete(route('appointments.destroy', $appointment))
            ->assertRedirect(route('appointments.index'));
        $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);

        $this->actingAs($admin)->put(route('settings.update'), $this->settingsPayload([
            'business_name' => 'Normal Admin Business',
        ]))->assertRedirect(route('settings.index'));
        $this->assertSame('Normal Admin Business', Setting::where('key', 'business_name')->value('value'));

        $this->actingAs($admin)->patch(route('profile.update'), [
            'name' => 'Updated Private Admin',
            'email' => 'updated.private@example.test',
        ])->assertRedirect(route('profile.edit'));
        $this->assertSame('Updated Private Admin', $admin->refresh()->name);

        $this->actingAs($admin)->from(route('profile.edit'))->put(route('password.update'), [
            'current_password' => 'password',
            'password' => 'new-private-password',
            'password_confirmation' => 'new-private-password',
        ])->assertRedirect(route('profile.edit'));
        $this->assertTrue(Hash::check('new-private-password', $admin->refresh()->password));
    }

    public function test_demo_login_panel_is_visible_on_login_page(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Demo Access')
            ->assertSee('demo@lumiere.com')
            ->assertSee('demo123')
            ->assertSee('Use Demo Account')
            ->assertDontSee('PRIVATE_ADMIN_PASSWORD');
    }

    private function normalAdminRoutes(): array
    {
        return [
            route('dashboard'),
            route('services.index'),
            route('customers.index'),
            route('appointments.index'),
            route('calendar.index'),
            route('reports.index'),
            route('settings.index'),
        ];
    }

    private function appointmentDependencies(): array
    {
        $customer = Customer::create([
            'full_name' => 'Ava Johnson',
            'phone' => '+1 555 0101',
            'email' => 'ava.johnson@example.com',
            'notes' => null,
        ]);

        $service = Service::create([
            'name' => 'Signature Facial',
            'category' => 'Skin Care',
            'duration_minutes' => 60,
            'price' => 85.00,
            'description' => null,
            'status' => 'active',
        ]);

        $staff = Staff::create([
            'name' => 'Olivia Smith',
            'phone' => '+1 555 0201',
            'email' => 'olivia.smith@example.com',
            'role' => 'Senior Stylist',
            'status' => 'active',
        ]);

        return [$customer, $service, $staff];
    }

    private function makeAppointment(Customer $customer, Service $service, ?Staff $staff): Appointment
    {
        return Appointment::create([
            'customer_id' => $customer->id,
            'service_id' => $service->id,
            'staff_id' => $staff?->id,
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '10:30',
            'status' => 'confirmed',
            'notes' => null,
        ]);
    }

    private function settingsPayload(array $overrides = []): array
    {
        return array_merge([
            'business_name' => 'Demo Business',
            'business_phone' => '+1 555 1234',
            'business_email' => 'demo@example.test',
            'business_address' => 'Demo Street',
            'business_description' => 'Demo-safe description.',
            'opening_time' => '09:00',
            'closing_time' => '17:00',
            'appointment_slot_duration' => 30,
            'currency' => 'USD',
            'timezone' => 'UTC',
        ], $overrides);
    }

    private function withPrivateAdminEnvironment(string $email, string $password): void
    {
        putenv('PRIVATE_ADMIN_NAME=RugosTech Admin');
        putenv('PRIVATE_ADMIN_EMAIL='.$email);
        putenv('PRIVATE_ADMIN_PASSWORD='.$password);
        $_ENV['PRIVATE_ADMIN_NAME'] = 'RugosTech Admin';
        $_ENV['PRIVATE_ADMIN_EMAIL'] = $email;
        $_ENV['PRIVATE_ADMIN_PASSWORD'] = $password;
        $_SERVER['PRIVATE_ADMIN_NAME'] = 'RugosTech Admin';
        $_SERVER['PRIVATE_ADMIN_EMAIL'] = $email;
        $_SERVER['PRIVATE_ADMIN_PASSWORD'] = $password;
    }
}