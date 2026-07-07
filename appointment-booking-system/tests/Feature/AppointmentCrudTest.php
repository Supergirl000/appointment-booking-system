<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_appointments_index_requires_authentication(): void
    {
        $this->get(route('appointments.index'))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_create_an_appointment(): void
    {
        $user = User::factory()->create();
        [$customer, $service, $staff] = $this->appointmentDependencies();

        $response = $this->actingAs($user)->post(route('appointments.store'), [
            'customer_id' => $customer->id,
            'service_id' => $service->id,
            'staff_id' => $staff->id,
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '10:30',
            'status' => 'confirmed',
            'notes' => 'First visit consultation.',
        ]);

        $appointment = Appointment::where('customer_id', $customer->id)->first();

        $response->assertRedirect(route('appointments.show', $appointment));
        $this->assertDatabaseHas('appointments', [
            'customer_id' => $customer->id,
            'service_id' => $service->id,
            'staff_id' => $staff->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_appointment_validation_rules_are_enforced(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('appointments.store'), [
            'customer_id' => 999,
            'service_id' => 999,
            'staff_id' => 999,
            'appointment_date' => '',
            'appointment_time' => '',
            'status' => 'unknown',
        ])->assertSessionHasErrors([
            'customer_id',
            'service_id',
            'staff_id',
            'appointment_date',
            'appointment_time',
            'status',
        ]);
    }

    public function test_user_can_update_and_delete_an_appointment(): void
    {
        $user = User::factory()->create();
        [$customer, $service, $staff] = $this->appointmentDependencies();
        $appointment = $this->makeAppointment($customer, $service, $staff);

        $this->actingAs($user)->put(route('appointments.update', $appointment), [
            'customer_id' => $customer->id,
            'service_id' => $service->id,
            'staff_id' => null,
            'appointment_date' => now()->addDays(2)->toDateString(),
            'appointment_time' => '14:00',
            'status' => 'completed',
            'notes' => 'Updated after visit.',
        ])->assertRedirect(route('appointments.show', $appointment));

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'staff_id' => null,
            'status' => 'completed',
        ]);

        $this->actingAs($user)->delete(route('appointments.destroy', $appointment))
            ->assertRedirect(route('appointments.index'));

        $this->assertDatabaseMissing('appointments', [
            'id' => $appointment->id,
        ]);
    }

    public function test_appointments_can_be_searched_and_filtered(): void
    {
        $user = User::factory()->create();
        [$customer, $service, $staff] = $this->appointmentDependencies();
        $appointment = $this->makeAppointment($customer, $service, $staff, [
            'appointment_date' => '2026-08-15',
            'status' => 'pending',
        ]);

        $otherCustomer = Customer::create([
            'full_name' => 'Emma Brown',
            'phone' => '+1 555 0104',
            'email' => 'emma.brown@example.com',
            'notes' => null,
        ]);
        $this->makeAppointment($otherCustomer, $service, null, [
            'appointment_date' => '2026-08-16',
            'status' => 'cancelled',
        ]);

        $this->actingAs($user)->get(route('appointments.index', [
            'search' => $customer->full_name,
            'status' => $appointment->status,
            'date' => '2026-08-15',
        ]))
            ->assertOk()
            ->assertSee($customer->full_name)
            ->assertDontSee('Emma Brown');
    }

    public function test_dashboard_shows_appointment_counts_and_todays_schedule(): void
    {
        $user = User::factory()->create();
        [$customer, $service, $staff] = $this->appointmentDependencies();
        $this->makeAppointment($customer, $service, $staff, [
            'appointment_date' => now()->toDateString(),
            'appointment_time' => '09:15',
            'status' => 'confirmed',
        ]);
        $this->makeAppointment($customer, $service, null, [
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '11:00',
            'status' => 'pending',
        ]);

        $this->actingAs($user)->get(route('dashboard'))
            ->assertOk()
            ->assertViewHas('todaysAppointmentsCount', 1)
            ->assertViewHas('upcomingAppointmentsCount', 1)
            ->assertViewHas('customersCount', 1)
            ->assertViewHas('servicesCount', 1)
            ->assertSee($customer->full_name)
            ->assertSee($service->name);
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

    private function makeAppointment(Customer $customer, Service $service, ?Staff $staff, array $overrides = []): Appointment
    {
        return Appointment::create(array_merge([
            'customer_id' => $customer->id,
            'service_id' => $service->id,
            'staff_id' => $staff?->id,
            'appointment_date' => now()->addDay()->toDateString(),
            'appointment_time' => '10:30',
            'status' => 'confirmed',
            'notes' => null,
        ], $overrides));
    }
}
