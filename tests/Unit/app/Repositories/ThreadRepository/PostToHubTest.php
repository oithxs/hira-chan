<?php

namespace Tests\Unit\app\Repositories\ThreadRepository;

use App\Consts\Tables\HubConst;
use App\Models\Hub;
use App\Repositories\ThreadRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\ArrayToolsTrait;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\PostTestTrait;
use Tests\TestCase;
use TypeError;

class PostToHubTest extends TestCase implements AssertSameInterface
{
    use RefreshDatabase,
        PostTestTrait,
        ArrayToolsTrait;


    /**
     * テースト対象のメソッド
     *
     * @var array
     */
    private array $method;

    public function setUp(): void
    {
        parent::setUp();
        $this->postSetUp();

        // メンバ変数に値を代入する
        $this->method = [new ThreadRepository, 'postToHub'];
    }

    /**
     * hub テーブルのすべてのカラムを期待する値として取得する
     *
     * @return array
     */
    public function getKeysExpected(): array
    {
        return HubConst::COLUMNS;
    }

    /**
     * hub テーブルの一部のカラムのデータを期待する値として返却する
     *
     * @param array $args
     * @return array
     */
    public function getValuesExpected(array $args): array
    {
        $expected = [];
        $expected[HubConst::COLUMNS[1]] = (int) $this->getThreadSecondaryCategoryId($args['i']);
        $expected[HubConst::COLUMNS[2]] = $this->getThreadUserId($args['i']);
        $expected[HubConst::COLUMNS[3]] = $this->getThreadName($args['i']);

        return $expected;
    }

    /**
     * hub テーブルの一部のカラムのデータを実際の値として返却する
     *
     * @param array $args
     * @return array
     */
    public function getValuesActual(array $args): array
    {
        return $this->getArrayElement($args['response'], [
            HubConst::COLUMNS[1],
            HubConst::COLUMNS[2],
            HubConst::COLUMNS[3],
        ]);
    }

    /**
     * 対応する hub テーブルのデータを返却する
     *
     * @param integer $i
     * @return Hub
     */
    private function getHub(int $i): Hub
    {
        return Hub::find($this->posts[$i]->hub_id);
    }

    /**
     * 対応する hub テーブルのデータの詳細カテゴリIDを返却する
     *
     * @param integer $i
     * @return string
     */
    private function getThreadSecondaryCategoryId(int $i): string
    {
        return $this->getHub($i)->thread_secondary_category_id;
    }

    /**
     * 対応する hub テーブルのデータのユーザIDを返却する
     *
     * @param integer $i
     * @return string
     */
    private function getThreadUserId(int $i): string
    {
        return $this->getHub($i)->user_id;
    }

    /**
     * 対応する hub テーブルのデータのスレッド名を取得する
     *
     * @param integer $i
     * @return string
     */
    private function getThreadName(int $i): string
    {
        return $this->getHub($i)->name;
    }

    /**
     * 書き込みから取得した hub をアサートする
     *
     * @return void
     */
    public function testAssertsTheHubRetrievedFromThePost(): void
    {
        for ($i = 0; $i < count($this->posts); $i++) {
            $response = ($this->method)($this->posts[$i])->toArray();
            $this->assertSame(
                $this->getValuesExpected(['i' => $i]),
                $this->getValuesActual(['response' => $response])
            );
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
        $this->assertThrows(
            fn () => ($this->method)($post),
            TypeError::class
        );
    }

    /**
     * 書き込み未定義
     *
     * @return void
     */
    public function testPostUndefined(): void
    {
        $this->assertThrows(
            fn () => ($this->method)(),
            TypeError::class
        );
    }
}
