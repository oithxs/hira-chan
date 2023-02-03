<?php

namespace Tests\Unit\app\Services\ThreadImageService;

use App\Services\ThreadImageService;
use ReflectionClass;
use Tests\TestCase;

class MakeImagePath extends TestCase
{
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
    }

    /**
     * アップロードされた画像パスを正規表現用に修正する
     *
     * @return string
     */
    private function makeRegexString(): string
    {
        $path = config('image.path.upload.thread');
        $path = str_replace('/', '\/', $path);
        $path = str_replace('.', '\.', $path);
        return $path;
    }

    /**
     * 取得した画像のパスを取得する
     *
     * @return void
     */
    public function testAssertThePathOfTheAcquiredImage(): void
    {
        $path = $this->makeRegexString();
        foreach (range(1, 10000) as $_) {
            // メソッドからの戻り値
            $this->assertMatchesRegularExpression(
                "/^$path([0-9a-z]{32}\.jpg)\$/",
                $this->service->makeImagePath()
            );

            // メンバ変数
            $this->assertMatchesRegularExpression(
                "/^$path([0-9a-z]{32}\.jpg)\$/",
                $this->propertyImagePath->getValue($this->service)
            );
        }
    }
}
