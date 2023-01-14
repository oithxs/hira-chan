<?php

namespace Tests\Unit\app\Repositories\ClubThreadRepository;

use App\Repositories\ClubThreadRepository;
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
        $this->assertSame('club_threads', ClubThreadRepository::getTableName());
    }
}
