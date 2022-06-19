<?php

namespace Tests\View\dashboard;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DashboardViewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private $user;
    private $access_ranking;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->make();

        $this->access_ranking = [
            array(
                'thread_name' => 'hoge',
                'access_count' => 1
            ),
            array(
                'thread_name' => 'fuga',
                'access_count' => 2
            ),
            array(
                'thread_name' => 'piyo',
                'access_count' => 3
            )
        ];
    }

    public function test_dashboard_view_have()
    {
        return $this->markTestSkipped('Dashboard view test is nore.');
    }
}
