<?php

namespace Tests\View\mypage;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MyPageViewTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_mypage_view_have_mypage_page_thema_select()
    {
        $view = $this
            ->actingAs($this->user)
            ->view('MyPage', [
                'username' => 'hoge'
            ]);

        $view->assertSee('mypage_page_thema_select');
    }

    public function test_mypage_view_have_jQuery()
    {
        $TextView = (string) $this
            ->actingAs($this->user)
            ->view('MyPage', [
                'username' => 'hoge'
            ]);

        if (strpos($TextView, '<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>') !== false) {
            $this->assertAuthenticated($this->user = null);
        } else {
            $this->assertGuest($this->user = null);
        }
    }

    public function test_mypage_view_have_js()
    {
        $TextView = (string) $this
            ->actingAs($this->user)
            ->view('MyPage', [
                'username' => 'hoge'
            ]);

        $text = '<script src="/js/app_jquery.js"></script>';

        if (strpos($TextView, $text) !== false) {
            $this->assertAuthenticated($this->user = null);
        } else {
            $this->assertGuest($this->user = null);
        }
    }

    public function test_mypage_view_have_url()
    {
        $TextView = (string) $this
            ->actingAs($this->user)
            ->view('MyPage', [
                'username' => 'hoge'
            ]);

        $text = 'const url = "' . (string) url('/') . '";';

        if (strpos($TextView, $text) !== false) {
            $this->assertAuthenticated($this->user = null);
        } else {
            $this->assertGuest($this->user = null);
        }
    }
}
