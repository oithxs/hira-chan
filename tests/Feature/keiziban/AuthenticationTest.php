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
        $this->user = User::factory()->make();
        $this->admin = User::factory()->admin()->make();

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

    public function test_keiziban_not_login_access()
    {
        $response = $this->get('/hub/thread_name=ThreadTestName/id=ThreadTestID');

        $response->assertRedirect('/login');
    }
}
