<?php

namespace Tests\Unit\app\Services\ThreadImageService;

use App\Services\ThreadImageService;
use Illuminate\Support\Str;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tests\Support\ImageTestTrait;

class GetImagePathTest extends TestCase
{
    use ImageTestTrait;

    private ThreadImageService $service;

    /**
     * privateなメンバ変数 ThreadImageService::$imagePath を操作する
     *
     * @var mixed
     */
    private mixed $propertyImagePath;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->service = new ThreadImageService;
        $reflection = new ReflectionClass($this->service);
        $this->propertyImagePath = $reflection->getProperty('imagePath');
        $this->propertyImagePath->setAccessible(true);
    }

    /**
     * 画像パスが取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatTheImagePathCanBeObtained(): void
    {
        foreach (range(1, 10000) as $_) {
            $imagePath = $this->makeImagePath();
            $this->propertyImagePath->setValue($this->service, $imagePath);
            $this->assertSame($imagePath, $this->service->getImagePath());
        }
    }

    /**
     * ThreadImagePathService::$imagePath に値が代入されていない
     *
     * @return void
     */
    public function testNotAssignedToAMemberVariable(): void
    {
        $this->assertSame('', $this->service->getImagePath());
    }
}
