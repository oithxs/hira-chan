<?php

namespace Tests\Unit\app\Http\Controllers\Report\FormContactAdministratorController;

use App\Consts\Tables\ContactTypeConst;
use App\Http\Controllers\Report\FormContactAdministratorController;
use App\Http\Requests\Report\FormContactAdministratorRequest;
use App\Models\User;
use Closure;
use ErrorException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\AssertSame\Tables\ContactAdministratorTrait;
use Tests\Support\MakeType;
use Tests\Support\Random;
use Tests\Support\Request;
use Tests\TestCase;
use Tests\Unit\app\Repositories\ContactAdministratorRepository\StoreTest as RepositoryTest;
use TypeError;

class StoreTest extends TestCase
{
    use RefreshDatabase,
        ContactAdministratorTrait;

    private User $user;

    private FormContactAdministratorController $controller;

    private RepositoryTest $repositoryTest;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->user = User::factory()->create();
        $this->controller = new FormContactAdministratorController();
        $this->repositoryTest = new RepositoryTest('');
    }

    /**
     * テスト対象のメソッドを実行する
     *
     * @param array $query $request->で取得可能にする要素
     * @param User|null $user $request->user()で取得可能にするユーザ
     * @return void
     */
    public function execute(array $query, User | null $user): void
    {
        $this->controller->store((new Request)->make(
            $query,
            $user,
            FormContactAdministratorRequest::class
        ));
    }

    /**
     * リクエストに渡すデータを取得する
     *
     * @param mixed $contactType お問い合わせの種類
     * @param mixed $message お問い合わせの詳細メッセージ
     * @return array リクエストに渡すデータ
     */
    public function getQuery(mixed $contactType = null, mixed $message = null): array
    {
        $query = [];
        is_null($contactType) ?: $query['radio_1'] = $contactType;
        is_null($message) ?: $query['report_form_textarea'] = $message;
        return $query;
    }

    /**
     * 引数によりユーザを取得する
     *
     * @param boolean $user ユーザを取得するかを指定
     * @return User|null メンバ変数のユーザ/null
     */
    public function getUser(bool $user): User | null
    {
        return $user ? $this->user : null;
    }

    /**
     * 正常に動作することを期待
     *
     * @param mixed $contactType $request->radio_1で取得にする値
     * @param mixed $message $request->report_form_textareaで取得する値
     * @param boolean $user $request->user()でユーザを取得できるか否かを指定する
     * @return void
     */
    public function successes(mixed $contactType = null, mixed $message = null, bool $user): void
    {
        $this->setUp();

        $this->execute(
            $this->getQuery($contactType, $message),
            $this->getUser($user)
        );

        $this->contactAdministrator = $this->repositoryTest->getContactAdministratorByMessage($message);
        $this->assertSame(
            $this->repositoryTest->getValuesExpected([
                'contactTypeId' => $this->repositoryTest->getContactTypeIdByName($contactType),
                'userId' => $this->user->id,
                'message' => $message
            ]),
            $this->getValuesActual()
        );
    }

    /**
     * 例外が発生することを期待
     *
     * @param mixed $contactType $request->radio_1で取得にする値
     * @param mixed $message $request->report_form_textareaで取得する値
     * @param boolean $user $request->user()でユーザを取得できるか否かを指定する
     * @param string $exception テスト対象のメソッド実行時に期待する例外
     * @return void
     */
    public function exception(mixed $contactType = null, mixed $message = null, bool $user, string $exception): void
    {
        $this->setUp();

        $this->assertThrows(
            fn () => $this->execute(
                $this->getQuery($contactType, $message),
                $this->getUser($user)
            ),
            $exception
        );

        $this->assertSame([], $this->repositoryTest->getAllContactAdministrator());
    }

    /**
     * @dataProvider dataProvider
     * @param mixed $contactType $request->radio_1で取得にする値
     * @param mixed $message $request->report_form_textareaで取得する値
     * @param boolean $user $request->user()でユーザを取得できるか否かを指定する
     * @param string|null $exception テスト対象のメソッド実行時に期待する例外
     * @return void
     */
    public function test(mixed $contactType = null, mixed $message = null, bool $user, string $exception = null): void
    {
        is_null($exception)
            ? $this->successes($contactType, $message, $user)
            : $this->exception($contactType, $message, $user, $exception);
    }

    /**
     * データプロバイダ
     *
     * @return array
     */
    public function dataProvider(): array
    {
        $this->createApplication();

        return [
            ...$this->existsRadio1(),
            ...$this->notExistsRadio1(),
            ...$this->variousTypeOfRadio1(),
            ...$this->userUndefined(),
            ...$this->variousTypeOfReportFormTextarea(),
            ...$this->numericReportFormTextarea(),
            ...$this->lowercaseReportFormTextarea(),
            ...$this->uppercaseReportFormTextarea(),
            ...$this->symbolReportFormTextarea(),
            ...$this->noData(),
        ];
    }

    /**
     * すべてのお問い合わせの種類で繰り返し処理行う
     *
     * @param Closure $func 繰り返しで行う処理
     * @return array
     */
    public function loopContactType(Closure $func): array
    {
        return $this->loop(ContactTypeConst::CONTACT_TYPES, $func);
    }

    /**
     * string で指定された引数に渡すとエラーが出る型を
     * 要素とした配列で繰り返し処理を行う
     *
     * @param Closure $func 繰り返しで行う処理
     * @return array
     */
    public function loopVariousType(Closure $func): array
    {
        return $this->loop(MakeType::ignoreString(), $func);
    }

    /**
     * 指定された配列で繰り返し処理を行う
     *
     * @param mixed $loop 繰り返しを行う配列
     * @param Closure $func 繰り返し内で行う処理
     * @return array
     */
    public function loop(mixed $loop, Closure $func): array
    {
        $response = [];
        foreach ($loop as $key => $value) {
            $response = $func($response, $value, $key);
        }
        return $response;
    }

    /**
     * 引数の文字列を report_form_textarea とする
     *
     * @param string $message report_form_textareaとする文字列
     * @param string $type 連想配列のキー（一部分）
     * @return array
     */
    public function variousStringReportFormTextarea(string $message, string $type): array
    {
        return $this->loopContactType(function ($response, $contactType) use ($message, $type) {
            $response["$contactType を radio_1 とし，すべて $type の文字列を report_form_textarea とする"] = [
                $contactType, $message, true
            ];
            return $response;
        });
    }

    /**
     * 期待する radio_1 の値
     *
     * @return array
     */
    public function existsRadio1(): array
    {
        return $this->loopContactType(function ($response, $contactType) {
            $response["$contactType を radio_1 の値とする"] = [
                $contactType, Random::string(), true
            ];
            return $response;
        });
    }

    /**
     * 存在しないお問い合わせの種類を radio_1 とする
     *
     * @return array
     */
    public function notExistsRadio1(): array
    {
        $radio_1 = 'not exists contact type name';
        return ['存在しないお問い合わせの種類を radio_1とする' => [
            $radio_1, Random::string(), true, ErrorException::class
        ]];
    }

    /**
     * 様々な型の変数を radio_1 とする
     *
     * @return array
     */
    public function variousTypeOfRadio1(): array
    {
        return $this->loopVariousType(function ($response, $value, $key) {
            $response["$key 型の変数を radio_1 とする"] = [
                $value, Random::string(), true, TypeError::class
            ];
            return $response;
        });
    }

    /**
     * リクエストのユーザ未定義
     *
     * @return array
     */
    public function userUndefined(): array
    {
        return $this->loopContactType(function ($response, $contactType) {
            $response["$contactType を radio_1 とするが，ユーザが未定義"] = [
                $contactType, Random::string(), false, ErrorException::class
            ];
            return $response;
        });
    }

    /**
     * 様々な型の変数を report_form_textarea とする
     *
     * @return array
     */
    public function variousTypeOfReportFormTextarea(): array
    {
        return $this->loopContactType(function ($_, $contactType) {
            return $this->loopVariousType(function ($response, $value, $key) use ($contactType) {
                $response["$key 型の変数を report_form_textarea とする"] = [
                    $contactType, $value, true, TypeError::class
                ];
                return $response;
            });
        });
    }

    /**
     * すべて数字のメッセージを report_form_textarea とする
     *
     * @return array
     */
    public function numericReportFormTextarea(): array
    {
        return $this->variousStringReportFormTextarea(Random::stringOfNumbers(), '数字');
    }

    /**
     * すべて英小文字のメッセージを report_form_textarea とする
     *
     * @return array
     */
    public function lowercaseReportFormTextarea(): array
    {
        return $this->variousStringReportFormTextarea(Random::lowercase(), '英小文字');
    }

    /**
     * すべて英大文字のメッセージを report_form_textarea とする
     *
     * @return array
     */
    public function uppercaseReportFormTextarea(): array
    {
        return $this->variousStringReportFormTextarea(Random::uppercase(), '英大文字');
    }

    /**
     * すべて記号のメッセージを report_form_textarea とする
     *
     * @return array
     */
    public function symbolReportFormTextarea(): array
    {
        return $this->variousStringReportFormTextarea(Random::symbol(), '記号');
    }


    /**
     * データなしのリクエスト
     *
     * @return array
     */
    public function noData(): array
    {
        return ['データなしのリクエスト' => [null, null, true, TypeError::class]];
    }
}
