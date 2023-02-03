<?php

namespace Tests\Unit\app\Repositories\ThreadPrimaryCategoryRepository;

use App\Consts\Tables\ThreadsConst;
use App\Repositories\ThreadPrimaryCategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use TypeError;

class GetNameTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 大枠カテゴリ名が取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatThreadPrimaryCategoryNameBeRetrieved(): void
    {
        foreach (ThreadsConst::CATEGORYS as $key => $value) {
            $this->assertSame(
                $value,
                ThreadPrimaryCategoryRepository::getName($key + 1)
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
            fn () => ThreadPrimaryCategoryRepository::getName($id),
            TypeError::class
        );


        $id = 0; // int
        $this->assertSame(null, ThreadPrimaryCategoryRepository::getName($id));
    }

    /**
     * `id` 未定義
     *
     * @return void
     */
    public function testIdUndefined(): void
    {
        $this->assertThrows(
            fn () => ThreadPrimaryCategoryRepository::getName(),
            TypeError::class
        );
    }
}
