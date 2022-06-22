<?php

namespace Tests\View\keiziban;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class KeizibanNotShowViewTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_keiziban_view_have_jQuery()
    {
        $TextView = (string) $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        if (strpos($TextView, '<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>') !== false) {
            $this->assertAuthenticated($this->user = null);
        } else {
            $this->assertGuest($this->user = null);
        }
    }

    public function test_keiziban_view_have_url()
    {
        $TextView = (string) $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $text = 'const url = "' . (string) url('/') . '";';

        if (strpos($TextView, $text) !== false) {
            $this->assertAuthenticated($this->user = null);
        } else {
            $this->assertGuest($this->user = null);
        }
    }

    public function test_keiziban_view_have_table()
    {
        $TextView = (string) $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $text = 'const table = "ThreadTestName";';

        if (strpos($TextView, $text) !== false) {
            $this->assertAuthenticated($this->user = null);
        } else {
            $this->assertGuest($this->user = null);
        }
    }

    public function test_keiziban_view_have_thread_id()
    {
        $TextView = (string) $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $text = 'const thread_id = "ThreadTestID";';

        if (strpos($TextView, $text) !== false) {
            $this->assertAuthenticated($this->user = null);
        } else {
            $this->assertGuest($this->user = null);
        }
    }

    public function test_keiziban_view_not_have_likes_function()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertDontSee('function likes(message_id, user_like)');
    }

    public function test_keiziban_view_not_have_keiziban_message_actions_form()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertDontSee('keiziban_message_actions_form');
    }

    public function test_keiziban_view_not_have_keiziban_message_id_number()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertDontSee('keiziban_message_id_number');
    }

    public function test_keiziban_view_not_have_keiziban_sendMessage_form()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertDontSee('keiziban_sendMessage_form');
    }

    public function test_keiziban_view_not_have_keiziban_message_textarea()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertDontSee('keiziban_message_textarea');
    }

    public function test_keiziban_view_not_have_keiziban_sendAlertArea()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertDontSee('keiziban_sendAlertArea');
    }

    public function test_keiziban_view_not_have_keiziban_sendMessage_btn()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertDontSee('keiziban_sendMessage_btn');
    }

    public function test_keiziban_view_not_have_keiziban_displayArea()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertDontSee('keiziban_displayArea');
    }

    public function test_keiziban_view_not_have_keiziban_DeleteMessage_Modal()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertDontSee('keiziban_DeleteMessage_Modal');
    }

    public function test_keiziban_view_not_have_keiziban_delete_message_btn()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertDontSee('keiziban_delete_message_btn');
    }

    public function test_keiziban_view_not_have_keiziban_RestoreMessage_Modal()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertDontSee('keiziban_RestoreMessage_Modal');
    }

    public function test_keiziban_view_not_have_keiziban_restore_message_btn()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $view->assertDontSee('keiziban_restore_message_btn');
    }

    public function test_keiziban_view_not_have_js()
    {
        $TextView = (string) $this
            ->actingAs($this->user)
            ->view('keiziban', [
                'result' => 0,
                'thread_name' => 'ThreadTestName',
                'thread_id' => 'ThreadTestID',
                'username' => 'TestUser',
                'url' => url('/')
            ]);

        $text = '<script src="/js/app_jquery.js"></script>';

        if (strpos($TextView, $text) === false) {
            $this->assertAuthenticated($this->user = null);
        } else {
            $this->assertGuest($this->user = null);
        }
    }
}
