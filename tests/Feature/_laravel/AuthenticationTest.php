<?php

namespace Tests\Feature\_laravel;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        // テストが通るようにemail修正
        $user = User::factory()->create([
            'email' => config('AddConfig.mail.example') . '@st.oit.ac.jp'
        ]);

        $response = $this->post('/login', [
            'email' => strstr($user->email, '@', true),
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        // テストが通るようにemail修正
        $user = User::factory()->create([
            'email' => config('AddConfig.mail.example') . '@st.oit.ac.jp'
        ]);

        $this->post('/login', [
            'email' => strstr($user->email, '@', true),
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
