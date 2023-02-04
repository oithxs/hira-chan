<?php

namespace Tests\Unit\app\Services\HubService;

use App\Consts\Tables\ThreadSecondaryCategoryConst;
use App\Models\Hub;
use App\Models\ThreadSecondaryCategory;
use App\Models\User;
use App\Services\HubService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\AssertSame\Tables\HubTrait;
use Tests\Support\Random;
use Tests\TestCase;
use TypeError;

class StoreTest extends TestCase implements AssertSameInterface
{
    use HubTrait,
        RefreshDatabase;

    /**
     * @var User テストで使用するユーザ
     */
    private User $user;

    /**
     * @var array テスト対象のメソッド
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->user = User::factory()->create();
        $this->method = [new HubService, 'store'];
    }

    /**
     * スレッドの期待するデータを返却する
     *
     * @param array $args ['threadSecondaryCategoryId', 'userId', 'name']の要素が必要
     * @return array 期待するhubテーブルに保存されたデータ
     */
    public function getValuesExpected(array $args): array
    {
        $expected = [];
        $expected['thread_secondary_category_id'] = $args['threadSecondaryCategoryId'];
        $expected['user_id'] = $args['userId'] . '';
        $expected['name'] = $args['name'];
        return $expected;
    }

    /**
     * 対応するhubテーブルのデータを取得する
     *
     * このテストでは各詳細カテゴリごとに1つしかスレッドを作成しないため，
     * 詳細カテゴリIDでスレッドを一意に識別することが可能
     *
     * @param integer $threadSecondaryCategoryId 詳細カテゴリID
     * @return array 対応するhubテーブルすべてのカラム
     */
    private function getHub(int $threadSecondaryCategoryId): array
    {
        return Hub::where('thread_secondary_category_id', $threadSecondaryCategoryId)
            ->first()->toArray();
    }

    /**
     * hubテーブルすべてのデータを取得する
     *
     * @return array hubテーブルに保存されたすべてのデータ
     */
    private function getAllHub(): array
    {
        return Hub::get()->toArray();
    }

    /**
     * thread_secondary_categorys テーブルのデータを取得する
     *
     * @return array thread_secondary_categorys テーブルすべてのデータ
     */
    private function getAllThreadSecondaryCategory(): array
    {
        return ThreadSecondaryCategory::get()->toArray();
    }

    /**
     * thread_secondary_categorys テーブルのすべてのIDを取得する
     *
     * @return array thread_secondary_categorys テーブルのすべてのID
     */
    private function getAllThreadSecondaryCategoryIds(): array
    {
        $ids = [];
        foreach ($this->getAllThreadSecondaryCategory() as $threadSecondaryCategory) {
            $ids[] = $threadSecondaryCategory['id'];
        }
        return $ids;
    }

    /**
     * 詳細カテゴリ名からIDを取得する
     *
     * @param string $threadSecondaryCategoryName 詳細カテゴリ名
     * @return integer|null 詳細カテゴリのID
     */
    private function nameToId(string $threadSecondaryCategoryName): int | null
    {
        return ThreadSecondaryCategory::where([
            ['name', $threadSecondaryCategoryName]
        ])->first()->id ?? null;
    }

    /**
     * getValuesActualメソッドで使用するメンバ変数「$hub」に値をセットする
     *
     * @param integer $threadSecondaryCategoryId 作成したスレッドが属する詳細カテゴリのID
     * @param string $userId スレッドを作成したユーザのID
     * @param string $name 作成したスレッド名
     * @return void
     */
    private function setHub(
        int $threadSecondaryCategoryId,
        string $userId,
        string $name
    ): void {
        $this->hub['thread_secondary_category_id'] = $threadSecondaryCategoryId;
        $this->hub['user_id'] = $userId;
        $this->hub['name'] = $name;
    }

    /**
     * スレッドが作成できることをアサートする
     *
     * @return void
     */
    public function testAssertThatAThreadCanBeCreated(): void
    {
        foreach (ThreadSecondaryCategoryConst::SECONDARY_CATEGORYS as $secondaryCategoryName) {
            $threadName = fake()->name;
            ($this->method)(
                $secondaryCategoryName,
                $this->user->id,
                $threadName
            );

            $threadSecondaryCategoryId = $this->nameToId($secondaryCategoryName);
            $this->setHub($threadSecondaryCategoryId, $this->user->id, $threadName);
            $this->assertSame($this->getKeysExpected(), array_keys($this->getHub($threadSecondaryCategoryId)));
            $this->assertSame(
                $this->getValuesExpected([
                    'threadSecondaryCategoryId' => $threadSecondaryCategoryId,
                    'userId' => $this->user->id,
                    'name' => $threadName,
                ]),
                $this->getValuesActual()
            );
        }
    }

    /**
     * 存在しない詳細カテゴリ名を引数とする
     *
     * @return void
     */
    public function testArgumentIsAThreadSecondaryCategoryNameThatDoesNotExist(): void
    {
        $threadSecondaryCategoryName = Random::english();
        $threadName = fake()->name;
        $this->assertThrows(
            fn () => ($this->method)(
                $threadSecondaryCategoryName,
                $this->user->id,
                $threadName
            ),
            TypeError::class
        );

        $this->assertSame([], $this->getAllHub());
    }

