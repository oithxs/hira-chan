<?php

namespace Tests\Unit\app\Repositories\ContactAdministratorRepository;

use App\Consts\Tables\ContactAdministratorConst;
use App\Consts\Tables\ContactTypeConst;
use App\Models\ContactAdministrator;
use App\Models\ContactType;
use App\Models\User;
use App\Repositories\ContactAdministratorRepository;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Support\AssertSame\AssertSameInterface;
use Tests\Support\AssertSame\Tables\ContactAdministratorTrait;
use Tests\Support\MakeType;
use Tests\Support\Random;
use Tests\TestCase;
use TypeError;

class StoreTest extends TestCase implements AssertSameInterface
{
    use RefreshDatabase,
        ContactAdministratorTrait;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        // メンバ変数に値を代入する
        $this->user = User::factory()->create();
    }

    /**
     * contact_administrators テーブルの期待する値を取得する
     *
     * @param array $args ['contactTypeId', 'userId', 'message'] の要素が必要
     * @return array contact_administrators テーブルの期待する値
     */
    public function getValuesExpected(array $args): array
    {
        $expected = [];
        $expected[ContactAdministratorConst::CONTACT_TYPE_ID] = $args['contactTypeId'];
        $expected[ContactAdministratorConst::USER_ID] = $args['userId'] . '';
        $expected[ContactAdministratorConst::MESSAGE] = $args['message'];
        return $expected;
    }

    /**
     * お問い合わせの種類名からそのIDを取得する
     *
     * @param string $name お問い合わせの種類名
     * @return integer お問い合わせの種類ID
     */
    public function getContactTypeIdByName(string $name): int
    {
        return ContactType::where('name', $name)->first()->id;
    }

    /**
     * 対応する報告を取得する
     *
     * @param string $message 報告の詳細メッセージ
     * @return array 保存された報告
     */
    public function getContactAdministratorByMessage(string $message): array
    {
        return ContactAdministrator::where('message', $message)->first()->toArray();
    }

    /**
     * すべての報告を取得する
     *
     * @return array すべての報告
     */
    public function getAllContactAdministrator(): array
    {
        return ContactAdministrator::get()->toArray();
    }

    /**
     * ユーザからの報告が保存できることをアサートする
     *
     * @return void
     */
    public function testAssertThatReportsFromUsersCanBeSaved(): void
    {
        $message = 0;
        foreach (ContactTypeConst::CONTACT_TYPES as $contactType) {
            ContactAdministratorRepository::store(
                $this->getContactTypeIdByName($contactType),
                $this->user->id,
                (string) ++$message
            );

            $this->contactAdministrator = $this->getContactAdministratorByMessage((string) $message);
            $this->assertSame(
                $this->getValuesExpected([
                    'contactTypeId' => $this->getContactTypeIdByName($contactType),
                    'userId' => $this->user->id,
                    'message' => (string) $message
                ]),
                $this->getValuesActual()
            );
        }
    }

    /**
     * 存在しないお問い合わせの種類を引数とする
     *
     * @return void
     */
    public function testArgumentThatContactTypeIdThatDoesNotExists(): void
    {
        $contactTypeId = 0;
        $this->assertThrows(
            fn () => ContactAdministratorRepository::store(
                $contactTypeId,
                $this->user->id,
                Random::string()
            ),
            QueryException::class
        );
        $this->assertSame([], $this->getAllContactAdministrator());
    }

    /**
     * お問い合わせ種類のIDとして様々な型を引数とする
     *
     * @return void
     */
    public function testVariousTypesOfArgumentsAsContactTypeIds(): void
    {
        foreach (MakeType::ignoreInt() as $type) {
            $this->assertThrows(
                fn () => ContactAdministratorRepository::store(
                    $type,
                    $this->user->id,
                    Random::string()
                )
            );
        }
        $this->assertSame([], $this->getAllContactAdministrator());
    }

    /**
     * 存在しないユーザIDを引数とする
     *
     * @return void
     */
    public function testArgumentThatAUserIdThatDoesNotExists(): void
    {
        $userId = 'not existent user id';
        $message = 0;
        foreach (ContactTypeConst::CONTACT_TYPES as $contactType) {
            $this->assertThrows(
                fn () => ContactAdministratorRepository::store(
                    $this->getContactTypeIdByName($contactType),
                    $userId,
                    (string) ++$message
                ),
                QueryException::class
            );
        }
        $this->assertSame([], $this->getAllContactAdministrator());
    }

    /**
     * ユーザIDとして様々な型を引数とする
     *
     * @return void
     */
    public function testVariousTypesOfArgumentsAsUserIds(): void
    {
        $message = 0;
        foreach (ContactTypeConst::CONTACT_TYPES as $contactType) {
            foreach (MakeType::ignoreString() as $type) {
                $this->assertThrows(
                    fn () => ContactAdministratorRepository::store(
                        $this->getContactTypeIdByName($contactType),
                        $type,
                        (string) ++$message
                    ),
                    TypeError::class
                );
            }
        }
        $this->assertSame([], $this->getAllContactAdministrator());
    }

    /**
     * メッセージとして様々な型を引数とする
     *
     * @return void
     */
    public function testVariousTypesOfArgumentsAsMessages(): void
    {
        foreach (ContactTypeConst::CONTACT_TYPES as $contactType) {
            foreach (MakeType::ignoreString() as $type) {
                $this->assertThrows(
                    fn () => ContactAdministratorRepository::store(
                        $this->getContactTypeIdByName($contactType),
                        $this->user->id,
                        $type
                    ),
                    TypeError::class
                );
            }
        }
        $this->assertSame([], $this->getAllContactAdministrator());
    }

    /**
     * すべて数字のメッセージを引数とする
     *
     * @return void
     */
    public function testAllNumericMessageAsAnArgument(): void
    {
        foreach (ContactTypeConst::CONTACT_TYPES as $contactType) {
            $message = Random::stringOfNumbers();
            ContactAdministratorRepository::store(
                $this->getContactTypeIdByName($contactType),
                $this->user->id,
                $message
            );

            $this->contactAdministrator = $this->getContactAdministratorByMessage($message);
            $this->assertSame(
                $this->getValuesExpected([
                    'contactTypeId' => $this->getContactTypeIdByName($contactType),
                    'userId' => $this->user->id,
                    'message' => $message
                ]),
                $this->getValuesActual()
            );
        }
    }

    /**
     * すべて英子文字のメッセージを引数とする
     *
     * @return void
     */
    public function testTakeAnAllLowercaseMessageAsAnArgument(): void
    {
        foreach (ContactTypeConst::CONTACT_TYPES as $contactType) {
            $message = Random::lowercase();
            ContactAdministratorRepository::store(
                $this->getContactTypeIdByName($contactType),
                $this->user->id,
                $message
            );

            $this->contactAdministrator = $this->getContactAdministratorByMessage($message);
            $this->assertSame(
                $this->getValuesExpected([
                    'contactTypeId' => $this->getContactTypeIdByName($contactType),
                    'userId' => $this->user->id,
                    'message' => $message
                ]),
                $this->getValuesActual()
            );
        }
    }

    /**
     * すべて英大文字のメッセージを引数とする
     *
     * @return void
     */
    public function testTakeAnAllUpperCaseMessageAsAnArgument(): void
    {
        foreach (ContactTypeConst::CONTACT_TYPES as $contactType) {
            $message = Random::uppercase();
            ContactAdministratorRepository::store(
                $this->getContactTypeIdByName($contactType),
                $this->user->id,
                $message
            );

            $this->contactAdministrator = $this->getContactAdministratorByMessage($message);
            $this->assertSame(
                $this->getValuesExpected([
                    'contactTypeId' => $this->getContactTypeIdByName($contactType),
                    'userId' => $this->user->id,
                    'message' => $message
                ]),
                $this->getValuesActual()
            );
        }
    }

    /**
     * すべて記号のメッセージを引数とする
     *
     * @return void
     */
    public function testTakeAnAllSymbolMessageAsAnArgument(): void
    {
        foreach (ContactTypeConst::CONTACT_TYPES as $contactType) {
            $message = Random::symbol();
            ContactAdministratorRepository::store(
                $this->getContactTypeIdByName($contactType),
                $this->user->id,
                $message
            );

            $this->contactAdministrator = $this->getContactAdministratorByMessage($message);
            $this->assertSame(
                $this->getValuesExpected([
                    'contactTypeId' => $this->getContactTypeIdByName($contactType),
                    'userId' => $this->user->id,
                    'message' => $message
                ]),
                $this->getValuesActual()
            );
        }
    }
}
