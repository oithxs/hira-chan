<?php

namespace Tests\Feature\keiziban;

use App\Models\User;
use App\Models\create_thread;
use Illuminate\Database\QueryException;
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
    }

    public function test_keiziban_not_login_access_thread_name1_id1()
    {
        $response = $this->get('/hub/thread_name=ThreadTestName/id=ThreadTestID');

        $response->assertRedirect('/login');
    }

    public function test_keiziban_not_login_access_thread_name1_id0()
    {
        $response = $this->get('/hub/thread_name=ThreadTestName/id=');

        $response->assertRedirect('/login');
    }

    public function test_keiziban_not_login_access_thread_name0_id1()
    {
        $response = $this->get('/hub/thread_name=/id=ThreadTestID');

        $response->assertRedirect('/login');
    }

    public function test_keiziban_not_login_access_thread_name0_id0()
    {
        $response = $this->get('/hub/thread_name=/id=');

        $response->assertRedirect('/login');
    }

    public function test_keiziban_user_access_thread_name1_id1()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/hub/thread_name=ThreadTestName/id=ThreadTestID');

        $response->assertStatus(200);
    }

    public function test_keiziban_user_access_thread_name1_id0()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/hub/thread_name=ThreadTestName/id=');

        $response->assertStatus(200);
    }

    public function test_keiziban_user_access_thread_name0_id1()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/hub/thread_name=/id=ThreadTestID');

        $response->assertStatus(200);
    }

    public function test_keiziban_user_access_thread_name0_id0()
    {
        $response = $this
            ->actingAs($this->user)
            ->get('/hub/thread_name=/id=');

        $response->assertStatus(200);
    }

    public function test_keiziban_admin_access_thread_name1_id1()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('/hub/thread_name=ThreadTestName/id=ThreadTestID');

        $response->assertStatus(200);
    }

    public function test_keiziban_admin_access_thread_name1_id0()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('/hub/thread_name=ThreadTestName/id=');

        $response->assertStatus(200);
    }

    public function test_keiziban_admin_access_thread_name0_id1()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('/hub/thread_name=/id=ThreadTestID');

        $response->assertStatus(200);
    }

    public function test_keiziban_admin_access_thread_name0_id0()
    {
        $response = $this
            ->actingAs($this->admin)
            ->get('/hub/thread_name=/id=');

        $response->assertStatus(200);
    }
}
