<?php

namespace Tests\Feature\keiziban;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KeizibanViewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make();
    }
    public function test_keiziban_view_have_likes_function()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 1,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertSee('function likes(message_id, user_like)');
    }
}
