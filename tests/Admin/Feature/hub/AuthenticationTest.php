<?php

namespace Tests\Admin\Feature\hub;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
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

    public function test_hub_not_login_access()
    {
        $response = $this->get('/hub');

        $response->assertStatus(404);
    }

    public function test_hub_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/hub');

        $response->assertStatus(404);
    }

    public function test_hub_admin_access()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('/hub');

        $response->assertStatus(200);
    }
}
