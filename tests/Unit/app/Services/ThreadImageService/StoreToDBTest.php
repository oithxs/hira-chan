<?php

namespace Tests\Unit\app\Services\ThreadImageService;

use App\Consts\Tables\ThreadsConst;
use App\Models\ThreadImagePath;
use App\Models\User;
use App\Services\ThreadImageService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use ReflectionClass;
use Tests\Support\ArrayToolsTrait;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\AssertSame\Tables\ThreadImagePathTrait;
use Tests\Support\ImageTestTrait;
use Tests\Support\PostTestTrait;
use Tests\TestCase;
use TypeError;

class StoreToDBTest extends TestCase implements AssertSameInterface
{
    use ArrayToolsTrait,
        ImageTestTrait,
        PostTestTrait,
        RefreshDatabase,
        ThreadImagePathTrait;

    private ThreadImageService $service;

    /**
     * privateなメンバ変数 ThreadImageService::$imagePath を操作する
     *
     * @var mixed
     */
    private mixed $propertyImagePath;

    /**
     * privateなメンバ変数 ThreadImageService::$imageSize を操作する
     *
     * @var mixed
     */
    private mixed $propertyImageSize;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->imageSetUp();
        $this->postSetUp();

        // メンバ変数に値を代入する
        $this->service = new ThreadImageService;
        $reflection = new ReflectionClass($this->service);
        $this->propertyImagePath = $reflection->getProperty('imagePath');
        $this->propertyImagePath->setAccessible(true);
        $this->propertyImageSize = $reflection->getProperty('imageSize');
        $this->propertyImageSize->setAccessible(true);
        $this->service = new ThreadImageService;
        $this->user = User::factory()->create();
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
     * 画像がデータベースに保存されていることをアサートする
     *
     * @return void
     */
    public function testAssertsThatImagesAreStoredInDatabase(): void
    {
        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $this->propertyImagePath->setValue($this->service, $this->makeImagePath());
            $this->propertyImageSize->setValue($this->service, $this->makeImageSize());
            $this->service->storeToDB(
                $this->posts[$i],
                $this->user->id
            );

            $this->threadImagePath = $this->getThreadImagePath($i);
            $this->assertSame($this->getKeysExpected(), array_keys($this->getThreadImagePath($i)));
            $this->assertSame($this->getValuesExpected(['i' => $i]), $this->getValuesActual());
        }
    }

    /**
     * 存在しない書き込みを引数とする
     *
     * @return void
     */
    public function testArgumentIsAPostThatDoseNotExist(): void
    {
        $post = 'not existent post';
        $this->propertyImagePath->setValue($this->service, $this->makeImagePath());
        $this->propertyImageSize->setValue($this->service, $this->makeImageSize());

        $this->assertThrows(
            fn () => $this->service->storeToDB(
                $post,
                $this->user->id
            ),
            TypeError::class
        );
        $this->assertSame([], $this->getAllThreadImagePath());
    }

    /**
     * 書き込み未定義
     *
     * @return void
     */
    public function testPostUndefined(): void
    {
        $this->propertyImagePath->setValue($this->service, $this->makeImagePath());
        $this->propertyImageSize->setValue($this->service, $this->makeImageSize());

        $this->assertThrows(
            fn () => $this->service->storeToDB(
                null,
                $this->user->id
            ),
            TypeError::class
        );
        $this->assertSame([], $this->getAllThreadImagePath());
    }

    /**
     * 存在しないユーザIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAUserIdThatDoseNotExist(): void
    {
        $userId = 'not existent user id';
        $this->propertyImagePath->setValue($this->service, $this->makeImagePath());
        $this->propertyImageSize->setValue($this->service, $this->makeImageSize());

        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $this->assertThrows(
                fn () => $this->service->storeToDB(
                    $this->posts[$i],
                    $userId
                ),
                QueryException::class
            );
            $this->assertSame([], $this->getAllThreadImagePath());
        }
    }

    /**
     * ユーザID未定義
     *
     * @return void
     */
    public function testUserIdUndefined(): void
    {
        $this->propertyImagePath->setValue($this->service, $this->makeImagePath());
        $this->propertyImageSize->setValue($this->service, $this->makeImageSize());

        for ($i = 0; $i < count(ThreadsConst::USED_FOREIGN_KEYS); $i++) {
            $this->assertThrows(
                fn () => $this->service->storeToDB(
                    $this->posts[$i],
                    null
                ),
                TypeError::class
            );
            $this->assertSame([], $this->getAllThreadImagePath());
        }
    }
}
