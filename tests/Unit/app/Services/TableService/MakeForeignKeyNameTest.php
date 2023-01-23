<?php

namespace Tests\Unit\app\Services\TableService;

use App\Services\TableService;
use PHPUnit\Framework\TestCase;

class MakeForeignKeyNameTest extends TestCase
{
    private array $method;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->method = [new TableService, 'makeForeignKeyName'];
    }

    public function test(): void
    {
        
    }
}
