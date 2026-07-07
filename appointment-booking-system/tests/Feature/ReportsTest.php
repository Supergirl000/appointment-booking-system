<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsTest extends TestCase
{
    use RefreshDatabase;

    public function test_reports_require_authentication(): void
    {
        $this->get(route('reports.index'))
            ->assertRedirect(route('login'));
    }

    public function test_reports_show_counts_tables_and_estimated_revenue(): void
    {
        $user = User::factory()->create();
        [$customer, $facial, $massage] = $this->reportDependencies();

        $this->makeAppointment($customer, $facial, [
            'appointment_date' => '2026-08-10',
            'status' => 'completed',
        ]);
        $this->makeAppointment($customer, $facial, [
            'appointment_date' => '2026-08-12',
            'status' => 'confirmed',
        ]);
        $this->makeAppointment($customer, $massage, [
            'appointment_date' => '2026-09-01',
            'status' => 'pending',
        ]);
        $this->makeAppointment($customer, $massage, [
            'appointment_date' => '2026-09-05',
            'status' => 'cancelled',
        ]);

        $this->actingAs($user)->get(route('reports.index'))
            ->assertOk()
            ->assertViewHas('totalAppointments', 4)
            ->assertViewHas('completedAppointments', 1)
            ->assertViewHas('confirmedAppointments', 1)
            ->assertViewHas('pendingAppointments', 1)
            ->assertViewHas('cancelledAppointments', 1)
            ->assertViewHas('estimatedRevenue', 85.0)
            ->assertSee('Most Requested Services')
            ->assertSee('Appointments Per Month')
            ->assertSee('Status Distribution')
            ->assertSee('Signature Facial')
            ->assertSee('Swedish Massage')
            ->assertSee('2026-08')
            ->assertSee('2026-09')
            ->assertSee('$85.00');
    }

    public function test_reports_apply_filters(): void
    {
        $user = User::factory()->create();
        [$customer, $facial, $massage] = $this->reportDependencies();

        $this->makeAppointment($customer, $facial, [
            'appointment_date' => '2026-08-10',
            'status' => 'completed',
        ]);
        $this->makeAppointment($customer, $massage, [
            'appointment_date' => '2026-09-05',
            'status' => 'cancelled',
        ]);

        $this->actingAs($user)->get(route('reports.index', [
            'date_from' => '2026-08-01',
            'date_to' => '2026-08-31',
            'service_id' => $facial->id,
            'status' => 'completed',
        ]))
            ->assertOk()
            ->assertViewHas('totalAppointments', 1)
            ->assertViewHas('completedAppointments', 1)
            ->assertViewHas('cancelledAppointments', 0)
            ->assertViewHas('estimatedRevenue', 85.0)
            ->assertSee('Signature Facial')
            ->assertDontSee('2026-09');
    }

    private function reportDependencies(): array
    {
        $customer = Customer::create([
            'full_name' => 'Ava Johnson',
            'phone' => '+1 555 0101',
            'email' => 'ava.johnson@example.com',
            'notes' => null,
        ]);

        $facial = Service::create([
            'name' => 'Signature Facial',
            'category' => 'Skin Care',
            'duration_minutes' => 60,
            'price' => 85.00,
            'description' => null,
            'status' => 'active',
        ]);

        $massage = Service::create([
            'name' => 'Swedish Massage',
            'category' => 'Massage',
            'duration_minutes' => 75,
            'price' => 110.00,
            'description' => null,
            'status' => 'active',
        ]);

        return [$customer, $facial, $massage];
    }

    private function makeAppointment(Customer $customer, Service $service, array $overrides = []): Appointment
    {
        return Appointment::create(array_merge([
            'customer_id' => $customer->id,
            'service_id' => $service->id,
            'staff_id' => null,
            'appointment_date' => '2026-08-10',
            'appointment_time' => '10:30',
            'status' => 'completed',
            'notes' => null,
        ], $overrides));
    }
}
