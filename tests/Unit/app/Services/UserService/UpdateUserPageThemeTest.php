<?php

namespace Tests\Unit\app\Services\UserService;

use App\Consts\Tables\UserConst;
use App\Consts\Tables\UserPageThemeConst;
use App\Models\User;
use App\Models\UserPageTheme;
use App\Services\UserService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\AssertSame\Tables\UserTrait;
use Tests\Support\MakeType;
use Tests\TestCase;
use TypeError;

class UpdateUserPageThemeTest extends TestCase implements AssertSameInterface
{
    use RefreshDatabase,
        UserTrait;

    private UserService $userService;

    private User $testUser;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->userService = new UserService;
        $testUser = User::factory()->create();
        $this->testUser = User::find($testUser->id);
    }

    /**
     * ユーザテーブルの期待する値を取得する
     *
     * @param array $args ['userPageThemeId'] が必要
     * @return array ユーザテーブルの期待する値
     */
    public function getValuesExpected(array $args): array
    {
        $expected = [];
        $expected[UserConst::USER_PAGE_THEME_ID] = $args['userPageThemeId'];
        $expected[UserConst::_NAME] = $this->testUser->name;
        $expected[UserConst::EMAIL] = $this->testUser->email;
        $expected[UserConst::EMAIL_VERIFIED_AT] = $this->testUser->email_verified_at . '';
        $expected[UserConst::TWO_FACTOR_CONFIRMED_AT] = $this->testUser->two_factor_confirmed_at;
        $expected[UserConst::CURRENT_TEAM_ID] = $this->testUser->current_team_id;
        $expected[UserConst::PROFILE_PHOTO_PATH] = $this->testUser->profile_photo_path;
        return $expected;
    }

    /**
     * ページテーマ名からIDを取得する
     *
     * @param string $themeName
     * @return integer
     */
    public function getUserPageThemeId(string $themeName): int
    {
        return UserPageTheme::where('theme_name', $themeName)->first()->id;
    }

    /**
     * 対応するユーザを取得する
     *
     * @param string $id ユーザID
     * @return array 対応するユーザ
     */
    public function getUser(string $id): array
    {
        return User::find($id)->toArray();
    }

    /**
     * ユーザのページテーマを更新できることをアサートする
     *
     * @return void
     */
    public function testAssertThatTheUserPageThemeCanBeUpdated(): void
    {
        foreach (UserPageThemeConst::PAGE_THEMES as $userPageTheme) {
            $userPageThemeId = $this->getUserPageThemeId($userPageTheme);
            $this->userService->updateUserPageTheme($this->testUser->id, $userPageThemeId);

            $this->user = $this->getUser($this->testUser->id);
            $this->assertSame(
                $this->getValuesExpected(['userPageThemeId' => $userPageThemeId]),
                $this->getValuesActual()
            );
        }
    }

    /**
     * 存在しないユーザIDを引数とする
     *
     * @return void
     */
    public function testArgumentThatAUserIdThatDoesNotExists(): void
    {
        $userId = 'not existent user id';
        foreach (UserPageThemeConst::PAGE_THEMES as $userPageTheme) {
            $userPageTHemeId = $this->getUserPageThemeId($userPageTheme);
            $this->userService->updateUserPageTheme($userId, $userPageTHemeId);

            $this->user = $this->getUser($this->testUser->id);
            $this->assertSame(
                $this->getValuesExpected(['userPageThemeId' => $this->testUser->user_page_theme_id]),
                $this->getValuesActual()
            );
        }
    }

    /**
     * ユーザIDとして様々な型を引数とする
     *
     * @return void
     */
    public function testVariousTypesOfArgumentsAsUserIds(): void
    {
        foreach (UserPageThemeConst::PAGE_THEMES as $userPageTheme) {
            $userPageThemeId = $this->getUserPageThemeId($userPageTheme);

            foreach (MakeType::ignores(['int', 'bool', 'float', 'string']) as $type) {
                $this->assertThrows(
                    fn () => $this->userService->updateUserPageTheme(
                        $type,
                        $userPageThemeId
                    ),
                    TypeError::class
                );

                $this->user = $this->getUser($this->testUser->id);
                $this->assertSame(
                    $this->getValuesExpected(['userPageThemeId' => $this->testUser->user_page_theme_id]),
                    $this->getValuesActual()
                );
            }
        }
    }


    /**
     * 存在しないユーザページテーマIDを引数とする
     *
     * @return void
     */
    public function testArgumentThatAUserPageThemeIdThatDoesNotExists(): void
    {
        $userPageThemeId = 0;
        $this->assertThrows(
            fn () => $this->userService->updateUserPageTheme($this->testUser->id, $userPageThemeId),
            QueryException::class
        );
        $this->user = $this->getUser($this->testUser->id);
        $this->assertSame(
            $this->getValuesExpected(['userPageThemeId' => $this->testUser->user_page_theme_id]),
            $this->getValuesActual()
        );
    }

    /**
     * ユーザページテーマIDとして様々な型を引数とする
     *
     * @return void
     */
    public function testVariousTypesOfArgumentsAsUserPageThemeIds(): void
    {
        foreach (MakeType::ignores(['bool', 'int', 'float']) as $type) {
            $this->assertThrows(
                fn () => $this->userService->updateUserPageTheme($this->testUser->id, $type),
                TypeError::class
            );

            $this->user = $this->getUser($this->testUser->id);
            $this->assertSame(
                $this->getValuesExpected(['userPageThemeId' => $this->testUser->user_page_theme_id]),
                $this->getValuesActual()
            );
        }
    }
}
