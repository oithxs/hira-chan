<?php

namespace Tests\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait ImageTestTrait
{
    /**
     * テストで使用する各フォーマットの画像パス
     *
     * @var array
     */
    private array $images = [
        'bmp' => ['path' => './tests/storage/image/test.bmp', 'name' => 'test.bmp'],
        'static.gif' => ['path' => './tests/storage/image/test.static.gif', 'name' => 'test.static.gif'],
        'animation.gif' => ['path' => './tests/storage/image/test.animation.gif', 'name' => 'test.animation.gif'],
        'jpg' => ['path' => './tests/storage/image/test.jpg', 'name' => 'test.jpg'],
        'png' => ['path' => './tests/storage/image/test.png', 'name' => 'test.png'],
        'webp' => ['path' => './tests/storage/image/test.webp', 'name' => 'test.webp'],
    ];

    /**
     * 保存済み・保存する画像のパス
     *
     * @var string
     */
    public string $imagePath;

    /**
     * 保存した・保存する画像のサイズ
     *
     * @var string
     */
    public string $imageSize;

    /**
     * メンバ変数に初期値を代入する
     *
     * @return void
     */
    public function imageSetUp(): void
    {
        $this->makeImagePath();
        $this->makeImageSize();
    }

    /**
     * 画像パスを取得する
     *
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * 画像パスを作成・取得する
     *
     * @return string
     */
    public function makeImagePath(): string
    {
        $this->imagePath = Str::uuid();
        return $this->imagePath;
    }

    /**
     * 1B ~ 10GB の範囲で数字を作成・取得する
     *
     * @return integer
     */
    public function makeImageSize(): int
    {
        $this->fileSize = random_int(1, 10485760);
        return $this->fileSize;
    }

    /**
     * UploadedFileのインスタンスを返却する
     *
     * @param array $image
     * @return UploadedFile
     */
    public function getUploadedFile(array $image): UploadedFile
    {
        return new UploadedFile($image['path'], $image['name']);
    }
}
