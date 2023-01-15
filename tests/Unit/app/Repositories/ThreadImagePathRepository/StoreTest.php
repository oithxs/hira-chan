<?php

namespace Tests\Unit\app\Repositories\ThreadImagePathRepository;

use App\Consts\DatabaseConst;
use App\Consts\Tables\ThreadImagePathConst;
use App\Consts\Tables\ThreadsConst;
use App\Models\ThreadImagePath;
use App\Models\User;
use App\Repositories\ThreadImagePathRepository;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;
use TypeError;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    /**
     * 画像パス
     *
     * @var string
     */
    private string $imagePath;

    /**
     * 画像のファイルサイズ
     *
     * @var integer
     */
    private int $fileSize;

    /**
     * 各大枠カテゴリのテーブルの外部キー名
     *
     * @var array
     */
    private array $foreignKeyNames;

    /**
     * 各大枠カテゴリスレッドへの書き込みデータ
     *
     * @var array
     */
    private array $posts;

    /**
     * DBに保存できる該当カラムの最小値
     *
     * @var integer
     */
    private int $min_int;

    /**
     * DBに保存できる該当カラムの最大値
     *
     * @var integer
     */
    private int $max_int;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->makeImagePath();
        $this->makeFileSize();
        $this->foreignKeyNames = ThreadsConst::USED_FOREIGN_KEYS;
        $this->posts = [];
        foreach (ThreadsConst::MODEL_FQCNS as $modelClassName) {
            $this->posts[] = $modelClassName::factory()->create();
        }
        $this->min_int = DatabaseConst::MIN_INT;
        $this->max_int = DatabaseConst::MAX_INT;

        if (count($this->foreignKeyNames) !== count($this->posts)) {
            $this->assertTrue(false);
        }
    }

    /**
     * 画像情報保存テストで期待される戻り値（key）を取得する
     *
     * @return array
     */
    private function getKeysExpected(): array
    {
        return ThreadImagePathConst::COLUMNS;
    }

    /**
     * 画像情報保存テストで期待される戻り値（value）を取得する
     *
     * @param integer|null $i
     * @return array
     */
    private function getValuesExpected(int $i = null): array
    {
        $expected = [];
        foreach ($this->foreignKeyNames as $foreignKeyName) {
            $expected[$foreignKeyName] = $i !== null && $this->foreignKeyNames[$i] === $foreignKeyName ? $this->posts[$i]->id : null;
        }
        $expected['user_id'] = $this->user->id . '';
        $expected['img_path'] = $this->imagePath;
        $expected['img_size'] = $this->fileSize;
        return $expected;
    }

    /**
     * 画像情報保存テストで実際に保存されているデータを取得する
     *
     * @param integer|null $i
     * @return array
     */
    private function getValuesActual(int $i = null): array
    {
        if ($i === null) {
            $threadImagePath = $this->getAllThreadImagePath();
        } else {
            $threadImagePath = $this->getThreadImagePath($i);
        }
        return $this->getArrayElement($threadImagePath, [
            'club_thread_id',
            'college_year_thread_id',
            'department_thread_id',
            'job_hunting_thread_id',
            'lecture_thread_id',
            'user_id',
            'img_path',
            'img_size',
        ]);
    }

    /**
     * 渡された配列のうち，指定したインデックスの要素を返却する
     *
     * @param array $ary 連想配列
     * @param array $keys 連想配列のインデックスを指定
     * @return array インデックスと一致した連想配列を返却
     */
    private function getArrayElement(array $ary, array $keys): array
    {
        $post = [];
        foreach ($keys as $key) {
            $post[$key] = $ary[$key];
        }
        return $post;
    }

    /**
     * 1B ~ 10GB の範囲で数字を作成・取得する
     *
     * @return integer
     */
    private function makeFileSize(): int
    {
        $this->fileSize = random_int(1, 10485760);
        return $this->fileSize;
    }

    /**
     * 画像パスを作成・取得する
     *
     * @return string
     */
    private function makeImagePath(): string
    {
        $this->imagePath = Str::uuid();
        return $this->imagePath;
    }

    /**
     * `thread_image_path` テーブルに保存された対応するデータを取得する
     *
     * @param integer $i
     * @return array|null
     */
    private function getThreadImagePath(int $i): array | null
    {
        $threadImagePath = ThreadImagePath::where($this->foreignKeyNames[$i], $this->posts[$i]->id)->first();
        return $threadImagePath ? $threadImagePath->toArray() : null;
    }

    /**
     * `thread_image_path` テーブルに保存されたすべてのデータを取得する
     *
     * @return array|null
     */
    private function getAllThreadImagePath(): array | null
    {
        $threadImagePath = ThreadImagePath::first();
        return $threadImagePath ? $threadImagePath->toArray() : null;
    }

    /**
     * スレッドに書き込まれた画像のデータをアサートする
     *
     * @return void
     */
    public function testAssertTheDataOfTheImageWrittenToTheThread(): void
    {
        for ($i = 0; $i < count($this->foreignKeyNames); $i++) {
            ThreadImagePathRepository::store(
                $this->foreignKeyNames[$i],
                $this->posts[$i]->id,
                $this->user->id,
                $this->makeImagePath(),
                $this->makeFileSize()
            );

            $threadImagePath = $this->getThreadImagePath($i);
            $this->assertSame($this->getKeysExpected(), array_keys($threadImagePath));
            $this->assertSame($this->getValuesExpected($i), $this->getValuesActual($i));
        }
    }

    /**
     * 存在しない外部キーを引数とする
     *
     * @return void
     */
    public function testNonExistentForeignKeyNameAsAnArgument(): void
    {
        $messageId = mt_rand(); // 存在しない外部キーなので何であろうと参照整合性違反にはならない
        $foreignKey = 'not existent foreign key';
        ThreadImagePathRepository::store(
            $foreignKey,
            $messageId,
            $this->user->id,
            $this->makeImagePath(),
            $this->makeFileSize()
        );

        $threadImagePath = $this->getAllThreadImagePath();
        $this->assertSame($this->getKeysExpected(), array_keys($threadImagePath));
        $this->assertSame($this->getValuesExpected(), $this->getValuesActual());
    }

    /**
     * 外部キー未定義
     *
     * @return void
     */
    public function testForeignKeyUndefined(): void
    {
        for ($i = 0; $i < count($this->foreignKeyNames); $i++) {
            $this->assertThrows(
                fn () => ThreadImagePathRepository::store(
                    null,
                    $this->posts[$i]->id,
                    $this->user->id,
                    $this->makeImagePath(),
                    $this->makeFileSize()
                ),
                TypeError::class
            );

            $threadImagePath = $this->getAllThreadImagePath();
            $this->assertSame(null, $threadImagePath);
        }
    }

    /**
     * 存在しない書き込みを引数とする
     *
     * 参照整合性違反をアサートする
     *
     * @return void
     */
    public function testArgumentsForNotExistentPosts(): void
    {
        $messageId = 0;
        for ($i = 0; $i < count($this->foreignKeyNames); $i++) {
            $this->assertThrows(
                fn () => ThreadImagePathRepository::store(
                    $this->foreignKeyNames[$i],
                    $messageId,
                    $this->user->id,
                    $this->makeImagePath(),
                    $this->makeFileSize()
                ),
                QueryException::class
            );

            $threadImagePath = $this->getAllThreadImagePath();
            $this->assertSame(null, $threadImagePath);
        }
    }

    /**
     * メッセージID未定義
     *
     * @return void
     */
    public function testMessageIdUndefined(): void
    {
        for ($i = 0; $i < count($this->foreignKeyNames); $i++) {
            $this->assertThrows(
                fn () => ThreadImagePathRepository::store(
                    $this->foreignKeyNames[$i],
                    null,
                    $this->user->id,
                    $this->makeImagePath(),
                    $this->makeFileSize()
                ),
                TypeError::class
            );

            $threadImagePath = $this->getAllThreadImagePath();
            $this->assertSame(null, $threadImagePath);
        }
    }

    /**
     * 存在しないユーザを引数とする
     *
     * 参照整合性違反をアサートする
     *
     * @return void
     */
    public function testArgumentsForNotExistentUser(): void
    {
        $userId = 'not existent user id';
        for ($i = 0; $i < count($this->foreignKeyNames); $i++) {
            $this->assertThrows(
                fn () => ThreadImagePathRepository::store(
                    $this->foreignKeyNames[$i],
                    $this->posts[$i]->id,
                    $userId,
                    $this->makeImagePath(),
                    $this->makeFileSize()
                ),
                QueryException::class
            );

            $threadImagePath = $this->getAllThreadImagePath();
            $this->assertSame(null, $threadImagePath);
        }
    }

    /**
     * ユーザID未定義
     *
     * @return void
     */
    public function testUserIdUndefined(): void
    {
        for ($i = 0; $i < count($this->foreignKeyNames); $i++) {
            $this->assertThrows(
                fn () => ThreadImagePathRepository::store(
                    $this->foreignKeyNames[$i],
                    $this->posts[$i]->id,
                    null,
                    $this->makeImagePath(),
                    $this->makeFileSize()
                ),
                TypeError::class
            );

            $threadImagePath = $this->getAllThreadImagePath();
            $this->assertSame(null, $threadImagePath);
        }
    }

    /**
     * 画像パス未定義
     *
     * @return void
     */
    public function testImagePathUndefined(): void
    {
        for ($i = 0; $i < count($this->foreignKeyNames); $i++) {
            $this->assertThrows(
                fn () => ThreadImagePathRepository::store(
                    $this->foreignKeyNames[$i],
                    $this->posts[$i]->id,
                    $this->user->id,
                    null,
                    $this->makeFileSize()
                ),
                TypeError::class
            );

            $threadImagePath = $this->getAllThreadImagePath();
            $this->assertSame(null, $threadImagePath);
        }
    }

    /**
     * 保存できる画像サイズの最小値
     *
     * @return void
     */
    public function testMinimumImageSizeThatCanBeSaved(): void
    {
        for ($i = 0; $i < count($this->foreignKeyNames); $i++) {
            $this->fileSize = $this->min_int;
            ThreadImagePathRepository::store(
                $this->foreignKeyNames[$i],
                $this->posts[$i]->id,
                $this->user->id,
                $this->makeImagePath(),
                $this->fileSize
            );

            $threadImagePath = $this->getThreadImagePath($i);
            $this->assertSame($this->getKeysExpected(), array_keys($threadImagePath));
            $this->assertSame($this->getValuesExpected($i), $this->getValuesActual($i));
        }
    }

    /**
     * 保存できる画像サイズの最小値超過
     *
     * @return void
     */
    public function testExceedsTheMinimumImageSizeThatCanBeSaved(): void
    {
        for ($i = 0; $i < count($this->foreignKeyNames); $i++) {
            $this->fileSize = $this->min_int - 1;
            $this->assertThrows(
                fn () => ThreadImagePathRepository::store(
                    $this->foreignKeyNames[$i],
                    $this->posts[$i]->id,
                    $this->user->id,
                    $this->makeImagePath(),
                    $this->fileSize
                ),
                QueryException::class
            );

            $threadImagePath = $this->getAllThreadImagePath();
            $this->assertSame(null, $threadImagePath);
        }
    }

    /**
     * 保存できる画像サイズの最大値
     *
     * @return void
     */
    public function testMaximumImageSizeThatCanBeSaved(): void
    {
        for ($i = 0; $i < count($this->foreignKeyNames); $i++) {
            $this->fileSize = $this->max_int;
            ThreadImagePathRepository::store(
                $this->foreignKeyNames[$i],
                $this->posts[$i]->id,
                $this->user->id,
                $this->makeImagePath(),
                $this->fileSize
            );

            $threadImagePath = $this->getThreadImagePath($i);
            $this->assertSame($this->getKeysExpected(), array_keys($threadImagePath));
            $this->assertSame($this->getValuesExpected($i), $this->getValuesActual($i));
        }
    }

    /**
     * 保存できる画像サイズの最大値超過
     *
     * @return void
     */
    public function testExceedsTheMaximumImageSizeThatCanBeSaved(): void
    {
        for ($i = 0; $i < count($this->foreignKeyNames); $i++) {
            $this->fileSize = $this->max_int + 1;
            $this->assertThrows(
                fn () => ThreadImagePathRepository::store(
                    $this->foreignKeyNames[$i],
                    $this->posts[$i]->id,
                    $this->user->id,
                    $this->makeImagePath(),
                    $this->fileSize
                ),
                QueryException::class
            );

            $threadImagePath = $this->getAllThreadImagePath();
            $this->assertSame(null, $threadImagePath);
        }
    }
    /**
     * ファイルサイズ未定義
     *
     * @return void
     */
    public function testFileSizeUndefined(): void
    {
        for ($i = 0; $i < count($this->foreignKeyNames); $i++) {
            $this->assertThrows(
                fn () => ThreadImagePathRepository::store(
                    $this->foreignKeyNames[$i],
                    $this->posts[$i]->id,
                    $this->user->id,
                    $this->makeImagePath(),
                    null
                ),
                TypeError::class
            );

            $threadImagePath = $this->getAllThreadImagePath();
            $this->assertSame(null, $threadImagePath);
        }
    }
}
