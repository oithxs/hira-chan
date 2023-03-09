<?php

namespace Tests\Feature\ThreadBrowsingHistory;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * テストユーザ
     *
     * @var User
     */
    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * ログインしていない状態でページにアクセス
     *
     * @return void
     */
    public function test_thread_browsing_history_not_login_access(): void
    {
        $response = $this->get(route('thread.history'));
        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $response = $this->post(route('thread.history'));
        $response->assertStatus(405);

        $response = $this->put(route('thread.history'));
        $response->assertStatus(405);

        $response = $this->patch(route('thread.history'));
        $response->assertStatus(405);

        $response = $this->delete(route('thread.history'));
        $response->assertStatus(405);
    }

    /**
     * ログインしている状態でページにアクセス
     *
     * @return void
     */
    public function test_thread_browsing_history_access(): void
    {
        $response = $this->actingAs($this->user)->get(route('thread.history'));
        $response->assertOk();

        $response = $this->actingAs($this->user)->post(route('thread.history'));
        $response->assertStatus(405);

        $response = $this->actingAs($this->user)->put(route('thread.history'));
        $response->assertStatus(405);

        $response = $this->actingAs($this->user)->patch(route('thread.history'));
        $response->assertStatus(405);

        $response = $this->actingAs($this->user)->delete(route('thread.history'));
        $response->assertStatus(405);
    }
}
