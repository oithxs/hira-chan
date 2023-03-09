<?php

namespace Tests\Unit\app\Actions\Fortify\CreateNewUser;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
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
     * setUpメソッドが実行されたときに最初に呼び出される．
     *
     * @return void
     */
    protected function setAny(): void
    {
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
     * ユーザ作成テストで期待される返り値（key）を返却する
     *
     * @return array
     */
    private function getKeysExpected(): array
    {
        return [
            'id',
            'name',
            'email',
            'updated_at',
            'created_at',
            'profile_photo_url'
        ];
    }

    /**
     * ユーザ作成テストで期待される返り値（value）を取得する
     *
     * @return array
     */
    private function getValuesExpected($str = 'z', $minus = 1): array
    {
        if ($str === 0) {
            return [
                'name' => $this->args['name'],
                'email' => $this->args['email'] . '@st.oit.ac.jp'
            ];
        }

        return [
            'name' => $this->args['name'],
            'email' => 'e1' . $str . $this->number - $minus . '@st.oit.ac.jp'
        ];
    }

    /**
     * ユーザ復元テストで期待される返り値（key）を取得する
     *
     * @return array
     */
    private function getRestoreKeysExpected(): array
    {
        return [
            'id',
            'user_page_theme_id',
            'name',
            'email',
            'email_verified_at',
            'two_factor_confirmed_at',
            'current_team_id',
            'profile_photo_path',
            'created_at',
            'updated_at',
            'deleted_at',
            'profile_photo_url'
        ];
    }

    /**
     * ユーザ復元テストで期待される返り値（value）を取得する
     *
     * @return array
     */
    private function getRestoreValuesExpected(): array
    {
        return [
            'user_page_theme_id' => 1, // default
            'name' => $this->args['name'],
            'email' => $this->deleted_email . '@st.oit.ac.jp',
            'email_verified_at' => NULL,
            'two_factor_confirmed_at' => NULL,
            'current_team_id' => NULL,
            'profile_photo_path' => NULL,
            'deleted_at' => NULL,
        ];
    }

    private function getArrayElement(array $ary, array $keys): array
    {
        $response = [];
        foreach ($keys as $key) {
            $response[$key] = $ary[$key];
        }
        return $response;
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
        $this->useFormRequest(['email'], [$this->deleted_email]);
        $this->useFormRequest(['email'], [$this->deleted_email]);
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
        } catch (Exception) {
            //
        } finally {
            User::where('email', '=', $this->deleted_email . '@st.oit.ac.jp')->delete();
        }
    }

    /**
     * ユーザ作成テスト
     *
     * @return void
     */
    public function test_user_creation(): void
    {
        $response = $this->useFormRequest(['name'], ['laravel'])->toArray();
        $this->assertSame($this->getKeysExpected(), array_keys($response));
        $this->assertSame($this->getValuesExpected(), $this->getArrayElement($response, ['name', 'email']));
    }

    /**
     * ユーザ名の重複
     *
     * @return void
     */
    public function test_duplicate_usernames(): void
    {
        $response = $this->useFormRequest(['name'], ['laravel'])->toArray();
        $this->assertSame($this->getKeysExpected(), array_keys($response));
        $this->assertSame($this->getValuesExpected(), $this->getArrayElement($response, ['name', 'email']));
    }

    /**
     * ユーザ名未定義
     *
     * @return void
     */
    public function test_username_undefined(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['name'], [Str::random(0)]),
            ValidationException::class
        );
    }

    /**
     * ユーザ名を定義可能な文字数範囲
     *
     * @return void
     */
    public function test_character_range_within_which_usernames_can_be_defined(): void
    {
        foreach (range(1, 255) as $num) {
            $response = $this->useFormRequest(['name'], [Str::random($num)])->toArray();
            $this->assertSame($this->getKeysExpected(), array_keys($response));
            $this->assertSame($this->getValuesExpected(), $this->getArrayElement($response, ['name', 'email']));
        }
    }

    /**
     * ユーザ名の最大文字数超過
     *
     * @return void
     */
    public function test_maximum_number_of_characters_in_user_name_exceeded(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['name'], [Str::random(256)]),
            ValidationException::class
        );
    }

    /**
     * 数字のみのユーザ名
     *
     * @return void
     */
    public function test_user_name_with_only_numbers(): void
    {
        $response = $this->useFormRequest(['name'], ['123456789'])->toArray();
        $this->assertSame($this->getKeysExpected(), array_keys($response));
        $this->assertSame($this->getValuesExpected(), $this->getArrayElement($response, ['name', 'email']));
    }

    /**
     * 英数字を使用しないユーザ名
     *
     * @return void
     */
    public function test_user_name_without_alphanumeric_characters(): void
    {
        $name = '';
        foreach ($this->symbols as $symbol) {
            $name .= $symbol;
        }
        $response = $this->useFormRequest(['name'], [$name])->toArray();
        $this->assertSame($this->getKeysExpected(), array_keys($response));
        $this->assertSame($this->getValuesExpected(), $this->getArrayElement($response, ['name', 'email']));
    }

    /**
     * Emailの1文字目が英字
     *
     * @return void
     */
    public function test_the_first_letter_of_the_email_is_an_english_letter(): void
    {
        foreach (range('a', 'z') as $str) {
            if (strcmp($str, 'e') === 0) {
                $response = $this->useFormRequest(['email'], [$str . str_replace("e", "", $this->getDummyEmail())])->toArray();
                $this->assertSame($this->getKeysExpected(), array_keys($response));
                $this->assertSame($this->getValuesExpected(minus: 2), $this->getArrayElement($response, ['name', 'email']));
            } else {
                $this->assertThrows(
                    fn () =>  $this->useFormRequest(['email'], [$str . str_replace("e", "", $this->getDummyEmail())]),
                    ValidationException::class
                );
            }
        }
    }

    /**
     * Emailの1文字目が数字
     *
     * @return void
     */
    public function test_the_first_letter_of_the_email_is_a_number(): void
    {
        foreach (range(0, 9) as $num) {
            $this->assertThrows(
                fn () => $this->useFormRequest(['email'], [$num . str_replace("e", "", $this->getDummyEmail())]),
                ValidationException::class
            );
        }
    }

    /**
     * Emailの1文字目が英数字以外
     *
     * @return void
     */
    public function test_the_first_letter_of_the_email_is_not_alphanumeric(): void
    {
        foreach ($this->symbols as $symbol) {
            $this->assertThrows(
                fn () => $this->useFormRequest(['email'], [$symbol . str_replace("e", "", $this->getDummyEmail())]),
                ValidationException::class
            );
        }
    }

    /**
     * Emailの2文字目が英字
     *
     * @return void
     */
    public function test_the_second_letter_of_the_email_is_an_english_letter(): void
    {
        foreach (range('a', 'z') as $str) {
            $this->assertThrows(
                fn () => $this->useFormRequest(['email'], ['e' . $str . str_replace("e1", "", $this->getDummyEmail())]),
                ValidationException::class
            );
        }
    }

    /**
     * Emailの2文字目が数字
     *
     * @return void
     */
    public function test_the_second_letter_of_the_email_is_a_number(): void
    {
        foreach (range(0, 9) as $num) {
            if ($num === 1) {
                $response = $this->useFormRequest(['email'], ['e' . $num . str_replace("e1", "", $this->getDummyEmail())])->toArray();
                $this->assertSame($this->getKeysExpected(), array_keys($response));
                $this->assertSame($this->getValuesExpected(minus: 2), $this->getArrayElement($response, ['name', 'email']));
            } else {
                $this->assertThrows(
                    fn () => $this->useFormRequest(['email'], ['e' . $num . str_replace("e1", "", $this->getDummyEmail())]),
                    ValidationException::class
                );
            }
        }
    }

    /**
     * Emailの2文字目が英数字以外
     *
     * @return void
     */
    public function test_the_second_letter_of_the_email_is_not_alphanumeric(): void
    {
        foreach ($this->symbols as $symbol) {
            $this->assertThrows(
                fn () => $this->useFormRequest(['email'], ['e' . $symbol . str_replace("e1", "", $this->getDummyEmail())]),
                ValidationException::class
            );
        }
    }

    /**
     * Emailの3文字目が英字
     *
     * @return void
     */
    public function test_the_third_letter_of_the_email_is_an_english_letter(): void
    {
        foreach (range('a', 'z') as $str) {
            $response = $this->useFormRequest(['email'], ['e1' . $str . str_replace("e1z", "", $this->getDummyEmail())])->toArray();
            $this->assertSame($this->getKeysExpected(), array_keys($response));
            $this->assertSame($this->getValuesExpected(str: $str, minus: 2), $this->getArrayElement($response, ['name', 'email']));
        }
    }

    /**
     * Emailの3文字目が数字
     *
     * @return void
     */
    public function test_the_third_letter_of_the_email_is_a_number(): void
    {
        foreach (range(0, 9) as $num) {
            $this->assertThrows(
                fn () => $this->useFormRequest(['email'], ['e1' . $num . str_replace("e1z", "", $this->getDummyEmail())]),
                ValidationException::class
            );
        }
    }

    /**
     * Emailの3文字目が英数字以外
     *
     * @return void
     */
    public function test_the_third_letter_of_the_email_is_not_alphanumeric(): void
    {
        foreach ($this->symbols as $symbol) {
            $this->assertThrows(
                fn () => $this->useFormRequest(['email'], ['e1' . $symbol . str_replace("e1z", "", $this->getDummyEmail())]),
                ValidationException::class
            );
        }
    }

    /**
     * Emailの下5桁が英字（桁数も1～6文字を検証）
     *
     * @return void
     */
    public function test_last_5_digits_of_email_are_alphabetic_characters(): void
    {
        foreach (range('a', 'z') as $str) {
            $strs = "";
            for ($i = 1; $i <= 6; $i++) {
                $strs .= $str;
                $this->assertThrows(
                    fn () => $this->useFormRequest(['email'], ['e1a' . $strs]),
                    ValidationException::class
                );
            }
        }
    }

    /**
     * Emailの下5桁が数字（桁数も1～6文字を検証）
     *
     * @return void
     */
    public function test_last_5_digits_of_email_are_numbers(): void
    {
        foreach (range(0, 9) as $num) {
            $nums = "";
            for ($i = 1; $i <= 6; $i++) {
                $nums .= $num;

                if ($i === 5) {
                    $response = $this->useFormRequest(['email'], ['e1a' . $nums])->toArray();
                    $this->assertSame($this->getKeysExpected(), array_keys($response));
                    $this->assertSame($this->getValuesExpected(0), $this->getArrayElement($response, ['name', 'email']));
                } else {
                    $this->assertThrows(
                        fn () => $this->useFormRequest(['email'], ['e1a' . $nums]),
                        ValidationException::class
                    );
                }
            }
        }
    }

    /**
     * Emailの下5桁が英数字（桁数も1～6文字を検証）
     *
     * @return void
     */
    public function test_last_5_digits_of_email_are_not_alphanumeric(): void
    {
        foreach ($this->symbols as $symbol) {
            $strs = '';
            for ($i = 1; $i <= 6; $i++) {
                $strs .= $symbol;
                for ($i = 1; $i <= 6; $i++) {
                    $strs .= $symbol;
                    $this->assertThrows(
                        fn () => $this->useFormRequest(['email'], ['e1a' . $strs]),
                        ValidationException::class
                    );
                }
            }
        }
    }

    /**
     * Emailの重複
     *
     * @return void
     */
    public function test_duplicate_email(): void
    {
        try {
            $this->useFormRequest(['email'], ['e1a00000']);
        } catch (ValidationException) {
            //
        }

        $this->assertThrows(
            fn () => $this->useFormRequest(['email'], ['e1a00000']),
            ValidationException::class
        );
    }

    /**
     * Email未定義
     *
     * @return void
     */
    public function test_email_undefined(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['email'], [Str::random(0)]),
            ValidationException::class
        );
    }

    /**
     * Email定義可能な最大文字数
     *
     * 定義可能ではあるが，正規表現に一致しないためEmailの検証は通らない
     *
     * @return void
     */
    public function test_maximum_number_of_characters_that_can_be_defined_in_an_email(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['email'], [Str::random(255)]),
            ValidationException::class
        );
    }

    /**
     * Email定義可能な最大文字数超過
     *
     * 定義可能ではあるが，正規表現に一致しないためEmailの検証は通らない
     *
     * @return void
     */
    public function test_maximum_number_of_characters_that_can_be_defined_in_an_email_exceeded(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['email'], [Str::random(256)]),
            ValidationException::class
        );
    }

    /**
     * ドメイン名付きEmail
     *
     * @return void
     */
    public function test_email_with_domain_name(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['email'], [$this->getDummyEmail() . '@st.oit.ac.jp']),
            ValidationException::class
        );
    }

    /**
     * Filamentで認証可能なEmailドメイン名
     *
     * @return void
     */
    public function test_email_domain_names_that_can_be_authenticated_with_filament(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['email'], [$this->getDummyEmail() .  config('filament.auth.email.domain')]),
            ValidationException::class
        );
    }

    /**
     * パスワード未定義
     *
     * @return void
     */
    public function test_password_undefined(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['password', 'password_confirmation'], [Str::random(0), Str::random(0)]),
            ValidationException::class
        );
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
     * 255文字以上も可能
     *
     * @return void
     */
    public function test_character_range_for_which_passwords_can_be_defined(): void
    {
        foreach (range(8, 255) as $num) {
            $password = Str::random($num);
            $response = $this->useFormRequest(['password', 'password_confirmation'], [$password, $password])->toArray();
            $this->assertSame($this->getKeysExpected(), array_keys($response));
            $this->assertSame($this->getValuesExpected(), $this->getArrayElement($response, ['name', 'email']));
        }
    }

    /**
     * 英字のみのパスワード
     *
     * @return void
     */
    public function test_password_with_only_alphanumeric(): void
    {
        $response = $this->useFormRequest(['password', 'password_confirmation'], ['abcdefgh', 'abcdefgh'])->toArray();
        $this->assertSame($this->getKeysExpected(), array_keys($response));
        $this->assertSame($this->getValuesExpected(), $this->getArrayElement($response, ['name', 'email']));
    }

    /**
     * 数字のみのパスワード
     *
     * @return void
     */
    public function test_password_with_only_numbers(): void
    {
        $response = $this->useFormRequest(['password', 'password_confirmation'], ['abcdefgh', 'abcdefgh'])->toArray();
        $this->assertSame($this->getKeysExpected(), array_keys($response));
        $this->assertSame($this->getValuesExpected(), $this->getArrayElement($response, ['name', 'email']));
    }

    /**
     * 英数字以外のパスワード
     *
     * @return void
     */
    public function test_password_without_alphanumeric_characters(): void
    {
        $password = '';
        foreach ($this->symbols as $symbol) {
            $password .= $symbol;
        }

        $response = $this->useFormRequest(['password', 'password_confirmation'], [$password, $password])->toArray();
        $this->assertSame($this->getKeysExpected(), array_keys($response));
        $this->assertSame($this->getValuesExpected(), $this->getArrayElement($response, ['name', 'email']));
    }

    /**
     * 1度目と2度目が異なるパスワード
     *
     * @return void
     */
    public function test_different_passwords_the_first_and_second_time(): void
    {
        $this->assertThrows(
            fn () => $this->useFormRequest(['password', 'password_confirmation'], ['12345678', '87654321']),
            ValidationException::class
        );
    }

    /**
     * ユーザ復元
     *
     * @return void
     */
    public function test_user_restore(): void
    {
        $this->restoreTest();
        $response = $this->useFormRequest(['name'], ['laravel'])->toArray();
        $this->assertSame($this->getRestoreKeysExpected(), array_keys($response));
        $this->assertSame(
            $this->getRestoreValuesExpected(),
            $this->getArrayElement($response, [
                'user_page_theme_id',
                'name',
                'email',
                'email_verified_at',
                'two_factor_confirmed_at',
                'current_team_id',
                'profile_photo_path',
                'deleted_at'
            ])
        );
    }

    /**
     * ユーザ復元時にユーザ名の重複
     *
     * @return void
     */
    public function test_duplicate_usernames_when_restoring_users(): void
    {
        $this->restoreTest();
        $response = $this->useFormRequest(['name'], ['laravel'])->toArray();
        $this->assertSame($this->getRestoreKeysExpected(), array_keys($response));
        $this->assertSame(
            $this->getRestoreValuesExpected(),
            $this->getArrayElement($response, [
                'user_page_theme_id',
                'name',
                'email',
                'email_verified_at',
                'two_factor_confirmed_at',
                'current_team_id',
                'profile_photo_path',
                'deleted_at'
            ])
        );
    }

    /**
     * ユーザ復元時にユーザ名未定義
     *
     * @return void
     */
    public function test_username_undefined_when_restoring_users(): void
    {
        $this->restoreTest();
        $this->assertThrows(
            fn () => $this->useFormRequest(['name'], [Str::random(0)]),
            ValidationException::class
        );
    }

    /**
     * ユーザ復元時にユーザ名を定義可能な文字数範囲
     *
     * @return void
     */
    public function test_character_range_within_which_usernames_can_be_defined_when_restoring_users(): void
    {
        $this->restoreTest();
        foreach (range(1, 255) as $num) {
            $response = $this->useFormRequest(['name'], [Str::random($num)])->toArray();
            $this->assertSame($this->getRestoreKeysExpected(), array_keys($response));
            $this->assertSame(
                $this->getRestoreValuesExpected(),
                $this->getArrayElement($response, [
                    'user_page_theme_id',
                    'name',
                    'email',
                    'email_verified_at',
                    'two_factor_confirmed_at',
                    'current_team_id',
                    'profile_photo_path',
                    'deleted_at'
                ])
            );
        }
    }

    /**
     * ユーザ復元時にユーザ名の最大文字数超過
     *
     * @return void
     */
    public function test_maximum_number_of_characters_in_user_name_exceeded_when_restoring_users(): void
    {
        $this->restoreTest();
        $this->assertThrows(
            fn () => $this->useFormRequest(['name'], [Str::random(256)]),
            ValidationException::class
        );
    }

    /**
     * ユーザ復元時に数字のみのユーザ名
     *
     * @return void
     */
    public function test_user_name_with_only_numbers_when_restoring_users(): void
    {
        $this->restoreTest();
        $response = $this->useFormRequest(['name'], ['123456789'])->toArray();
        $this->assertSame($this->getRestoreKeysExpected(), array_keys($response));
        $this->assertSame(
            $this->getRestoreValuesExpected(),
            $this->getArrayElement($response, [
                'user_page_theme_id',
                'name',
                'email',
                'email_verified_at',
                'two_factor_confirmed_at',
                'current_team_id',
                'profile_photo_path',
                'deleted_at'
            ])
        );
    }

    /**
     * ユーザ復元時に英数字を使用しないユーザ名
     *
     * @return void
     */
    public function test_user_name_without_alphanumeric_characters_when_restoring_users(): void
    {
        $this->restoreTest();
        $name = '';
        foreach ($this->symbols as $symbol) {
            $name .= $symbol;
        }
        $response = $this->useFormRequest(['name'], [$name])->toArray();
        $this->assertSame($this->getRestoreKeysExpected(), array_keys($response));
        $this->assertSame(
            $this->getRestoreValuesExpected(),
            $this->getArrayElement($response, [
                'user_page_theme_id',
                'name',
                'email',
                'email_verified_at',
                'two_factor_confirmed_at',
                'current_team_id',
                'profile_photo_path',
                'deleted_at'
            ])
        );
    }

    /**
     * 異なるユーザ名で復元
     *
     * 'laravel' -> 'hoge'
     *
     * @return void
     */
    public function test_restore_user_with_different_user_name(): void
    {
        $this->restoreTest();
        $response = $this->useFormRequest(['name'], ['hoge'])->toArray();
        $this->assertSame($this->getRestoreKeysExpected(), array_keys($response));
        $this->assertSame(
            $this->getRestoreValuesExpected(),
            $this->getArrayElement($response, [
                'user_page_theme_id',
                'name',
                'email',
                'email_verified_at',
                'two_factor_confirmed_at',
                'current_team_id',
                'profile_photo_path',
                'deleted_at'
            ])
        );
    }

    /**
     * ユーザ復元時にパスワード未定義
     *
     * @return void
     */
    public function test_password_undefined_when_restoring_users(): void
    {
        $this->restoreTest();
        $this->assertThrows(
            fn () => $this->useFormRequest(['password', 'password_confirmation'], [Str::random(0), Str::random(0)]),
            ValidationException::class
        );
    }

    /**
     * ユーザ復元時にパスワードを定義出来ない文字数範囲
     *
     * @return void
     */
    public function test_character_range_for_which_passwords_cannot_be_defined_when_restoring_users(): void
    {
        $this->restoreTest();
        foreach (range(1, 7) as $num) {
            $password = Str::random($num);
            $this->assertThrows(
                fn () => $this->useFormRequest(['password', 'password_confirmation'], [$password, $password]),
                ValidationException::class
            );
        }
    }

    /**
     * ユーザ復元時にパスワードを定義出来る文字数範囲
     *
     * 255文字以上も可能
     *
     * @return void
     */
    public function test_character_range_for_which_passwords_can_be_defined_when_restoring_users(): void
    {
        $this->restoreTest();
        foreach (range(8, 255) as $num) {
            $password = Str::random($num);
            $response = $this->useFormRequest(['password', 'password_confirmation'], [$password, $password])->toArray();
            $this->assertSame($this->getRestoreKeysExpected(), array_keys($response));
            $this->assertSame(
                $this->getRestoreValuesExpected(),
                $this->getArrayElement($response, [
                    'user_page_theme_id',
                    'name',
                    'email',
                    'email_verified_at',
                    'two_factor_confirmed_at',
                    'current_team_id',
                    'profile_photo_path',
                    'deleted_at'
                ])
            );
        }
    }

    /**
     * ユーザ復元時に英字のみのパスワード
     *
     * @return void
     */
    public function test_password_with_only_alphanumeric_when_restoring_users(): void
    {
        $this->restoreTest();
        $response = $this->useFormRequest(['password', 'password_confirmation'], ['abcdefgh', 'abcdefgh'])->toArray();
        $this->assertSame($this->getRestoreKeysExpected(), array_keys($response));
        $this->assertSame(
            $this->getRestoreValuesExpected(),
            $this->getArrayElement($response, [
                'user_page_theme_id',
                'name',
                'email',
                'email_verified_at',
                'two_factor_confirmed_at',
                'current_team_id',
                'profile_photo_path',
                'deleted_at'
            ])
        );
    }

    /**
     * ユーザ復元時に数字のみのパスワード
     *
     * @return void
     */
    public function test_password_with_only_numbers_when_restoring_users(): void
    {
        $this->restoreTest();
        $response = $this->useFormRequest(['password', 'password_confirmation'], ['abcdefgh', 'abcdefgh'])->toArray();
        $this->assertSame($this->getRestoreKeysExpected(), array_keys($response));
        $this->assertSame(
            $this->getRestoreValuesExpected(),
            $this->getArrayElement($response, [
                'user_page_theme_id',
                'name',
                'email',
                'email_verified_at',
                'two_factor_confirmed_at',
                'current_team_id',
                'profile_photo_path',
                'deleted_at'
            ])
        );
    }

    /**
     * ユーザ復元時に英数字以外のパスワード
     *
     * @return void
     */
    public function test_password_without_alphanumeric_characters_when_restoring_users(): void
    {
        $this->restoreTest();
        $password = '';
        foreach ($this->symbols as $symbol) {
            $password .= $symbol;
        }

        $response = $this->useFormRequest(['password', 'password_confirmation'], [$password, $password])->toArray();
        $this->assertSame($this->getRestoreKeysExpected(), array_keys($response));
        $this->assertSame(
            $this->getRestoreValuesExpected(),
            $this->getArrayElement($response, [
                'user_page_theme_id',
                'name',
                'email',
                'email_verified_at',
                'two_factor_confirmed_at',
                'current_team_id',
                'profile_photo_path',
                'deleted_at'
            ])
        );
    }

    /**
     * ユーザ復元時に1度目と2度目が異なるパスワード
     *
     * @return void
     */
    public function test_different_passwords_the_first_and_second_time_when_restoring_users(): void
    {
        $this->restoreTest();
        $this->assertThrows(
            fn () => $this->useFormRequest(['password', 'password_confirmation'], ['12345678', '87654321']),
            ValidationException::class
        );
    }
}
