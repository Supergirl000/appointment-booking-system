<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class LocalizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_uses_english_by_default(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Demo Access')
            ->assertSee('Use Demo Account')
            ->assertSee('EN')
            ->assertSee('FR');
    }

    public function test_language_switcher_stores_french_locale_in_session(): void
    {
        $this->from(route('login'))
            ->get(route('language.switch', 'fr'))
            ->assertRedirect(route('login'))
            ->assertSessionHas('locale', 'fr');
    }

    public function test_login_page_uses_french_accents_without_visible_entities(): void
    {
        App::setLocale('fr');

        $response = $this->withSession(['locale' => 'fr'])->get(route('login'));

        $response->assertOk()
            ->assertSee(__('Demo Access'), false)
            ->assertSee(__('Use Demo Account'), false)
            ->assertSee(__('Password'), false)
            ->assertDontSee('&#039;', false)
            ->assertDontSee('&quot;', false)
            ->assertDontSee('&amp;#039;', false);
    }

    public function test_component_translations_do_not_double_escape_french_apostrophes(): void
    {
        App::setLocale('fr');
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->withSession(['locale' => 'fr'])
            ->get(route('settings.index'));

        $response->assertOk()
            ->assertSee(__('Manage business profile, working hours, appointment rules, and localization preferences.'), false)
            ->assertSee(__('Business Name'), false)
            ->assertSee(__('Business Phone'), false)
            ->assertDontSee('&#039;', false)
            ->assertDontSee('&amp;#039;', false)
            ->assertDontSee('&quot;', false);
    }

    public function test_unsupported_locale_returns_not_found(): void
    {
        $this->get('/language/es')->assertNotFound();
    }
}
