<?php

namespace Tests\Feature\mypage;

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

    public function test_hub_not_login_access()
    {
        $response = $this->get('/mypage');

        $response->assertRedirect('/login');
    }

    public function test_hub_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/mypage');

        $response->assertStatus(200);
    }

    public function test_hub_admin_access()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('/mypage');

        $response->assertStatus(200);
    }
}
