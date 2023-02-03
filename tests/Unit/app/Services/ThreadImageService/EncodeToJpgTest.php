<?php

namespace Tests\Unit\app\Services\ThreadImageService;

use App\Services\ThreadImageService;
use Illuminate\Support\Facades\Storage;
use Tests\Support\ImageTestTrait;
use Tests\TestCase;
use TypeError;

class EncodeToJpgTest extends TestCase
{
    use ImageTestTrait;

    /**
     * テスト対象のメソッド
     *
     * @var array
     */
    private array $method;

    /**
     * Storage::disk('local') までのパス
     *
     * @var string
     */
    private string $storagePath;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->method = [new ThreadImageService, 'encodeToJpg'];
        $this->storagePath = './storage/app/';
    }

    /**
     * JPG形式の画像が取得できることをアサートする
     *
     * @return void
     */
    public function testAssertThatImagesInJpgFormatCanBeAcquired(): void
    {
        foreach ($this->images as $image) {
            $this->makeImagePath();
            Storage::disk('local')->put(
                $this->imagePath,
                ($this->method)($this->getUploadedFile($image))
            );

            $this->assertSame(
                IMAGETYPE_JPEG,
                exif_imagetype($this->storagePath . $this->imagePath)
            );
            Storage::disk('local')->delete($this->imagePath);
        }
    }

    /**
     * 存在しない画像を引数とする
     *
     * @return void
     */
    public function testArgumentIsAImageThatDoseNotExist(): void
    {
        $image = 'not existent image';
        $this->assertThrows(
            fn () => ($this->method)($this->getUploadedFile($image)),
            TypeError::class
        );
    }

    /**
     * 画像未定義
     *
     * @return void
     */
    public function testImageUndefined(): void
    {
        $this->assertThrows(
            fn () => ($this->method)($this->getUploadedFile()),
            TypeError::class
        );
    }
}
