<?php

namespace Tests\Feature\welcome;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_welcome_view_have_hub_link()
    {
        $view = $this->view('welcome');

        $view->assertSee('/hub');
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
