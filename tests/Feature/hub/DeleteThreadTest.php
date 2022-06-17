<?php

namespace Tests\Feature\hub;

use App\Models\User;
use App\Models\create_thread;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteThreadTest extends TestCase
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

        try {
            $create = new create_thread;
            $create->create_thread('DeleteThreadTestID');
            $create->insertTable(
                'DeleteThreadTestName',
                'DeleteThreadTestID',
                'test@example.com'
            );
        } catch (QueryException $error) {
            // nothing to do
        }
    }

    public function test_not_login_get_access_admin_delete_thread()
    {
        $response = $this->get('jQuery.ajax/admin/delete_thread');

        $response->assertStatus(404);
    }

    public function test_user_get_access_admin_delete_thread()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('jQuery.ajax/admin/delete_thread');

        $response->assertStatus(404);
    }

    public function test_admin_get_access_admin_delete_thread()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('jQuery.ajax/admin/delete_thread');

        $response->assertStatus(404);
    }

    public function test_not_login_post_access_admin_delete_thread()
    {
        $response = $this->post('jQuery.ajax/admin/delete_thread', [
            'thread_id' => 'DeleteThreadTestID'
        ]);

        $response->assertStatus(500);
    }

    public function test_user_post_access_admin_delete_thread()
    {
        $response = $this
            ->actingAs($this->user)
            ->post('jQuery.ajax/admin/delete_thread', [
                'thread_id' => 'DeleteThreadTestID'
            ]);

        $response->assertStatus(403);
    }

    public function test_admin_post_access_admin_delete_thread()
    {
        $response = $this
            ->actingAs($this->admin)
            ->post('jQuery.ajax/admin/delete_thread', [
                'thread_id' => 'DeleteThreadTestID'
            ]);

        $response->assertStatus(200);
    }
}
