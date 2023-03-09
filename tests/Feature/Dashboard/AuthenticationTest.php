<?php

namespace Tests\Feature\Dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_dashboard_not_login_access()
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_dashboard_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/dashboard');

        $response->assertStatus(200);
    }

    public function test_dashboard_sort1_not_login_access()
    {
        $response = $this->get('/dashboard?sort=new_create');

        $response->assertStatus(200);
    }

    public function test_dashboard_sort0_not_login_access()
    {
        $response = $this->get('/dashboard?sort=');

        $response->assertStatus(200);
    }

    public function test_dashboard_sort1_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/dashboard?sort=new_create');

        $response->assertStatus(200);
    }

    public function test_dashboard_sort0_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/dashboard?sort=');

        $response->assertStatus(200);
    }

    public function test_dashboard_page1_not_login_access()
    {
        $response = $this->get('/dashboard?page=1');

        $response->assertStatus(200);
    }

    public function test_dashboard_page0_not_login_access()
    {
        $response = $this->get('/dashboard?page=');

        $response->assertStatus(200);
    }

    public function test_dashboard_page1_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/dashboard?page=1');

        $response->assertStatus(200);
    }

    public function test_dashboard_page0_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/dashboard?page=');

        $response->assertStatus(200);
    }

    public function test_dashboard_page1_sort1_not_login_access()
    {
        $response = $this->get('/dashboard?page=1&sort=new_create');

        $response->assertStatus(200);
    }

    public function test_dashboard_page1_sort0_not_login_access()
    {
        $response = $this->get('/dashboard?page=1&sort=');

        $response->assertStatus(200);
    }

    public function test_dashboard_page0_sort1_not_login_access()
    {
        $response = $this->get('/dashboard?page=&sort=new_create');

        $response->assertStatus(200);
    }

    public function test_dashboard_page0_sort0_not_login_access()
    {
        $response = $this->get('dashboard?page=&sort=');

        $response->assertStatus(200);
    }

    public function test_dashboard_page1_sort1_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/dashboard?page=1&sort=new_create');

        $response->assertStatus(200);
    }

    public function test_dashboard_page1_sort0_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/dashboard?page=1&sort=');

        $response->assertStatus(200);
    }

    public function test_dashboard_page0_sort1_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/dashboard?page=&sort=new_create');

        $response->assertStatus(200);
    }

    public function test_dashbaord_page0_sort0_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/dashboard?page=&sort=');

        $response->assertStatus(200);
    }
}
