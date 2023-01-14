<?php

namespace Tests\Unit\app\Repositories\LectureThreadRepository;

use App\Repositories\LectureThreadRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetTableNameTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 正しいテーブル名を取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatTheCorrectTableNameCanBeObtained(): void
    {
        $this->assertSame('lecture_threads', LectureThreadRepository::getTableName());
    }
}
