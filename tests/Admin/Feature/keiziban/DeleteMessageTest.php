<?php

namespace Tests\Admin\Feature\keiziban;

use App\Models\User;
use App\Models\create_thread;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteMessageTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->admin = User::factory()->admin()->create();

        try {
            $create = new create_thread;
            $create->create_thread('ThreadTestID');
            $create->insertTable(
                'ThreadTestName',
                'ThreadTestID',
                'test@example.com'
            );
        } catch (QueryException $error) {
            // nothing to do
        }

        $this
        ->actingAs($this->user)
        ->post('/jQuery.ajax/sendRow', [
            'table' => 'ThreadTestID',
            'message' => 'This is test comment!'
        ]);
    }

    public function test_not_login_get_access_delete_message()
    {
        $response = $this->get('/jQuery.ajax/admin/delete_message');

        $response->assertStatus(404);
    }

    public function test_user_get_access_delete_message()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/jQuery.ajax/admin/delete_message');

        $response->assertStatus(404);
    }

    public function test_admin_get_access_delete_message()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('/jQuery.ajax/admin/delete_message');

        $response->assertStatus(404);
    }

    public function test_not_login_post_access_delete_message()
    {
        $response = $this->post('/jQuery.ajax/admin/delete_message', [
            'thread_id' => 'ThreadTestID',
            'message_id' => 1
        ]);

        $response->assertStatus(404);
    }

    public function test_user_post_access_delete_message()
    {
        $response = $this
            ->actingAs($this->user)
            ->post('/jQuery.ajax/admin/delete_message', [
                'thread_id' => 'ThreadTestID',
                'message_id' => 1
            ]);

        $response->assertStatus(404);
    }

    public function test_admin_post_access_delete_message()
    {
        $response = $this
            ->actingAs($this->admin)
            ->post('/jQuery.ajax/admin/delete_message', [
                'thread_id' => 'ThreadTestID',
                'message_id' => 1
            ]);

        $response->assertStatus(200);
    }
}
