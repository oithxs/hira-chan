<?php

namespace Tests\Unit\app\Repositories\JobHuntingThreadRepository;

use App\Repositories\JobHuntingThreadRepository;
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
        $this->assertSame('job_hunting_threads', JobHuntingThreadRepository::getTableName());
    }
}
