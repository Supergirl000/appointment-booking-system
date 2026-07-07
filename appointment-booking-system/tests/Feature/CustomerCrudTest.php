<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_customers_index_requires_authentication(): void
    {
        $this->get(route('customers.index'))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_create_a_customer(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('customers.store'), [
            'full_name' => 'Ava Johnson',
            'phone' => '+1 555 0101',
            'email' => 'ava.johnson@example.com',
            'notes' => 'Prefers morning appointments.',
        ]);

        $customer = Customer::where('email', 'ava.johnson@example.com')->first();

        $response->assertRedirect(route('customers.show', $customer));
        $this->assertDatabaseHas('customers', [
            'full_name' => 'Ava Johnson',
            'email' => 'ava.johnson@example.com',
        ]);
    }

    public function test_customer_validation_rules_are_enforced(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('customers.store'), [
            'full_name' => '',
            'phone' => str_repeat('1', 51),
            'email' => 'not-an-email',
        ])->assertSessionHasErrors([
            'full_name',
            'phone',
            'email',
        ]);
    }

    public function test_user_can_update_and_delete_a_customer(): void
    {
        $user = User::factory()->create();
        $customer = Customer::create([
            'full_name' => 'Mia Carter',
            'phone' => '+1 555 0102',
            'email' => 'mia.carter@example.com',
            'notes' => null,
        ]);

        $this->actingAs($user)->put(route('customers.update', $customer), [
            'full_name' => 'Mia Carter-Smith',
            'phone' => '+1 555 0199',
            'email' => 'mia.smith@example.com',
            'notes' => 'Usually books on weekends.',
        ])->assertRedirect(route('customers.show', $customer));

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'full_name' => 'Mia Carter-Smith',
            'email' => 'mia.smith@example.com',
        ]);

        $this->actingAs($user)->delete(route('customers.destroy', $customer))
            ->assertRedirect(route('customers.index'));

        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);
    }

    public function test_customers_can_be_searched_by_name_phone_or_email(): void
    {
        $user = User::factory()->create();

        Customer::create([
            'full_name' => 'Sophia Williams',
            'phone' => '+1 555 0103',
            'email' => 'sophia.williams@example.com',
            'notes' => null,
        ]);

        Customer::create([
            'full_name' => 'Emma Brown',
            'phone' => '+1 555 0104',
            'email' => 'emma.brown@example.com',
            'notes' => null,
        ]);

        $this->actingAs($user)->get(route('customers.index', [
            'search' => '0103',
        ]))
            ->assertOk()
            ->assertSee('Sophia Williams')
            ->assertDontSee('Emma Brown');
    }

    public function test_customer_show_page_has_appointment_history_placeholder(): void
    {
        $user = User::factory()->create();
        $customer = Customer::create([
            'full_name' => 'Olivia Reed',
            'phone' => null,
            'email' => null,
            'notes' => null,
        ]);

        $this->actingAs($user)->get(route('customers.show', $customer))
            ->assertOk()
            ->assertSee('Appointment History')
            ->assertSee('No appointment history yet');
    }
}
