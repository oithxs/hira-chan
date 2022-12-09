<?php

namespace Tests\Unit\app\Actions\Fortify\UpdateUserProfileInformation;

use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Tests\UseFormRequestTestCase;

class UpdateTest extends UseFormRequestTestCase
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
     * @see \Tests\UseFormRequestTestCase::setMethod() [Overirde]
     * @return void
     */
    protected function setMethod(): void
    {
        $this->method = [
            new UpdateUserProfileInformation,
            'update'
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
            'id' => $this->user->id,
            'user_page_theme_id' => $this->user->user_page_theme_id,
            'name' => $this->user->name,
            'email' => $this->user->email,
            'email_verified_at' => $this->user->email_verified_at,
            'two_factor_confirmed_at' => $this->user->two_factor_confirmed_at,
            'current_team_id' => $this->user->current_team_id,
            'profile_photo_path' => $this->user->profile_photo_url,
            'created_at' => $this->user->created_at,
            'updated_at' => $this->user->updated_at,
            'deleted_at' => $this->user->deleted_at,
            'profile_photo_url' => $this->user->profile_photo_url,
            // 'photo' =>
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
     * ユーザ名の更新
     *
     * @return void
     */
    public function test_update_username(): void
    {
        $this->assertSame(null, $this->useFormRequest(['name'], ['hoge']));
    }

    /**
     * ユーザ名の重複
     *
     * @return void
     */
    public function test_duplicate_usernames(): void
    {
        $this->assertSame(null, $this->useFormRequest(['name'], ['laravel']));
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
            $this->assertSame(null, $this->useFormRequest(['name'], [Str::random($num)]));
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
        $this->assertSame(null, $this->useFormRequest(['name'], ['123456789']));
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
        $this->assertSame(null, $this->useFormRequest(['name'], [$name]));
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
     * @return void
     */
    public function test_maximum_number_of_characters_that_can_be_defined_in_an_email(): void
    {
        $domain_len = 12;
        $this->assertSame(null, $this->useFormRequest(['email'], [Str::random(255 - $domain_len) . '@example.com']));
    }

    /**
     * Email定義可能な最大文字数超過
     *
     * @return void
     */
    public function test_maximum_number_of_characters_that_can_be_defined_in_an_email_exceeded(): void
    {
        $domain_len = 12;
        $this->assertThrows(
            fn () => $this->useFormRequest(['email'], [Str::random(256 - $domain_len)]),
            ValidationException::class
        );
    }

    /**
     * 同じEmail
     *
     * @return void
     */
    public function test_same_email(): void
    {
        $this->assertSame(null, $this->useFormRequest(['email'], [$this->user->email]));
    }
}
