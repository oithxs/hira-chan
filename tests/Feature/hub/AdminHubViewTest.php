<?php

namespace Tests\Feature\hub;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminHubViewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private $admin;
    private $threads;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->admin()->make();

        $this->threads = [
            array(
                'id' => 1,
                'thread_id' => 'hogehoge',
                'thread_name' => 'hoge',
                'user_email' => 'hoge@example.com',
                'created_at' => now(),
                'updated_at' => null
            ),
            array(
                'id' => 2,
                'thread_id' => 'fugafuga',
                'thread_name' => 'fuga',
                'user_email' => 'fuga@example.com',
                'created_at' => now(),
                'updated_at' => null
            ),
            array(
                'id' => 3,
                'thread_id' => 'piyopiyo',
                'thread_name' => 'piyo',
                'user_email' => 'piyo@example.com',
                'created_at' => now(),
                'updated_at' => null
            )
        ];
    }

    public function test_hub_view_have_create_threadBtn()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('create_threadBtn');
    }

    public function test_hub_view_have_createThread()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('createThread');
    }

    public function test_hub_view_have_threadName()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('threadName');
    }

    public function test_hub_view_have_thread_actions_form()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('thread_actions_form');
    }

    public function test_hub_view_have_thread_id()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('thread_id');
    }

    public function test_hub_view_have_navbarDropdown()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('navbarDropdown');
    }


    public function test_hub_view_have_DeleteThreadModlBtn()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('#DeleteThreadModal');
    }


    public function test_hub_view_have_EditThreadModalBtn()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('#EditThreadModal');
    }


    public function test_hub_view_have_DeleteThreadModal()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('DeleteThreadModal');
    }


    public function test_hub_view_have_delete_threadBtn()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('delete_threadBtn');
    }


    public function test_hub_view_have_EditThreadModal()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('EditThreadModal');
    }


    public function test_hub_view_have_edit_thread_form()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('edit_thread_form');
    }


    public function test_hub_view_have_ThreadNameText()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('ThreadNameText');
    }


    public function test_hub_view_have_edit_threadBtn()
    {
        $view = $this
            ->actingAs($this->admin)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('edit_threadBtn');
    }
}
