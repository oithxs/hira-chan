<?php

namespace Tests\Feature\hub;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private $user;
    private $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make();
        $this->admin = User::factory()->admin()->make();
    }

    public function test_hub_access()
    {
        $response = $this->get('/hub');

        $response->assertRedirect('/login');
    }

    public function test_hub_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/hub');

        $response->assertStatus(200);
    }

    public function test_hub_admin_access()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('/hub');

        $response->assertStatus(200);
    }
}
