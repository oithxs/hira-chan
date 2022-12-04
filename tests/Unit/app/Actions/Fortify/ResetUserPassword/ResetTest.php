<?php

namespace Tests\Unit\app\Actions\Fortify\ResetUserPassword;

use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
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
     * @return void
     */
    protected function useMethod(): void
    {
        ($this->method)($this->user, $this->args);
    }

    /**
     * 様々なパスワードを入力してパスワードリセットが行える事を確認する．
     *
     * @return void
     */
    public function test_reset_user_password(): void
    {
        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['password', 'password'])); // ユーザ作成
        $this->assertFalse($this->useFormRequest(['password', 'password_confirmation'], [Str::random(0), Str::random(0)])); // パスワード未定義

        // パスワードを定義出来ない文字数
        foreach (range(1, 7) as $num) {
            $password = Str::random($num);
            $this->assertFalse($this->useFormRequest(['password', 'password_confirmation'], [$password, $password]));
        }

        // パスワードを定義出来る文字数（実際には256文字以降も可）
        foreach (range(8, 255) as $num) {
            $password = Str::random($num);
            $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], [$password, $password]));
        }

        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['abcdefgh', 'abcdefgh'])); // 全て英字
        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['12345678', '12345678'])); // 全て数字
        $this->assertFalse($this->useFormRequest(['password', 'password_confirmation'], ['12345678', '87654321'])); // 1度目と2度目を異なる入力
        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['!"#$%&\'()-^\\@[;:],./\\=~|`{+*}<>?_', '!"#$%&\'()-^\\@[;:],./\\=~|`{+*}<>?_'])); // 英数字以外
    }
}
