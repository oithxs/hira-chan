<?php

namespace Tests\Unit\app\Http\Controllers\Dashboard\HubController;

use App\Http\Controllers\Dashboard\HubController;
use App\Models\Hub;
use App\Models\ThreadSecondaryCategory;
use App\Models\User;
use ErrorException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use SebastianBergmann\Type\VoidType;
use Tests\UseFormRequestTestCase;

class StoreTest extends UseFormRequestTestCase
{
    use RefreshDatabase;

    /**
     * テストユーザ
     *
     * @var \App\Models\User
     */
    private User $user;

    /**
     * 詳細カテゴリ一覧
     *
     * @var mixed
     */
    private mixed $thread_secondary_categorys;

    /**
     * 詳細カテゴリ一覧をセットする
     *
     * @return void
     */
    protected function setAny(): void
    {
        $this->user = User::factory()->create();
        $this->thread_secondary_categorys = ThreadSecondaryCategory::get();
    }

    /**
     * テスト対象のメソッドを設定
     *
     * @return void
     */
    protected function setMethod(): void
    {
        $this->method = [
            new HubController,
            'store'
        ];
    }

    /**
     * テスト対象のメソッドに渡す引数を設定
     *
     * @return void
     */
    protected function setArgument(): void
    {
        $this->args = new Request([
            'thread_name' => 'thread',
            'thread_category' => $this->thread_secondary_categorys[0]->name,
        ]);
        $this->args->setUserResolver(function () {
            return $this->user;
        });
    }

    /**
     * useFormRequestメソッドが実行されたときに最初に呼び出される
     *
     * すべてのスレッドを削除する
     *
     * @return void
     */
    protected function setUpUseFormRequest(): void
    {
        DB::table('hub')->delete();
    }

    /**
     * スレッド作成テストで期待される返り値（key）を返却する
     *
     * @return array
     */
    private function getKeysExpected(): array
    {
        return [
            'id',
            'thread_secondary_category_id',
            'user_id',
            'name',
            'created_at',
            'updated_at',
            'deleted_at',
        ];
    }

    /**
     * スレッド作成テストで期待される返り値（value）を取得する
     *
     * @return array
     */
    private function getValuesExpected(): array
    {
        return [
            'thread_secondary_category_id' => ThreadSecondaryCategory::where(
                'name',
                '=',
                $this->args['thread_category']
            )->first()->id,
            'user_id' => $this->user->id . '',
            'name' => $this->args['thread_name'],
            'deleted_at' => NULL
        ];
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
        $response = [];
        foreach ($keys as $key) {
            $response[$key] = $ary[$key];
        }
        return $response;
    }

    /**
     * 複数のスレッドを作成
     *
     * @return void
     */
    public function test_create_multiple_threads(): void
    {
        foreach ($this->thread_secondary_categorys as $thread_secondary_category) {
            $keys = ['thread_category'];
            $values = [$thread_secondary_category->name];

            for ($i = 0; $i < count($keys); $i++) {
                $this->args[$keys[$i]] = $values[$i];
            }

            $this->assertTrue(!$this->useMethod());
        }
    }

    /**
     * スレッド名未定義
     *
     * 現在はバリデーションをjsで行っているためテストが通る
     *
     * @todo https://github.com/oithxs/hira-chan/issues/170
     *
     * @return void
     */
    public function test_thread_name_undefined(): void
    {
        $this->useFormRequest(['thread_name'], [Str::random(0)]);
        $this->assertSame($this->getKeysExpected(), array_keys(Hub::first()->toArray()));
        $this->assertSame(
            $this->getValuesExpected(),
            $this->getArrayElement(Hub::first()->toArray(), [
                'thread_secondary_category_id',
                'user_id',
                'name',
                'deleted_at'
            ])
        );
    }

    /**
     * スレッド名を定義できる文字数範囲
     *
     * @return void
     */
    public function test_character_range_within_which_thread_names_can_be_defined(): void
    {
        foreach (range(1, 255) as $num) {
            $this->useFormRequest(['thread_name'], [Str::random($num)]);
            $this->assertSame($this->getKeysExpected(), array_keys(Hub::first()->toArray()));
            $this->assertSame(
                $this->getValuesExpected(),
                $this->getArrayElement(Hub::first()->toArray(), [
                    'thread_secondary_category_id',
                    'user_id',
                    'name',
                    'deleted_at'
                ])
            );
        }
    }

    /**
     * スレッド名を定義できる文字数超過
     *
     * 現在はバリデーションを行っていないため投げられる例外が異なる
     *
     * @todo https://github.com/oithxs/hira-chan/issues/170
     *
     * @return void
     */
    public function test_exceeds_the_number_of_characters_allowed_to_define_a_thread_name(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['thread_name'], [Str::random(256)]),
            QueryException::class
        );
    }

    /**
     * 数字だけのスレッド名
     *
     * @return void
     */
    public function test_thread_name_with_only_numbers(): void
    {
        foreach (range(0, 9) as $num) {
            $this->useFormRequest(['thread_name'], ["$num"]);
            $this->assertSame($this->getKeysExpected(), array_keys(Hub::first()->toArray()));
            $this->assertSame(
                $this->getValuesExpected(),
                $this->getArrayElement(Hub::first()->toArray(), [
                    'thread_secondary_category_id',
                    'user_id',
                    'name',
                    'deleted_at'
                ])
            );
        }
    }

    /**
     * 記号だけのスレッド名
     *
     * @return void
     */
    public function test_thread_name_with_only_symbols(): void
    {
        $symbols = [
            '!', '"', '\'', '#', '$', '%', '&', '\\', '(', ')',
            '-', '^', '@', '[', ';', ':', ']', ',', '.', '/',
            '=', '~', '|', '`', '{', '+', '*', '}', '<', '>',
            '?', '_'
        ];

        foreach ($symbols as $symbol) {
            $this->useFormRequest(['thread_name'], [$symbol]);
            $this->assertSame($this->getKeysExpected(), array_keys(Hub::first()->toArray()));
            $this->assertSame(
                $this->getValuesExpected(),
                $this->getArrayElement(Hub::first()->toArray(), [
                    'thread_secondary_category_id',
                    'user_id',
                    'name',
                    'deleted_at'
                ])
            );
        }
    }

    /**
     * スレッドカテゴリ未選択
     *
     * 現在はバリデーションを行っていないため投げられる例外が異なる
     *
     * @todo https://github.com/oithxs/hira-chan/issues/170
     *
     * @return void
     */
    public function test_thread_category_not_selected(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['thread_category'], [Str::random(0)]),
            ErrorException::class
        );
    }

    /**
     * すべての詳細カテゴリでスレッドを作成
     *
     * @return void
     */
    public function test_threads_created_in_thread_secondary_category(): void
    {
        foreach ($this->thread_secondary_categorys as $thread_secondary_category) {
            $this->useFormRequest(['thread_category'], [$thread_secondary_category->name]);
            $this->assertSame($this->getKeysExpected(), array_keys(Hub::first()->toArray()));
            $this->assertSame(
                $this->getValuesExpected(),
                $this->getArrayElement(Hub::first()->toArray(), [
                    'thread_secondary_category_id',
                    'user_id',
                    'name',
                    'deleted_at'
                ])
            );
        }
    }

    /**
     * 存在しないスレッドカテゴリ
     *
     * 現在はバリデーションを行っていないため投げられる例外が異なる
     *
     * @todo https://github.com/oithxs/hira-chan/issues/170
     *
     * @return void
     */
    public function test_non_existent_thread_categories(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['thread_category'], [now()]),
            ErrorException::class
        );
    }
}
