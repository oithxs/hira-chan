<?php

namespace Tests\Unit\app\Repositories\HubRepository;

use App\Models\Hub;
use App\Models\ThreadSecondaryCategory;
use App\Repositories\HubRepository;
use ErrorException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetThreadSecondaryCategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * すべての詳細カテゴリのスレッド
     *
     * @var array
     */
    private array $threads;

    public function setUp(): void
    {
        parent::setUp();

        foreach (ThreadSecondaryCategory::get() as $threadSecondaryCategory) {
            $this->threads[$threadSecondaryCategory->id] = Hub::factory([
                'thread_secondary_category_id' => $threadSecondaryCategory->id
            ])->create();
        }
    }

    /**
     * 詳細カテゴリが取得できることをアサートする
     *
     * @return void
     */
    public function testAssertsThatTheDetailCategoryCanBeObtained(): void
    {
        foreach ($this->threads as $thread) {
            $this->assertSame(
                ThreadSecondaryCategory::find($thread->thread_secondary_category_id)->toArray(),
                HubRepository::getThreadSecondaryCategory($thread->id)->toArray()
            );
        }
    }

    /**
     * 存在しないスレッドIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAThreadIdThatDoseNotExist(): void
    {
        $threadId = 'non-existent thread id';
        $this->assertThrows(
            fn () => HubRepository::getThreadPrimaryCategory($threadId),
            ErrorException::class
        );
    }
}
