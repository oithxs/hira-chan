<?php

namespace Tests\Unit\app\Actions\Fortify\CreateNewUser;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\UseFormRequestTestCase;

class CreateTest extends UseFormRequestTestCase
{
    use RefreshDatabase;

    /**
     * 学生番号（数字5桁）
     *
     * @var integer
     */
    private int $number = 10000;

    /**
     * ユーザー復元テストに使用する．
     * userSoftDelete メソッドを実行するかどうかを決定する．
     *
     * @var boolean
     */
    private bool $restore_flag = false;

    /**
     * 論理削除されるEmail（学生番号）
     *
     * @var string
     */
    private string $deleted_email = 'e1z12345';

    /**
     * 各テストメソッドの前に実行される．（はず）
     *
     * @link https://readouble.com/laravel/9.x/ja/testing.html
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->restore_flag = false;
    }

    /**
     * テスト対象のメソッドを定義する．
     *
     * @see \Tests\UseFormRequestTestCase::setMethod() [Overirde]
     * @return void
     */
    protected function setMethod(): void
    {
        $this->method = [
            new CreateNewUser,
            'create'
        ];
    }

    /**
     * テスト対象のメソッドに渡す引数を定義する．
     *
     * @see \Tests\UseFormRequestTestCase::setArgument() [Override]
     * @return void
     */
    protected function setArgument(): void
    {
        $this->args = [
            '_token' => 'abcdefghijklmnopqrstuvwsyzABCDEFGHIJKLMN',
            'name' => 'laravel',
            'email' => $this->getDummyEmail(),
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
    }

    /**
     * useFormRequestメソッドの始めに実行される．
     *
     * @see \Tests\UseFormRequestTestCase::setUpUseFormRequest() [Overirde]
     * @return void
     */
    protected function setUpUseFormRequest(): void
    {
        if ($this->restore_flag) {
            $this->userSoftDelete();
        } else {
            $this->args['email'] = $this->getDummyEmail();
        }
    }

    /**
     * 学生番号を返却し，インクリメントを行う．
     *
     * Emailが重複するとユーザ作成が出来ないため．
     *
     * @return string
     */
    private function getDummyEmail(): string
    {
        return 'e1z' . $this->number++;
    }

    /**
     * ユーザ復元テスト中に実行される．
     *
     * - 全く同じユーザを作成するために引数を調整する．
     * - 全てのユーザを削除し，同じユーザを作成する．
     * - 作成したユーザの論理削除を行う．
     *
     * @return void
     */
    private function userSoftDelete(): void
    {
        $this->setArgument();
        $this->args['email'] = $this->deleted_email;

        try {
            User::withTrashed()->forceDelete();
            (new CreateNewUser())->create($this->args);
        } catch (Exception $e) {
            //
        } finally {
            User::where('email', '=', $this->deleted_email . '@st.oit.ac.jp')->delete();
        }
    }

    /**
     * ユーザ復元テストを実行可能にする．
     *
     * このメソッドを呼び出すテストメソッド内で，「email」が「$this->deleted_email」であるユーザに対して
     * SoftDeletes を指定して useFormRequest メソッドを呼び出すことが可能．また，「$this->args」にある
     * 「email」の初期値は「$this->deleted_email」に設定される．
     *
     * 下2つのuseFormRequest呼び出しは論理削除のテストが可能かを確認している．
     *
     * @return void
     */
    private function restoreTest(): void
    {
        $this->restore_flag = true;
        $this->assertTrue($this->useFormRequest(['email'], [$this->deleted_email]));
        $this->assertTrue($this->useFormRequest(['email'], [$this->deleted_email]));
    }

    /**
     * 様々な名前を引数としてユーザーが作成されることを確認する．
     *
     * @return void
     */
    public function test_user_creation_on_name(): void
    {
        $this->assertTrue($this->useFormRequest(['name'], ['laravel'])); // ユーザ作成
        $this->assertTrue($this->useFormRequest(['name'], ['laravel'])); // ユーザ名の重複
        $this->assertFalse($this->useFormRequest(['name'], [Str::random(0)])); // ユーザ名未定義

        // ユーザー名を定義できる文字数範囲
        foreach (range(1, 255) as $num) {
            $this->assertTrue($this->useFormRequest(['name'], [Str::random($num)]));
        }

        $this->assertFalse($this->useFormRequest(['name'], [Str::random(256)])); // ユーザ名の最大文字数超過
        $this->assertTrue($this->useFormRequest(['name'], ['123456789'])); // 数字のみのユーザ名
        $this->assertTrue($this->useFormRequest(['name'], ['!"#$%&\'()-^\\@[;:],./\\=~|`{+*}<>?_'])); // 英数字を使用しないユーザ名
    }

    /**
     * 様々なEmailを引数としてユーザが作成されることを確認する．
     *
     * @return void
     */
    public function test_user_creation_on_email(): void
    {
        // 1文字目を英字にした際のテスト
        foreach (range('a', 'z') as $str) {
            if (strcmp($str, 'e') === 0) {
                $this->assertTrue($this->useFormRequest(['email'], [$str . str_replace("e", "", $this->getDummyEmail())]));
            } else {
                $this->assertFalse($this->useFormRequest(['email'], [$str . str_replace("e", "", $this->getDummyEmail())]));
            }
        }

        // 1文字目を数字にした際のテスト
        foreach (range(0, 9) as $num) {
            $this->assertFalse($this->useFormRequest(['email'], [$num . str_replace("e", "", $this->getDummyEmail())]));
        }

        // 2文字目を英字にした際のテスト
        foreach (range('a', 'z') as $str) {
            $this->assertFalse($this->useFormRequest(['email'], ['e' . $str . str_replace("e1", "", $this->getDummyEmail())]));
        }

        // 2文字目のを数字にした際のテスト
        foreach (range(0, 9) as $num) {
            if ($num === 1) {
                $this->assertTrue($this->useFormRequest(['email'], ['e' . $num . str_replace("e1", "", $this->getDummyEmail())]));
            } else {
                $this->assertFalse($this->useFormRequest(['email'], ['e' . $num . str_replace("e1", "", $this->getDummyEmail())]));
            }
        }

        // 3文字目を英字にした際のテスト
        foreach (range('a', 'z') as $str) {
            $this->assertTrue($this->useFormRequest(['email'], ['e1' . $str . str_replace("e1z", "", $this->getDummyEmail())]));
        }

        // 3文字目を数字にした際のテスト
        foreach (range(0, 9) as $num) {
            $this->assertFalse($this->useFormRequest(['email'], ['e1' . $num . str_replace("e1z", "", $this->getDummyEmail())]));
        }

        // 下5桁を英字にした際のテスト（桁数も変更）
        foreach (range('a', 'z') as $str) {
            $strs = "";
            for ($i = 1; $i <= 5; $i++) {
                $strs .= $str;
                if ($i === 5) {
                    $this->assertFalse($this->useFormRequest(['email'], ['e1a' . $strs]));
                } else {
                    $this->assertFalse($this->useFormRequest(['email'], ['e1a' . $strs]));
                }
            }
        }

        // 下5桁を数字にした際のテスト（桁数も変更）
        foreach (range(0, 9) as $num) {
            $nums = "";
            for ($i = 1; $i <= 5; $i++) {
                $nums .= $num;

                if ($i === 5) {
                    $this->assertTrue($this->useFormRequest(['email'], ['e1a' . $nums]));
                } else {
                    $this->assertFalse($this->useFormRequest(['email'], ['e1a' . $nums]));
                }
            }
        }

        $this->assertFalse($this->useFormRequest(['email'], ['e1a00000'])); // Emailの重複
        $this->assertFalse($this->useFormRequest(['email'], [Str::random(0)])); // Email未定義
        $this->assertFalse($this->useFormRequest(['email'], [Str::random(255)])); // Email定義可能な最大文字列
        $this->assertFalse($this->useFormRequest(['email'], [Str::random(256)])); // Email定義可能な最大文字列超過
        $this->assertFalse($this->useFormRequest(['email'], [$this->getDummyEmail() . '@st.oit.ac.jp'])); // ドメイン名付きEmail
        $this->assertFalse($this->useFormRequest(['email'], [$this->getDummyEmail() .  config('filament.auth.email.domain')])); // Filamentで認証可能なEmailドメイン名
    }

    /**
     * 様々なパスワードを引数としてユーザが作成されることを確認する．
     *
     * @return void
     */
    public function test_user_creation_on_password(): void
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

    /**
     * 様々なユーザ名を引数として，ユーザの復元が可能かどうかを確認する．
     *
     * @return void
     */
    public function test_name_at_user_restore(): void
    {
        $this->restoreTest();
        $this->assertTrue($this->useFormRequest(['name'], ['laravel'])); // ユーザ復元
        $this->assertTrue($this->useFormRequest(['name'], ['laravel'])); // ユーザ名重複
        $this->assertFalse($this->useFormRequest(['name'], [Str::random(0)])); // ユーザ名未定義

        // ユーザ名を定義出来る文字数範囲
        foreach (range(1, 255) as $num) {
            $this->assertTrue($this->useFormRequest(['name'], [Str::random($num)]));
        }

        $this->assertFalse($this->useFormRequest(['name'], [Str::random(256)])); // ユーザ名を定義出来る文字数超過
        $this->assertTrue($this->useFormRequest(['name'], ['123456789'])); // 数字のみのユーザ名
        $this->assertTrue($this->useFormRequest(['name'], ['!"#$%&\'()-^\\@[;:],./\\=~|`{+*}<>?_'])); // 英数字を使用しないユーザ名
        $this->assertTrue($this->useFormRequest(['name'], ['hoge'])); // 異なるユーザ名でユーザ復元 ('laravel' -> 'hoge')
    }

    /**
     * 論理削除されたユーザが存在する中で，それ以外のEmailを指定した際にユーザが作成されることを確認する．
     *
     * @return void
     */
    public function test_email_at_user_restore(): void
    {
        $this->restoreTest();
        $this->assertTrue($this->useFormRequest(['email'], [$this->deleted_email])); // ユーザ復元

        // 1文字目を英字にした際のテスト
        foreach (range('a', 'z') as $str) {
            if (strcmp($str, 'e') === 0) {
                $this->assertTrue($this->useFormRequest(['email'], [$str . str_replace("e", "", $this->getDummyEmail())]));
            } else {
                $this->assertFalse($this->useFormRequest(['email'], [$str . str_replace("e", "", $this->getDummyEmail())]));
            }
        }

        // 1文字目を数字にした際のテスト
        foreach (range(0, 9) as $num) {
            $this->assertFalse($this->useFormRequest(['email'], [$num . str_replace("e", "", $this->getDummyEmail())]));
        }

        // 2文字目を英字にした際のテスト
        foreach (range('a', 'z') as $str) {
            $this->assertFalse($this->useFormRequest(['email'], ['e' . $str . str_replace("e1", "", $this->getDummyEmail())]));
        }

        // 2文字目のを数字にした際のテスト
        foreach (range(0, 9) as $num) {
            if ($num === 1) {
                $this->assertTrue($this->useFormRequest(['email'], ['e' . $num . str_replace("e1", "", $this->getDummyEmail())]));
            } else {
                $this->assertFalse($this->useFormRequest(['email'], ['e' . $num . str_replace("e1", "", $this->getDummyEmail())]));
            }
        }

        // 3文字目を英字にした際のテスト
        foreach (range('a', 'z') as $str) {
            $this->assertTrue($this->useFormRequest(['email'], ['e1' . $str . str_replace("e1z", "", $this->getDummyEmail())]));
        }

        // 3文字目を数字にした際のテスト
        foreach (range(0, 9) as $num) {
            $this->assertFalse($this->useFormRequest(['email'], ['e1' . $num . str_replace("e1z", "", $this->getDummyEmail())]));
        }

        // 下5桁を英字にした際のテスト（桁数も変更）
        foreach (range('a', 'z') as $str) {
            $strs = "";
            for ($i = 1; $i <= 5; $i++) {
                $strs .= $str;
                if ($i === 5) {
                    $this->assertFalse($this->useFormRequest(['email'], ['e1a' . $strs]));
                } else {
                    $this->assertFalse($this->useFormRequest(['email'], ['e1a' . $strs]));
                }
            }
        }

        // 下5桁を数字にした際のテスト（桁数も変更）
        foreach (range(0, 9) as $num) {
            $nums = "";
            for ($i = 1; $i <= 5; $i++) {
                $nums .= $num;

                if ($i === 5) {
                    $this->assertTrue($this->useFormRequest(['email'], ['e1a' . $nums]));
                } else {
                    $this->assertFalse($this->useFormRequest(['email'], ['e1a' . $nums]));
                }
            }
        }

        $this->assertFalse($this->useFormRequest(['email'], [Str::random(0)])); // Email未定義
        $this->assertFalse($this->useFormRequest(['email'], [Str::random(255)])); // Email定義可能な最大文字列
        $this->assertFalse($this->useFormRequest(['email'], [Str::random(256)])); // Email定義可能な最大文字列超過
        $this->assertFalse($this->useFormRequest(['email'], [$this->getDummyEmail() . '@st.oit.ac.jp'])); // ドメイン名付きEmail
        $this->assertFalse($this->useFormRequest(['email'], [$this->getDummyEmail() .  config('filament.auth.email.domain')])); // Filamentで認証可能なEmailドメイン名
    }

    /**
     * 様々なパスワードを引数として，ユーザの復元が可能かどうかを確認する．
     *
     * @return void
     */
    public function test_password_at_user_restore(): void
    {
        $this->restoreTest();
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
        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['different_passwords', 'different_passwords'])); // 作成時と異なるパスワード
    }
}
