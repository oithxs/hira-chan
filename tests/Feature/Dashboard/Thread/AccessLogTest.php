<?php

namespace Tests\Feature\Dashboard\Thread;

use App\Models\AccessLog;
use App\Models\Hub;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccessLogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * テスト用ユーザ
     *
     * @var User
     */
    private User $user;

    /**
     * テスト用スレッド
     *
     * @var Hub
     */
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
     * ログインしていない状態でスレッドにアクセスする
     *
     * @return void
     */
    public function test_accessing_threads_without_being_logged_in(): void
    {
        $this->assertSame(session()->get('thread_id'), null);
        $response = $this->get('/dashboard/thread/name=' . $this->thread->name . '&id=' . $this->thread->id);
        $response->assertOk();
        $this->assertSame(session()->get('thread_id'), $this->thread->id . '');

        $access_log = AccessLog::where('hub_id', '=', $this->thread->id)->first()->toArray();
        $access_logs_count = AccessLog::where('hub_id', '=', $this->thread->id)->count();

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

    /**
     * ログインしている状態でスレッドにアクセスする
     *
     * @return void
     */
    public function test_accessing_threads_while_logged_in(): void
    {
        $this->assertSame(session()->get('thread_id'), null);
        $response = $this->actingAs($this->user)
            ->get('/dashboard/thread/name=' . $this->thread->name . '&id=' . $this->thread->id);
        $response->assertOk();
        $this->assertSame(session()->get('thread_id'), $this->thread->id . '');

        $access_log = AccessLog::where('hub_id', '=', $this->thread->id)
            ->where('user_id', '=', $this->user->id)
            ->first()
            ->toArray();
        $access_logs_count = AccessLog::where('hub_id', '=', $this->thread->id)
            ->where('user_id', '=', $this->user->id)
            ->count();

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
                $this->assertSame(session()->get('thread_id'), $this->thread->id . '');
            }
            $response = $this->get('/dashboard/thread/name=' . $this->thread->name . '&id=' . $this->thread->id);
            $response->assertOk();
            $this->assertSame(session()->get('thread_id'), $this->thread->id . '');

            $access_log = AccessLog::where('hub_id', '=', $this->thread->id)->first()->toArray();
            $access_logs_count = AccessLog::where('hub_id', '=', $this->thread->id)->count();

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
                $this->assertSame(session()->get('thread_id'), $this->thread->id . '');
            }
            $response = $this->actingAs($this->user)
                ->get('/dashboard/thread/name=' . $this->thread->name . '&id=' . $this->thread->id);
            $response->assertOk();
            $this->assertSame(session()->get('thread_id'), $this->thread->id . '');

            $access_log = AccessLog::where('hub_id', '=', $this->thread->id)
                ->where('user_id', '=', $this->user->id)
                ->first()
                ->toArray();
            $access_logs_count = AccessLog::where('hub_id', '=', $this->thread->id)
                ->where('user_id', '=', $this->user->id)
                ->count();

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
        $thread_name = 'non existent thread id';
        $thread_id = 'non existent thread id';

        $this->assertSame(session()->get('thread_id'), null);
        $response = $this->get('/dashboard/thread/name=' . $thread_name . '&id=' . $thread_id);
        $response->assertNotFound();
        $this->assertSame(session()->get('thread_id'), null);

        $access_log = AccessLog::where('hub_id', '=', $this->thread->id)->get()->toArray();
        $access_logs_count = AccessLog::where('hub_id', '=', $this->thread->id)->count();

        $this->assertSame([], $access_log);
        $this->assertSame(0, $access_logs_count);
    }

    /**
     * ログインしている状態で存在しないスレッドにアクセスする
     *
     * @return void
     */
    public function /*test*/ _accessing_a_thread_that_does_not_exist_while_logged_in(): void
    {
        $thread_name = 'non existent thread id';
        $thread_id = 'non existent thread id';

        $this->assertSame(session()->get('thread_id'), null);
        $response = $this
            ->actingAs($this->user)
            ->get('/dashboard/thread/name=' . $thread_name . '&id=' . $thread_id);
        $response->assertNotFound();
        $this->assertSame(session()->get('thread_id'), null);

        $access_log = AccessLog::where('hub_id', '=', $this->thread->id)
            ->where('user_id', '=', $this->user->id)
            ->get()
            ->toArray();
        $access_logs_count = AccessLog::where('hub_id', '=', $this->thread->id)
            ->where('user_id', '=', $this->user->id)
            ->count();

        $this->assertSame([], $access_log);
        $this->assertSame(0, $access_logs_count);
    }

    /**
     * ログインしていない状態で複数のスレッドにアクセスする
     *
     * @return void
     */
    public function test_accessing_multiple_threads_without_being_logged_in(): void
    {
        foreach (range(1, random_int(2, 10)) as $num) {
            $pre_thread = $thread ?? null;
            $thread = Hub::factory()->create();
            if ($num === 1) {
                $this->assertSame(session()->get('thread_id'), null);
            } else {
                $this->assertSame(session()->get('thread_id'), $pre_thread->id . '');
            }
            $response = $this->get('/dashboard/thread/name=' . $thread->name . '&id=' . $thread->id);
            $response->assertOk();
            $this->assertSame(session()->get('thread_id'), $thread->id . '');

            $access_log = AccessLog::where('hub_id', '=', $thread->id)->first()->toArray();
            $access_logs_count = AccessLog::where('hub_id', '=', $thread->id)->count();

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
            $pre_thread = $thread ?? null;
            $thread = Hub::factory()->create();
            if ($num === 1) {
                $this->assertSame(session()->get('thread_id'), null);
            } else {
                $this->assertSame(session()->get('thread_id'), $pre_thread->id . '');
            }
            $response = $this->actingAs($this->user)
                ->get('/dashboard/thread/name=' . $thread->name . '&id=' . $thread->id);
            $response->assertOk();
            $this->assertSame(session()->get('thread_id'), $thread->id . '');

            $access_log = AccessLog::where('hub_id', '=', $thread->id)
                ->where('user_id', '=', $this->user->id)->first()->toArray();
            $access_logs_count = AccessLog::where('hub_id', '=', $thread->id)
                ->where('user_id', '=', $this->user->id)->count();

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

    /**
     * スレッド以外へアクセスした際にアクセスログが保存されないことを確認
     *
     * すべてのルートを網羅している訳ではありません
     *
     * @todo すべてのルートを網羅する
     *
     * @return void
     */
    public function test_confirmation_that_access_logs_are_not_saved_when_accessing_non_threads(): void
    {
        $pre_access_logs_count = AccessLog::count();
        $this->get('/');
        $this->get(route('dashboard'));
        $this->get(route('Q_and_A'));
        $this->get(route('mypage'));
        $this->get(route('profile.show'));
        $this->get(route('report.create'));
        $this->get(route('login'));
        $this->get(route('register'));
        $access_logs_count = AccessLog::count();
        $this->assertSame($pre_access_logs_count, $access_logs_count);
    }
}
