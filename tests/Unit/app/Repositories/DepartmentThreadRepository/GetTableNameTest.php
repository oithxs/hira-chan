<?php

namespace Tests\Unit\app\Repositories\DepartmentThreadRepository;

use App\Repositories\DepartmentThreadRepository;
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
        $this->assertSame('department_threads', DepartmentThreadRepository::getTableName());
    }
}
