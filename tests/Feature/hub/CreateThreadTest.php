<?php

namespace Tests\Feature\hub;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadTest extends TestCase
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

    public function test_not_login_get_access_create_thread()
    {
        $response = $this->get('jQuery.ajax/create_thread');

        $response->assertStatus(404);
    }

    public function test_user_get_access_create_thread()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('jQuery.ajax/create_thread');

        $response->assertStatus(404);
    }

    public function test_admin_get_access_create_thread()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('jQuery.ajax/create_thread');

        $response->assertStatus(404);
    }

    public function test_not_login_post_access_create_thread()
    {
        $response = $this->post('jQuery.ajax/create_thread', [
            'table' => 'TestThread'
        ]);

        $response->assertStatus(500);
    }

    public function test_user_post_access_create_thread()
    {
        $response = $this
            ->actingAs($this->user)
            ->post('jQuery.ajax/create_thread', [
                'table' => 'TestThread'
            ]);

        $response->assertStatus(200);
    }

    public function test_admin_post_access_create_thread()
    {
        $response = $this
            ->actingAs($this->admin)
            ->post('jQuery.ajax/create_thread', [
                'table' => 'TestThread'
            ]);

        $response->assertStatus(200);
    }
}
