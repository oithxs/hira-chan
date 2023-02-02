<?php

namespace App\Services;

use App\Models\ClubThread;
use App\Models\CollegeYearThread;
use App\Models\DepartmentThread;
use App\Models\JobHuntingThread;
use App\Models\LectureThread;
use App\Repositories\ThreadImagePathRepository;
use App\Repositories\ThreadRepository;
use App\Services\ThreadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as FacadesImage;
use Intervention\Image\Image;
use Illuminate\Support\Str;

class ThreadImageService
{
    private Image | null $image;

    private ThreadService $threadService;

    /**
     * 画像までのパス
     *
     * @var string
     */
    private string $imagePath;

    /**
     * 画像のサイズ
     *
     * @var integer
     */
    private int $imageSize;

    public function __construct()
    {
        $this->image = null;
        $this->threadService = new threadService();
        $this->imagePath = '';
        $this->imageSize = 0;
    }

    /**
     * 画像を storage に保存し，DBに画像の情報を保存する
     *
     * @param UploadedFile $image アップロードされた画像
     * @param ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread $post スレッドへの書き込み
     * @param string $userId 画像をアップロードしたユーザのID
     * @return void
     */
    public function store(
        UploadedFile $image,
        ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread $post,
        string $userId
    ): void {
        // 画像をストレージに保存
        $this->storeImage($image);

        // 画像の情報をDBに保存
        $this->storeToDB($post, $userId);
    }

    /**
     * 画像を storage に保存する
     *
     * @param UploadedFile $image アップロードされた画像
     * @return void
     */
    public function storeImage(UploadedFile $image)
    {
        $this->image = $this->encodeToJpg($image);
        $this->imageSize = $this->image->filesize();
        Storage::disk('local')->put($this->makeImagePath(), $this->image);
    }

    /**
     * 画像の情報をデータベースに保存する
     *
     * @param ClubThread|CollegeYearThread|DepartmentThread|JobHuntingThread|LectureThread $post スレッドへの書き込み
     * @param string $userId 画像をアップロードしたユーザのID
     * @return void
     */
    public function storeToDB(
        ClubThread | CollegeYearThread | DepartmentThread | JobHuntingThread | LectureThread $post,
        $userId
    ): void {
        ThreadImagePathRepository::store(
            $this->threadService->postToForeignKey($post),
            ThreadRepository::getId($post),
            $userId,
            $this->imagePath,
            $this->getImageSize()
        );
    }

    /**
     * 画像パスを作成する
     *
     * @return string スレッドへアップロードされた画像の保存先（の文字列）
     */
    public function makeImagePath(): string
    {
        $this->imagePath = config('image.path.upload.thread') . str_replace('-', '', Str::uuid()) . '.jpg';
        return $this->imagePath;
    }

    /**
     * 画像をJPGに変換する
     *
     * @param UploadedFile $image アップロードした画像
     * @return Image JPG形式に変換した画像
     */
    public function encodeToJpg(UploadedFile $image): Image
    {
        return FacadesImage::make($image)->encode('jpg')->orientate();
    }

    /**
     * インスタンスの画像パスを取得する
     *
     * @return string （メンバ変数：imagePath）画像パス
     */
    public function getImagePath(): string
    {
        return $this->imagePath;
    }

    /**
     * ファイルサイズを取得する
     *
     * @return integer （メンバ変数：imageSize）画像のサイズ
     */
    public function getImageSize(): int
    {
        return $this->imageSize;
    }
}
