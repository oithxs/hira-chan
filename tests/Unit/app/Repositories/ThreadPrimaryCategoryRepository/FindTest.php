<?php

namespace Tests\Unit\app\Repositories\ThreadPrimaryCategoryRepository;

use App\Consts\Tables\ThreadsConst;
use App\Models\ThreadPrimaryCategory;
use App\Repositories\ThreadPrimaryCategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TypeError;

class FindTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 対応する `thread_primary_categorys` テーブルのデータを取得する
     *
     * @param string $name
     * @return array
     */
    private function findThreadPrimaryCategory(string $name): array
    {
        return ThreadPrimaryCategory::where('name', $name)->first()->toArray();
    }

    /**
     * 大枠カテゴリが取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatThreadPrimaryCategoryCanBeRetrieved(): void
    {
        foreach (ThreadsConst::CATEGORYS as $key => $value) {
            $this->assertSame(
                $this->findThreadPrimaryCategory($value),
                ThreadPrimaryCategoryRepository::find($key + 1)->toArray()
            );
        }
    }

    /**
     * 存在しない `id` を引数とする
     *
     * @return void
     */
    public function testArgumentIsAThreadPrimaryCategoryIdThatDoesNotExist(): void
    {
        $id = 'not existent id'; // string
        $this->assertThrows(
            fn () => ThreadPrimaryCategoryRepository::find($id),
            TypeError::class
        );

        $id = 0; // int
        $this->assertSame(null, ThreadPrimaryCategoryRepository::find($id));
    }

    /**
     * `id` 未定義
     *
     * @return void
     */
    public function testIdUndefined(): void
    {
        $this->assertThrows(
            fn () => ThreadPrimaryCategoryRepository::find(),
            TypeError::class
        );
    }
}