    /**
     * 詳細カテゴリ名未定義
     *
     * @return void
     */
    public function testThreadSecondaryCategoryNameUndefined(): void
    {
        $threadName = fake()->name;
        $this->assertThrows(
            fn () => ($this->method)(
                userId: $this->user->id,
                threadName: $threadName
            ),
            TypeError::class
        );
        $this->assertSame([], $this->getAllHub());
    }

    /**
     * 存在しないユーザIDを引数とする
     *
     * @return void
     */
    public function testArgumentIsAUserIdThatDoesNotExist(): void
    {
        foreach (ThreadSecondaryCategoryConst::SECONDARY_CATEGORYS as $secondaryCategoryName) {
            $userId = 'not existent user id';
            $threadName = fake()->name;
            $this->assertThrows(
                fn () => ($this->method)(
                    $secondaryCategoryName,
                    $userId,
                    $threadName
                ),
                QueryException::class
            );
        }
        $this->assertSame([], $this->getAllHub());
    }

    /**
     * ユーザID未定義
     *
     * @return void
     */
    public function testUserIdUndefined(): void
    {
        foreach (ThreadSecondaryCategoryConst::SECONDARY_CATEGORYS as $secondaryCategoryName) {
            $threadName = fake()->name;

            $this->assertThrows(
                fn () => ($this->method)(
                    threadSecondaryCategoryName: $secondaryCategoryName,
                    threadName: $threadName
                ),
                TypeError::class
            );
        }
        $this->assertSame([], $this->getAllHub());
    }

    /**
     * すべて数字の文字列をスレッド名とする
     *
     * @return void
     */
    public function testAllNumericThreadNames(): void
    {
        foreach (ThreadSecondaryCategoryConst::SECONDARY_CATEGORYS as $secondaryCategoryName) {
            $threadName = Random::stringOfNumbers();
            ($this->method)(
                $secondaryCategoryName,
                $this->user->id,
                $threadName
            );

            $threadSecondaryCategoryId = $this->nameToId($secondaryCategoryName);
            $this->setHub($threadSecondaryCategoryId, $this->user->id, $threadName);
            $this->assertSame($this->getKeysExpected(), array_keys($this->getHub($threadSecondaryCategoryId)));
            $this->assertSame(
                $this->getValuesExpected([
                    'threadSecondaryCategoryId' => $threadSecondaryCategoryId,
                    'userId' => $this->user->id,
                    'name' => $threadName,
                ]),
                $this->getValuesActual()
            );
        }
    }
    /**
     * すべて記号の文字列をスレッド名とする
     *
     * @return void
     */
    public function testAllSymbolicThreadNames(): void
    {
        foreach (ThreadSecondaryCategoryConst::SECONDARY_CATEGORYS as $secondaryCategoryName) {
            $threadName = Random::symbol();
            ($this->method)(
                $secondaryCategoryName,
                $this->user->id,
                $threadName
            );

            $threadSecondaryCategoryId = $this->nameToId($secondaryCategoryName);
            $this->setHub($threadSecondaryCategoryId, $this->user->id, $threadName);
            $this->assertSame($this->getKeysExpected(), array_keys($this->getHub($threadSecondaryCategoryId)));
            $this->assertSame(
                $this->getValuesExpected([
                    'threadSecondaryCategoryId' => $threadSecondaryCategoryId,
                    'userId' => $this->user->id,
                    'name' => $threadName,
                ]),
                $this->getValuesActual()
            );
        }
    }
    /**
     * 指定できる最大文字長の文字列をスレッド名とする
     *
     * @return void
     */
    public function testMaximumCharacterLengthThatCanBeSpecifiedIsTheThreadName(): void
    {
        foreach (ThreadSecondaryCategoryConst::SECONDARY_CATEGORYS as $secondaryCategoryName) {
            $threadName = Random::string(255);
            ($this->method)(
                $secondaryCategoryName,
                $this->user->id,
                $threadName
            );

            $threadSecondaryCategoryId = $this->nameToId($secondaryCategoryName);
            $this->setHub($threadSecondaryCategoryId, $this->user->id, $threadName);
            $this->assertSame($this->getKeysExpected(), array_keys($this->getHub($threadSecondaryCategoryId)));
            $this->assertSame(
                $this->getValuesExpected([
                    'threadSecondaryCategoryId' => $threadSecondaryCategoryId,
                    'userId' => $this->user->id,
                    'name' => $threadName,
                ]),
                $this->getValuesActual()
            );
        }
    }
    /**
     * 最大文字長を超えたものをスレッド名とする
     *
     * @return void
     */
    public function testThreadNameBeyondTheMaximumCharacterLength(): void
    {
        foreach (ThreadSecondaryCategoryConst::SECONDARY_CATEGORYS as $secondaryCategoryName) {
            $threadName = Random::string(256);
            $this->assertThrows(
                fn () => ($this->method)(
                    $secondaryCategoryName,
                    $this->user->id,
                    $threadName
                ),
                QueryException::class
            );
        }
        $this->assertSame([], $this->getAllHub());
    }

    /**
     * スレッド名未定義
     *
     * @return void
     */
    public function testThreadNameUndefined(): void
    {
        foreach (ThreadSecondaryCategoryConst::SECONDARY_CATEGORYS as $secondaryCategoryName) {
            $this->assertThrows(
                fn () => ($this->method)(
                    threadSecondaryCategoryName: $secondaryCategoryName,
                    userId: $this->user->id
                ),
                TypeError::class
            );
        }
        $this->assertSame([], $this->getAllHub());
    }
}
