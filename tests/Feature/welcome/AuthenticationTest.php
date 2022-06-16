<?php

namespace Tests\Feature\welcome;

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
        $this->user = User::factory()->create();
        $this->admin = User::factory()->admin()->create();
    }

    public function test_welcome_access()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_welcome_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/');

        $response->assertStatus(200);
    }

    public function test_welcome_admin_access()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('/');

        $response->assertStatus(200);
    }
}
