<?php

namespace Tests\Unit\app\Repositories\HubRepository;

use App\Models\Hub;
use App\Models\ThreadPrimaryCategory;
use App\Models\ThreadSecondaryCategory;
use App\Repositories\HubRepository;
use ErrorException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetThreadPrimaryCategoryNameTest extends TestCase
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
     * 大枠カテゴリ名が取得できることをアサートする
     *
     * @return void
     */
    public function testAssertsThatALargeFrameCategoryNameCanBeObtained(): void
    {
        foreach ($this->threads as $thread) {
            $this->assertSame(
                ThreadPrimaryCategory::find($thread->thread_secondary_category->thread_primary_category_id)->name,
                HubRepository::getThreadPrimaryCategoryName($thread->id)
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
            fn () => HubRepository::getThreadPrimaryCategoryName($threadId),
            ErrorException::class
        );
    }
}
