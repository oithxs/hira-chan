<?php

namespace Tests\Feature\hub;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HubViewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private $user;
    private $threads;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make();

        $this->threads = [
            array(
                'id' => 0,
                'thread_id' => 'hogehoge',
                'thread_name' => 'hoge',
                'user_email' => 'hoge@example.com',
                'created_at' => now(),
                'updated_at' => null
            ),
            array(
                'id' => 1,
                'thread_id' => 'fugafuga',
                'thread_name' => 'fuga',
                'user_email' => 'fuga@example.com',
                'created_at' => now(),
                'updated_at' => null
            ),
            array(
                'id' => 2,
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
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('create_threadBtn');
    }

    public function test_hub_view_have_createThread()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('createThread');
    }

    public function test_hub_view_have_threadName()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertSee('threadName');
    }

    public function test_hub_view_not_have_thread_actions_form()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertDontSee('thread_actions_form');
    }

    public function test_hub_view_not_have_thread_id()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertDontSee('thread_id');
    }

    public function test_hub_view_not_have_navbarDropdown()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertDontSee('navbarDropdown');
    }


    public function test_hub_view_not_have_DeleteThreadModlBtn()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertDontSee('#DeleteThreadModal');
    }


    public function test_hub_view_not_have_EditThreadModalBtn()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertDontSee('#EditThreadModal');
    }


    public function test_hub_view_not_have_DeleteThreadModal()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertDontSee('DeleteThreadModal');
    }


    public function test_hub_view_not_have_delete_threadBtn()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertDontSee('delete_threadBtn');
    }


    public function test_hub_view_not_have_EditThreadModal()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertDontSee('EditThreadModal');
    }


    public function test_hub_view_not_have_edit_thread_form()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertDontSee('edit_thread_form');
    }


    public function test_hub_view_not_have_ThreadNameText()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertDontSee('ThreadNameText');
    }


    public function test_hub_view_not_have_edit_threadBtn()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('hub', [
                'tables' => $this->threads,
                'url' => url('/')
            ]);

        $view->assertDontSee('edit_threadBtn');
    }
}
