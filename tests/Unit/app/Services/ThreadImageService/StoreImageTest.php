<?php

namespace Tests\Unit\app\Services\ThreadImageService;

use App\Services\ThreadImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Support\ImageTestTrait;
use Tests\TestCase;
use TypeError;

class StoreImageTest extends TestCase
{
    use RefreshDatabase,
        ImageTestTrait;

    private ThreadImageService $service;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->service = new ThreadImageService();
    }

    /**
     * 画像が storage に保存されていることをアサートする
     *
     * @return void
     */
    public function testAssertsThatTheImageIsStoredInStorage(): void
    {
        Storage::fake('local');
        foreach ($this->images as $image) {
            $this->service->storeImage($this->getUploadedFile($image));
            $this->imagePath = $this->service->getImagePath();

            Storage::assertExists($this->imagePath);
            Storage::assertDirectoryNotEmpty(config('image.path.upload.thread'));
        }
    }

    /**
     * 存在しない画像を引数とする
     *
     * @return void
     */
    public function testArgumentIsAImageThatDoseNotExist(): void
    {
        Storage::fake('local');
        $image = 'not existent image';
        $this->assertThrows(
            fn () => $this->service->storeImage($this->getUploadedFile($image)),
            TypeError::class
        );
        Storage::assertDirectoryEmpty(config('image.path.upload.thread'));
    }

    /**
     * 画像未定義
     *
     * @return void
     */
    public function testImageUndefined(): void
    {
        Storage::fake('local');
        $this->assertThrows(
            fn () => $this->service->storeImage($this->getUploadedFile()),
            TypeError::class
        );
        Storage::assertDirectoryEmpty(config('image.path.upload.thread'));
    }
}
