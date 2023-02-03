<?php

namespace Tests\Unit\app\Services\ThreadImageService;

use App\Services\ThreadImageService;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tests\Support\ImageTestTrait;

class GetImageSize extends TestCase
{
    use ImageTestTrait;

    private ThreadImageService $service;

    /**
     * privateなメンバ変数 ThreadImageService::$imageSize を操作する
     *
     * @var mixed
     */
    private mixed $propertyImageSize;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->service = new ThreadImageService;
        $reflection = new ReflectionClass($this->service);
        $this->propertyImageSize = $reflection->getProperty('imageSize');
        $this->propertyImageSize->setAccessible(true);
    }

    /**
     * 画像パスが取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatTheImageSizeCanBeObtained(): void
    {
        foreach (range(1, 10000) as $_) {
            $imageSize = $this->makeImageSize();
            $this->propertyImageSize->setValue($this->service, $imageSize);
            $this->assertSame($imageSize, $this->service->getImageSize());
        }
    }

    /**
     * ThreadImagePathService::$imageSize に値が代入されていない
     *
     * @return void
     */
    public function testNotAssignedToAMemberVariable(): void
    {
        $this->assertSame(0, $this->service->getImageSize());
    }
}
