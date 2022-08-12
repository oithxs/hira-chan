<?php

namespace Tests\Feature\mypage;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SelectPageThemaTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_not_login_get_access_select_page_thema()
    {
        $response = $this->get('/jQuery.ajax/page_thema');

        $response->assertStatus(404);
    }

    public function test_user_get_access_select_page_thema()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/jQuery.ajax/page_thema');

        $response->assertStatus(404);
    }

    public function test_admin_get_access_select_page_thema()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('/jQuery.ajax/page_thema');

        $response->assertStatus(404);
    }

    public function test_not_login_post_access_select_default_page_thema()
    {
        $response = $this->post('/jQuery.ajax/page_thema', [
            'page_thema' => 0,
        ]);

        $response->assertRedirect('/login');
    }

    public function test_user_post_access_select_default_page_thema()
    {
        $response = $this
            ->actingAs($this->user)
            ->post('/jQuery.ajax/page_thema', [
                'page_thema' => 0,
            ]);

        $response->assertStatus(200);
    }

    public function test_admin_post_access_select_default_page_thema()
    {
        $response = $this
            ->actingAs($this->admin)
            ->post('/jQuery.ajax/page_thema', [
                'page_thema' => 0,
            ]);

        $response->assertStatus(200);
    }

    public function test_not_login_post_access_select_dark_page_thema()
    {
        $response = $this->post('/jQuery.ajax/page_thema', [
            'page_thema' => 1,
        ]);

        $response->assertRedirect('/login');
    }

    public function test_user_post_access_select_dark_page_thema()
    {
        $response = $this
            ->actingAs($this->user)
            ->post('/jQuery.ajax/page_thema', [
                'page_thema' => 1,
            ]);

        $response->assertStatus(200);
    }

    public function test_admin_post_access_select_dark_page_thema()
    {
        $response = $this
            ->actingAs($this->admin)
            ->post('/jQuery.ajax/page_thema', [
                'page_thema' => 1,
            ]);

        $response->assertStatus(200);
    }
}
