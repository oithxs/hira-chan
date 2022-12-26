<?php

namespace Tests\Unit\app\Http\Controllers\Dashboard\NotLoggedIn\ThreadsController;

use App\Http\Controllers\Dashboard\LikeController;
use App\Http\Controllers\Dashboard\NotLoggedIn\ThreadsController;
use App\Models\ClubThread;
use App\Models\CollegeYearThread;
use App\Models\DepartmentThread;
use App\Models\Hub;
use App\Models\JobHuntingThread;
use App\Models\LectureThread;
use App\Models\Like;
use App\Models\ThreadImagePath;
use App\Models\ThreadPrimaryCategory;
use App\Models\User;
use ErrorException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\UseFormRequestTestCase;

class ShowTest extends UseFormRequestTestCase
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
     * メッセージ
     *
     * @var array
     */
    private array $messages;

    /**
     * メッセージを生成する場合の最大メッセージ数
     *
     * @return void
     */
    private int $max_message_id;

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
        $this->max_message_id = 5;

        $this->threads = [
            'club_thread' => Hub::factory()->create([
                'thread_secondary_category_id' => ThreadPrimaryCategory::where('name', '=', '部活')
                    ->first()
                    ->thread_secondary_categorys()
                    ->first()
                    ->id,
            ]),
            'college_year_thread' => Hub::factory()->create([
                'thread_secondary_category_id' => ThreadPrimaryCategory::where('name', '=', '学年')
                    ->first()
                    ->thread_secondary_categorys()
                    ->first()
                    ->id
            ]),
            'department_thread' => Hub::factory()->create([
                'thread_secondary_category_id' => ThreadPrimaryCategory::where('name', '=', '学科')
                    ->first()
                    ->thread_secondary_categorys()
                    ->first()
                    ->id
            ]),
            'job_hunting_thread' => Hub::factory()->create([
                'thread_secondary_category_id' => ThreadPrimaryCategory::where('name', '=', '就職')
                    ->first()
                    ->thread_secondary_categorys()
                    ->first()
                    ->id
            ]),
            'lecture_thread' => Hub::factory()->create([
                'thread_secondary_category_id' => ThreadPrimaryCategory::where('name', '=', '授業')
                    ->first()
                    ->thread_secondary_categorys()
                    ->first()
                    ->id
            ]),
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
            new ThreadsController,
            'show'
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
            'thread_id' => $this->threads['club_thread']->id,
            'max_message_id' => 0
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
            'hub_id',
            'user_id',
            'message_id',
            'message',
            'created_at',
            'updated_at',
            'likes_count',
            'user',
            'thread_image_path',
            'likes'
        ];
    }

    /**
     * スレッド作成テストで期待される返り値（value）を取得する
     *
     * @param string $response
     * @param int $i
     * @return array
     */
    private function getThreadValuesExpected($response, int $i): array
    {
        if ($response instanceof ClubThread) {
            $thread_category = 'club_thread';
        } else if ($response instanceof CollegeYearThread) {
            $thread_category = 'college_year_thread';
        } else if ($response instanceof DepartmentThread) {
            $thread_category = 'department_thread';
        } else if ($response instanceof JobHuntingThread) {
            $thread_category = 'job_hunting_thread';
        } else if ($response instanceof LectureThread) {
            $thread_category = 'lecture_thread';
        } else {
            return [];
        }

        $club_thread_id = ClubThread::where('hub_id', '=', $this->threads[$thread_category]->id)
            ->where('message_id', '=', $i + 1)->first()->id ?? null;
        $college_year_thread_id = CollegeYearThread::where('hub_id', '=', $this->threads[$thread_category]->id)
            ->where('message_id', '=', $i + 1)->first()->id ?? null;
        $department_thread_id = DepartmentThread::where('hub_id', '=', $this->threads[$thread_category]->id)
            ->where('message_id', '=', $i + 1)->first()->id ?? null;
        $job_hunting_thread_id = JobHuntingThread::where('hub_id', '=', $this->threads[$thread_category]->id)
            ->where('message_id', '=', $i + 1)->first()->id ?? null;
        $lecture_thread_id = LectureThread::where('hub_id', '=', $this->threads[$thread_category]->id)
            ->where('message_id', '=', $i + 1)->first()->id ?? null;

        $thread_image_paths = ThreadImagePath::where('club_thread_id', '=', $club_thread_id ?? null)
            ->where('college_year_thread_id', '=', $college_year_thread_id ?? null)
            ->where('department_thread_id', '=', $department_thread_id ?? null)
            ->where('job_hunting_thread_id', '=', $job_hunting_thread_id ?? null)
            ->where('lecture_thread_id', '=', $lecture_thread_id ?? null)
            ->get()
            ->toArray();

        return [
            'id' => $this->messages[$i][$thread_category]->id,
            'hub_id' => $this->threads[$thread_category]->id . '',
            'user_id' => $this->messages[$i][$thread_category]->user_id . '',
            'message_id' => $this->messages[$i][$thread_category]->message_id,
            'message' => $this->messages[$i][$thread_category]->message,
            'likes_count' => Like::where('club_thread_id', '=', $club_thread_id ?? null)
                ->where('college_year_thread_id', '=', $college_year_thread_id ?? null)
                ->where('department_thread_id', '=', $department_thread_id ?? null)
                ->where('job_hunting_thread_id', '=', $job_hunting_thread_id ?? null)
                ->where('lecture_thread_id', '=', $lecture_thread_id ?? null)
                ->count(),
            'user' => User::where('id', '=', $this->messages[$i][$thread_category]->user_id)->first()->toArray(),
            'thread_image_path' => $thread_image_paths === [] ? null : $thread_image_paths[0],
            'likes' => Like::where('user_id', '=', Auth::check() ? $this->user->id : null)
                ->where('club_thread_id', '=', $club_thread_id ?? null)
                ->where('college_year_thread_id', '=', $college_year_thread_id ?? null)
                ->where('department_thread_id', '=', $department_thread_id ?? null)
                ->where('job_hunting_thread_id', '=', $job_hunting_thread_id ?? null)
                ->where('lecture_thread_id', '=', $lecture_thread_id ?? null)
                ->get()
                ->toArray()
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
     * ユーザのログインを行う
     *
     * @return void
     */
    public function login(): void
    {
        $this->actingAs($this->user);
    }

    /**
     * スレッドに引数の数書き込みを行う
     *
     * @param int $num
     * @return void
     */
    private function postToThread($num = 1): void
    {
        foreach (range(0, $num - 1) as $i) {
            $this->messages[$i]['club_thread'] = ClubThread::factory()->create([
                'hub_id' => $this->threads['club_thread']->id,
                'message_id' => ClubThread::where('hub_id', '=', $this->threads['club_thread']->id)
                    ->max('message_id') + 1 ?? 0,
            ]);
            $this->messages[$i]['college_year_thread'] = CollegeYearThread::factory()->create([
                'hub_id' => $this->threads['college_year_thread'],
                'message_id' => CollegeYearThread::where('hub_id', '=', $this->threads['college_year_thread']->id)
                    ->max('message_id') + 1 ?? 0,
            ]);
            $this->messages[$i]['department_thread'] = DepartmentThread::factory()->create([
                'hub_id' => $this->threads['department_thread'],
                'message_id' => DepartmentThread::where('hub_id', '=', $this->threads['department_thread']->id)
                    ->max('message_id') + 1 ?? 0,
            ]);
            $this->messages[$i]['job_hunting_thread'] = JobHuntingThread::factory()->create([
                'hub_id' => $this->threads['job_hunting_thread'],
                'message_id' => JobHuntingThread::where('hub_id', '=', $this->threads['job_hunting_thread']->id)
                    ->max('message_id') + 1 ?? 0,
            ]);
            $this->messages[$i]['lecture_thread'] = LectureThread::factory()->create([
                'hub_id' => $this->threads['lecture_thread'],
                'message_id' => LectureThread::where('hub_id', '=', $this->threads['lecture_thread']->id)
                    ->max('message_id') + 1 ?? 0,
            ]);
        }
    }

    /**
     * 書き込みにいいねをする
     *
     * @param int $max_message_id
     * @return void
     */
    private function like(int $max_message_id = 1, int $duplication = 1, User | null  $user = null): void
    {
        foreach ($this->threads as $key => $value) {
            foreach (range(1, $max_message_id) as $i) {
                foreach (range(1, $duplication) as $_) {
                    Like::factory()->post($this->messages[$i - 1][$key])->create([
                        'user_id' => $user->id ?? $this->user->id,
                    ]);
                }
            }
        }
    }

    private function image(int $max_message_id = 1): void
    {
        foreach ($this->threads as $key => $value) {
            foreach (range(1, $max_message_id) as $i) {
                ThreadImagePath::factory()->post($this->messages[$i - 1][$key])->create([
                    'user_id' => $this->messages[$i - 1][$key]->user_id
                ]);
            }
        }
    }

    /**
     * リクエストされたスレッドが存在しない
     *
     * 未ログイン
     *
     * @return void
     */
    public function test_requested_thread_does_not_exist_not_logged_in(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['thread_id'], ['test']),
            ErrorException::class
        );
    }

    /**
     * リクエストされたスレッドが存在しない
     *
     * テストユーザログイン済み
     *
     * @return void
     */
    public function test_requested_thread_does_not_exist(): void
    {
        $this->login();
        $this->assertThrows(
            fn () => $this->useFormRequest(['thread_id'], ['test']),
            ErrorException::class
        );
    }

    /**
     * すべての大枠カテゴリにおいて，書き込みがない状態でのメッセージの取得
     *
     * 未ログイン
     *
     * @return void
     */
    public function test_get_of_messages_in_all_large_frame_categories_with_no_writing_not_logged_in(): void
    {
        foreach ($this->threads as $thread) {
            $response = $this->useFormRequest(['thread_id'], [$thread->id])->toArray();
            $this->assertSame([], $response);
        }
    }

    /**
     * すべての大枠カテゴリにおいて，書き込みがない状態でのメッセージの取得
     *
     * テストユーザログイン済み
     *
     * @return void
     */
    public function test_get_of_messages_in_all_large_frame_categories_with_no_writing(): void
    {
        $this->login();
        foreach ($this->threads as $thread) {
            $response = $this->useFormRequest(['thread_id'], [$thread->id])->toArray();
            $this->assertSame([], $response);
        }
    }

    /**
     * すべての大枠カテゴリにおいて，書き込みがある状態でメッセージの取得
     *
     * 未ログイン
     *
     * @return void
     */
    public function test_get_of_messages_in_all_general_frame_categories_with_writing_not_logged_in(): void
    {
        $this->postToThread($this->max_message_id);
        foreach ($this->threads as $thread) {
            $responses = $this->useFormRequest(['thread_id'], [$thread->id]);

            for ($i = 0; $i < count($responses); $i++) {
                $this->assertSame($this->getKeysExpected(), array_keys($responses[$i]->toArray()));
                $this->assertSame(
                    $this->getThreadValuesExpected($responses[$i], $i),
                    $this->getArrayElement($responses[$i]->toArray(), [
                        'id',
                        'hub_id',
                        'user_id',
                        'message_id',
                        'message',
                        'likes_count',
                        'user',
                        'thread_image_path',
                        'likes'
                    ])
                );
            }
        }
    }

    /**
     * すべての大枠カテゴリにおいて，書き込みがある状態でメッセージの取得
     *
     * テストユーザログイン済み
     *
     * @return void
     */
    public function test_get_of_messages_in_all_general_frame_categories_with_writing(): void
    {
        $this->login();
        $this->postToThread($this->max_message_id);

        foreach ($this->threads as $thread) {
            $responses = $this->useFormRequest(['thread_id'], [$thread->id]);
            for ($i = 0; $i < count($responses); $i++) {
                $this->assertSame($this->getKeysExpected(), array_keys($responses[$i]->toArray()));
                $this->assertSame(
                    $this->getThreadValuesExpected($responses[$i], $i),
                    $this->getArrayElement($responses[$i]->toArray(), [
                        'id',
                        'hub_id',
                        'user_id',
                        'message_id',
                        'message',
                        'likes_count',
                        'user',
                        'thread_image_path',
                        'likes'
                    ])
                );
            }
        }
    }

    /**
     * すべての大枠カテゴリにおいて、書き込みに他ユーザのいいねがつけられた状態のメッセージ取得
     *
     * 未ログイン
     *
     * @return void
     */
    public function test_get_of_messages_in_which_posts_are_liked_by_other_users_in_all_broad_categories_not_logged_in(): void
    {
        $this->postToThread($this->max_message_id);
        $this->like(random_int(1, $this->max_message_id), random_int(1, $this->max_message_id));

        foreach ($this->threads as $thread) {
            $responses = $this->useFormRequest(['thread_id'], [$thread->id]);
            for ($i = 0; $i < count($responses); $i++) {
                $this->assertSame($this->getKeysExpected(), array_keys($responses[$i]->toArray()));
                $this->assertSame(
                    $this->getThreadValuesExpected($responses[$i], $i),
                    $this->getArrayElement($responses[$i]->toArray(), [
                        'id',
                        'hub_id',
                        'user_id',
                        'message_id',
                        'message',
                        'likes_count',
                        'user',
                        'thread_image_path',
                        'likes'
                    ])
                );
            }
        }
    }

    /**
     * すべての大枠カテゴリにおいて、書き込みに他ユーザのいいねがつけられた状態のメッセージ取得
     *
     * テストユーザログイン済み
     *
     * @return void
     */
    public function test_get_of_messages_in_which_posts_are_liked_by_other_users_in_all_broad_categories(): void
    {
        $this->login();
        $this->postToThread($this->max_message_id);
        $this->like(random_int(1, $this->max_message_id), random_int(1, $this->max_message_id));

        foreach ($this->threads as $thread) {
            $responses = $this->useFormRequest(['thread_id'], [$thread->id]);
            for ($i = 0; $i < count($responses); $i++) {
                $this->assertSame($this->getKeysExpected(), array_keys($responses[$i]->toArray()));
                $this->assertSame(
                    $this->getThreadValuesExpected($responses[$i], $i),
                    $this->getArrayElement($responses[$i]->toArray(), [
                        'id',
                        'hub_id',
                        'user_id',
                        'message_id',
                        'message',
                        'likes_count',
                        'user',
                        'thread_image_path',
                        'likes'
                    ])
                );
            }
        }
    }

    /**
     * すべての大枠カテゴリにおいて、書き込みに自分のいいねをつけた状態のメッセージ取得
     *
     * 未ログイン
     *
     * @return void
     */
    public function test_get_of_messages_with_your_own_likes_on_the_posts_in_all_broad_categories_not_logged_in(): void
    {
        $this->postToThread($this->max_message_id);
        $this->like(random_int(1, $this->max_message_id), random_int(1, $this->max_message_id), $this->user);

        foreach ($this->threads as $thread) {
            $responses = $this->useFormRequest(['thread_id'], [$thread->id]);
            for ($i = 0; $i < count($responses); $i++) {
                $this->assertSame($this->getKeysExpected(), array_keys($responses[$i]->toArray()));
                $this->assertSame(
                    $this->getThreadValuesExpected($responses[$i], $i),
                    $this->getArrayElement($responses[$i]->toArray(), [
                        'id',
                        'hub_id',
                        'user_id',
                        'message_id',
                        'message',
                        'likes_count',
                        'user',
                        'thread_image_path',
                        'likes'
                    ])
                );
            }
        }
    }

    /**
     * すべての大枠カテゴリにおいて、書き込みに自分のいいねをつけた状態のメッセージ取得
     *
     * テストユーザログイン済み
     *
     * @return void
     */
    public function test_get_of_messages_with_your_own_likes_on_the_posts_in_all_broad_categories(): void
    {
        $this->login();
        $this->postToThread($this->max_message_id);
        $this->like(random_int(1, $this->max_message_id), random_int(1, $this->max_message_id), $this->user);

        foreach ($this->threads as $thread) {
            $responses = $this->useFormRequest(['thread_id'], [$thread->id]);
            for ($i = 0; $i < count($responses); $i++) {
                $this->assertSame($this->getKeysExpected(), array_keys($responses[$i]->toArray()));
                $this->assertSame(
                    $this->getThreadValuesExpected($responses[$i], $i),
                    $this->getArrayElement($responses[$i]->toArray(), [
                        'id',
                        'hub_id',
                        'user_id',
                        'message_id',
                        'message',
                        'likes_count',
                        'user',
                        'thread_image_path',
                        'likes'
                    ])
                );
            }
        }
    }

    /**
     * すべての大枠カテゴリにおいて書き込みとともに画像のパスを取得
     *
     * 未ログイン
     *
     * @return void
     */
    public function test_get_the_path_of_the_image_along_with_the_post_in_all_broad_categories_not_logged_in(): void
    {
        $this->postToThread($this->max_message_id);
        $this->image(random_int(1, $this->max_message_id));

        foreach ($this->threads as $thread) {
            $responses = $this->useFormRequest(['thread_id'], [$thread->id]);
            for ($i = 0; $i < count($responses); $i++) {
                $this->assertSame($this->getKeysExpected(), array_keys($responses[$i]->toArray()));
                $this->assertSame(
                    $this->getThreadValuesExpected($responses[$i], $i),
                    $this->getArrayElement($responses[$i]->toArray(), [
                        'id',
                        'hub_id',
                        'user_id',
                        'message_id',
                        'message',
                        'likes_count',
                        'user',
                        'thread_image_path',
                        'likes'
                    ])
                );
            }
        }
    }

    /**
     * すべての大枠カテゴリにおいて書き込みとともに画像のパスを取得
     *
     * テストユーザログイン済み
     *
     * @return void
     */
    public function test_get_the_path_of_the_image_along_with_the_post_in_all_broad_categories(): void
    {
        $this->login();
        $this->postToThread($this->max_message_id);
        $this->image(random_int(1, $this->max_message_id));

        foreach ($this->threads as $thread) {
            $responses = $this->useFormRequest(['thread_id'], [$thread->id]);
            for ($i = 0; $i < count($responses); $i++) {
                $this->assertSame($this->getKeysExpected(), array_keys($responses[$i]->toArray()));
                $this->assertSame(
                    $this->getThreadValuesExpected($responses[$i], $i),
                    $this->getArrayElement($responses[$i]->toArray(), [
                        'id',
                        'hub_id',
                        'user_id',
                        'message_id',
                        'message',
                        'likes_count',
                        'user',
                        'thread_image_path',
                        'likes'
                    ])
                );
            }
        }
    }
}
