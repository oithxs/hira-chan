<?php

namespace Tests\View\welcome;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WelcomeViewTest extends TestCase
{
    use RefreshDatabase;
    public function test_welcome_view_have_hub_link()
    {
        $view = $this->view('welcome');

        $view->assertSee('/dashboard');
    }

    public function test_welcome_view_have_twitter_link()
    {
        $view = $this->view('welcome');

        $view->assertSee('https://twitter.com/hxs_');
    }

    public function test_welcome_view_have_github_link()
    {
        $view = $this->view('welcome');

        $view->assertSee('https://github.com/oithxs');
    }
}
