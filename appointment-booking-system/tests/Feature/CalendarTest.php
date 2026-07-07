<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_calendar_requires_authentication(): void
    {
        $this->get(route('calendar.index'))
            ->assertRedirect(route('login'));
    }

    public function test_calendar_displays_month_appointments_and_navigation(): void
    {
        $user = User::factory()->create();
        [$customer, $service, $staff] = $this->appointmentDependencies();
        $appointment = $this->makeAppointment($customer, $service, $staff, [
            'appointment_date' => '2026-08-15',
            'appointment_time' => '10:30',
            'status' => 'confirmed',
        ]);

        $this->actingAs($user)->get(route('calendar.index', ['month' => '2026-08']))
            ->assertOk()
            ->assertSee('August 2026')
            ->assertSee('Previous')
            ->assertSee('Today')
            ->assertSee('Next')
            ->assertSee('10:30')
            ->assertSee($customer->full_name)
            ->assertSee($service->name)
            ->assertSee(route('appointments.show', $appointment));
    }

    public function test_calendar_filters_by_status_staff_and_service(): void
    {
        $user = User::factory()->create();
        [$customer, $service, $staff] = $this->appointmentDependencies();
        $this->makeAppointment($customer, $service, $staff, [
            'appointment_date' => '2026-08-15',
            'status' => 'confirmed',
        ]);

        $otherCustomer = Customer::create([
            'full_name' => 'Emma Brown',
            'phone' => null,
            'email' => 'emma.brown@example.com',
            'notes' => null,
        ]);
        $otherService = Service::create([
            'name' => 'Gel Manicure',
            'category' => 'Nails',
            'duration_minutes' => 45,
            'price' => 45.00,
            'description' => null,
            'status' => 'active',
        ]);
        $this->makeAppointment($otherCustomer, $otherService, null, [
            'appointment_date' => '2026-08-15',
            'status' => 'pending',
        ]);

        $this->actingAs($user)->get(route('calendar.index', [
            'month' => '2026-08',
            'status' => 'confirmed',
            'staff_id' => $staff->id,
            'service_id' => $service->id,
        ]))
            ->assertOk()
            ->assertSee($customer->full_name)
            ->assertSee($service->name)
            ->assertDontSee('Emma Brown');
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
            'phone' => null,
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
            'appointment_date' => '2026-08-15',
            'appointment_time' => '10:30',
            'status' => 'confirmed',
            'notes' => null,
        ], $overrides));
    }
}
