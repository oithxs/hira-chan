<?php

namespace Tests\Unit\app\Http\Controllers\Dashboard\LikeController;

use App\Http\Controllers\Dashboard\LikeController;
use App\Models\ClubThread;
use App\Models\CollegeYearThread;
use App\Models\DepartmentThread;
use App\Models\Hub;
use App\Models\JobHuntingThread;
use App\Models\LectureThread;
use App\Models\Like;
use App\Models\ThreadPrimaryCategory;
use App\Models\User;
use ErrorException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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
     * スレッド
     *
     * @var array
     */
    private array $threads;

    /**
     * ユーザをセットする
     *
     * すべての大枠カテゴリの書き込みをセットする
     *
     * @return void
     */
    protected function setAny(): void
    {
        $this->user = User::factory()->create();

        $this->threads = [
            'club_thread' => ClubThread::factory()->create(),
            'college_year_thread' => CollegeYearThread::factory()->create(),
            'department_thread' => DepartmentThread::factory()->create(),
            'job_hunting_thread' => JobHuntingThread::factory()->create(),
            'lecture_thread' => LectureThread::factory()->create(),
        ];
    }

    /**
     * テスト対象のメソッドを設定
     *
     * @return void
     */
    protected function setMethod(): void
    {
        $this->method = [
            new LikeController,
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
            'thread_id' => $this->threads['club_thread']->hub_id,
            'message_id' => '1'
        ]);

        $this->args->setUserResolver(function () {
            return $this->user;
        });
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
            'club_thread_id',
            'college_year_thread_id',
            'department_thread_id',
            'job_hunting_thread_id',
            'lecture_thread_id',
            'user_id',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * スレッド作成テストで期待される返り値（value）を取得する
     *
     * @param string
     * @return array
     */
    private function getValuesExpected(string $key): array
    {
        return [
            'club_thread_id' => $this->threads[$key] instanceof ClubThread ? $this->threads[$key]->id : NULL,
            'college_year_thread_id' => $this->threads[$key] instanceof CollegeYearThread ? $this->threads[$key]->id : NULL,
            'department_thread_id' => $this->threads[$key] instanceof DepartmentThread ? $this->threads[$key]->id : NULL,
            'job_hunting_thread_id' => $this->threads[$key] instanceof JobHuntingThread ? $this->threads[$key]->id : NULL,
            'lecture_thread_id' => $this->threads[$key] instanceof LectureThread ? $this->threads[$key]->id : NULL,
            'user_id' => $this->user->id . '',
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
     * すべての大枠カテゴリの書き込みにいいね
     *
     * @return void
     */
    public function test_good_for_all_broad_categories_of_posts(): void
    {
        foreach ($this->threads as $key => $value) {
            $response = $this->useFormRequest(['thread_id'], [$value->hub_id]);
            $like = Like::where('club_thread_id', '=', $value instanceof ClubThread ? $value->id : NULL)
                ->where('college_year_thread_id', '=', $value instanceof CollegeYearThread ? $value->id : NULL)
                ->where('department_thread_id', '=', $value instanceof DepartmentThread ? $value->id : NULL)
                ->where('job_hunting_thread_id', '=', $value instanceof JobHuntingThread ? $value->id : NULL)
                ->where('lecture_thread_id', '=', $value instanceof LectureThread ? $value->id : NULL)
                ->first()
                ->toArray();

            $this->assertSame(1, $response);
            $this->assertSame($this->getKeysExpected(), array_keys($like));
            $this->assertSame(
                $this->getValuesExpected($key),
                $this->getArrayElement($like, [
                    'club_thread_id',
                    'college_year_thread_id',
                    'department_thread_id',
                    'job_hunting_thread_id',
                    'lecture_thread_id',
                    'user_id',
                ])
            );
        }
    }

    /**
     * スレッドID未定義
     *
     * 現在はバリデーションを行っていないため投げられる例外が異なる
     *
     * @todo https://github.com/oithxs/hira-chan/issues/227
     *
     * @return void
     */
    public function test_thread_id_undefined(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['thread_id'], [Str::random(0)]),
            ErrorException::class
        );
    }

    /**
     * 存在しないスレッドID
     *
     * 現在はバリデーションを行っていないため投げられる例外が異なる
     *
     * @todo https://github.com/oithxs/hira-chan/issues/227
     *
     * @return void
     */
    public function test_non_existent_thread_id(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['thread_id'], [Str::uuid()]),
            ErrorException::class
        );
    }

    /**
     * メッセージID未定義
     *
     * 現在はバリデーションを行っていないため投げられる例外が異なる
     *
     * @todo https://github.com/oithxs/hira-chan/issues/227
     *
     * @return void
     */
    public function test_message_id_undefined(): void
    {
        foreach ($this->threads as $thread) {
            $this->assertThrows(
                fn () => $this->useFormRequest(['thread_id', 'message_id'], [$thread->hub_id, Str::random(0)]),
                ErrorException::class
            );
        }
    }

    /**
     * 英字のメッセージID
     *
     * 現在はバリデーションを行っていないため投げられる例外が異なる
     *
     * @todo https://github.com/oithxs/hira-chan/issues/227
     *
     * @return void
     */
    public function test_alphabetic_message_id(): void
    {
        foreach ($this->threads as $thread) {
            foreach (range('a', 'z') as $str) {
                $this->assertThrows(
                    fn () => $this->useFormRequest(['thread_id', 'message_id'], [$thread->hub_id, $str]),
                    ErrorException::class
                );
            }
        }
    }

    /**
     * 記号のメッセージID
     *
     * 現在はバリデーションを行っていないため投げられる例外が異なる
     *
     * @todo https://github.com/oithxs/hira-chan/issues/227
     *
     * @return void
     */
    public function test_symbol_message_id(): void
    {
        $symbols = [
            '!', '"', '\'', '#', '$', '%', '&', '\\', '(', ')',
            '-', '^', '@', '[', ';', ':', ']', ',', '.', '/',
            '=', '~', '|', '`', '{', '+', '*', '}', '<', '>',
            '?', '_'
        ];

        foreach ($this->threads as $thread) {
            foreach ($symbols as $symbol) {
                $this->assertThrows(
                    fn () => $this->useFormRequest(['thread_id', 'message_id'], [$thread->hub_id, $symbol]),
                    ErrorException::class
                );
            }
        }
    }

    /**
     * すべての大枠カテゴリで1つの書き込みに複数のいいね
     *
     * @return void
     */
    public function test_multiple_likes_for_one_post_in_all_broad_categories(): void
    {
        foreach (range(1, 10) as $num) {
            foreach ($this->threads as $key => $value) {
                $response = $this->useFormRequest(['thread_id'], [$value->hub_id]);
                $like = Like::where('club_thread_id', '=', $value instanceof ClubThread ? $value->id : NULL)
                    ->where('college_year_thread_id', '=', $value instanceof CollegeYearThread ? $value->id : NULL)
                    ->where('department_thread_id', '=', $value instanceof DepartmentThread ? $value->id : NULL)
                    ->where('job_hunting_thread_id', '=', $value instanceof JobHuntingThread ? $value->id : NULL)
                    ->where('lecture_thread_id', '=', $value instanceof LectureThread ? $value->id : NULL)
                    ->first()
                    ->toArray();

                $this->assertSame($num, $response);
                $this->assertSame($this->getKeysExpected(), array_keys($like));
                $this->assertSame(
                    $this->getValuesExpected($key),
                    $this->getArrayElement($like, [
                        'club_thread_id',
                        'college_year_thread_id',
                        'department_thread_id',
                        'job_hunting_thread_id',
                        'lecture_thread_id',
                        'user_id',
                    ])
                );
            }
        }
    }
}
