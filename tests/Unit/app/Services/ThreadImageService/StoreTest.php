<?php

namespace Tests\Unit\app\Services\ThreadImageService;

use App\Consts\Tables\ThreadsConst;
use App\Models\ThreadImagePath;
use App\Models\User;
use App\Services\ThreadImageService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Support\ArrayToolsTrait;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\AssertSame\Tables\ThreadImagePathTrait;
use Tests\Support\ImageTestTrait;
use Tests\Support\PostTestTrait;
use Tests\TestCase;
use TypeError;

class StoreTest extends TestCase implements AssertSameInterface
{
    use RefreshDatabase,
        ArrayToolsTrait,
        ImageTestTrait,
        PostTestTrait,
        ThreadImagePathTrait;

    private User $user;

    private ThreadImageService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->postSetUp();

        // メンバ変数に値を代入
        $this->user = User::factory()->create();
        $this->service = new ThreadImageService;
    }

    /**
     * thread_image_paths テーブルの一部のカラムのデータを期待する値として返却する
     *
     * @param array $args
     * @return array
     */
    public function getValuesExpected(array $args): array
    {
        $expected = [];
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $expected[ThreadsConst::USED_FOREIGN_KEYS[$i]] = $this->checkPostCategory($args['i'], $i)
                ? $this->posts[$args['i']]->id
                : null;
        }
        $expected['user_id'] = $this->user->id . '';
        $expected['img_path'] = $this->imagePath;
        $expected['img_size'] = (int) $this->imageSize;

        return $expected;
    }

    /**
     * thread_image_paths テーブルの対応するデータを取得する
     *
     * @param integer $i
     * @return array
     */
    private function getThreadImagePath(int $i): array
    {
        return ThreadImagePath::where([
            [ThreadsConst::USED_FOREIGN_KEYS[$i], $this->posts[$i]->id]
        ])->orderByDesc('id')->first()->toArray();
    }

    /**
     * thread_image_paths テーブルのすべてのデータを取得する
     *
     * @return array
     */
    private function getAllThreadImagePath(): array
    {
        return ThreadImagePath::all()->toArray();
    }

    /**
     * 書き込みを行ったスレッドの大枠カテゴリ名を取得する
     *
     * @param integer $i
     * @return void
     */
    private function postToThreadPrimaryCategoryName(int $i)
    {
        return $this->posts[$i]->hub->thread_secondary_category->thread_primary_category->name;
    }

    /**
     * 書き込みを行ったスレッドの大枠カテゴリ名が指定したものと一致することを確認する
     *
     * @param integer $postsIndex メンバ変数「$posts」のインデックス
     * @param integer $threadPrimaryCategoryIndex ThreadsConst::CATEGORYS のインデックス
     * @return boolean
     */
    private function checkPostCategory(int $postsIndex, int $threadPrimaryCategoryIndex): bool
    {
        return $this->postToThreadPrimaryCategoryName($postsIndex) === ThreadsConst::CATEGORYS[$threadPrimaryCategoryIndex];
    }

    /**
     * 画像がストレージとデータベースに保存されていることをアサートする
     *
     * @return void
     */
    public function testAssertsThatImagesAreStoredInStorageAndDatabase(): void
    {
        Storage::fake('local');
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            foreach ($this->images as $image) {
                $this->service->store(
                    $this->getUploadedFile($image),
                    $this->posts[$i],
                    $this->user->id
                );
                $this->imagePath = $this->service->getImagePath();
                $this->imageSize = $this->service->getImageSize();
                $this->threadImagePath = $this->getThreadImagePath($i);

                Storage::disk('local')->assertExists($this->imagePath);
                Storage::disk('local')->assertDirectoryNotEmpty(config('image.path.upload.thread'));
                $this->assertMatchesRegularExpression(
                    '/^public\/images\/thread_message\/[0-9a-z]{32}\.jpg$/',
                    $this->imagePath
                );
                $this->assertSame($this->getKeysExpected(), array_keys($this->getThreadImagePath($i)));
                $this->assertSame($this->getValuesExpected(['i' => $i]), $this->getValuesActual());
            }
        }
    }

    /**
     * 画像ファイルをアップロードしない
     *
     * @return void
     */
    public function testUploadingNotImageFile(): void
    {
        Storage::fake('local');
        $image = 'not existent image';

        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $this->assertThrows(
                fn () => $this->service->store(
                    $image,
                    $this->posts[$i],
                    $this->user->id
                ),
                TypeError::class
            );

            Storage::disk('local')->assertDirectoryEmpty(config('image.path.upload.thread'));
            $this->assertSame([],  $this->getAllThreadImagePath());
        }
    }

    /**
     * 画像ファイル未定義
     *
     * @return void
     */
    public function testImageFileUndefined(): void
    {
        Storage::fake('local');
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            foreach ($this->images as $image) {
                $this->assertThrows(
                    fn () => $this->service->store(
                        null,
                        $this->posts[$i],
                        $this->user->id
                    ),
                    TypeError::class
                );

                Storage::disk('local')->assertDirectoryEmpty(config('image.path.upload.thread'));
                $this->assertSame([],  $this->getAllThreadImagePath());
            }
        }
    }

    /**
     * 存在しない書き込みを引数とする
     *
     * @return void
     */
    public function testArgumentIsAPostThatDoseNotExist(): void
    {
        Storage::fake('local');
        $post = 'not existent post';

        foreach ($this->images as $image) {
            $this->assertThrows(
                fn () => $this->service->store(
                    $this->getUploadedFile($image),
                    $post,
                    $this->user->id
                ),
                TypeError::class
            );

            Storage::disk('local')->assertDirectoryEmpty(config('image.path.upload.thread'));
            $this->assertSame([],  $this->getAllThreadImagePath());
        }
    }

    /**
     * 書き込み未定義
     *
     * @return void
     */
    public function testPostUndefined(): void
    {
        Storage::fake('local');
        foreach ($this->images as $image) {
            $this->assertThrows(
                fn () => $this->service->store(
                    $this->getUploadedFile($image),
                    null,
                    $this->user->id
                ),
                TypeError::class
            );

            Storage::disk('local')->assertDirectoryEmpty(config('image.path.upload.thread'));
            $this->assertSame([],  $this->getAllThreadImagePath());
        }
    }

    /**
     * 存在しないユーザIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAUserIdThatDoseNotExist(): void
    {
        Storage::fake('local');
        $userId = 'not existent user id';

        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            foreach ($this->images as $image) {
                $this->assertThrows(
                    fn () => $this->service->store(
                        $this->getUploadedFile($image),
                        $this->posts[$i],
                        $userId
                    ),
                    QueryException::class
                );
                $this->imagePath = $this->service->getImagePath();
                $this->imageSize = $this->service->getImageSize();

                Storage::disk('local')->assertExists($this->imagePath);
                Storage::disk('local')->assertDirectoryNotEmpty(config('image.path.upload.thread'));
                $this->assertMatchesRegularExpression(
                    '/^public\/images\/thread_message\/[0-9a-z]{32}\.jpg$/',
                    $this->imagePath
                );
                $this->assertSame([],  $this->getAllThreadImagePath());
            }
        }
    }

    /**
     * ユーザID未定義
     *
     * @return void
     */
    public function testUserIdUndefined(): void
    {
        Storage::fake('local');
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            foreach ($this->images as $image) {
                $this->assertThrows(
                    fn () => $this->service->store(
                        $this->getUploadedFile($image),
                        $this->posts[$i],
                        null
                    ),
                    TypeError::class
                );

                Storage::disk('local')->assertDirectoryEmpty(config('image.path.upload.thread'));
                $this->assertSame([],  $this->getAllThreadImagePath());
            }
        }
    }
}
