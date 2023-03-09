<?php

namespace Tests\Feature\welcome;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

    public function test_welcome_not_login_access()
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
}
