<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_redirects_to_login_for_public_demo(): void
    {
        $response = $this->get('/register');

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHas('demo_restricted', 'Public registration is disabled for this demo.');
    }

    public function test_new_users_cannot_register_in_public_demo(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHas('demo_restricted', 'Public registration is disabled for this demo.');

        $this->assertGuest();
        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com',
        ]);
        $this->assertSame(0, User::count());
    }
}