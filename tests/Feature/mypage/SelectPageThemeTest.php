<?php

namespace Tests\Feature\mypage;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SelectPageThemeTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_not_login_get_access_select_page_theme()
    {
        $response = $this->get('/jQuery.ajax/page_theme');

        $response->assertStatus(404);
    }

    public function test_user_get_access_select_page_theme()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/jQuery.ajax/page_theme');

        $response->assertStatus(404);
    }

    public function test_not_login_post_access_select_default_page_theme()
    {
        $response = $this->post('/jQuery.ajax/page_theme', [
            'page_theme' => 1,
        ]);

        $response->assertRedirect('/login');
    }

    public function test_user_post_access_select_default_page_theme()
    {
        $response = $this
            ->actingAs($this->user)
            ->post('/jQuery.ajax/page_theme', [
                'page_theme' => 1,
            ]);

        $response->assertStatus(200);
    }

    public function test_not_login_post_access_select_dark_page_theme()
    {
        $response = $this->post('/jQuery.ajax/page_theme', [
            'page_theme' => 2,
        ]);

        $response->assertRedirect('/login');
    }

    public function test_user_post_access_select_dark_page_theme()
    {
        $response = $this
            ->actingAs($this->user)
            ->post('/jQuery.ajax/page_theme', [
                'page_theme' => 2,
            ]);

        $response->assertStatus(200);
    }
}
