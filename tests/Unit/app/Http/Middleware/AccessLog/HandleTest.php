<?php

namespace Tests\Unit\app\Http\Middleware\AccessLog;

use App\Http\Middleware\AccessLog;
use App\Models\AccessLog as AccessLogs;
use App\Models\Hub;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tests\TestCase;

class HandleTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Hub $thread_id;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->thread = Hub::factory()->create();
    }

    /**
     * アクセスログ保存後に，access_logs テーブルに保存されているデータ（key）の期待値を返却する
     *
     * @return array
     */
    private function getKeysExpected(): array
    {
        return [
            'id',
            'hub_id',
            'user_id',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * アクセスログ保存後に，access_logs テーブルに保存されているデータ（value）の期待値を返却する
     *
     * @param string|null $thread_idn
     * @param User|null $user
     * @return array
     */
    private function getValuesExpected(string $thread_id = null, User $user = null): array
    {
        $user_id = null;
        if ($user !== null) {
            $user_id = $user->id . '';
        }

        return [
            'hub_id' => $thread_id ?? $this->thread->id . '',
            'user_id' => $user_id,
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
     * リクエストインスタンスを取得する
     *
     * @param string|null $thread_idn
     * @param User|null $user
     * @return Request
     */
    private function getRequest(string $thread_id = null, User $user = null): Request
    {
        $request = new Request([
            'thread_id' => $thread_id ?? $this->thread->id,
        ]);
        if ($user !== null) {
            $request->setUserResolver(function () use ($user) {
                return $user;
            });
        }

        return $request;
    }

    /**
     * ログインしていない状態でアクセスログを保存する
     *
     * @return void
     */
    public function test_store_access_logs_without_logging_in(): void
    {
        $this->assertSame(session()->get('thread_id'), null);

        $response = (new AccessLog())->handle($this->getRequest(), function () {
            //
        });
        $access_log = AccessLogs::where('hub_id', '=', $this->thread->id)
            ->orderByDesc('id')
            ->first()
            ->toArray();

        $this->assertSame(session()->get('thread_id'), $this->thread->id);
        $this->assertSame($this->getKeysExpected(), array_keys($access_log));
        $this->assertSame(
            $this->getValuesExpected(),
            $this->getArrayElement($access_log, [
                'hub_id',
                'user_id',
            ])
        );
    }

    /**
     * ログインしている状態でアクセスログを保存する
     *
     * @return void
     */
    public function test_store_access_logs_while_logged_in(): void
    {
        $this->assertSame(session()->get('thread_id'), null);

        $response = (new AccessLog())->handle($this->getRequest(user: $this->user), function () {
            //
        });
        $access_log = AccessLogs::where('hub_id', '=', $this->thread->id)
            ->where('user_id', '=', $this->user->id)
            ->orderByDesc('id')
            ->first()
            ->toArray();

        $this->assertSame(session()->get('thread_id'), $this->thread->id);
        $this->assertSame($this->getKeysExpected(), array_keys($access_log));
        $this->assertSame(
            $this->getValuesExpected(user: $this->user),
            $this->getArrayElement($access_log, [
                'hub_id',
                'user_id',
            ])
        );
    }

    /**
     * ログインしていない状態で同じスレッドに複数回アクセスする
     *
     * @return void
     */
    public function test_accessing_the_same_thread_multiple_times_without_being_logged_in(): void
    {
        foreach (range(1, random_int(2, 10)) as $num) {
            if ($num === 1) {
                $this->assertSame(session()->get('thread_id'), null);
            } else {
                $this->assertSame(session()->get('thread_id'), $this->thread->id);
            }

            $response = (new AccessLog())->handle($this->getRequest(), function () {
                //
            });
            $access_log = AccessLogs::where('hub_id', '=', $this->thread->id)
                ->orderByDesc('id')
                ->first()
                ->toArray();
            $access_logs_count = AccessLogs::where('hub_id', '=', $this->thread->id)
                ->count();

            $this->assertSame(session()->get('thread_id'), $this->thread->id);
            $this->assertSame($this->getKeysExpected(), array_keys($access_log));
            $this->assertSame(
                $this->getValuesExpected(),
                $this->getArrayElement($access_log, [
                    'hub_id',
                    'user_id',
                ])
            );
            $this->assertSame(1, $access_logs_count);
        }
    }

    /**
     * ログインしている状態で同じスレッドに複数回アクセスする
     *
     * @return void
     */
    public function test_accessing_the_same_thread_multiple_times_while_logged_in(): void
    {
        foreach (range(1, random_int(2, 10)) as $num) {
            if ($num === 1) {
                $this->assertSame(session()->get('thread_id'), null);
            } else {
                $this->assertSame(session()->get('thread_id'), $this->thread->id);
            }

            $response = (new AccessLog())->handle($this->getRequest(user: $this->user), function () {
                //
            });
            $access_log = AccessLogs::where('hub_id', '=', $this->thread->id)
                ->where('user_id', '=', $this->user->id)
                ->orderByDesc('id')
                ->first()
                ->toArray();
            $access_logs_count = AccessLogs::where('hub_id', '=', $this->thread->id)
                ->where('user_id', '=', $this->user->id)
                ->count();

            $this->assertSame(session()->get('thread_id'), $this->thread->id);
            $this->assertSame($this->getKeysExpected(), array_keys($access_log));
            $this->assertSame(
                $this->getValuesExpected(user: $this->user),
                $this->getArrayElement($access_log, [
                    'hub_id',
                    'user_id',
                ])
            );
            $this->assertSame(1, $access_logs_count);
        }
    }

    /**
     * ログインしていない状態で存在しないスレッドにアクセスする
     *
     * @return void
     */
    public function /*test_*/ accessing_non_existent_threads_without_being_logged_in(): void
    {
        $thread_id = 'non existent thread id';
        $this->assertSame(session()->get('thread_id'), null);

        $this->assertThrows(
            fn () => (new AccessLog())->handle($this->getRequest(thread_id: $thread_id), function () {
                //
            }),
            NotFoundHttpException::class
        );

        $access_log = AccessLogs::where('hub_id', '=', $thread_id)
            ->get()
            ->toArray() ?? null;
        $this->assertSame(session()->get('thread_id'), null);
        $this->assertSame([], $access_log);
    }

    /**
     * ログインしている状態で存在しないスレッドにアクセスする
     *
     * @return void
     */
    public function /*test_*/ accessing_a_thread_that_does_not_exist_while_logged_in(): void
    {
        $thread_id = 'non existent thread id';
        $this->assertSame(session()->get('thread_id'), null);

        $this->assertThrows(
            fn () => (new AccessLog())->handle($this->getRequest(thread_id: $thread_id, user: $this->user), function () {
                //
            }),
            NotFoundHttpException::class
        );

        $access_log = AccessLogs::where('hub_id', '=', $thread_id)
            ->get()
            ->toArray() ?? null;
        $this->assertSame(session()->get('thread_id'), null);
        $this->assertSame([], $access_log);
    }

    /**
     * ログインしていない状態で複数のスレッドにアクセスする
     *
     * @return void
     */
    public function test_accessing_multiple_threads_without_being_logged_in(): void
    {
        foreach (range(1, random_int(2, 10)) as $num) {
            if ($num === 1) {
                $this->assertSame(session()->get('thread_id'), null);
            } else {
                $this->assertSame(session()->get('thread_id'), $thread->id . '');
            }

            $thread = Hub::factory()->create();
            $response = (new AccessLog())->handle($this->getRequest(thread_id: $thread->id), function () {
                //
            });
            $access_log = AccessLogs::where('hub_id', '=', $thread->id)
                ->orderByDesc('id')
                ->first()
                ->toArray();
            $access_logs_count = AccessLogs::where('hub_id', '=', $thread->id)
                ->count();

            $this->assertSame(session()->get('thread_id'), $thread->id . '');
            $this->assertSame($this->getKeysExpected(), array_keys($access_log));
            $this->assertSame(
                $this->getValuesExpected(thread_id: $thread->id),
                $this->getArrayElement($access_log, [
                    'hub_id',
                    'user_id',
                ])
            );
            $this->assertSame(1, $access_logs_count);
        }
    }

    /**
     * ログインしている状態で複数のスレッドにアクセスする
     *
     * @return void
     */
    public function test_access_multiple_threads_while_logged_in(): void
    {
        foreach (range(1, random_int(2, 10)) as $num) {
            if ($num === 1) {
                $this->assertSame(session()->get('thread_id'), null);
            } else {
                $this->assertSame(session()->get('thread_id'), $thread->id . '');
            }

            $thread = Hub::factory()->create();
            $response = (new AccessLog())->handle($this->getRequest(thread_id: $thread->id, user: $this->user), function () {
                //
            });
            $access_log = AccessLogs::where('hub_id', '=', $thread->id)
                ->orderByDesc('id')
                ->first()
                ->toArray();
            $access_logs_count = AccessLogs::where('hub_id', '=', $thread->id)
                ->count();

            $this->assertSame(session()->get('thread_id'), $thread->id . '');
            $this->assertSame($this->getKeysExpected(), array_keys($access_log));
            $this->assertSame(
                $this->getValuesExpected(thread_id: $thread->id, user: $this->user),
                $this->getArrayElement($access_log, [
                    'hub_id',
                    'user_id',
                ])
            );
            $this->assertSame(1, $access_logs_count);
        }
    }
}
