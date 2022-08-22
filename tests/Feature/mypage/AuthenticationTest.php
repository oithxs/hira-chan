<?php

namespace Tests\Feature\mypage;

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

    public function test_mypage_not_login_access()
    {
        $response = $this->get('/mypage');

        $response->assertRedirect('/login');
    }

    public function test_mypage_user_access()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/mypage');

        $response->assertStatus(200);
    }
}
