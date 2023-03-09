<?php

namespace Tests\Unit\app\Http\Controllers\ThreadBrowsingHistory\ThreadBrowsingHistoryController;

use App\Http\Controllers\ThreadBrowsingHistory\ThreadBrowsingHistoryController;
use App\Models\AccessLog;
use App\Models\Hub;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use ReflectionClass;
use Tests\UseFormRequestTestCase;
use TypeError;

class GetHistoryTest extends UseFormRequestTestCase
{
    use RefreshDatabase;

    /**
     * テストユーザ
     *
     * @var User
     */
    private User $user;

    /**
     * アクセスログの id
     *
     * @var integer
     */
    private int $access_log_id;

    /**
     * アクセスログ
     *
     * @var array
     */
    private array $access_logs;

    /**
     * ユーザをセットする
     *
     * @return void
     */
    protected function setAny(): void
    {
        $this->user = User::factory()->create();
        $this->access_log_id = 0;
        $this->access_logs = [];
    }

    /**
     * テスト対象のメソッドを設定
     *
     * @return void
     */
    protected function setMethod(): void
    {
        $reflection = new ReflectionClass(ThreadBrowsingHistoryController::class);
        $this->method = $reflection->getMethod('getHistory');
        $this->method->setAccessible(true);
    }

    /**
     * テスト対象のメソッドに渡す引数を設定
     *
     * @return void
     */
    protected function setArgument(): void
    {
        $this->args = new Request([
            'user_id' => $this->user->id
        ]);
    }

    /**
     * テスト対象メソッドの引数を変更する．
     *
     * @return mixed
     */
    protected function useMethod(): mixed
    {
        return $this->method->invoke(
            new ThreadBrowsingHistoryController(),
            $this->args['user_id']
        );
    }

    /**
     * 過去に閲覧したスレッド取得テストで期待される返り値（key）を返却する
     *
     * access_logs テーブル
     *
     * @return array
     */
    private function getAccessLogKeysExpected(): array
    {
        return [
            'id',
            'hub_id',
            'user_id',
            'created_at',
            'updated_at',
            'hub'
        ];
    }

    /**
     * 過去に閲覧したスレッド取得テストで期待される返り値（key）を返却する
     *
     * hub テーブル
     *
     * @return array
     */
    private function getHubKeysExpected(): array
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
     * 過去に閲覧したスレッド取得テストで期待される返り値（value）を取得する
     *
     * @param AccessLog $response
     * @return array
     */
    private function getValuesExpected(AccessLog $response): array
    {
        // 取得したアクセスログは id カラムにおいて降順でなければならない
        if ($this->access_log_id !== 0 && $this->access_log_id <= $response->id) {
            return [];
        }
        $this->access_log_id = $response->id;

        // 取得したアクセスログに同じスレッドが存在してはならない
        if (!isset($this->access_logs[$response->hub->id])) {
            $this->access_logs[$response->hub->id] = 0;
        }
        $this->access_logs[$response->hub->id]++;
        if ($this->access_logs[$response->hub->id] !== 1) {
            return [];
        }

        return [
            'id' => AccessLog::where('hub_id', '=', $response->hub->id)
                ->where('user_id', '=', $this->user->id)
                ->orderByDesc('id')
                ->first()
                ->id,
            'hub_id' => AccessLog::where('hub_id', '=', $response->hub->id)
                ->where('user_id', '=', $this->user->id)
                ->orderByDesc('id')
                ->first()
                ->hub_id . '',
            'user_id' => $this->user->id . '',
            'hub' => Hub::where('id', '=', $response->hub->id)->first()->toArray(),
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
     * テストメソッドの戻り値に，アクセスログのすべてのスレッドが存在しているかどうか確認する
     *
     * @param Collection $responses
     * @return boolean
     */
    private function checkAllThreadsAccessExist(Collection $responses): bool
    {
        $access_logs_count = AccessLog::where('user_id', '=', $this->user->id)->count();
        $threads_count = [];

        foreach ($responses as $response) {
            $threads_count[$response->hub->id] = AccessLog::where('hub_id', '=', $response->hub->id)
                ->where('user_id', '=', $this->user->id)
                ->count();
        }

        $count_sum = 0;
        foreach ($threads_count as $thread_count) {
            $count_sum += $thread_count;
        }

        if ($access_logs_count === $count_sum) {
            return true;
        }
        return false;
    }

    /**
     * アクセスログにデータがない
     *
     * @return void
     */
    public function test_no_data_in_access_log(): void
    {
        $response = $this->useFormRequest();
        $this->assertSame([], $response->toArray());
        $this->assertSame([], AccessLog::get()->toArray());
        $this->assertTrue($this->checkAllThreadsAccessExist($response));
    }

    /**
     * アクセスログに自分のデータがない
     *
     * @return void
     */
    public function test_no_data_of_my_own_in_the_access_log(): void
    {
        foreach (range(1, 5) as $num) {
            AccessLog::factory()->create();
            AccessLog::factory()->user()->create();
        }

        $response = $this->useFormRequest();

        $this->assertSame([], $response->toArray());
        if (AccessLog::where('user_id', '=', $this->user->id)->get()->toArray() === []) {
            $this->assertTrue(true);
        } else {
            $this->assertTrue(false);
        }
        $this->assertTrue($this->checkAllThreadsAccessExist($response));
    }

    /**
     * アクセスログにデータがある
     *
     * @return void
     */
    public function test_there_is_data_in_the_access_log(): void
    {
        foreach (range(1, 10) as $i) {
            AccessLog::factory()->user($this->user)->create();
        }

        $responses = $this->useFormRequest();

        foreach ($responses as $response) {
            $this->assertSame($this->getAccessLogKeysExpected(), array_keys($response->toArray()));
            $this->assertSame($this->getHubKeysExpected(), array_keys($response->hub->toArray()));
            $this->assertSame(
                $this->getValuesExpected($response),
                $this->getArrayElement($response->toArray(), [
                    'id',
                    'hub_id',
                    'user_id',
                    'hub',
                ])
            );
        }
        $this->assertTrue($this->checkAllThreadsAccessExist($responses));
    }

    /**
     * アクセスログに同じスレッドへのアクセスがある
     *
     * @return void
     */
    public function test_there_are_accesses_to_the_same_thread_in_the_access_log(): void
    {
        $threads = [];
        foreach (range(0, 2) as $i) {
            $threads[$i] = Hub::factory()->create();
        }

        foreach (range(1, 10) as $i) {
            AccessLog::factory([
                'hub_id' => $threads[random_int(0, 2)]->id
            ])
                ->user($this->user)
                ->create();
        }

        $responses = $this->useFormRequest();

        foreach ($responses as $response) {
            $this->assertSame($this->getAccessLogKeysExpected(), array_keys($response->toArray()));
            $this->assertSame($this->getHubKeysExpected(), array_keys($response->hub->toArray()));
            $this->assertSame(
                $this->getValuesExpected($response),
                $this->getArrayElement($response->toArray(), [
                    'id',
                    'hub_id',
                    'user_id',
                    'hub',
                ])
            );
        }
        $this->assertTrue($this->checkAllThreadsAccessExist($responses));
    }

    /**
     * user_id 未定義
     *
     * @return void
     */
    public function test_user_id_undefined(): void
    {
        foreach (range(1, 10) as $i) {
            AccessLog::factory()->user($this->user)->create();
        }
        $this->assertThrows(
            fn () => $this->useFormRequest(['user_id'], [null]),
            TypeError::class
        );
    }
}
