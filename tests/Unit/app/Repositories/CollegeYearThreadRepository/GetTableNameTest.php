<?php

namespace Tests\Unit\app\Repositories\CollegeYearThreadRepository;

use App\Repositories\CollegeYearThreadRepository;
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
        $this->assertSame('college_year_threads', CollegeYearThreadRepository::getTableName());
    }
}
