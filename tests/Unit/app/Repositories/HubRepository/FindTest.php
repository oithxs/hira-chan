<?php

namespace Tests\Unit\app\Repositories\HubRepository;

use App\Models\Hub;
use App\Repositories\HubRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FindTest extends TestCase
{
    use RefreshDatabase;

    private Hub $thread;

    public function setUp(): void
    {
        parent::setUp();
        $thread = Hub::factory()->create();
        $this->thread = Hub::find($thread->id);
    }

    /**
     * スレッドが取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatThreadsCanBeRetrieved(): void
    {
        $this->assertSame($this->thread->toArray(), HubRepository::find($this->thread->id)->toArray());
    }

    /**
     * 存在しないスレッドIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAThreadIdThatDoseNotExist(): void
    {
        $threadId = 'non-existent thread id';
        $this->assertSame(null, HubRepository::find($threadId));
    }
}
