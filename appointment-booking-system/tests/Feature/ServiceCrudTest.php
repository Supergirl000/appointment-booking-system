<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_services_index_requires_authentication(): void
    {
        $this->get(route('services.index'))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_create_a_service(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('services.store'), [
            'name' => 'Aromatherapy Massage',
            'category' => 'Massage',
            'duration_minutes' => 60,
            'price' => 95.00,
            'description' => 'Relaxing essential oil massage.',
            'status' => 'active',
        ]);

        $service = Service::where('name', 'Aromatherapy Massage')->first();

        $response->assertRedirect(route('services.show', $service));
        $this->assertDatabaseHas('services', [
            'name' => 'Aromatherapy Massage',
            'status' => 'active',
        ]);
    }

    public function test_service_validation_rules_are_enforced(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('services.store'), [
            'name' => '',
            'duration_minutes' => 4,
            'price' => -1,
            'status' => 'archived',
        ])->assertSessionHasErrors([
            'name',
            'duration_minutes',
            'price',
            'status',
        ]);
    }

    public function test_user_can_update_and_delete_a_service(): void
    {
        $user = User::factory()->create();
        $service = Service::create([
            'name' => 'Classic Facial',
            'category' => 'Skin Care',
            'duration_minutes' => 45,
            'price' => 75.00,
            'description' => null,
            'status' => 'active',
        ]);

        $this->actingAs($user)->put(route('services.update', $service), [
            'name' => 'Premium Facial',
            'category' => 'Skin Care',
            'duration_minutes' => 60,
            'price' => 105.00,
            'description' => 'A richer treatment.',
            'status' => 'inactive',
        ])->assertRedirect(route('services.show', $service));

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Premium Facial',
            'status' => 'inactive',
        ]);

        $this->actingAs($user)->delete(route('services.destroy', $service))
            ->assertRedirect(route('services.index'));

        $this->assertDatabaseMissing('services', [
            'id' => $service->id,
        ]);
    }

    public function test_services_can_be_searched_and_filtered(): void
    {
        $user = User::factory()->create();

        Service::create([
            'name' => 'Gel Manicure',
            'category' => 'Nails',
            'duration_minutes' => 45,
            'price' => 45.00,
            'description' => null,
            'status' => 'active',
        ]);

        Service::create([
            'name' => 'Retired Brow Service',
            'category' => 'Beauty',
            'duration_minutes' => 30,
            'price' => 35.00,
            'description' => null,
            'status' => 'inactive',
        ]);

        $this->actingAs($user)->get(route('services.index', [
            'search' => 'nails',
            'status' => 'active',
        ]))
            ->assertOk()
            ->assertSee('Gel Manicure')
            ->assertDontSee('Retired Brow Service');
    }
}
