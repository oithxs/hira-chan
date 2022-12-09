<?php

namespace Tests\Unit\app\Actions\Fortify\ResetUserPassword;

use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tests\UseFormRequestTestCase;

class ResetTest extends UseFormRequestTestCase
{
    use RefreshDatabase;

    /**
     * テストユーザ
     *
     * @var \App\Models\User
     */
    private User $user;

    /**
     * 記号
     *
     * @var array
     */
    private array $symbols = [
        '!', '"', '\'', '#', '$', '%', '&', '\\', '(', ')',
        '-', '^', '@', '[', ';', ':', ']', ',', '.', '/',
        '=', '~', '|', '`', '{', '+', '*', '}', '<', '>',
        '?', '_'
    ];

    /**
     * setUpメソッドが実行されたときに最初に呼び出される
     *
     * ユーザを作成する．
     *
     * @return void
     */
    protected function setAny(): void
    {
        $this->user = User::factory()->create();
    }

    /**
     * テスト対象のメソッドを定義する．
     *
     * @see UseFormRequestTestCase::setMethod()
     * @return void
     */
    protected function setMethod(): void
    {
        $this->method = [
            new ResetUserPassword,
            'reset'
        ];
    }

    /**
     * テスト対象メソッドの引数を定義する．
     *
     * @see UseFormRequestTestCase::setArgument()
     * @return void
     */
    protected function setArgument(): void
    {
        $this->args = [
            '_token' => 'abcdefghijklmnopqrstuvwsyzABCDEFGHIJKLMN',
            'token' => 'ff9b18e477cc4786873a265cd096fc4255198296775d7793ddcf2f6d4cd262b3',
            'email' => $this->user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
    }

    /**
     * テスト対象メソッドの引数を変更することが可能．
     *
     * @return mixed
     */
    protected function useMethod(): mixed
    {
        return ($this->method)($this->user, $this->args);
    }

    /**
     * パスワードリセットテスト
     *
     * @return void
     */
    public function test_password_reset(): void
    {
        $this->assertSame(null, $this->useFormRequest(['password', 'password_confirmation'], ['password', 'password']));
    }

    /**
     * パスワード未定義
     *
     * @return void
     */
    public function test_password_undefined(): void
    {
        $this->assertSame(null, $this->useFormRequest(['password', 'password_confirmation'], ['password', 'password']));
    }

    /**
     * パスワードを定義出来ない文字数範囲
     *
     * @return void
     */
    public function test_character_range_for_which_passwords_cannot_be_defined(): void
    {
        foreach (range(1, 7) as $num) {
            $password = Str::random($num);
            $this->assertThrows(
                fn () => $this->useFormRequest(['password', 'password_confirmation'], [$password, $password]),
                ValidationException::class
            );
        }
    }

    /**
     * パスワードを定義出来る文字数範囲
     *
     * 実際には256文字以上も可能
     *
     * @return void
     */
    public function test_the_range_of_characters_for_which_a_password_can_be_defined(): void
    {
        foreach (range(8, 255) as $num) {
            $password = Str::random($num);
            $this->assertSame(null, $this->useFormRequest(['password', 'password_confirmation'], [$password, $password]));
        }
    }

    /**
     * 全て英字のパスワード
     *
     * @return void
     */
    public function test_all_alphanumeric_passwords(): void
    {
        $this->assertSame(null, $this->useFormRequest(['password', 'password_confirmation'], ['abcdefgh', 'abcdefgh']));
    }

    /**
     * 全て数字のパスワード
     *
     * @return void
     */
    public function test_all_numbers_password(): void
    {
        $this->assertSame(null, $this->useFormRequest(['password', 'password_confirmation'], ['12345678', '12345678']));
    }

    /**
     * 全て英数字以外のパスワード
     *
     * @return void
     */
    public function test_all_not_alphanumeric_passwords(): void
    {
        $password = '';
        foreach ($this->symbols as $symbol) {
            $password .= $symbol;
        }
        $this->assertSame(null, $this->useFormRequest(['password', 'password_confirmation'], [$password, $password]));
    }

    /**
     * パスワードの1度目と2度目が異なる入力
     *
     * @return void
     */
    public function test_password_entered_differently_the_first_and_second_time(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['password', 'password_confirmation'], ['12345678', '87654321']),
            ValidationException::class
        );
    }
}
